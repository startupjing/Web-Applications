var main = function() {
	
	setInterval(nextSlide, 3000);
	
    $('.dropdown-toggle').click(function(){
        $('.dropdown-menu').toggle();
    });
    
    $('.arrow-next').click(nextSlide);
    
    $('.arrow-prev').click(preSlide);
    				
};

var nextSlide = function(){
    var currentSlide = $('.active-slide');
    var nextSlide = currentSlide.next();
    var currentDot = $('.active-dot');
    var nextDot = currentDot.next();
    if(nextSlide.length == 0){
        nextSlide = $('.slide').first();
    }
    if(nextDot.length == 0){
        nextDot = $('.dot').first();
    }
    currentSlide.fadeOut(600).removeClass('active-slide');
    nextSlide.fadeIn(600).addClass('active-slide');
    currentDot.removeClass('active-dot');
    nextDot.addClass('active-dot');
 };
 
 
var preSlide = function() {
    var currentSlide = $('.active-slide');
    var prevSlide = currentSlide.prev();
    var currentDot = $('.active-dot');
    var prevDot = currentDot.prev();
    if(prevSlide.length == 0){
        prevSlide = $('.slide').last();
    }
    if(prevDot.length == 0){
        prevDot = $('.dot').last();
    }
    currentSlide.fadeOut(600).removeClass('active-slide');
    prevSlide.fadeIn(600).addClass('active-slide');
    currentDot.removeClass('active-dot');
    prevDot.addClass('active-dot');
 };

$(document).ready(main);