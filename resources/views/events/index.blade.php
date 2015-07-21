@extends('app')
 
@section('content')
 
<div class="container-fluid">
    <div class="row">

        <div class="cold-md-12 text-center">
            <h1><?php echo $title; ?></h1>
        </div>

        <?php foreach ($events as $event) { ?>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading text-center"><strong><?php echo $event->title ?></strong> - hosted by <?php echo $event->creator->full_name; ?></div>
                    <div class="panel-body">
                        <div class="form-group clearfix">
                            <label class="col-md-4">Capacity</label>
                            <div class="col-md-8"><?php echo $event->capacity ?></div>
                        </div>
                        
                        <div class="form-group clearfix">
                            <label class="col-md-4">Start time</label>
                            <div class="col-md-8"><?php echo $event->start_time_friendly ?></div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4">End time</label>
                            <div class="col-md-8"><?php echo $event->end_time_friendly ?></div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <a class="btn btn-primary" href="<?php echo url('events/show', $parameters = ['id' => $event->id], $secure = null); ?>">View details</a>
                                <?php if($event->host != Auth::id()) : ?>
                                <form class="form-horizontal" role="form" method="POST" action="/events/book/{{ $event->id }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-success">Book!</button>
                                </form>                            
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>

</div>
 
@endsection