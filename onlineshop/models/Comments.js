// Comment model
var mongoose = require('mongoose');

var CommentSchema = new mongoose.Schema({
    body: String,
    upvotes: {type: Number, default: 0},
    shop: { type: mongoose.Schema.Types.ObjectId, ref: 'Shop' }
});


//Comment method

CommentSchema.methods.upvote = function(cb) {
    this.upvotes += 1;
    this.save(cb);
};

CommentSchema.methods.downvote = function(cb) {
    this.upvotes -= 1;
    this.save(cb);
};

mongoose.model('Comment', CommentSchema);
