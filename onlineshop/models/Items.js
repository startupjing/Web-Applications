//Item model

var mongoose = require('mongoose');
 
 
var ItemSchema = new mongoose.Schema({
  item_name: String,
  item_description: String,

  item_quantity: {type: Number, default: 0},
  item_price: {type: Number, default: 0},
  
  upvotes: {type: Number, default: 0},
  shop: { type: mongoose.Schema.Types.ObjectId, ref: 'Shop' }

});



//Item method

ItemSchema.methods.upvote = function(cb) {
    this.upvotes += 1;
    this.save(cb);
};

ItemSchema.methods.downvote = function(cb) {
    this.upvotes -= 1;
    this.save(cb);
};

ItemSchema.methods.update = function(edit_item_description, edit_item_quantity, edit_item_price, cb){
   
     this.item_description = edit_item_description;
     this.item_quantity = edit_item_quantity;
     this.item_price = edit_item_price;
     this.save(cb);
}
 
mongoose.model('Item', ItemSchema);