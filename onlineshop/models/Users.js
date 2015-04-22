//User model

var mongoose = require('mongoose');
var crypto = require('crypto');
var jwt = require('jsonwebtoken');

var UserSchema = new mongoose.Schema({
  username: {type: String, lowercase: true, unique: true},
  hash: String,
  salt: String,

  history: [{ type: mongoose.Schema.Types.ObjectId, ref: 'Item' }],
  
  //seller
  revenue: {type: Number, default: 0},
  seller_shops: [{ type: mongoose.Schema.Types.ObjectId, ref: 'Shop' }],
  
  //buyer
  balance: {type: Number, default: 100},
  buyer_cart: [{ type: mongoose.Schema.Types.ObjectId, ref: 'Item' }],

  
  wish_list: [{ type: mongoose.Schema.Types.ObjectId, ref: 'Item' }]
});


UserSchema.methods.generateJWT = function() {

  // set expiration to 60 days
  var today = new Date();
  var exp = new Date(today);
  exp.setDate(today.getDate() + 60);

  return jwt.sign({
    _id: this._id,
    username: this.username,
    exp: parseInt(exp.getTime() / 1000),
  }, 'SECRET');
};



//User password
UserSchema.methods.setPassword = function(password){
  this.salt = crypto.randomBytes(16).toString('hex');

  this.hash = crypto.pbkdf2Sync(password, this.salt, 1000, 64).toString('hex');
};

UserSchema.methods.validPassword = function(password) {
  var hash = crypto.pbkdf2Sync(password, this.salt, 1000, 64).toString('hex');

  return this.hash === hash;
};


mongoose.model('User', UserSchema);