@extends('app')
 
@section('content')
 
<div class="container-fluid" ng-app="eventApp" ng-controller="mainController">
        <div class="row">

        <div class="cold-md-12 text-center">
            <h1>Upcoming Events</h1>
        </div>

        <ul class="nav nav-tabs">
          <li role="events" class="active"><a href="#" ng-click="getEvents(eventsType.upcoming)">Upcoming events</a></li>
          <li role="events"><a href="#" ng-click="getEvents(eventsType.booked)">Booked events</a></li>
          <li role="events"><a href="#" ng-click="getEvents(eventsType.hosted)">Hosted events</a></li>
        </ul>

        <div ng-hide="loading" ng-repeat="event in events">
            <!-- Event panel -->
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading text-center"><strong><% event.title %></strong> - hosted by <% event.creator.full_name %></div>
                    <div class="panel-body">
                        <div class="form-group clearfix">
                            <!-- Occupancy -->
                            <label class="col-md-4">Occupancy</label>
                            <div class="col-md-8"><% event.bookings.length %> / <% event.capacity == 0 ? 'unlimited': event.capacity %></div>
                        </div>
                        <!-- Start time -->
                        <div class="form-group clearfix">
                            <label class="col-md-4">Start time</label>
                            <div class="col-md-8"><% event.start_time_friendly %></div>
                        </div>
                        <!-- End time -->
                        <div class="form-group">
                            <label class="col-md-4">End time</label>
                            <div class="col-md-8"><% event.end_time_friendly %></div>
                        </div>
                        <!-- Buttons -->
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <!-- Show event details -->
                                <a class="btn btn-primary" href="/events/show/<% event.id %>">View details</a>
                                <!-- Delete event -->
                                <a class="btn btn-danger" href="#" ng-click="deleteEvent(event.id)" class="text-muted">Delete</a>
                                <!-- Book event -->
                                <a class="btn btn-success" href="#" ng-click="bookEvent(event.id)" class="text-muted">Book!</a>
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
        /*$("[name='hostedEvents']").bootstrapSwitch();
        $(".bootstrap-switch-id-switchEventsList").attr('ng-model', 'checkboxHostedModel.value1');
        $(".bootstrap-switch-id-switchEventsList").attr('ng-click', 'toggleHosted(checkboxHostedModel.value1)');
        */
    });
</script>
@endsection 
@endsection