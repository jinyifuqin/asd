layer.config({
    extend: ['pintuer/style.css'], //加载新皮肤
    skin: 'layer-ext-pintuer' //一旦设定，所有弹层风格都采用此主题。
});
$(document).ready(function() {
    $(".leftnav ul li a").click(function(){
        layer.load(1, {
            shade: [0.4,'#000'], //0.1透明度的白色背景
            time: 3 * 1000 //3s后自动关闭
        });
        var obj1 = $(".admin-nav li").eq($(this).parents('.leftnav_sub').index()-1).find('a');
        $(".bread").find('li').eq(0).find('a').text(obj1.text()).attr('class', obj1.attr('class'))
        // .attr('href', $(".leftnav").find('.leftnav_sub').eq(obj1.parent('li').index()).children('ul').first().find('a').attr('href'));

        $(".bread").find('li').eq(1).find('a').text($(this).parents('ul').prev('h2').text());
        $(".bread").find('li').eq(2).text($(this).text());
        $(".leftnav ul li a").removeClass("on");
        $(this).addClass("on");
        $("#admin_main").find('iframe').attr('src', $(this).attr('href'));
        // hideMenu();
        return false;
    });
    $(".leftnav h2").click(function(){
       $(this).next().show(200).children('li').first().children('a').click().parents('ul').siblings('ul').hide(200);    
       $(this).toggleClass("on").siblings('h2').removeClass("on");
    });
    $(".admin-nav li").click(function(){
       $(this).addClass("active").siblings("li").removeClass("active");

       $(".leftnav").find('.leftnav_sub').eq($(this).index()).slideDown('400').children('h2').first().click().parent().siblings(".leftnav_sub").slideUp('400');
       return false;
    });
    $(".admin-nav").find("li").first().click();
    $(".leftnav").find('.leftnav_sub').first().show(200).find('h2').first().click();
    // 清除缓存
    $(".clear-cache").click(function(event) {
        layer.load(1, {
            shade: [0.4,'#000'], //0.1透明度的白色背景
            time: 5 * 1000 //3s后自动关闭
        });
        $.getJSON($(this).attr('href'), {}, function(json, textStatus) {
            layer.closeAll();
            if(json.status == 1){                
                layer.msg('操作成功！', {
                    icon: 1,
                    // shade: [0.4,'#000'], //0.1透明度的白色背景
                    skin: 'layer-ext-moon'
                });
            }
        });
        return false;
    });
});
// 响应式相关
var window_h = $(window).height();
function showMenu() {
    $('.header').css('height', 'auto');
    $('.leftnav').slideDown(500);
    $('.logo_menu').addClass('show');
    var header_h = $(".header").height();
    var leftnav_h = $(".leftnav").height();
    var iframe_h = window_h - header_h - leftnav_h - 20;
    $("#admin_main iframe").height(iframe_h);
}

function hideMenu() {
    $('.header').height(50);
    $('.leftnav').slideUp(500);
    $('.logo_menu').removeClass('show');
    $("#admin_main iframe").height(window_h - 70);
}
$(document).ready(function() {
    $(".logo_menu").click(function(event) {
        if ($(this).hasClass('show')) {
            hideMenu();
        } else {
            showMenu();
        }
    });
    if ($(window).width() < 1024) {
        $("#admin_main iframe").height(window_h - 70);
    }
    $(window).scroll(function(event) {
        if ($(this).width() < 1024 && $(this).scrollTop() > 0) {
            hideMenu();
        }
    });
    $(window).resize(function(event) {
        if ($(this).width() < 1024) {
            hideMenu();
        } else {
            $('.header').css('height', '80px');
            $('.leftnav').show();
            $("#admin_main iframe").height('100%');
        }
    });
});