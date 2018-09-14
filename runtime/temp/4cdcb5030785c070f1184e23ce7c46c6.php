<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:65:"D:\xampp001\htdocs\wj31/application/backend\view\auth\access.html";i:1494043387;s:58:"D:\xampp001\htdocs\wj31/application/backend\view\base.html";i:1520934308;s:65:"D:\xampp001\htdocs\wj31/application/backend\view\development.html";i:1495532356;}*/ ?>
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
    <div class="panel-head"><strong class="icon-reorder"> 授权管理</strong></div>
    <div class="panel-button padding border-bottom">
</div>
    <div class="body-content">
<div class="table-responsive">
<table class="table table-hover">
    <tr>      
      <th>菜单名称</th>
      <th>菜单URL</th>
      <th>查看(GET)</th>
      <th>保存(POST)</th>
    </tr>
    <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): $i = 0; $__LIST__ = $dataList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <tr>      
      <td><?php echo $vo['prefix']; ?><?php echo $vo['menu_name']; ?></td>
      <td><?php echo $vo['menu_link']; ?></td>
      <td><?php if(!(empty($vo['menu_link']) || (($vo['menu_link'] instanceof \think\Collection || $vo['menu_link'] instanceof \think\Paginator ) && $vo['menu_link']->isEmpty()))): ?><input class="auth" <?php if((isset($vo['get']) && ($vo['get'] !== '')?$vo['get']:0) != '0'): ?>checked<?php endif; ?> type="checkbox" url="<?php echo $vo['menu_link']; ?>" name="get"><?php endif; ?></td>
      <td><?php if(!(empty($vo['menu_link']) || (($vo['menu_link'] instanceof \think\Collection || $vo['menu_link'] instanceof \think\Paginator ) && $vo['menu_link']->isEmpty()))): ?><input class="auth" <?php if((isset($vo['post']) && ($vo['post'] !== '')?$vo['post']:0) != '0'): ?>checked<?php endif; ?> type="checkbox" url="<?php echo $vo['menu_link']; ?>" name="post"><?php endif; ?></td>      
    </tr>
	<?php endforeach; endif; else: echo "" ;endif; ?>
</table>
</div>
</div>
</div>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/pintuer.js"></script>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/admin.js"></script>

<script type="text/javascript">
    $(function(){
        $(".auth").click(function(event) {
            var url = $(this).attr('url');
            var get = $(this).parents('tr').find('input[name=get]').is(':checked') ? 1 : 0 ;
            var post = $(this).parents('tr').find('input[name=post]').is(':checked') ? 1 : 0;
            var put = 0;
            var deleteStr = 0;
            $.ajax({
                url: '',
                type: 'POST',
                dataType: 'json',
                data: {urlName: url, get: get, post: post, put: put, delete: deleteStr}
            })
            .always(function(data) {
                if(data.code == 1){
                    layer.msg('操作成功！', {
                        icon: 1,                        
                        skin: 'layer-ext-moon'
                    });
                }
            });
            
        });
    });
</script>

</body>
</html>
