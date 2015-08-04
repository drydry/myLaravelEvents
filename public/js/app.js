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