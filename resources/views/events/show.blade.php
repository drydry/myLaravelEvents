@extends('app')
 
@section('content')
 
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
        	<form class="form-horizontal" role="form" method="POST" action="/events/delete/<?php echo $event->id ?>">
        		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	            <div class="panel panel-default">
	                <div class="panel-heading">Event details</div>
	                <div class="panel-body">
	                	@if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
	                    <div class="form-group clearfix">
	                        <label class="col-md-4 control-label">Title</label>
	                        <div class="col-md-8">
	                        	<?php echo $event->title; ?>
	                        </div>
	                    </div>

	                    <div class="form-group clearfix">
                            <label class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                {{ $event->description }}
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <label class="col-md-4 control-label">Capacity</label>
                            <div class="col-md-6">
                                {{ $event->capacity }}
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

	                    <div class="form-group clearfix">
	                        <label class="col-md-4 control-label">End time</label>
	                        <div class="col-md-8">
	                            <?php echo $event->end_time_friendly; ?>
	                        </div>
	                    </div> 
	                    <div class="form-group">
	                        <div class="col-md-8 col-md-offset-4">
	                        	<?php if($event->host == Auth::id()) { ?>
		                            <a class="btn btn-primary" href="<?php echo url('events/edit', $parameters = ['id' => $event->id], $secure = null); ?>">Edit</a>
		                            <button type="submit" class="btn btn-danger">Delete</button>	                            
		                        <?php } ?>
	                        </div>
	                    </div>                  
	                </div>
	            </div>
	        </form>
        </div>
    </div>
</div>
 
@endsection