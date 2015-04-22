//import variables
var express = require('express');
var router = express.Router();
var passport = require('passport');


// mongoose configuration
var mongoose = require('mongoose');
var User = mongoose.model('User');
var Item = mongoose.model('Item');
var Comment = mongoose.model('Comment');
var Shop = mongoose.model('Shop');

//user authenication
var jwt = require('express-jwt');

var auth = jwt({secret: 'SECRET', userProperty: 'payload'});

// GET home page.
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});

//get shop page
router.get('/shops', function(req, res, next) {
    Shop.find(function(err, shops){
        if(err){ return next(err); }
        res.json(shops);
    });
});


//create a new shop
router.post('/shops', auth, function(req, res, next) {
    var shop = new Shop(req.body);
    shop.shop_owner = req.payload.username;

    shop.save(function(err, shop) {
        if(err){ return next(err); }
        res.json(shop);
    });
});


//encode url params
router.param('shop', function(req, res, next, id) {
    var query = Shop.findById(id);

    query.exec(function (err, shop){
        if (err) { return next(err); }
        if (!shop) { return next(new Error("can't find shop")); }

        req.shop = shop;
        return next();
    });
});


router.param('item', function(req, res, next, id) {
    var query = Item.findById(id);

    query.exec(function (err, item){
        if (err) { return next(err); }
        if (!item) { return next(new Error("can't find item")); }

        req.item = item;
        return next();
    });
});


router.param('comment', function(req, res, next, id) {
    var query = Comment.findById(id);

    query.exec(function (err, comment){
        if (err) { return next(err); }
        if (!comment) { return next(new Error("can't find comment")); }

        req.comment = comment;
        return next();
    });
});


//get item page in shop
router.get('/shops/:shop', function(req, res) {
    req.shop.populate('shop_items shop_comments', function(err, shop) {
         res.json(req.shop);
    });
});



//create a new item
router.post('/shops/:shop/items', function(req, res, next) {
    var item = new Item(req.body);
    item.shop = req.shop;

    item.save(function(err, item){
        if(err){ return next(err); }

        req.shop.shop_items.push(item);
        req.shop.save(function(err, shop) {
            if(err){ return next(err); }

            res.json(item);
        });
    });
});


//post a new comment
router.post('/shops/:shop/comments', function(req, res, next) {
    var comment = new Comment(req.body);
    comment.shop = req.shop;
    comment.save(function(err, comment){
        if(err){ return next(err); }
        req.shop.shop_comments.push(comment);
        req.shop.save(function(err, shop) {
            if(err){ return next(err); }

            res.json(comment);
        });
    });
});


// upvote shop
router.put('/shops/:shop/upvote', function(req, res, next) {

    req.shop.upvote(function(err, shop){
        if (err) { return next(err); }
        res.json(shop);
    });
});

// downvote a shop
router.put('/shops/:shop/downvote', function(req, res, next) {
    req.shop.downvote(function(err, shop){
        if (err) { return next(err); }

        res.json(shop);
    });
});



//upvote item in shop
router.put('/shops/:shop/items/:item/upvote', function(req, res, next) {
    req.item.upvote(function(err, item){
        if (err) { return next(err); }

        res.json(item);
    });
});

//downvote item in shop
router.put('/shops/:shop/items/:item/downvote', function(req, res, next) {
    req.item.downvote(function(err, item){
        if (err) { return next(err); }

        res.json(item);
    });
});


//upvote comments in shop
router.put('/shops/:shop/comments/:comment/upvote', function(req, res, next) {
    req.comment.upvote(function(err, comment){
        if (err) { return next(err); }
        res.json(comment);
    });
});

//downvote comments in shop
router.put('/shops/:shop/comments/:comment/downvote', function(req, res, next) {
    req.comment.downvote(function(err, comment){
        if (err) { return next(err); }

        res.json(comment);
    });
});





//register user
router.post('/register', function(req, res, next){
  if(!req.body.username || !req.body.password){
    return res.status(400).json({message: 'Please fill out all fields'});
  }
  var user = new User();

  user.username = req.body.username;

  user.balance = 100;

  user.setPassword(req.body.password)

  user.save(function (err){
    if(err){ return next(err); }

    return res.json({token: user.generateJWT()})
  });
});


//login user
router.post('/login', function(req, res, next){
  if(!req.body.username || !req.body.password){
    return res.status(400).json({message: 'Please fill out all fields'});
  }

  passport.authenticate('local', function(err, user, info){
    if(err){ return next(err); }

    if(user){
      return res.json({token: user.generateJWT()});
    } else {
      return res.status(401).json(info);
    }
  })(req, res, next);
});


//encode url params
router.param('new_name', function(req, res, next, new_name) {
    req.new_name = new_name;
    return next();
});


router.param('new_description', function(req, res, next, new_description) {
    req.new_description = new_description;
    return next();
});

router.param('new_category', function(req, res, next, new_category) {
    req.new_category = new_category;
    return next();
});

router.param('itemid', function(req, res, next, itemid) {
    req.itemid = itemid;
    return next();
});

router.param('edit_item_description', function(req, res, next, edit_item_description) {
    req.edit_item_description = edit_item_description;
    return next();
});

router.param('edit_item_quantity', function(req, res, next, edit_item_quantity) {
    req.edit_item_quantity = edit_item_quantity;
    return next();
});

router.param('edit_item_price', function(req, res, next, edit_item_price) {
    req.edit_item_price = edit_item_price;
    return next();
});


//edit item in shop
router.put('/shops/:shop/:item/:edit_item_description/:edit_item_quantity/:edit_item_price', function(req, res, next){
    req.item.update(req.edit_item_description, req.edit_item_quantity, req.edit_item_price, function(err, item){
        if (err) { return next(err); }

        res.json(item);
    });
});



router.param('shopid', function(req, res, next, shopid) {
    req.shopid = shopid;
    return next();
});


//edit shop 
router.put('/shops/:shop/:new_name/:new_category/:new_description', function(req, res, next) {
   req.shop.update(req.new_name,  req.new_description, req.new_category, function(err, shop){
        if (err) { return next(err); }

        res.json(shop);
    });

});




//delete a shop
router.delete('/shops/:shopid/delete', function(req, res, next) {
  Shop.findById(req.shopid, function (err, shop) {
    if(err) { return next(err); }
    if(!shop) { return res.send(404); }
    shop.remove(function(err) {
      if(err) { return handleError(res, err); }
      return res.send(204);
    });
  });
});

//delete an item
router.delete('/shops/:shop/deleteItem/:itemid', function(req, res, next) {
  Item.findById(req.itemid, function (err, item) {
    if(err) { return next(err); }
    if(!item) { return res.send(404); }
    item.remove(function(err) {
      if(err) { return handleError(res, err); }
      return res.send(204);
    });
  });
});





module.exports = router;
