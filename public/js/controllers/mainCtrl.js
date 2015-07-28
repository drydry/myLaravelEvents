angular.module('mainCtrl', [])

// inject the Event service into our controller
.controller('mainController', function($scope, $http, Event) {
    // object to hold all the data for the new event form
    $scope.eventData = {};

    // loading variable to show the spinning loading icon
    $scope.loading = true;

    // Hosted checkbox values
    $scope.checkboxHostedModel = {
       value0 : 0,
       value1 : 1
     };

    // Set the value for displaying all events
    $scope.hostedEvents = $scope.checkboxHostedModel.value0;
        

    // get all the events first and bind it to the $scope.events object
    // use the function we created in our service
    // GET ALL EVENTS ==============
    $scope.getEvents = function(hosted) {
        $scope.loading = true;
        Event.get(hosted)
        .success(function(data) {
            $scope.events = data;
            $scope.loading = false;
        });
    }

    // Display all events
    $scope.getEvents($scope.checkboxHostedModel.value0);

    // function to handle submitting the form
    // SAVE AN EVENT ================
    $scope.saveEvent = function() {
        $scope.loading = true;

        // save the event. pass in event data from the form
        // use the function we created in our service
        Event.save($scope.eventData)
            .success(function(data) {

                // if successful, we'll need to refresh the events list
                Event.get()
                    .success(function(getData) {
                        $scope.events = getData;
                        $scope.loading = false;
                    });

            })
            .error(function(data) {
                console.log(data);
            });
    };

    // function to handle deleting an event
    // DELETE AN EVENT ====================================================
    $scope.deleteEvent = function(id) {
        $scope.loading = true; 

        // use the function we created in our service
        Event.destroy(id)
            .success(function(data) {

                // if successful, we'll need to refresh the event list
                Event.get()
                    .success(function(getData) {
                        $scope.events = getData;
                        $scope.loading = false;
                    });

            })
            .error(function(data, status, headers, config){
                $scope.loading = false;
                alert(data);
            });
    };

    // function to handle booking an event
    // BOOK AN EVENT ====================================================
    $scope.bookEvent = function(id) {
        $scope.loading = true;
        
        // use the function we created in our service
        Event.book(id)
            .success(function(data){
                // if successful, we display all the events
                Event.get()
                    .success(function(getData){
                        $scope.events = getData;
                        $scope.loading = false;
                    });
            })
            .error(function(data, status, headers, config){
                $scope.loading = false;
                alert(data);
            });
    }
});