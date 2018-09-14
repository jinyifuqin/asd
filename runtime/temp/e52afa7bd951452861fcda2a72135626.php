<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:62:"D:\xampp001\htdocs\wj31/application/backend\view\cate\add.html";i:1495273886;s:58:"D:\xampp001\htdocs\wj31/application/backend\view\base.html";i:1520934308;s:65:"D:\xampp001\htdocs\wj31/application/backend\view\development.html";i:1495532356;s:57:"D:\xampp001\htdocs\wj31/application/backend\view\seo.html";i:1495263836;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title> - 管理中心 - Powered by <?php echo config('base.app_powered'); ?></title>
    <link rel="stylesheet" href="<?php echo $style_path; ?>/css/pintuer.css">
    <link rel="stylesheet" href="<?php echo $style_path; ?>/css/admin.css">
    <script type="text/javascript" src="<?php echo $style_path; ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo $style_path; ?>/layer/layer.js"></script>
    <style type="text/css">
    <?php if(!config('app_debug')): ?>
    .show-development{display: none !important;}
    <?php endif; ?>
</style>
    
</head>
<body>
<div class="panel admin-panel">
    <div class="panel-head"><strong class="icon-reorder"> 添加/编辑</strong></div>
    <div class="panel-button padding border-bottom"></div>
    <div class="body-content">
<div class="tab">
	<div class="tab-head">		
		<ul class="tab-nav">
			<li class="active"><a href="#tab-start">基本信息</a> </li>
			<li><a href="#tab-advanced">高级信息</a> </li>			
			<li><a href="#tab-css">SEO信息</a> </li>			
		</ul>
	</div>
	<div class="tab-body">
		<form method="post" class="form-x" action="">				
			<div class="tab-panel active" id="tab-start">
			<div class="form-group"><div class="label"><label><?php echo '分类名称' . '：';?></label></div><div class="field"><textarea name="<?php echo 'cate_name';?>"  style="height:80px;width:80%" class="input input" type="text" data-validate="required:请输入分类名称，可以批量添加，一行一个" placeholder="可以批量添加，一行一个"></textarea><div class="input-note"><?php echo '';?></div></div></div>
			<div class="form-group"><div class="label"><label><?php echo '上级栏目' . '：';?></label></div><div class="field"><?php if(is_array($cateTree) || $cateTree instanceof \think\Collection):  $__LIST__ = $cateTree; $__ATTR__ = ''; $__ATTR__ = $__ATTR__ ? explode(',', $__ATTR__) : [];if( count($__LIST__)==0 ) : echo "" ;else: ?><select name="<?php echo 'parent_id' ;?>" class="input " data-select="<?php echo \think\Request::instance()->param('parent_id') ;?>" data-validate="required:请选择上级栏目"><option value="0">--请选择--</option><?php foreach($__LIST__ as $val): ?><option value="<?php echo $val['id'];?>" <?php foreach($__ATTR__ as $val_attr): echo isset($val[$val_attr]) ? $val_attr.'="'.$val[$val_attr].'"' : ''; endforeach; ?>> <?php echo (isset($val['prefix']) ? $val['prefix'] : "").$val['cate_name'];?></option><?php endforeach; endif; ?></select><?php else: echo "" ;endif; ?><div class="tips"></div></div></div>
			<div class="form-group"><div class="label"><label><?php echo '缩略图' . '：';?></label></div><div class="field"><a class="button input-flie" more="0" file-name="<?php echo 'cate_img';?>" id="v_a97f219b3ecfa6c6729a0c51624e9a3b_button" href="javascript:void(0);">+ 浏览文件</a><div class="imgdiv"></div><?php if(!isset($_ueditor) || $_ueditor != true): ;?><script type="text/javascript">var ueControllerPath = "/backend/ueditor/index.html";</script><script type="text/javascript" src="/public/static/backend/plugin/ueditor/ueditor.config.js"></script><script type="text/javascript" src="/public/static/backend/plugin/ueditor/ueditor.all.min.js"></script><script type="text/javascript" src="/public/static/backend/plugin/ueditor/lang/zh-cn/zh-cn.js"></script><?php $_ueditor = true; endif;?><script id="v_a97f219b3ecfa6c6729a0c51624e9a3b"></script><script>var v_a97f219b3ecfa6c6729a0c51624e9a3b_imgstr = "";
                    var v_a97f219b3ecfa6c6729a0c51624e9a3b_imgarr = v_a97f219b3ecfa6c6729a0c51624e9a3b_imgstr.split(",");<?php if(!isset($_has_addimg) || $_has_addimg != true): ;?>
                    function addImg(imgsrc, obj, class_name){
                        var name = $(obj).attr("file-name");
                        var html = '<div class="padding border float-left margin-right badge-corner"><span class="imgremove badge bg-red">X</span><img src="'+imgsrc+'" class="img-border radius-small" />';
                        html += '<input name="'+name+'" id="<?php echo '';?>" class="input '+class_name+'" type="hidden" value="'+imgsrc+'" >';
                        if($(obj).attr("more") == 1){
                            html += '<br><button class="imgprev button border-main button-little float-left"  type="button" >前移</button><button class="imgnext button border-sub button-little float-right"  type="button" >后移</button></div>';
                        }
                        if($(obj).attr("more") == 1){
                            $(obj).siblings(".imgdiv").append(html);
                        }else{
                            $(obj).siblings(".imgdiv").html(html);
                        }
                        // return html;
                    }
                    $(document).ready(function() {
                        $(document).on("click", ".imgremove", function(event) {
                            $(this).parent("div").remove();
                        });
                        $(document).on("click", ".imgprev", function(event) {
                            $(this).parent("div").after($(this).parent("div").prev("div").prop("outerHTML"));
                            $(this).parent("div").prev("div").remove();
                        });
                        $(document).on("click", ".imgnext", function(event) {
                            $(this).parent("div").before($(this).parent("div").next("div").prop("outerHTML"));
                            $(this).parent("div").next("div").remove();
                        });
                    });
                    <?php $_has_addimg = true; endif;?>if(v_a97f219b3ecfa6c6729a0c51624e9a3b_imgstr != "" && v_a97f219b3ecfa6c6729a0c51624e9a3b_imgarr){
                        $.each(v_a97f219b3ecfa6c6729a0c51624e9a3b_imgarr, function(index, val) {
                            // console.log(val);
                            addImg(val, "#v_a97f219b3ecfa6c6729a0c51624e9a3b_button",'input w50');
                        });
                    }
                    var v_a97f219b3ecfa6c6729a0c51624e9a3b = UE.getEditor("v_a97f219b3ecfa6c6729a0c51624e9a3b");
                    v_a97f219b3ecfa6c6729a0c51624e9a3b.ready(function (){
                        //设置编辑器不可用(事实上不可以设置不可用...所以注释掉,以观后效)
                        // v_a97f219b3ecfa6c6729a0c51624e9a3b.setDisabled();
                        //隐藏编辑器,因为只使用上传功能
                        v_a97f219b3ecfa6c6729a0c51624e9a3b.hide();
                        //侦听图片上传
                        v_a97f219b3ecfa6c6729a0c51624e9a3b.addListener('beforeInsertImage',function(t,arg){
                            console.log(arg);
                            var imgsrc = arg[0].src;
                        
                            // $("#v_a97f219b3ecfa6c6729a0c51624e9a3b_button").prev("input[type=text]").val(imgsrc);
                                addImg(imgsrc, "#v_a97f219b3ecfa6c6729a0c51624e9a3b_button",'input w50');
                        // if(layer) layer.msg("上传成功！");
                        });
                    });
                    //上传dialog
                    $(document).ready(function() {
                        $("#v_a97f219b3ecfa6c6729a0c51624e9a3b_button").click(function(event) {
                            var myImage = v_a97f219b3ecfa6c6729a0c51624e9a3b.getDialog("insertimage");
                            // var myImage = v_a97f219b3ecfa6c6729a0c51624e9a3b.getDialog("attachment");
                            myImage.open();
                        });
                    });
                    </script><div class="clear"></div><div class="input-note"><?php echo '';?></div></div></div>
			<div class="form-group"><div class="label"><label><?php echo '栏目类型' . '：';?></label></div><div class="field"><div class="button-group border-main radio"><?php $_result=config('cate_model'); $__LIST__ = $_result; foreach($__LIST__ as $key => $val): ?><label class="button  <?php if(!is_null('1') && $key == '1'): echo "active"; endif;?>" ><input name="<?php echo 'cate_model' ;?>" value="<?php echo $key;?>" type="radio" <?php if(!is_null('1') && $key == '1'): echo "checked=\"checked\""; endif;?>><?php echo $val;?></label><?php endforeach; ?></div><div class="input-note"><?php echo '';?></div></div></div>							
			<div class="form-group"><div class="label"><label><?php echo '显示' . '：';?></label></div><div class="field"><div class="button-group border-main radio"><?php $_result=config('is_show'); $__LIST__ = $_result; foreach($__LIST__ as $key => $val): ?><label class="button  <?php if(!is_null('1') && $key == '1'): echo "active"; endif;?>" ><input name="<?php echo 'is_show' ;?>" value="<?php echo $key;?>" type="radio" <?php if(!is_null('1') && $key == '1'): echo "checked=\"checked\""; endif;?>><?php echo $val;?></label><?php endforeach; ?></div><div class="input-note"><?php echo '';?></div></div></div>
			</div>
			<div class="tab-panel" id="tab-advanced">
				<div class="form-group"><div class="label"><label><?php echo '别名' . '：';?></label></div><div class="field"><input name="<?php echo 'alias_name';?>"   class="input input w50" type="text" value="<?php echo '';?>" ><div class="input-note"><?php echo '';?></div></div></div>
				<div class="form-group"><div class="label"><label><?php echo '唯一标识' . '：';?></label></div><div class="field"><input name="<?php echo 'guid';?>"   class="input input w50" type="text" value="<?php echo '';?>" ><div class="input-note"><?php echo '';?></div></div></div>
				<div class="form-group"><div class="label"><label><?php echo '栏目链接' . '：';?></label></div><div class="field"><input name="<?php echo 'cate_link';?>"   class="input input w50" type="text" value="<?php echo '';?>" ><div class="input-note"><?php echo '';?></div></div></div>	
				<div class="form-group"><div class="label"><label><?php echo '排序' . '：';?></label></div><div class="field"><input name="<?php echo 'order_id';?>"   class="input input w50" type="text" value="<?php echo '1';?>" ><div class="input-note"><?php echo '';?></div></div></div>
			</div>
			<div class="tab-panel" id="tab-css">
				<div class="form-group"><div class="label"><label><?php echo 'SEO标题' . '：';?></label></div><div class="field"><input name="<?php echo 'seo';?>"   class="input input w50" type="text" value="<?php echo isset($dataEdit['seo']) ? $dataEdit['seo'] : '';?>" ><div class="input-note"><?php echo 'SEO标题，一般不超过80个字符';?></div></div></div>
<div class="form-group"><div class="label"><label><?php echo 'SEO关键词' . '：';?></label></div><div class="field"><input name="<?php echo 'keywords';?>"   class="input input w50" type="text" value="<?php echo isset($dataEdit['keywords']) ? $dataEdit['keywords'] : '';?>" ><div class="input-note"><?php echo '网站关键词，一般不超过100个字符';?></div></div></div>
<div class="form-group"><div class="label"><label><?php echo 'SEO描述' . '：';?></label></div><div class="field"><textarea name="<?php echo 'description';?>"  style="height:80px;" class="input input w80" type="text" ><?php echo isset($dataEdit['description']) ? $dataEdit['description'] : '';?></textarea><div class="input-note"><?php echo '网站描述，一般不超过200个字符';?></div></div></div>
			</div>	
			<div class="form-group">
				<div class="label">
					<label></label>
				</div>
				<div class="field">
					<button id="" class="button bg-main icon-check-square-o" type="submit"> 提交</button>
				</div>
			</div>
		</form>
	</div>
</div>
</div>
</div>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/pintuer.js"></script>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/admin.js"></script>

</body>
</html>
