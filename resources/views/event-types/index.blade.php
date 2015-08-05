@extends('app')
 
@section('content')
 
<div class="container-fluid" ng-app="eventTypeApp" ng-controller="eventTypesController">
        <div class="row">
            <div class="cold-md-12 text-center">
                <h1>My Events Types</h1>
            </div>
            <div ng-hide="loading" ng-repeat="eventType in eventsTypes">
                <!-- Event panel -->
            <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center"><strong><% eventType.title %></strong></div>
                        <div class="panel-body">
                            <div class="form-group clearfix">
                                <!-- Description -->
                                <label class="col-md-4">Description</label>
                                <div class="col-md-8"><% eventType.description %></div>
                            </div>
                            <div class="form-group clearfix">
                                <!-- Capacity -->
                                <label class="col-md-4">Capacity</label>
                                <div class="col-md-8"><% eventType.capacity == 0 ? 'unlimited': eventType.capacity %></div>
                            </div>
                            <!-- Buttons -->
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <!-- Create event from -->
                                    <a class="btn btn-primary" href="/events/create/<% eventType.id %>">Create event</a>
                                    <!-- Edit event type -->
                                    <a class="btn btn-primary" href="/eventsTypes/edit/<% eventType.id %>">Edit</a>
                                    <!-- Delete event type -->
                                    <a class="btn btn-danger" href="#" ng-click="deleteEventType(eventType.id)" class="text-muted">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@section('view.scripts')
<script type="text/javascript">                             
    $(function () {
    });
</script>
@endsection 
@endsection