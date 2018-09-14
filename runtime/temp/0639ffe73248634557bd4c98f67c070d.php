<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:69:"D:\xampp001\htdocs\wj31/application/backend\view\index\dashboard.html";i:1520934367;s:65:"D:\xampp001\htdocs\wj31/application/backend\view\development.html";i:1495532356;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="renderer" content="webkit">
    <title> | 管理中心</title>
    <link rel="stylesheet" href="<?php echo $style_path; ?>/css/pintuer.css">
    <link rel="stylesheet" href="<?php echo $style_path; ?>/css/admin.css">
    <style type="text/css">
    <?php if(!config('app_debug')): ?>
    .show-development{display: none !important;}
    <?php endif; ?>
</style>
    
</head>
<body style="overflow-x: hidden;">
	<div class="line-big">
		<div class="xm3">
			<div class="panel border-back">
				<div class="panel-body text-center">
					<img src="<?php echo $avatar; ?>" onerror="this.src='<?php echo $style_path; ?>/images/avatar/noavatar_middle.gif'" width="120" class="radius-circle">
					<br> admin
				</div>
				<div class="panel-foot bg-back border-back">您好，<?php echo $nickname; ?>，这是您第<?php echo $login_times; ?>次登录！上次登录为<?php echo $login_time; ?>。</div>
			</div>
			<br>
			<div class="panel">
				<div class="panel-head"><strong>站点统计</strong></div>
				<ul class="list-group">							
					<li><span class="float-right badge bg-main"><?php echo $siteCount['admin']; ?></span><span class="icon-user"></span> 管理员</li>
					<li><span class="float-right badge bg-main"><?php echo $siteCount['category']; ?></span><span class="icon-th-list"></span> 栏目</li>
					<li><span class="float-right badge bg-main"><?php echo $siteCount['article']; ?></span><span class="icon-list-alt"></span> 文章</li>
					<li><span class="float-right badge bg-main"><?php echo $siteCount['link']; ?></span><span class="icon-arrows"></span> 链接</li>
					<li><span class="float-right badge bg-main"><?php echo $siteCount['ad']; ?></span><span class="icon-laptop"></span> 广告</li>
					<li><span class="float-right badge bg-main"><?php echo $siteCount['message']; ?></span><span class="icon-comments"></span> 留言</li>
					<li><span class="float-right badge bg-main"><?php echo $siteCount['log']; ?></span><span class="icon-pencil-square"></span> 日志</li>
					<li><span class="float-right badge bg-main"><?php echo $siteCount['db']; ?></span><span class="icon-database"></span> 数据库</li>
				</ul>
			</div>
			<br>
			<!-- <div class="panel">
				<div class="panel-head"><strong>研发团队</strong></div>
				<table class="table">
					<tbody>
					<tr><td colspan="2">总架构师</td></tr>
					<tr>
						<td width="110" align="right">TechLee&emsp;</td>
						<td></td>								
					</tr>
					<tr><td colspan="2">技术支持</td></tr>
					<tr>
						<td width="110" align="right">&emsp;</td>
						<td></td>								
					</tr>
					<tr><td colspan="2">鸣谢</td></tr>
					<tr>
						<td width="110" align="right">&emsp;</td>
						<td></td>								
					</tr>
				</tbody></table>
			</div> -->
		</div>
		<div class="xm9">						
			<div class="alert alert-red show-development"><span class="close"></span><strong>警告：</strong>当前系统为开发模式，如果您的平台已上线，安全起见，请联系开发者切换为生产模式！</div>			
			<div class="alert">
				<div class="media padding-big-bottom">
                    <img src="<?php echo $style_path; ?>/images/logo_normal.png" class="radius" alt="<?php echo config('base.app_name'); ?>">
                </div>
				<h4><?php echo $app_name; ?></h4>
				<p class="text-gray"><?php echo $app_description; ?></p>
				<!-- <a target="_blank" class="button bg-dot icon-code" href="pintuer2.zip"> 下载示例代码</a>
				<a target="_blank" class="button bg-main icon-download" href="http://www.pintuer.com/download/pintuer.zip"> 下载框架</a>
				<a target="_blank" class="button border-main icon-file" href="http://www.pintuer.com/"> 使用教程</a> -->
			</div>
			<div class="panel">
				<div class="panel-head"><strong>系统信息</strong></div>
				<table class="table">
					<tbody>
					<tr><td colspan="2">应用信息</td></tr>
					<tr>
						<td width="110" align="right">应用名称：</td>
						<td><?php echo $app_name; ?></td>								
					</tr>
					<tr>
						<td width="110" align="right">应用版本：</td>
						<td><?php echo $app_version; ?></td>								
					</tr>
					<tr><td colspan="2">服务器信息</td></tr>
					<tr>
						<td width="110" align="right">操作系统：</td>
						<td><?php echo $serverInfo['os']; ?></td>								
					</tr>
					<tr>
						<td align="right">Web服务器：</td>
						<td><?php echo $serverInfo['server_software']; ?></td>								
					</tr>
					<tr>
						<td align="right">程序语言：</td>
						<td><?php echo $serverInfo['program_version']; ?></td>								
					</tr>
					<tr>
						<td align="right">数据库：</td>
						<td><?php echo $serverInfo['db_version']; ?></td>								
					</tr>
					<tr>
						<td align="right">服务器时间：</td>
						<td><?php echo $serverInfo['date']; ?></td>								
					</tr>
					<tr>
						<td align="right">浏览器信息：</td>
						<td><?php echo $serverInfo['http_user_agent']; ?></td>								
					</tr>
					<tr>
						<td align="right">官方团队：</td>
						<td><a href="<?php echo $serverInfo['app_support_site']; ?>" target="_blank"><?php echo $serverInfo['app_support']; ?></a></td>
					</tr>
				</tbody></table>
			</div>
		</div>
	</div>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo $style_path; ?>/layer/layer.js"></script>
<script type="text/javascript" src="<?php echo $style_path; ?>/js/pintuer.js"></script>  
<script type="text/javascript" src="<?php echo $style_path; ?>/js/admin.js"></script>  
</body>
</html>