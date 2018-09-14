<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:67:"D:\xampp001\htdocs\wj31/application/backend\view\setting\index.html";i:1495779259;s:58:"D:\xampp001\htdocs\wj31/application/backend\view\base.html";i:1520934308;s:65:"D:\xampp001\htdocs\wj31/application/backend\view\development.html";i:1495532356;s:72:"D:\xampp001\htdocs\wj31/application/backend\view\setting\form-group.html";i:1495783547;}*/ ?>
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
    <div class="panel-head"><strong class="icon-reorder"> 站点配置</strong></div>
    <div class="panel-button padding border-bottom">
<?php if($group == 'custom'): $_result=url('add');?><button id="" class="button border-main"" type="submit" chick-href="<?php echo $_result; ?>"><span class="icon-plus-square-o"></span> 添加</button> 
<?php endif; ?>
</div>
    <div class="body-content">
<div class="body-content">
    <form method="post" class="form-x" action="">
        <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): $i = 0; $__LIST__ = $dataList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;switch($vo['type']): case "input": ?>
        <div class="form-group"><div class="label"><label><?php echo $vo['title'] . '：';?></label></div><div class="field"><input name="<?php echo $vo['id'];?>"   class="input input w50" type="text" value="<?php echo $vo['value'];?>" ><div class="input-note"><?php echo $vo['desc'];?></div></div></div>
    <?php break; case "password": ?>
        <div class="form-group"><div class="label"><label><?php echo $vo['title'] . '：';?></label></div><div class="field"><input name="<?php echo $vo['id'];?>"   class="input input w50" type="password" value="<?php echo $vo['value'];?>" ><div class="input-note"><?php echo $vo['desc'];?></div></div></div>
    <?php break; case "textarea": ?>
        <div class="form-group"><div class="label"><label><?php echo $vo['title'] . '：';?></label></div><div class="field"><textarea name="<?php echo $vo['id'];?>"   class="input input w80" type="text" ><?php echo $vo['value'];?></textarea><div class="input-note"><?php echo $vo['desc'];?></div></div></div>
    <?php break; case "img": ?>
        <div class="form-group"><div class="label"><label><?php echo $vo['title'] . '：';?></label></div><div class="field"><a class="button input-flie" more="0" file-name="<?php echo $vo['id'];?>" id="v_b57c41451d2e60a8800f4d40eb28b6ac_button" href="javascript:void(0);">+ 浏览文件</a><div class="imgdiv"></div><?php if(!isset($_ueditor) || $_ueditor != true): ;?><script type="text/javascript">var ueControllerPath = "/backend/ueditor/index.html";</script><script type="text/javascript" src="/public/static/backend/plugin/ueditor/ueditor.config.js"></script><script type="text/javascript" src="/public/static/backend/plugin/ueditor/ueditor.all.min.js"></script><script type="text/javascript" src="/public/static/backend/plugin/ueditor/lang/zh-cn/zh-cn.js"></script><?php $_ueditor = true; endif;?><script id="v_b57c41451d2e60a8800f4d40eb28b6ac"></script><script>var v_b57c41451d2e60a8800f4d40eb28b6ac_imgstr = "<?php echo $vo['value'];?>";
                    var v_b57c41451d2e60a8800f4d40eb28b6ac_imgarr = v_b57c41451d2e60a8800f4d40eb28b6ac_imgstr.split(",");<?php if(!isset($_has_addimg) || $_has_addimg != true): ;?>
                    function addImg(imgsrc, obj, class_name){
                        var name = $(obj).attr("file-name");
                        var html = '<div class="padding border float-left margin-right badge-corner"><span class="imgremove badge bg-red">X</span><img src="'+imgsrc+'" class="img-border radius-small" />';
                        html += '<input name="'+name+'" id="<?php echo $vo['id'];?>" class="input '+class_name+'" type="hidden" value="'+imgsrc+'" >';
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
                    <?php $_has_addimg = true; endif;?>if(v_b57c41451d2e60a8800f4d40eb28b6ac_imgstr != "" && v_b57c41451d2e60a8800f4d40eb28b6ac_imgarr){
                        $.each(v_b57c41451d2e60a8800f4d40eb28b6ac_imgarr, function(index, val) {
                            // console.log(val);
                            addImg(val, "#v_b57c41451d2e60a8800f4d40eb28b6ac_button",'');
                        });
                    }
                    var v_b57c41451d2e60a8800f4d40eb28b6ac = UE.getEditor("v_b57c41451d2e60a8800f4d40eb28b6ac");
                    v_b57c41451d2e60a8800f4d40eb28b6ac.ready(function (){
                        //设置编辑器不可用(事实上不可以设置不可用...所以注释掉,以观后效)
                        // v_b57c41451d2e60a8800f4d40eb28b6ac.setDisabled();
                        //隐藏编辑器,因为只使用上传功能
                        v_b57c41451d2e60a8800f4d40eb28b6ac.hide();
                        //侦听图片上传
                        v_b57c41451d2e60a8800f4d40eb28b6ac.addListener('beforeInsertImage',function(t,arg){
                            console.log(arg);
                            var imgsrc = arg[0].src;
                        
                            // $("#v_b57c41451d2e60a8800f4d40eb28b6ac_button").prev("input[type=text]").val(imgsrc);
                                addImg(imgsrc, "#v_b57c41451d2e60a8800f4d40eb28b6ac_button",'');
                        // if(layer) layer.msg("上传成功！");
                        });
                    });
                    //上传dialog
                    $(document).ready(function() {
                        $("#v_b57c41451d2e60a8800f4d40eb28b6ac_button").click(function(event) {
                            var myImage = v_b57c41451d2e60a8800f4d40eb28b6ac.getDialog("insertimage");
                            // var myImage = v_b57c41451d2e60a8800f4d40eb28b6ac.getDialog("attachment");
                            myImage.open();
                        });
                    });
                    </script><div class="clear"></div><div class="input-note"><?php echo $vo['desc'];?></div></div></div>         
    <?php break; case "editor": ?>
        <div class="form-group"><div class="label"><label><?php echo $vo['title'] . '：';?></label></div><div class="field"><textarea name="<?php echo $vo['id'] ;?>" id="<?php echo $vo['id'] ;?>" style='width:100%;height:300px;max-width:1000px;'><?php echo $vo['value']; ?></textarea><?php if(!isset($_ueditor) || $_ueditor != true): ;?><script type="text/javascript">var ueControllerPath = "/backend/ueditor/index.html";</script><script type="text/javascript" src="/public/static/backend/plugin/ueditor/ueditor.config.js"></script><script type="text/javascript" src="/public/static/backend/plugin/ueditor/ueditor.all.min.js"></script><script type="text/javascript" src="/public/static/backend/plugin/ueditor/lang/zh-cn/zh-cn.js"></script><?php $_ueditor = true; endif;?><script>var ue = UE.getEditor("<?php echo $vo['id'] ;?>"); </script><div class="input-note"><?php echo $vo['desc'];?></div></div></div>
    <?php break; case "radio": ?>
        <div class="form-group"><div class="label"><label><?php echo $vo['title'] . '：';?></label></div><div class="field"><div class="button-group border-main radio"><?php $_result=config('radio'); $__LIST__ = $_result; foreach($__LIST__ as $key => $val): ?><label class="button  <?php if(!is_null($vo['value']) && $key == $vo['value']): echo "active"; endif;?>" ><input name="<?php echo $vo['id'] ;?>" value="<?php echo $key;?>" type="radio" <?php if(!is_null($vo['value']) && $key == $vo['value']): echo "checked=\"checked\""; endif;?>><?php echo $val;?></label><?php endforeach; ?></div><div class="input-note"><?php echo $vo['desc'];?></div></div></div>                      
    <?php break; endswitch; endforeach; endif; else: echo "" ;endif; ?>
        <div class="form-group">
            <div class="label">
                <label></label>
            </div>
        <div class="field">
            <button class="button bg-main icon-check-square-o" type="submit"> 提交</button>
        </div>
      </div>
    </form>
  </div>
</div>
</div>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/pintuer.js"></script>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/admin.js"></script>

</body>
</html>
