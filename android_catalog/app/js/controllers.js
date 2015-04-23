'use strict';

/* Controllers */

var phonecatControllers = angular.module('phonecatControllers', []);


phonecatControllers.controller('PhoneListCtrl', ['$scope', 'Phone',
  function($scope, Phone) {
    $scope.phones = Phone.query(function(phones){
      phones.forEach(function(phone){
        Phone.get({  phoneId: phone.id}, function(detail){
         phone.screenSize = parseFloat(detail.display.screenSize);
         console.log(detail.storage.ram);
         if(detail.storage.ram == "" || detail.storage.ram == null){
          phone.ram = 99999;
        }else{
          phone.ram = parseInt(detail.storage.ram);
          phone.ramdisp = parseInt(detail.storage.ram);
        }
        phone.weight = parseFloat(detail.sizeAndWeight.weight);
        if(detail.storage.flash == "" || detail.storage.flash == null){ 
          phone.internalStorage = 99999;
        }else{
          phone.internalStorage = parseInt(detail.storage.flash);
          phone.internaldisp = parseInt(detail.storage.flash);
        }
      })
      })
    } );
    $scope.orderProp = 'age';
  }]);




phonecatControllers.controller('PhonePagingCtrl', ['$scope', 'Phone',
  function($scope, Phone) {
    $scope.phones = Phone.query(function(phones){

    	phones.forEach(function(phone){
                Phone.get({  phoneId: phone.id}, function(detail){
                 phone.screenSize = parseFloat(detail.display.screenSize);
                 console.log(detail.storage.ram);
                 if(detail.storage.ram == "" || detail.storage.ram == null){
                    phone.ram = 99999;
                }else{
                        phone.ram = parseInt(detail.storage.ram);
                        phone.ramdisp = parseInt(detail.storage.ram);
                }
                 phone.weight = parseFloat(detail.sizeAndWeight.weight);
                 if(detail.storage.flash == "" || detail.storage.flash == null){ 
                    phone.internalStorage = 99999;
                   }else{
                        phone.internalStorage = parseInt(detail.storage.flash);
                        phone.internaldisp = parseInt(detail.storage.flash);
                }
              })
      })
    });


    $scope.itemsPerPage = 5;
    $scope.currentPage = 0;
    $scope.orderProp = 'age';

    $scope.range = function() {
      var rangeSize = 5;
      var ret = [];
      var start;

      start = $scope.currentPage;

      if ( start > $scope.pageCount()-rangeSize ) {
          start = $scope.pageCount()-rangeSize+1;
      }

      for (var i=start; i<start+rangeSize; i++) {
           ret.push(i);
      }
      return ret;
    };

    $scope.prevPage = function() {
      if ($scope.currentPage > 0) {
        $scope.currentPage--;
      }
    };

    $scope.prevPageDisabled = function() {
      return $scope.currentPage === 0 ? "disabled" : "";
    };

    $scope.pageCount = function() {
      return Math.ceil($scope.phones.length/$scope.itemsPerPage)-1;
    };

    $scope.nextPage = function() {
      if ($scope.currentPage < $scope.pageCount()) {
        $scope.currentPage++;
      }
    };

    $scope.nextPageDisabled = function() {
      return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
    };

    $scope.setPage = function(n) {
      $scope.currentPage = n;
    };


  }]);

phonecatControllers.controller('PhoneCompareCtrl', ['$scope', '$routeParams', 'Phone',
  
  function($scope, $routeParams, Phone) {
    $scope.phone1 = Phone.get( { phoneId: $routeParams.phoneId1 }, function(phone1) {
    });

    $scope.phone2 = Phone.get( { phoneId: $routeParams.phoneId2 }, function(phone2) {
    });
}]);


phonecatControllers.controller('PhoneCompareCtrl3', ['$scope', '$routeParams', 'Phone',
  
  function($scope, $routeParams, Phone) {
    $scope.phone1 = Phone.get( { phoneId: $routeParams.phoneId1 }, function(phone1) {
    });

    $scope.phone2 = Phone.get( { phoneId: $routeParams.phoneId2 }, function(phone2) {
    });

    $scope.phone3 = Phone.get( { phoneId: $routeParams.phoneId3 }, function(phone2) {
    });
}]);



phonecatControllers.controller('PhoneDetailCtrl', ['$scope', '$routeParams', 'Phone',
  function($scope, $routeParams, Phone) {
    $scope.phone = Phone.get({phoneId: $routeParams.phoneId}, function(phone) {
      $scope.mainImageUrl = phone.images[0];
    });

    $scope.setImage = function(imageUrl) {
      $scope.mainImageUrl = imageUrl;
    }
  }]);
