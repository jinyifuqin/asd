<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:68:"D:\xampp001\htdocs\wj31/application/backend\view\database\index.html";i:1494043390;s:58:"D:\xampp001\htdocs\wj31/application/backend\view\base.html";i:1520934308;s:65:"D:\xampp001\htdocs\wj31/application/backend\view\development.html";i:1495532356;}*/ ?>
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
    <div class="panel-head"><strong class="icon-reorder"> 数据表</strong></div>
    <div class="panel-button padding border-bottom">
<?php $_result=url('backup');?><button id="" class="button border-main"" type="submit" chick-href="<?php echo $_result; ?>"><span class="icon-plus-square-o"></span> 全部备份</button> 
</div>
    <div class="body-content">
<div class="table-responsive">
  <table class="table table-hover">
    <tr>
      <th width="8%">序号</th>
      <th>表名称</th>
      <th width="*">引擎</th>
      <th width="*">行数</th>
      <th width="*">数据大小</th>
      <th width="">更新时间</th>
      <th width="*">注释</th>
      <th width="24%">操作</th>
    </tr>
    <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): $i = 0; $__LIST__ = $dataList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <tr>
      <td><label for="id_<?php echo $i; ?>"><?php echo $i; ?></label></td>
      <td><?php echo $vo['Name']; ?></td>
      <td><?php echo (isset($vo['Engine']) && ($vo['Engine'] !== '')?$vo['Engine']:"--"); ?></td>
      <td><?php echo $vo['Rows']; ?></td>
      <td><?php echo get_byte_size($vo['Index_length']+$vo['Data_length']); ?></td>
      <td><?php echo (isset($vo['Update_time']) && ($vo['Update_time'] !== '')?$vo['Update_time']:$vo['Create_time']); ?></td>
      <td><?php echo $vo['Comment']; ?></td>
      <td><div class="button-group"> 
      <a class="button border-main" href="<?php echo url('struct','table='.$vo['Name']); ?>"><span class="icon-edit"></span> 结构</a> 
      <a class="button border-main button-ajax" href="<?php echo url('optimize','table='.$vo['Name']); ?>"><span class="icon-edit"></span> 优化</a> 
      <a class="button border-main button-ajax" href="<?php echo url('repair','table='.$vo['Name']); ?>"><span 
      class="icon-edit"></span> 修复</a> 
      <a class="button border-main" href="<?php echo url('backup','table='.$vo['Name']); ?>"><span class="icon-edit"></span> 备份</a> 
      </div></td>
    </tr>
	<?php endforeach; endif; else: echo "" ;endif; ?>
  </table>  
</div>
</div>
</div>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/pintuer.js"></script>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/admin.js"></script>

<script type="text/javascript">
  $(function() {
    $('.button-ajax').click(function(event) {
        var href = $(this).attr('href');
        $.getJSON(href, {}, function(data, textStatus) {
            if(data.code == 1){
                showTips(data.msg, 1);
            }else{
                showTips(data.msg, 2);
            }
        });
        return false;
    });
  });
</script>

</body>
</html>
