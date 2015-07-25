// Angular apps
var eventApp = angular.module('eventApp', ['mainCtrl', 'eventService'], function($interpolateProvider){
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});