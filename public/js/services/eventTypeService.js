angular.module('eventTypeService', [])

.factory('EventType', function($http) {

    return {
        // get all the event types
        get : function() {

            return $http.get('/api/eventTypes'); 
        },
        // save an event (pass in event data)
        save : function(eventTypeData) {
            return $http({
                method: 'POST',
                url: '/api/eventTypes',
                withCredentials: true,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(eventTypeData)
            });
        },
        // update an event type
        update: function(eventTypeData) {
            return $http({
                method: 'POST',
                withCredentials: true,
                url: '/api/eventTypes/edit/' + eventTypeData.id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(eventTypeData)
            });
        },
        // destroy an event type
        destroy : function(id) {
            return $http({
                method: 'POST',
                withCredentials: true,
                url: '/api/eventTypes/delete/' + id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
            });
        }
    }

});