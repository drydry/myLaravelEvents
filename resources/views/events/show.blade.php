@extends('app')
 
@section('content')
 
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Event details</div>
                <div class="panel-body">
                    <div class="form-group clearfix">
                        <label class="col-md-4 control-label">Title</label>
                        <div class="col-md-8">
                        	<?php echo $event->title; ?>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label class="col-md-4 control-label">Host</label>
                        <div class="col-md-8">
                        	<?php if($event->host == Auth::id()) { ?>
                        	<strong>You!</strong>
                        	<?php } else { ?>
                            <?php echo $event->creator->full_name; ?>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group clearfix">
                        <label class="col-md-4 control-label">Start time</label>
                        <div class="col-md-8">
                            <?php echo $event->start_time_friendly; ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label">End time</label>
                        <div class="col-md-8">
                            <?php echo $event->end_time_friendly; ?>
                        </div>
                    </div> 
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                        	<?php if($event->host == Auth::id()) { ?>
	                            <a class="btn btn-primary" href="<?php echo url('events/edit', $parameters = ['id' => $event->id], $secure = null); ?>">Edit</a>	                            
	                        <?php } ?>
                        </div>
                    </div>                  
                </div>
            </div>
        </div>
    </div>
</div>
 
@endsection