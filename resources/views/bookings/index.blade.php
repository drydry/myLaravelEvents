@extends('app')
 
@section('content')
 
<div class="container-fluid" ng-app="bookingApp" ng-controller="bookingsController">
        <div class="row">
            <div class="cold-md-12 text-center">
                <h1 ng-if="bookings.length > 0"><% bookings[0].event_data.title %></h1>
                <h1 ng-if="bookings.length ==0">No bookings</h1>
            </div>
            <div ng-hide="loading" ng-repeat="booking in bookings">
                <!-- Event panel -->
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center"><strong><% booking.user.full_name %></strong></div>
                        <div class="panel-body">
                            <div class="form-group clearfix">
                                <!-- Description -->
                                <label class="col-md-4">Booked on</label>
                                <div class="col-md-8"><%  booking.updated_at | amDateFormat:'YYYY/DD/MM @ hh:mm' %></div>
                            </div>
                            <!-- Buttons -->
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <!-- Kick user -->
                                    <a class="btn btn-danger" href="#" ng-click="kickUser(booking.id)">Kick user</a>                            
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