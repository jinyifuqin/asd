//返回顶部
$(document).ready(function() {
    $(".fanhui").click(function(){
		if(scroll=="off") return;//如果（滚动= =“关闭”)返回
		$('html,body').animate({scrollTop:0},600);
		});
		$(window).scroll(function(){
			var htmlTop=$(document).scrollTop();
			if(htmlTop>0){
				
				$(".fanhui").fadeIn();
				}
				else{
					$(".fanhui").fadeOut();
					};
			});
});

/**banner**/
$(document).ready(function () {
	$(".ly_banner .main_visual").hover(function(){
		$("#btn_prev,#btn_next").fadeIn();
		},function(){
		$("#btn_prev,#btn_next").fadeOut();
		});
	$dragBln = false;
	$(".main_image").touchSlider({
		flexible : true,
		speed : 500,
		btn_prev : $("#btn_prev"),
		btn_next : $("#btn_next"),
		paging : $(".flicking_con a"),
		counter : function (e) {
			$(".flicking_con a").removeClass("on").eq(e.current-1).addClass("on");
		}
	});
	$(".main_image").bind("mousedown", function() {
		$dragBln = false;
	});
	$(".main_image").bind("dragstart", function() {
		$dragBln = true;
	});
	$(".main_image a").click(function() {
		if($dragBln) {
			return false;
		};
	});
	timer = setInterval(function() { $("#btn_next").click();}, 5000);
	$(".main_visual").hover(function() {
		clearInterval(timer);
	}, function() {
		timer = setInterval(function() { $("#btn_next").click();}, 5000);
	});
	$(".main_image").bind("touchstart", function() {
		clearInterval(timer);
	}).bind("touchend", function() {
		timer = setInterval(function() { $("#btn_next").click();}, 5000);
	});
});

$(function(){
var mySwiper = new Swiper('.pa1tl .swiper-container',{
	pagination: '.pagination',
	loop:true,
	autoplay:3000,
	grabCursor: true,
	paginationClickable: true
  });
  $('.arrow-left').on('click', function(e){
	e.preventDefault();
	mySwiper.swipePrev();
  });
  $('.arrow-right').on('click', function(e){
	e.preventDefault();
	mySwiper.swipeNext();
  });
  
 $('.pa3c a:last').css('background','none'); 
 $('.pa4l li').hover(function(){
	 $(this).addClass('act').siblings().removeClass('act');
	});		
	
	
	
})
