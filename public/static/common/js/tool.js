// 需要 
// jQuery 1.8.0+
// layer 3.0.0+


//定义加入收藏夹函数
function oollection(siteUrl, siteName){  
    //捕获加入收藏过程中的异常       
    try {       
    //判断浏览器是否支持document.all        
        if(document.all){                     
            //如果支持则用external方式加入收藏夹              
            window.external.addFavorite(siteUrl,siteName);                
        }else if(window.sidebar){                      
            //如果支持window.sidebar，则用下列方式加入收藏夹  
            window.sidebar.addPanel(siteName, siteUrl,'');         
        }else{
            alert("加入收藏，请使用Ctrl+D快捷键进行添加操作!");       
        }

    } //处理异常       
    catch (e){
        alert("加入收藏，请使用Ctrl+D快捷键进行添加操作!");   
    }
}


function toolPost(url, params) {
    //创建form表单
    var temp_form = document.createElement("form");
    temp_form.action = url;    
    //如需打开新窗口，form的target属性要设置为'_blank'
    temp_form.target = "_self";
    temp_form.method = "post";
    temp_form.style.display = "none";
    //添加参数
    for (var item in params) {
        var opt = document.createElement("input");
        opt.name = params[item].name;
        opt.value = params[item].value;
        temp_form.appendChild(opt);
    }
    document.body.appendChild(temp_form);
    //提交数据
    temp_form.submit();
}

function toolTips(tips, status, url){
	if(!status) status = 0;
    layer.msg(tips, {
        icon: status,
        shade: [0.4,'#fff'],
        skin: 'layer-ext-moon'
    },function(){        
        if(url !='' && typeof (url) !='undefined'){
            location.href = url;
        }        
    });

}
function toolLoad(){	
	return layer.load(1, {		
		shade: [0.4,'#fff'] 
	});	
}
var scripts = document.getElementsByTagName('script');
// 获取现在已经加载的所有script
var lastScript = scripts[scripts.length-1];
// 获取最近一个加载的script，即这个js本身
var scriptName = lastScript.src;
// 暂无图片
var commonPath = scriptName.replace(/\/[^\/]+\/[^\/]+$/,"/");
var nopicPath  = commonPath + 'images/nopic.png';
$(document).ready(function() {    
    $(".nopic").error(function() {        
        $(this).attr('src', nopicPath);
    });
});