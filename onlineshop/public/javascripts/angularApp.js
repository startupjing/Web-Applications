//variabless
var app = angular.module('onlineShop', ['ui.router']);
var cart_items =  [];
var user_balance = 100;
var wish_list = [];
var transaction_history = [];
var shopping_plan = [];
var shopping_news = ["Fruits shop are selling cheap apples and bananas", "New-style clothing on sale", "New brands sold in Outdoors Category"];


//application configuration
//declare states
app.config([
'$stateProvider',
'$urlRouterProvider',
function($stateProvider, $urlRouterProvider) {
    $stateProvider
         //welcome
        .state('welcome', {
            url: '/welcome',
            templateUrl: '/welcome.html',
            controller: 'WelcomeCtrl'
        })

        //home page
        .state('home', {
            url: '/home',
            templateUrl: '/home.html',
            controller: 'MainCtrl',
            resolve: {
                shopPromise: ['shops', function(shops){
                    return shops.getAll();
                }]
            }
        })
        

        //shop page
        .state('shops', {
            url: '/shops/{id}',
            templateUrl: '/shop_items.html',
            controller: 'ShopItemsCtrl',
            resolve: {
                shop: ['$stateParams', 'shops', function($stateParams, shops) {
                    return shops.get($stateParams.id);
                }]
            }
        })

        //shop edit
        .state('shops/:shop/edit_shop', {
            url: '/shops/{id}/edit_shop',
            templateUrl: '/edit_shop.html',
            controller: 'EditShopCtrl',
            resolve: {
                shop: ['$stateParams', 'shops', function($stateParams, shops) {
                    return shops.get($stateParams.id);
                }]
            }
        })
        
        //login page
        .state('login', {
            url: '/login',
            templateUrl: '/login.html',
            controller: 'AuthCtrl',
            onEnter: ['$state', 'auth', function($state, auth){
                if(auth.isLoggedIn()){
                    console.log("inside login account");
                    $state.go('home');
                }
            }]
        })


        //register page
        .state('register', {
            url: '/register',
            templateUrl: '/register.html',
            controller: 'AuthCtrl',
            onEnter: ['$state', 'auth', function($state, auth){
                if(auth.isLoggedIn()){
                    $state.go('home');
                }
            }]
        })
        

        //account page
        .state('account', {
            url: '/account',
            templateUrl: '/account.html',
            controller: 'AccountCtrl'
        })

        //shopping cart page
        .state('cart', {
            url: '/cart',
            templateUrl: '/cart.html',
            controller: 'CartCtrl'
        })

    $urlRouterProvider.otherwise('home');
}])


//main page controller
app.controller('MainCtrl', ['$scope','shops', 'auth',
function($scope, shops, auth){

    $scope.shops = shops.shops;
    $scope.isLoggedIn = auth.isLoggedIn;
    

    //add a shop
    $scope.addShop = function(){
        if(!$scope.shop_name || $scope.shop_name === '') { return; }
        shops.create({
            shop_name: $scope.shop_name,
            shop_category: $scope.shop_category,
            shop_description: $scope.shop_description,
            
        });
        $scope.shop_name = '';
        $scope.shop_category = '';
        $scope.shop_description = '';
    };

    //check shop owner
    $scope.isShopOwner = function(shop){
        console.log("shop onwer: " + shop.shop_owner);
        console.log("currentUser: " + auth.currentUser());
        return shop.shop_owner === auth.currentUser();
    }
    

    //like or dislike shops
    $scope.incrementUpvotes = function(shop) {
        shops.upvote(shop);
    };
    $scope.decrementUpvotes = function(shop) {
        shops.downvote(shop);
    };
 
}])


//shop page controller
app.controller('ShopItemsCtrl', ['$scope','shop', 'shops', 'auth', '$location',
function($scope, shop, shops, auth, $location){
    $scope.shop = shop;
    $scope.isOwner = (shop.shop_owner === auth.currentUser());
    $scope.isLoggedIn = auth.isLoggedIn;
   
    //add item to shop
    $scope.addItem = function() {
        if(!$scope.item_name || $scope.item_name === '') { return; }
        shops.addItem(shop._id, {
            item_name: $scope.item_name,
            item_description: $scope.item_description,
            item_quantity: $scope.item_quantity,
            item_price: $scope.item_price
        }).success(function(item) {
            $scope.shop.shop_items.push(item);
        });
        $scope.item_name = '';
        $scope.item_description = '';
        $scope.item_quantity = '';
        $scope.item_price = '';
    };

    //edit item in shop
    $scope.editItem = function(){
        console.log("shop id: " + shop._id);
        console.log("item id: " + $scope.edit_item_id);
        console.log("item id: " + $scope.edit_item_description);
        shops.editItem(shop._id, $scope.edit_item_id, $scope.edit_item_description, $scope.edit_item_quantity, $scope.edit_item_price).success(function(){
               $scope.edit_item_description = "";
               $scope.edit_item_quantity = "";
               $scope.edit_item_price = "";
               $scope.edit_item_id = "";
               $location.url('/home');
        });
    };

    //delete item in shop
    $scope.deleteItem = function(){
        shops.deleteItem(shop._id, $scope.delete_item_id).success(function(){
            console.log("item delete success");
            $location.url('/home');
        });
    };

    //add item to shoppping cart
    $scope.add_item_cart = function(item){
        cart_items.push({qty: 1, description: item.item_name, cost: item.item_price});
    };



    //add item to wishlist
    $scope.add_wish_list = function(item){
        wish_list.push({item_name: item.item_name, item_description: item.item_description});

    };
    

    //like or dislike item
    $scope.incrementItemUpvotes = function(item) {
        shops.upvoteItem(shop,item);
    };
    $scope.decrementItemUpvotes = function(item) {
        shops.downvoteItem(shop,item);
    };

    $scope.orderProp = 'upvotes';
     
     //add comments
     $scope.addComment = function() {
        // prevent user from submitting a post with a blank title
        if(!$scope.body || $scope.body === '') { return; }
        shops.addComment(shop._id, {
            body: $scope.body
        }).success(function(comment) {
            //push into the array of items in a certain shop
            $scope.shop.shop_comments.push(comment);
        });
        $scope.body = '';
    };
    

    //like or dislike comments
    $scope.incrementCommentUpvotes = function(comment) {
        shops.upvoteComment(shop,comment);
    };
    $scope.decrementCommentUpvotes = function(comment) {
        shops.downvoteComment(shop,comment);
    };
}])



//shop factory service
app.factory('shops', ['$http', 'auth', function($http, auth){
    var o = {
        shops: []

    };
    
    //get all shops
    o.getAll = function() {
        return $http.get('/shops').success(function(data){
            angular.copy(data, o.shops);
        });
    };

    //create a shop
    o.create = function(shop) {
        return $http.post('/shops', shop, {
            headers: {Authorization: 'Bearer ' + auth.getToken()}
        }).success(function(data){
            o.shops.push(data);
        });
    };

    //like or dislike a shop
    o.upvote = function(shop) {
        return $http.put('/shops/' + shop._id + '/upvote')
            .success(function(data){
                shop.star += 1;
                shop.shop_name = 'changename';
                console.log("change name : " + shop.shop_name);
            });
    };


    o.downvote = function(shop) {
        return $http.put('/shops/' + shop._id + '/downvote')
            .success(function(data){
                shop.star -= 1;
            });
    };

    //get a shop
    o.get = function(id) {
        return $http.get('/shops/' + id).then(function(res){
            return res.data;
        });
    };

    //add item to a shop
    o.addItem = function(id, item) {
        return $http.post('/shops/' + id + '/items', item);
    };

    
    //like or dislike an item
    o.upvoteItem = function(shop, item) {
        return $http.put('/shops/' + shop._id + '/items/' + item._id + '/upvote')
            .success(function(data){
                item.upvotes += 1;
            });
    };


    o.downvoteItem = function(shop, item) {
        return $http.put('/shops/' + shop._id + '/items/' + item._id + '/downvote')
            .success(function(data){
                item.upvotes -= 1;
            });
    };

    
    //add comments in a shop
    o.addComment = function(id, comment) {
        return $http.post('/shops/' + id + '/comments', comment);
    };

    
    //like or dislike a comment
    o.upvoteComment = function(shop, comment) {
        return $http.put('/shops/' + shop._id + '/comments/' + comment._id + '/upvote')
            .success(function(data){
                comment.upvotes += 1;
            });
    };

    o.downvoteComment = function(shop, comment) {
        return $http.put('/shops/' + shop._id + '/comments/' + comment._id + '/downvote')
            .success(function(data){
                comment.upvotes -= 1;
            });
    };
    

    //edit item
    o.editItem = function(shopid, itemid, edit_item_description, edit_item_quantity, edit_item_price) {
        return $http.put('/shops/' + shopid + '/' + itemid + '/' + edit_item_description + '/' + edit_item_quantity + '/' + edit_item_price);
    };
    

    //edit shop
    o.editShop = function(id, new_shop_name, new_shop_description, new_shop_category) {
        return $http.put('/shops/' + id + '/' + new_shop_name + '/' + new_shop_description + '/' + new_shop_category);
       
    };

    //delete an item
    o.deleteItem = function(shopid, itemid) {
        return $http.delete('/shops/' + shopid + '/deleteItem/' + itemid);
    };



    //delete a shop
    o.deleteShop = function(id) {
        return $http.delete('/shops/' + id + '/delete');
    };



    return o;
}])


//user factory service
app.factory('auth', ['$http', '$window', function($http, $window){
   var auth = {};

   //save user token
   auth.saveToken = function (token){
        $window.localStorage['shopping-token'] = token;
   };
    

    //get user token
    auth.getToken = function (){
      return $window.localStorage['shopping-token'];
    }
    

    //check if user is logged in
    auth.isLoggedIn = function(){
      var token = auth.getToken();

      if(token){
        var payload = JSON.parse($window.atob(token.split('.')[1]));
        return payload.exp > Date.now() / 1000;
      } else {
        return false;
      }
    };
    

    //get current username
    auth.currentUser = function(){
      if(auth.isLoggedIn()){
        var token = auth.getToken();
        var payload = JSON.parse($window.atob(token.split('.')[1]));

        return payload.username;
      }
    };
    

    //register a new user
    auth.register = function(user){
      return $http.post('/register', user).success(function(data){
           auth.saveToken(data.token);
      });
    };
    

    //login a new user
    auth.logIn = function(user){
      return $http.post('/login', user).success(function(data){
          auth.saveToken(data.token);
      });
    };
    

    //logout user
    auth.logOut = function(){
      $window.localStorage.removeItem('shopping-token');
    };



  return auth;
}])


//user controller
app.controller('AuthCtrl', ['$scope','$state','auth',
    function($scope, $state, auth){
        $scope.user = {};
        
        //register a new user
        $scope.register = function(){
            auth.register($scope.user).error(function(error){
                $scope.error = error;
            }).then(function(){
                $state.go('home');
            });
        };
        

        //login user
        $scope.logIn = function(){
            auth.logIn($scope.user).error(function(error){
                $scope.error = error;
            }).then(function(){
                $state.go('home');
            });
        };

}])


//navigation controller
app.controller('NavCtrl', ['$scope','auth',
function($scope, auth){
   $scope.isLoggedIn = auth.isLoggedIn;
   $scope.currentUser = auth.currentUser;
   $scope.logOut = auth.logOut;
}])

//welcome page controller
app.controller('WelcomeCtrl', ['$scope',
function($scope){
    $scope.shopping_news = shopping_news;
  
}])

//account controller
app.controller('AccountCtrl', ['$scope',
    function($scope){
        $scope.wish_list = wish_list;
        $scope.transaction_history = transaction_history;


        $scope.addNews = function(){
            shopping_news.push($scope.shop_news);
            $scope.shop_news = '';
        };

}])




//shopping cart controller
app.controller('CartCtrl', ['$scope', 
    function($scope){
        $scope.invoice ={items: cart_items};
 
        $scope.balance = user_balance;
        

        //remove item from cart
        $scope.removeItem = function(index) {
            $scope.invoice.items.splice(index, 1);
        },


        //checkout the shopping cart
        $scope.checkout = function(){
            $scope.balance -= $scope.total();
            user_balance = $scope.balance;

            
            for(var i=0; i<cart_items.length; ++i){

                transaction_history.push( {item_name:cart_items[i].description});
                
            }

            cart_items = [];
            $scope.invoice = {items: cart_items};

        },
        
        //compute total cost in shopping cart
        $scope.total = function() {
            var total = 0;
            angular.forEach($scope.invoice.items, function(item) {
                total += item.qty * item.cost;
            })
     
            return total;
        },
        

        //add balance to account
        $scope.addBal = function(){
            $scope.balance += $scope.value_add;
            user_balance = $scope.balance;
        }
    
}])


//shop controller
app.controller('EditShopCtrl', ['$scope','shop', 'shops', '$location',
function($scope, shop, shops, $location){
    $scope.shop = shop;
    
    //edit a shop
    $scope.editShop = function(){
        shops.editShop(shop._id, $scope.shop_name, $scope.shop_category, $scope.shop_description).success(function(){
            $scope.shop_name = '';
            $scope.shop_category = '';
            $scope.shop_description = '';
            $location.url('/home');
        });
    }
    

    //delete a shop
    $scope.deleteShop = function(){
        shops.deleteShop(shop._id).success(function(){
            console.log("delete shop success");
            $location.url('/home');
        });
    }

}])

//shopping plan controller
app.controller('CartForm', ['$scope', 
    function($scope){
        $scope.invoice = {
        items: [
            {
                id: 1,
                qty: 10,
                name: 'T-shirt',
                cost: 9.53
            },
            {
                id: 2,
                qty: 5,
                name: 'Apples',
                cost: 4.55

            }
        ]
    };
    

    //add new item to plan
    $scope.addItem = function() {
        $scope.invoice.items.push({
            qty: 1,
            name: '',
            cost: 0
        });
    };
    
    //increase or decrease item quantity  
    $scope.increase = function(item) {
        var items = $scope.invoice.items;
        
        for(var i=0; items.length; i++){
            if(items[i].id === item.id){
                items[i].qty += 1;
            }
        }
    };
    
    $scope.decrease = function(item) {
        var items = $scope.invoice.items;
        
        for(var i=0; items.length; i++){
            if(items[i].id === item.id){
                items[i].qty -= 1;
            }
        }
    };
    
    //remove item from cart 
    $scope.removeItem = function(index) {
        $scope.invoice.items.splice(index, 1);
    };
    

    //compute total cost
    $scope.total = function() {
        var total = 0;
        angular.forEach($scope.invoice.items, function(item) {
            total += item.qty * item.cost;
        });

        return total;
    }
    
}])


