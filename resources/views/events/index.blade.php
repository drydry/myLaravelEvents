@extends('app')
 
@section('content')
 
<div class="container-fluid">
    <div class="row">

        <div class="cold-md-12 text-center">
            <h1>Events</h1>
        </div>

        <?php foreach ($events as $event) { ?>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading text-center"><strong><?php echo $event->title ?></strong> - hosted by <?php echo $event->creator->full_name; ?></div>
                    <div class="panel-body">
                        <div class="form-group clearfix">
                            <label class="col-md-4">Start time</label>
                            <div class="col-md-8"><?php echo $event->start_time ?></div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4">End time</label>
                            <div class="col-md-8"><?php echo $event->end_time ?></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>

</div>
 
@endsection