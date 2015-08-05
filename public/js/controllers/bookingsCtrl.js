
angular.module('bookingsCtrl', [])

// inject the Booking service into our controller
.controller('bookingsController', function($scope, $http, $location, Booking) {
    // object to hold all the data for the service form
    $scope.bookingData = {};

    // loading variable to show the spinning loading icon
    $scope.loading = true;

    // Get the event id from the URL
    $scope.eventId = $location.path().split("/")[2];

    // get all the bookings first and bind it to the $scope.bookings object
    // use the function we created in our service
    // GET ALL BOOKINGS ==============
    $scope.getBookings = function(id) {
        $scope.loading = true;

        Booking.get(id)
        .success(function(data) {
            $scope.bookings = data;
            $scope.loading = false;
        });
    }

    // Display all upcoming events types
    $scope.getBookings($scope.eventId);

    // function to handle kicking a user from an event
    // KICK A USER ====================================================
    $scope.kickUser = function(id) {
        $scope.loading = true; 

        // use the function we created in our service
        Booking.kick(id)
            .success(function(data) {

                // if successful, we'll need to refresh the events types list
                Booking.get()
                    .success(function(getData) {
                        $scope.bookings = getData;
                        $scope.loading = false;
                        $.notify({
                            // options
                            message: 'User successfully kicked from the event!' 
                        },{
                            // settings
                            type: 'success'
                        });
                    });

            })
            .error(function(data, status, headers, config){
                $scope.loading = false;
                $.notify({
                    // options
                    message: data 
                },{
                    // settings
                    type: 'danger'
                });
            });
    };
});