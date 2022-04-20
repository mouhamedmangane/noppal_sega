var last_position=0;
window.addEventListener('scroll',function(e){
	if(window.scrollY <= 20 && window.scrollY>=0){
		
		var y1= 5 - ( window.scrollY)/4;
		var y2= 16 - ( window.scrollY)/4;
		var y3= 
		$(".m-logo").css('padding',y1+'px');
		$(".m-nav").css('margin-top',y2+'px');
		$(".m-nav").css('margin-bottom',y2+'px');
		$(".m-nav-item , .m-nav-item button ").css('font-size','16px');
		
	}
	
	if(window.scrollY >= 20){
		$(".m-logo ").css('padding','0px');
		$(".m-nav").css('margin-top','11px');
		$(".m-nav").css('margin-bottom','11px');
		$(".m-nav-item , .m-nav-item button ").css('font-size','14px');
	}

	last_position = window.scrollY;
});


