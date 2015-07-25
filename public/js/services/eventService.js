angular.module('eventService', [])

.factory('Event', function($http) {

    return {
        // get all the events
        get : function(hosted) {
            if(hosted == 1){
                return $http.get('/api/events?hosted=1');
            } else {
                return $http.get('/api/events');    
            }
            
        },
        // save an event (pass in event data)
        save : function(eventData) {
            return $http({
                method: 'POST',
                url: '/api/events',
                withCredentials: true,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(eventData)
            });
        },
        // update an event
        update: function(eventData) {
            return $http({
                method: 'POST',
                withCredentials: true,
                url: '/api/events/edit/' + eventData.id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' },
                data: $.param(eventData)
            });

        },
        // book an event
        book: function(id) {
            return $http({
                method: 'POST',
                withCredentials: true,
                url: '/api/events/book/' + id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
            });
        },
        // destroy an event
        destroy : function(id) {
            return $http({
                method: 'POST',
                withCredentials: true,
                url: '/api/events/delete/' + id,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
            });
        }
    }

});