// Event module
var eventApp = angular.module('eventApp', ['eventCtrl', 'eventService'], function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});
// Event type module
var eventTypeApp = angular.module('eventTypeApp', ['eventTypesCtrl', 'eventTypeService'], function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
}); 

var bookingApp = angular.module('bookingApp', ['angularMoment', 'bookingsCtrl', 'bookingService'], function($interpolateProvider, $locationProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
    $locationProvider.html5Mode({
	  enabled: true,
	  requireBase: false
	});
});  