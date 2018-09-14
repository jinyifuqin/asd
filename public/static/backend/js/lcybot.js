$(function(){
	// click-lcy-closed == 1 关闭
	// click-lcy-closed == 0 开启
	var cookieName = "click-lcy-closed";
	var url = "";	//龙采云iframe链接地址	
	var html  = '<div class="fixed-bottom-box">'+
			        '<div class="fixed-bottom-bar">'+
			            '<div class="close"></div>'+
			            '<div class="box"><iframe src="' + url + '"></iframe></div>'+
			            '<div class="shadow"></div>'+
			        '</div>'+
			        '<div class="down-bar-btn">'+
			            '<p>开启</p>'+
			        '</div>'+
			    '</div>';
	$('body').append(html);

	$(".fixed-bottom-box").css({ "clear": "both","font-family":"微软雅黑" });
	$(".fixed-bottom-box .fixed-bottom-bar").css({"height":"50px","width":"100%","position":"fixed","z-index":"20000","bottom":"0","left":"0","font-size":"14px","visibility":"hidden !important","transform":"translateX(-100%) !important","-webkit-transform":"translateX(-100%) !important","transition":"all ease .3s","-webkit-transition":"all ease .3s"});
	$(".fixed-bottom-bar .close").css({"width":"30px","height":"30px","text-align":"center","line-height":"120%","position":"absolute","right":"0","top":"0","color":"#fff","font-size":"20px","cursor":"pointer","z-index":"11"});
	$(".fixed-bottom-bar .shadow").css({"background":"#000","opacity":".7","filter":"alpha(opacity=70)","width":"100%","height":"100%","position":"absolute","left":"0","top":"0"});
	$(".fixed-bottom-bar .box").css({"position":"relative","z-index":"10"});
	$(".fixed-bottom-bar .box iframe").css({"width":"100%","height":"100%"});
	$(".fixed-bottom-box .down-bar-btn").css({"width":"35px","height":"50px","position":"fixed","left":"0","bottom":"0","z-index":"20001","background":"rgba(0,0,0,0.6)","cursor":"pointer","transform":"translateX(0)","-webkit-transform":"translateX(0)","transition":"all ease .3s","-webkit-transition":"all ease .3s"});
	$(".fixed-bottom-box .down-bar-btn p").css({"font-size":"12px","color":"#fff","width":"20px","text-align":"center","margin":"5px auto"});
	$(".fixed-bottom-box.active .fixed-bottom-bar").css({"visibility":"visible","transform":"translateX(0)","-webkit-transform":"translateX(0)"});
	$(".fixed-bottom-box.active .down-bar-btn").css({"visibility":"hidden","transform":"translateX(-100px)","-webkit-transform":"translateX(-100px)"});
	
	if (getCookie(cookieName) == 1) {
		$('.fixed-bottom-box').removeClass('active');
		$('.fixed-bottom-bar').css({"visibility":"hidden"});
	} else {
		$('.fixed-bottom-box').addClass('active');
		$('.down-bar-btn').css({"visibility":"hidden"});
	}
	
	$('.down-bar-btn').click(function(){
		setCookie(cookieName, 0);
		$('.fixed-bottom-box').addClass('active');
		$('.down-bar-btn').css({"visibility":"hidden","transform":"translateX(-100%)","-webkit-transform":"translateX(-100%)"});
		$('.fixed-bottom-bar').css({"transform":"translateX(0)","-webkit-transform":"translateX(0)","visibility":"visible"});	
	});
	$('.fixed-bottom-box .close').click(function(){
		setCookie(cookieName, 1);
		$('.fixed-bottom-box').removeClass('active');
		$('.down-bar-btn').css({"transform":"translateX(0)","-webkit-transform":"translateX(0)","visibility":"visible"});	
		$('.fixed-bottom-bar').css({"visibility":"hidden","transform":"translateX(-100%)","-webkit-transform":"translateX(-100%)"});
	});

})

function getCookie(name) {
    var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
    if (arr = document.cookie.match(reg)) {
    	return (arr[2]);
    } else {
    	return null;
    }
}

function setCookie(c_name, value, expiredays) {
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + expiredays);
    document.cookie = c_name + "=" + decodeURI(value) + ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString());
}