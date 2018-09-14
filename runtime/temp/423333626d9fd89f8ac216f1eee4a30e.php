<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:64:"D:\xampp001\htdocs\wj31/application/backend\view\auth\index.html";i:1494043388;s:58:"D:\xampp001\htdocs\wj31/application/backend\view\base.html";i:1520934308;s:65:"D:\xampp001\htdocs\wj31/application/backend\view\development.html";i:1495532356;}*/ ?>
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
    <div class="panel-head"><strong class="icon-reorder"> 权限管理</strong></div>
    <div class="panel-button padding border-bottom">
<?php $_result=url('add');?><button id="" class="button border-main"" type="submit" chick-href="<?php echo $_result; ?>"><span class="icon-plus-square-o"></span> 添加用户组</button> 
</div>
    <div class="body-content">
<div class="table-responsive">
  <table class="table table-hover">
    <tr>
      <th width="5%">ID</th>
      <th>用户组</th>
      <th>描述</th>
      <th>更新时间</th>      
      <th>状态</th>
      <th width="20%">操作</th>
    </tr>
    <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): $i = 0; $__LIST__ = $dataList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <tr>
      <td><?php echo $vo->id; ?></td>
      <td><?php echo $vo->name; ?></td>
      <td><?php echo (isset($vo->description) && ($vo->description !== '')?$vo->description:"--"); ?></td>      
      <td><?php echo $vo->update_time_text; ?></td>
      <td><span class="tag_ststus_show" tag-value="<?php echo $vo->status; ?>"></span></td>
      <td><div class="button-group"> 
      <a class="button border-main" href="<?php echo url('access','id='.$vo->id); ?>"><span class="icon-edit"></span> 授权</a>
      <a class="button border-main" href="<?php echo url('edit','id='.$vo->id); ?>"><span class="icon-edit"></span> 修改</a>
      <a class="button border-red button-delete need-confirm" href="<?php echo url('delete','id='.$vo->id); ?>"><span class="icon-trash-o"></span> 删除</a> </div></td>
    </tr>
	<?php endforeach; endif; else: echo "" ;endif; ?>
  </table>
</div>
</div>
</div>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/pintuer.js"></script>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/admin.js"></script>

</body>
</html>
