<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:64:"D:\xampp001\htdocs\wj31/application/backend\view\ad\ad_edit.html";i:1495601537;s:58:"D:\xampp001\htdocs\wj31/application/backend\view\base.html";i:1520934308;s:65:"D:\xampp001\htdocs\wj31/application/backend\view\development.html";i:1495532356;}*/ ?>
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
	<form method="post" class="form-x" action="">		
		<input name="id"  class="input" type="hidden" value="<?php echo $dataEdit['id'];?>" >	
		<div class="form-group"><div class="label"><label><?php echo '广告位名称' . '：';?></label></div><div class="field"><input name="<?php echo 'ad_name';?>"   class="input input w50" type="text" value="<?php echo $dataEdit['ad_name'];?>" data-validate="required:请输入名称"><div class="input-note"><?php echo '';?></div></div></div>
		<div class="form-group"><div class="label"><label><?php echo '广告位置' . '：';?></label></div><div class="field"><?php if(is_array($ad) || $ad instanceof \think\Collection):  $__LIST__ = $ad; $__ATTR__ = ''; $__ATTR__ = $__ATTR__ ? explode(',', $__ATTR__) : [];if( count($__LIST__)==0 ) : echo "" ;else: ?><select name="<?php echo 'ad_id' ;?>" class="input " data-select="<?php echo $dataEdit['ad_id'] ;?>" data-validate="required:请选择广告位置"><option value="0">--请选择--</option><?php foreach($__LIST__ as $val): ?><option value="<?php echo $val['id'];?>" <?php foreach($__ATTR__ as $val_attr): echo isset($val[$val_attr]) ? $val_attr.'="'.$val[$val_attr].'"' : ''; endforeach; ?>> <?php echo (isset($val['prefix']) ? $val['prefix'] : "").$val['ad_name'];?></option><?php endforeach; endif; ?></select><?php else: echo "" ;endif; ?><div class="tips"></div></div></div>
		
		<div class="form-group"><div class="label"><label><?php echo '广告图片' . '：';?></label></div><div class="field"><a class="button input-flie" more="0" file-name="<?php echo 'ad_img';?>" id="v_05bf09b142239606addc95079aba7263_button" href="javascript:void(0);">+ 浏览文件</a><div class="imgdiv"></div><?php if(!isset($_ueditor) || $_ueditor != true): ;?><script type="text/javascript">var ueControllerPath = "/backend/ueditor/index.html";</script><script type="text/javascript" src="/public/static/backend/plugin/ueditor/ueditor.config.js"></script><script type="text/javascript" src="/public/static/backend/plugin/ueditor/ueditor.all.min.js"></script><script type="text/javascript" src="/public/static/backend/plugin/ueditor/lang/zh-cn/zh-cn.js"></script><?php $_ueditor = true; endif;?><script id="v_05bf09b142239606addc95079aba7263"></script><script>var v_05bf09b142239606addc95079aba7263_imgstr = "<?php echo $dataEdit['ad_img'];?>";
                    var v_05bf09b142239606addc95079aba7263_imgarr = v_05bf09b142239606addc95079aba7263_imgstr.split(",");<?php if(!isset($_has_addimg) || $_has_addimg != true): ;?>
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
                    <?php $_has_addimg = true; endif;?>if(v_05bf09b142239606addc95079aba7263_imgstr != "" && v_05bf09b142239606addc95079aba7263_imgarr){
                        $.each(v_05bf09b142239606addc95079aba7263_imgarr, function(index, val) {
                            // console.log(val);
                            addImg(val, "#v_05bf09b142239606addc95079aba7263_button",'input w50');
                        });
                    }
                    var v_05bf09b142239606addc95079aba7263 = UE.getEditor("v_05bf09b142239606addc95079aba7263");
                    v_05bf09b142239606addc95079aba7263.ready(function (){
                        //设置编辑器不可用(事实上不可以设置不可用...所以注释掉,以观后效)
                        // v_05bf09b142239606addc95079aba7263.setDisabled();
                        //隐藏编辑器,因为只使用上传功能
                        v_05bf09b142239606addc95079aba7263.hide();
                        //侦听图片上传
                        v_05bf09b142239606addc95079aba7263.addListener('beforeInsertImage',function(t,arg){
                            console.log(arg);
                            var imgsrc = arg[0].src;
                        
                            // $("#v_05bf09b142239606addc95079aba7263_button").prev("input[type=text]").val(imgsrc);
                                addImg(imgsrc, "#v_05bf09b142239606addc95079aba7263_button",'input w50');
                        // if(layer) layer.msg("上传成功！");
                        });
                    });
                    //上传dialog
                    $(document).ready(function() {
                        $("#v_05bf09b142239606addc95079aba7263_button").click(function(event) {
                            var myImage = v_05bf09b142239606addc95079aba7263.getDialog("insertimage");
                            // var myImage = v_05bf09b142239606addc95079aba7263.getDialog("attachment");
                            myImage.open();
                        });
                    });
                    </script><div class="clear"></div><div class="input-note"><?php echo '';?></div></div></div>

		<div class="form-group"><div class="label"><label><?php echo '链接' . '：';?></label></div><div class="field"><input name="<?php echo 'ad_link';?>"   class="input input w50" type="text" value="<?php echo $dataEdit['ad_link'];?>" ><div class="input-note"><?php echo '';?></div></div></div>
		<div class="form-group"><div class="label"><label><?php echo '打开方式' . '：';?></label></div><div class="field"><div class="button-group border-main radio"><?php $_result=config('link_target'); $__LIST__ = $_result; foreach($__LIST__ as $key => $val): ?><label class="button  <?php if(!is_null($dataEdit['ad_target']) && $key == $dataEdit['ad_target']): echo "active"; endif;?>" ><input name="<?php echo 'ad_target' ;?>" value="<?php echo $key;?>" type="radio" <?php if(!is_null($dataEdit['ad_target']) && $key == $dataEdit['ad_target']): echo "checked=\"checked\""; endif;?>><?php echo $val;?></label><?php endforeach; ?></div><div class="input-note"><?php echo '';?></div></div></div>				
		
		<div class="form-group"><div class="label"><label><?php echo '排序' . '：';?></label></div><div class="field"><input name="<?php echo 'order_id';?>"   class="input input w50" type="text" value="<?php echo '1';?>" ><div class="input-note"><?php echo '';?></div></div></div>
		<div class="form-group"><div class="label"><label><?php echo '显示' . '：';?></label></div><div class="field"><div class="button-group border-main radio"><?php $_result=config('is_show'); $__LIST__ = $_result; foreach($__LIST__ as $key => $val): ?><label class="button  <?php if(!is_null($dataEdit['is_show']) && $key == $dataEdit['is_show']): echo "active"; endif;?>" ><input name="<?php echo 'is_show' ;?>" value="<?php echo $key;?>" type="radio" <?php if(!is_null($dataEdit['is_show']) && $key == $dataEdit['is_show']): echo "checked=\"checked\""; endif;?>><?php echo $val;?></label><?php endforeach; ?></div><div class="input-note"><?php echo '';?></div></div></div>
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
<script type="text/javascript" src="<?php echo $style_path; ?>/js/pintuer.js"></script>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/admin.js"></script>

</body>
</html>
