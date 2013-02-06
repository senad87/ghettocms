$(document).ready(function(){
$("#close_mess").live('click',function(){
	$('#message').fadeOut('slow');
});

jQuery.fn.delay = function(time, func){
    return this.each(function(){
        setTimeout(func,time);
    });
};

jQuery.fn.dissapear = function(id, speed){
	$('#'+id).delay(5000, function(){$('#'+id).fadeOut(speed)});
};
jQuery.fn.dissapear('message', 'slow');

});
$(function(){
$('.modal').colorbox({ //init modal box
			iframe:true,
			height:800,
			width:1000,
			overlayClose:false
		});
});