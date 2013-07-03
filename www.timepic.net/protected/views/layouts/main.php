<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="zh-CN" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->getBaseUrl(true); ?>/css/style.css"/>

	<?php Yii::app()->bootstrap->register(); ?>
</head>

<body>
<div class="row-fluid">
	<div id="cloud1" class="clouds">
		<div id="clouds_small"></div>
	</div><!-- end clouds -->
	<div id="cloud_front" class="clouds">
		<div id="clouds_big"></div>
	</div>
</div><!-- end clouds -->
<script>
	var small_scrollSpeed = 50;
	var small_step = 5;
	var small_current = 0;
	var small_imageWidth = 600;
	var small_headerWidth = 800;   
//	var small_restartPosition = (small_headerWidth - small_imageWidth);
        var small_restartPosition = 500;
	var small_clouds = $('#clouds_small');
	
	function scrollBg(){
		small_current += small_step;
		if (small_current == small_restartPosition){
		  small_current = 0;
		}
		small_clouds.css("background-position",small_current+"px 0");
	}
	// init = setInterval("scrollBg()", small_scrollSpeed);
	//var init_big = setInterval("scrollBg('big')", big_scrollSpeed);
</script>
<?php

//memberinfo
$memberInfo = array();
if (!Yii::app()->user->isGuest && Yii::app()->user->username) {
        $adminLogin = isset (Yii::app()->user->adminid) ? '<li><a href="/admin/member/login">'."登陆后台".'</a></li>': '';
        $memberInfo = '<ul class="nav pull-right">
                         <li class="dropdown">
                                <a href="#" class="userInfo dropdown-toggle" data-toggle="dropdown">
                                        <img class="avatar" src="'.Yii::app()->user->avatar.'"/>  <span class="nc">'.Yii::app()->user->username.'</span>
                                        <b class="caret"></b>
                                </a>

                                <ul class="dropdown-menu">
                                        '.$adminLogin.'
                                        <li><a href="/TPUser/logout">'.Yii::t('Base', 'Logout').'</a></li>
                                </ul>
                         </li>
                         
                       </ul>';
} else {
        $sinaLoginUrl = CommonHelper::getOpenIdUrl(1);
        $memberInfo = '<ul class="nav pull-right"><li><a href="'.$sinaLoginUrl.'"><img src="'.Yii::app()->request->getBaseUrl(true).'/images/static/common/sina_16.png"/>  '.Yii::t('Base', 'Login').'</a></li></ul>';
}

$this->widget('bootstrap.widgets.TbNavbar', array(
    'fixed' => 'top',
    'type' => 'inverse',
    'brand' => 'TimePic',
    'brandUrl' => Yii::app()->params['site'],
    'collapse' => true, // requires bootstrap-responsive.css
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'items' => CommonHelper::TimePicMenu(Yii::app()->request->requestUri),
        ),
        $memberInfo,
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'htmlOptions' => array('class' => 'pull-right'),
            'items' => CommonHelper::TimePicMenu(Yii::app()->request->requestUri, true),
        ),
        
    ),
));
?>

<div id="container" class="container">
	<header></header>
	
	<?php echo $content; ?>
	<div class="clear"></div>

</div><!-- page -->

<footer id="footer" class="footer">
    <div class="container">
        <!-- <p>Copyright &copy; <?php echo date('Y'); ?> TimePic. All Rights Reserved.</p> -->
        <address>
            <strong><?php echo Yii::t('Base','Contact Us');?> </strong><br>
            <a href="mailto:#">timepic.net@gmail.com</a>
        </address>                
    </div>
</footer><!-- footer -->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-30636024-1']);
  _gaq.push(['_setDomainName', 'timepic.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script type="text/javascript"> 
if (top.location !== self.location) { 
top.location=self.location; 
} 
</script> 

</body>
</html>
