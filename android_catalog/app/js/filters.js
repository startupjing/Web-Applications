'use strict';

/* Filters */

angular.module('phonecatFilters', []).filter('checkmark', function() {
  return function(input) {
    return input ? '\u2713' : '\u2718';
  };
});


angular.module('phonepageFilters', []).filter('offset', function() {
  return function(input, start) {
      start = parseInt(start, 10);
      return input.slice(start);
  };
});



angular.module('phonecompareFilters', []).filter('isAvailable', function() {
  return function(input) {
     return input ? input : 'not available';
  };
});









