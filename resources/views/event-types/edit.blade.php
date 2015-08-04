@extends('app')
 
@section('content')
 
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Edit event type</div>
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
 
                    <form class="form-horizontal" role="form" method="POST" action="/api/eventTypes/update/{{$eventType->id}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
 
                        <div class="form-group">
                            <label class="col-md-4 control-label">Title</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="title" value="{{ $eventType->title }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Description</label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="description">{{ $eventType->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Capacity</label>
                            <div class="col-md-6">
                                <input id="capacity" type="text" class="form-control" name="capacity" value="{{ $eventType->capacity }}">
                            </div>
                        </div>           
 
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
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
        $("#capacity").TouchSpin();
    });
</script>
@endsection 
@endsection