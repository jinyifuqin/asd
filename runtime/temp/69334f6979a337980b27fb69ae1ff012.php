<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:61:"D:\xampp001\htdocs\wj31/application/common\view\tpl\tips.html";i:1494043415;s:61:"D:\xampp001\htdocs\wj31/application/common\view\tpl\base.html";i:1494043415;}*/ ?>
<!DOCTYPE html>
<html lang="cn">
<head>
	<meta charset="UTF-8">
	<title>提示消息……</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />	
	<link rel="stylesheet" href="<?php echo $style_path; ?>/css/tpl.css">
	<script type="text/javascript" src="<?php echo $style_path; ?>/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo $style_path; ?>/layer/layer.js"></script>
</head>
<body>	
	<div id="tips_con">
		<ul class="tips_con_header">
			<li class="tips_bg1"></li><li class="tips_bg2"></li><li class="tips_bg1"></li><li class="tips_bg2"></li><li class="tips_bg1"></li><li class="tips_bg2"></li><li class="tips_bg1"></li><li class="tips_bg2"></li><li class="tips_bg1"></li><li class="tips_bg2"></li>
		</ul>
		<div class="clear"></div>
		<div class="tips_con_body">
			<div class="tips_con_body_up">				
		        <?php if (@$status_code) {?>
		        	<h1><?php echo($status_code);?></h1><?php echo(strip_tags($msg));}else{ switch ($code) {case 1:?>
		            <h1>:)</h1><?php echo(strip_tags($msg));break;case 0:?>
		            <h1>:(</h1><?php echo(strip_tags($msg));break;}} ?>
			</div>
			
<div class="tips_con_body_down">
	<ul class="tips_body_list">
		<li class="tips_body_list_tit">您还可以：</li>
		<li><a href="<?php echo url('index/dashboard'); ?>">&bull;&nbsp;返回控制台</a></li>
		<li><a id="href" href="<?php echo($url);?>">&bull;&nbsp;页面将在（<b id="wait"><?php echo($wait);?></b>）秒后自动跳转……</a></li>
	</ul>
</div>

			<div class="clear"></div>
		</div>
	</div>	
	    <script type="text/javascript">
	    //layer全局
		var layer = parent.layer;
		layer.closeAll();
        (function(){
            var wait = document.getElementById('wait'),
                href = document.getElementById('href').href;
            var interval = setInterval(function(){
                var time = --wait.innerHTML;
                if(time <= 0) {
                    location.href = href;
                    clearInterval(interval);
                };
            }, 1000);
        })();
    </script>
</body>
</html>