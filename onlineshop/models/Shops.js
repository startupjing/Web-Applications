//Shop model

var mongoose = require('mongoose');
 
 
var ShopSchema = new mongoose.Schema({
  shop_name: String,
  shop_category: String,
  shop_description: String,
  star: {type: Number, default: 0},
  shop_owner: String,
  shop_items: [{ type: mongoose.Schema.Types.ObjectId, ref: 'Item' }],
  shop_comments: [{ type: mongoose.Schema.Types.ObjectId, ref: 'Comment' }]
 
});



//Shop method
ShopSchema.methods.upvote = function(cb) {
  this.star += 1;
  this.save(cb);
};
 

ShopSchema.methods.downvote = function(cb) {
    this.upvotes -= 1;
    this.save(cb);
};

ShopSchema.methods.update = function(new_name,cb){
   
     this.shop_name = new_name;
     this.save(cb);
};

ShopSchema.methods.update = function(new_name, new_description, new_category, cb){
   
     this.shop_name = new_name;
     this.shop_description = new_description;
     this.shop_category = new_category;

     this.save(cb);
};

mongoose.model('Shop', ShopSchema);