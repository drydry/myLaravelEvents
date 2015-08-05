angular.module('eventTypesCtrl', [])

// inject the Event type service into our controller
.controller('eventTypesController', function($scope, $http, EventType) {
    // object to hold all the data for the new event form
    $scope.eventTypesData = {};

    // loading variable to show the spinning loading icon
    $scope.loading = true;  

    // get all the events types first and bind it to the $scope.events object
    // use the function we created in our service
    // GET ALL EVENTS TYPES ==============
    $scope.getEventsTypes = function() {
        $scope.loading = true;

        EventType.get()
        .success(function(data) {
            $scope.eventsTypes = data;
            $scope.loading = false;
        });
    }

    // Display all upcoming events types
    $scope.getEventsTypes();

    // function to handle submitting the form
    // SAVE AN EVENT TYPE ================
    $scope.saveEventType = function() {
        $scope.loading = true;

        // save the event type. pass in event data from the form
        // use the function we created in our service
        EventType.save($scope.eventTypesData)
            .success(function(data) {

                // if successful, we'll need to refresh the events types list
                EventType.get()
                    .success(function(getData) {
                        $scope.eventsTypes = getData;
                        $scope.loading = false;                        
                    });
                $.notify({
                    // options
                    message: 'Event type successfully created!' 
                },{
                    // settings
                    type: 'success'
                });

            })
            .error(function(data) {
                console.log(data);
                $.notify({
                    // options
                    message: data 
                },{
                    // settings
                    type: 'danger'
                });
            });
    };

    // function to handle deleting an event type
    // DELETE AN EVENT TYPE ====================================================
    $scope.deleteEventType = function(id) {
        $scope.loading = true; 

        // use the function we created in our service
        EventType.destroy(id)
            .success(function(data) {

                // if successful, we'll need to refresh the events types list
                EventType.get()
                    .success(function(getData) {
                        $scope.eventsTypes = getData;
                        $scope.loading = false;
                        $.notify({
                            // options
                            message: 'Event type successfully deleted!' 
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