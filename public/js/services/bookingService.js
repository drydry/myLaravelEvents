angular.module('bookingService', [])

.factory('Booking', function($http) {

    return {
        // get all the bookings
        get : function(id) {
            return $http.get('/api/events/' + id + '/bookings'); 
        },
        // kick a user from an event
        kick : function(id) {
            return $http({
                method: 'POST',
                url: '/api/bookings/kick/'+ id,
                withCredentials: true,
                headers: { 'Content-Type' : 'application/x-www-form-urlencoded' }
            });
        }
    }

});