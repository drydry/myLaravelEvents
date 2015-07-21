@extends('app')
 
@section('content')
 
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create event</div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
 
                    <form class="form-horizontal" role="form" method="POST" action="/events/create">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
 
                        <div class="form-group">
                            <label class="col-md-4 control-label">Title</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                            </div>
                        </div>
 
                        <div class="form-group">
                            <label class="col-md-4 control-label">Start time</label>
                            <div class="col-md-6">
                                <!--<input type="text" class="form-control" name="start_time" value="{{ old('start_time') }}">-->
                                <div class='input-group date' id='start_time'>
				                    <input type='text' class="form-control" />
				                    <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                </div>
                            </div>

                        </div>
                        <!--
                        <div class="container">
						    <div class="row">
						        <div class='col-sm-6'>
						            <div class="form-group">
						                <div class='input-group date' id='datetimepicker1'>
						                    <input type='text' class="form-control" />
						                    <span class="input-group-addon">
						                        <span class="glyphicon glyphicon-calendar"></span>
						                    </span>
						                </div>
						            </div>
						        </div>
						        <script type="text/javascript">
						            $(function () {
						                $('#datetimepicker1').datetimepicker();
						            });
						        </script>
						    </div>
						</div>
						-->
						 
                        <div class="form-group">
                            <label class="col-md-4 control-label">End time</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="end_time" value="{{ old('end_time') }}">
                            </div>
                        </div>                     
 
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('view.scripts')
<script type="text/javascript">                            	
    $(function () {
        $('#start_time').datetimepicker();
    });
</script>
@endsection 
@endsection