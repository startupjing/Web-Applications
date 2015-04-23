'use strict';

/* App Module */

var phonecatApp = angular.module('phonecatApp', [
  'ngRoute',
  'phonecatAnimations',
  'phonecompareFilters',
  'phonecatControllers',
  'phonecatFilters',
  'phonecatServices',
  'phonepageFilters'
]);

phonecatApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/phones', {
        templateUrl: 'partials/phone-list.html',
        controller: 'PhoneListCtrl'
      }).

      when('/phones-paging', {
        templateUrl: 'partials/phone-page.html',
        controller: 'PhonePagingCtrl'
      }).

      when('/phones/:phoneId', {
        templateUrl: 'partials/phone-detail.html',
        controller: 'PhoneDetailCtrl'
      }).
      when('/phones/compare/:phoneId1/:phoneId2', {
        templateUrl: 'partials/phone-compare.html',
        controller: 'PhoneCompareCtrl'
      }).
      when('/phones/compare/:phoneId1/:phoneId2/:phoneId3', {
        templateUrl: 'partials/phone-compare3.html',
        controller: 'PhoneCompareCtrl3'
      }).
      
      otherwise({
        redirectTo: '/phones'
      });
  }]);
