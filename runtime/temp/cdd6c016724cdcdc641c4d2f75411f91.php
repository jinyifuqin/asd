<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:67:"D:\xampp001\htdocs\wj31/application/backend\view\article\index.html";i:1495371645;s:58:"D:\xampp001\htdocs\wj31/application/backend\view\base.html";i:1520934308;s:65:"D:\xampp001\htdocs\wj31/application/backend\view\development.html";i:1495532356;s:68:"D:\xampp001\htdocs\wj31/application/backend\view\article\search.html";i:1494043387;}*/ ?>
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
    <div class="panel-head"><strong class="icon-reorder"> 文章管理</strong></div>
    <div class="panel-button padding border-bottom">
<div class="panel-body panel-search">
	<form action="" method="get" class="form-x">	    
	    <div class="form-group"><div class="label"><label><?php echo '标题' . '：';?></label></div><div class="field"><input name="<?php echo 'title';?>"   class="input input w50" type="text" value="<?php echo '';?>" ><div class="input-note"><?php echo '';?></div></div></div>
		<div class="form-group"><div class="label"><label><?php echo '所属栏目' . '：';?></label></div><div class="field"><?php if(is_array($cateTree) || $cateTree instanceof \think\Collection):  $__LIST__ = $cateTree; $__ATTR__ = 'cate_model'; $__ATTR__ = $__ATTR__ ? explode(',', $__ATTR__) : [];if( count($__LIST__)==0 ) : echo "" ;else: ?><select name="<?php echo 'cate_id' ;?>" class="input " data-select="<?php echo \think\Request::instance()->get('cate_id') ;?>" ><option value="0">--请选择--</option><?php foreach($__LIST__ as $val): ?><option value="<?php echo $val['id'];?>" <?php foreach($__ATTR__ as $val_attr): echo isset($val[$val_attr]) ? $val_attr.'="'.$val[$val_attr].'"' : ''; endforeach; ?>> <?php echo (isset($val['prefix']) ? $val['prefix'] : "").$val['cate_name'];?></option><?php endforeach; endif; ?></select><?php else: echo "" ;endif; ?><div class="tips"></div></div></div>	   
	    <div class="form-group"><div class="label"><label><?php echo '审核' . '：';?></label></div><div class="field"><div class="button-group border-main radio"><?php $_result=config('status'); $__LIST__ = $_result; foreach($__LIST__ as $key => $val): ?><label class="button  <?php if(!is_null(\think\Request::instance()->get('status')) && $key == \think\Request::instance()->get('status')): echo "active"; endif;?>" ><input name="<?php echo 'status' ;?>" value="<?php echo $key;?>" type="radio" <?php if(!is_null(\think\Request::instance()->get('status')) && $key == \think\Request::instance()->get('status')): echo "checked=\"checked\""; endif;?>><?php echo $val;?></label><?php endforeach; ?></div><div class="input-note"><?php echo '';?></div></div></div>
	    <div class="form-group">
	    	<div class="label"><label></label></div>
	        <div class="field"><button class="button" type="submit">搜索</button></div>
	    </div>
	</form>
</div>

<button id="" class="button border-blue search" type="submit"><span class="icon-search"></span> 搜索</button> 
<?php $_result=url('delete');?><button id="" class="button border-red delete-multi" type="submit" chick-href="<?php echo $_result; ?>"><span class="icon-trash-o"></span> 批量删除</button> 
<?php $_result=url('add');?><button id="" class="button border-main"" type="submit" chick-href="<?php echo $_result; ?>"><span class="icon-plus-square-o"></span> 添加</button> 
</div>
    <div class="body-content">
<div class="table-responsive">
  <table class="table table-hover table-middle">
    <tr>
      <th width="5%"><input type="checkbox" checkfor="id" class="check_all" title="全选">ID</th>      
      <th>标题</th>
      <th>浏览</th>
      <th width="*">栏目类型</th>
      <th width="*">修改时间</th>
      <th width="10%">状态</th>
      <th width="15%">操作</th>
    </tr>
    <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): $i = 0; $__LIST__ = $dataList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
    <tr>
      <td><input type="checkbox" name="id" value="<?php echo $vo->id; ?>" id="id_<?php echo $vo->id; ?>"><label for="id_<?php echo $vo->id; ?>"><?php echo $vo->id; ?></label></td>
      <td title="<?php echo $vo->title; ?>" class="table-title"><?php echo substr_cn($vo->title,24); ?></td>
      <td><span class="badge bg-main"><?php echo $vo->views; ?>+</span></td>
      <td><?php echo (isset($vo->cate->cate_name) && ($vo->cate->cate_name !== '')?$vo->cate->cate_name:"--"); ?></td>
      <td><?php echo $vo->update_time_text; ?></td>
      <td><span class="tag_ststus_show" tag-value="<?php echo $vo->is_show; ?>"></span></td>
      <td><div class="button-group"> 
      <a class="button border-main" href="<?php echo url('edit','id='.$vo->id); ?>"><span class="icon-edit"></span> 修改</a> 
      <a class="button border-red button-delete need-confirm" href="<?php echo url('delete','id='.$vo->id); ?>"><span class="icon-trash-o"></span> 删除</a> </div></td>
    </tr>
	<?php endforeach; endif; else: echo "" ;endif; ?>
  </table>
</div>
  <?php echo $dataList->render(); ?>
</div>
</div>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/pintuer.js"></script>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/admin.js"></script>

<script id="uploadImage"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $("select[name=cate_id]").find('option[cate_model]').each(function(index, el) {
      if($(this).attr('cate_model') != '2'){
        $(this).attr('disabled','true').css('color', '#ccc');;        
      }
    });   
  });
</script>

</body>
</html>
