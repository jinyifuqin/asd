//layer全局
var layer = parent.layer;
layer.closeAll();
function adminLoad(time){
	if(!time)  time = 3;
	layer.load(1, {
		   shade: [0.4,'#000'], //0.1透明度的白色背景
	       time: time * 1000 //3s后自动关闭
		});
}
function adminToUrl(url){		
	adminLoad(3);
	location.href = url;  
}
function showTips(tips, icon){
	icon = icon ? icon : '1';
	layer.msg(tips, {
                icon: icon,
                shade: [0.4,'#000'], //0.1透明度的白色背景
                skin: 'layer-ext-moon'
            });
}
$(document).ready(function(){
	// 按钮区块，如果没有内容就去除，更好看
	$(".panel-button").each(function(index, el) {		
		if($(this).find('*').length < 1)	$(this).remove();
		else $(this).slideDown('400');
	});
	//多选默认值
	$("select[data-select]").each(function(){
		if($(this).attr('data-select') != '')
		$(this).val($(this).attr('data-select'));
	});	

	//带链接的按钮点击事件
	$("body").on('click', 'button[chick-href]', function(event) {
		adminToUrl($(this).attr('chick-href'));
		return false;
	});

	// 状态图标显示
	$(".tag_ststus_show").each(function(index, el) {
		var status = $(this).attr('tag-value');
		if(status == 1){
			$(this).addClass('tag bg-green').text("显示");
		}else if(status == 0){
			$(this).addClass('tag bg-yellow').text("隐藏");
		}
	});

	//删除按钮
	$(".button-delete,.need-confirm").click(function(event) {
		var href = $(this).attr('href');
		if($(this).hasClass('need-confirm')){
			var delete_index = layer.confirm('数据诚可贵，信息价更高！<br>您确定要操作吗？', {
		        btn: ['确定','还没想好'] //按钮
		    }, function(){
		        layer.close(delete_index);
		        location.href = href;
		    }, function(){
		        layer.close(delete_index);
		    });
		}else{
			location.href = href;
		}
		return false;
	});
	// 批量删除
	$(".delete-multi").click(function(event) {
		var id = [];
		$("table input[name=id]").each(function(index, el) {
			if($(this).is(':checked')){
				id.push($(this).val());
			}
		});
		if(id.length <1){
			showTips('请选择要删除的项！',2);
		}else{
			var that = $(this);
			var delete_index = layer.confirm('数据诚可贵，信息价更高！<br>您确定要删除吗？', {
		        btn: ['确定','还没想好'] //按钮
		    }, function(){
		        layer.close(delete_index);
		        var url = that.attr('chick-href') + '?id=' +id.join(',');
				adminToUrl(url);
		    }, function(){
		        layer.close(delete_index);
		    });			
		}
		return false;
	});

	//全选
	$(".check_all").click(function(event) {
		var checkfor = $(this).attr('checkfor') ? $(this).attr('checkfor') : 'id';
		var type = $(this).is(':checked');		
		$(this).parents('table').find('input[name='+checkfor+']').each(function(index, el) {
			el.checked = type;
			if(el.checked){
				$(this).parents('tr').addClass('green');
			}else{
				$(this).parents('tr').removeClass('green');
			}
			$(this).click(function(event) {
				if(!$(this).is(':checked')){
					$(".check_all").each(function(index, el) {
						el.checked = false;	
					});
					$(this).parents('tr').removeClass('green');
				}else{
					$(this).parents('tr').addClass('green');	
				}
			});
		});
	});

	//搜索按钮
	$("button.search").click(function(event) {
		$('.panel-search').toggle(400);		
	});


	setInterval("resizeUeditor()",800);
	// resizeUeditor();	
    // $(window).resize(function(event) {
    //     resizeUeditor();
    // }); 
});
function resizeUeditor(){
	var nowWidth = $(window).width();
	// console.log(nowWidth);
	// var objArr = $('body').find('#edui71,#edui76');	
	var objArr = $('body').find('.edui-dialog');
	// var objArr = $('body').find('#eduidds0f');
	objArr.each(function(index, el) {
		var obj = $(this);
		if(obj.length > 0 && obj.css('display') != 'none' && $(this).attr('id')){
			if(!$(this).attr('oldStyle')){
				$(this).attr('oldStyle', $(this).attr('style'));
			}
			console.log('调整编辑器' + $(this).attr('id'));
			if(nowWidth <= 600){
				var dialog_width = nowWidth < 320 ? '320px' : (nowWidth) + 'px';
	            obj.css({
	            	'left': '5px',
	            	'width': dialog_width
	            });
	            obj.children('div').css('width', dialog_width);
	        }else{
	         	$(this).attr('style', $(this).attr('oldStyle')).removeAttr('oldStyle');   
	        }
		}
	});
}