angular.module('eventCtrl', [])

// inject the Event service into our controller
.controller('eventController', function($scope, $http, Event) {
    // object to hold all the data for the new event form
    $scope.eventData = {};

    // loading variable to show the spinning loading icon
    $scope.loading = true;

    // Hosted checkbox values
    $scope.eventsType = {
       upcoming : 'upcoming',
       booked :   'booked',
       hosted :   'hosted'
     };

    // event tabs
    $scope.tabs = [{
            title: 'Upcoming events',
            type: $scope.eventsType.upcoming
        }, {
            title: 'Booked events',
            type: $scope.eventsType.booked
        }, {
            title: 'Hosted events',
            type: $scope.eventsType.hosted
    }];

    $scope.currentTab = $scope.eventsType.upcoming;
    $scope.currentTitle = $scope.tabs[0].title;

    $scope.onClickTab = function (tab) {
        $scope.currentTab = tab.type;
        $scope.currentTitle = tab.title;
        $scope.getEvents(tab.type);
    }
    
    $scope.isActiveTab = function(tabType) {
        return tabType == $scope.currentTab;
    }    

    // get all the events first and bind it to the $scope.events object
    // use the function we created in our service
    // GET ALL EVENTS ==============
    $scope.getEvents = function(eventType) {
        $scope.loading = true;

        Event.get(eventType)
        .success(function(data) {
            $scope.events = data;
            $scope.loading = false;
        });
    }

    // Display all upcoming events
    $scope.getEvents($scope.eventsType.upcoming);

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
                $.notify({
                    // options
                    message: 'Event successfully created!' 
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

    // function to handle deleting an event
    // DELETE AN EVENT ====================================================
    $scope.deleteEvent = function(id) {
        $scope.loading = true; 

        // use the function we created in our service
        Event.destroy(id)
            .success(function(data) {

                // if successful, we'll need to refresh the event list
                Event.get($scope.eventsType.hosted)
                    .success(function(getData) {
                        $scope.events = getData;
                        $scope.loading = false;
                        $.notify({
                            // options
                            message: 'Event successfully deleted!' 
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

    // function to handle booking an event
    // BOOK AN EVENT ====================================================
    $scope.bookEvent = function(id) {
        $scope.loading = true;
        
        // use the function we created in our service
        Event.book(id)
            .success(function(data){
                // if successful, we display all the events
                Event.get($scope.eventsType.upcoming)
                    .success(function(getData){
                        $scope.events = getData;
                        $scope.loading = false;
                    });
                $.notify({
                    // options
                    message: 'Event successfully booked!' 
                },{
                    // settings
                    type: 'success'
                });
            })
            .error(function(data, status, headers, config){
                $scope.loading = false;
                // Displays the first error message
                $.notify({
                    // options
                    message: data[Object.keys(data)[0]][0] 
                },{
                    // settings
                    type: 'danger'
                });
            });
    }

    // function to handle unbooking an event
    // BOOK AN EVENT ====================================================
    $scope.unbookEvent = function(id) {
        $scope.loading = true;
        
        // use the function we created in our service
        Event.unbook(id)
            .success(function(data){
                // if successful, we display all the events
                Event.get($scope.eventsType.booked)
                    .success(function(getData){
                        $scope.events = getData;
                        $scope.loading = false;
                    });
                $.notify({
                    // options
                    message: 'Event successfuly unbooked!' 
                },{
                    // settings
                    type: 'success'
                });
            })
            .error(function(data, status, headers, config){
                $scope.loading = false;
                // Displays the first error message
                $.notify({
                    // options
                    message: data[Object.keys(data)[0]][0] 
                },{
                    // settings
                    type: 'success'
                });
            });
    };
});