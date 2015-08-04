// Angular apps
var eventApp = angular.module('eventApp', ['eventCtrl', 'eventService'], function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});