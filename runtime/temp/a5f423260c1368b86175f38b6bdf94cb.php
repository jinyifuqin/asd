<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:66:"D:\xampp001\htdocs\wj31/application/portal\view\common\footer.html";i:1495376238;}*/ ?>
<!--footer--><div class="footer"><div class="container"><div class="fottop"><?php $_result=get_nav_child_all('footer');if(is_array($_result) || $_result instanceof \think\Collection || $_result instanceof \think\Paginator): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="fotbox float_l" <?php if($i == 1): ?>style="padding-left:0;"<?php endif; ?>><h1><?php echo $vo['nav_name']; ?></h1><?php if(is_array($vo['_child']) || $vo['_child'] instanceof \think\Collection || $vo['_child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$_child): $mod = ($i % 2 );++$i;?><a href="<?php echo $_child['nav_link']; ?>" target="<?php echo $_child['nav_target']; ?>"><?php echo $_child['nav_name']; ?></a><?php endforeach; endif; else: echo "" ;endif; ?></div><?php endforeach; endif; else: echo "" ;endif; ?><div class="fotbox1 float_r"><div class="ewm"><img src="<?php echo $default_path; ?>/images/ewm.jpg" alt="" width="132"/>关注网站微信</div></div><div class="clear"></div></div><div class="fotbot"><a href=""><?php echo $setting['copyright']; ?><?php echo $setting['icp']; ?></a><div class="fotb float_r"><p>全国咨询热线</p><h1><?php echo $setting['telephone']; ?></h1><span>Consultation hitline</span></div><div class="clear"></div></div></div></div><div class="fanhui"><img src="<?php echo $default_path; ?>/images/top.png"/></div><script type="text/javascript" src="<?php echo $default_path; ?>/js/aos.js"></script><script>    AOS.init({
        easing: 'ease-out-back',
        duration: 1000
    });
</script>