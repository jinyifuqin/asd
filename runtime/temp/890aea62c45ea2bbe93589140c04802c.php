<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:61:"D:\xampp001\htdocs\wj31/application/backend\view\ad\edit.html";i:1495601565;s:58:"D:\xampp001\htdocs\wj31/application/backend\view\base.html";i:1520934308;s:65:"D:\xampp001\htdocs\wj31/application/backend\view\development.html";i:1495532356;}*/ ?>
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
		<div class="form-group"><div class="label"><label><?php echo '唯一标识' . '：';?></label></div><div class="field"><input name="<?php echo 'guid';?>"   class="input input w50" type="text" value="<?php echo $dataEdit['guid'];?>" ><div class="input-note"><?php echo '';?></div></div></div>
		<div class="form-group"><div class="label"><label><?php echo '广告类型' . '：';?></label></div><div class="field"><div class="button-group border-main radio"><?php $_result=config('ad_type'); $__LIST__ = $_result; foreach($__LIST__ as $key => $val): ?><label class="button  <?php if(!is_null($dataEdit['ad_type']) && $key == $dataEdit['ad_type']): echo "active"; endif;?>" ><input name="<?php echo 'ad_type' ;?>" value="<?php echo $key;?>" type="radio" <?php if(!is_null($dataEdit['ad_type']) && $key == $dataEdit['ad_type']): echo "checked=\"checked\""; endif;?>><?php echo $val;?></label><?php endforeach; ?></div><div class="input-note"><?php echo '';?></div></div></div>				
		
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
