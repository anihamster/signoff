<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo It::baseUrl(); ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo It::baseUrl(); ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo It::baseUrl(); ?>/css/ie.css" media="screen, projection" />
	<![endif]--> 


	<link rel="stylesheet" type="text/css" href="<?php echo It::baseUrl(); ?>/css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo It::baseUrl(); ?>/css/form.css" />

	<script type="text/javascript">
		var BaseUrl = "<?php echo It::baseUrl(); ?>";
	</script>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="<?php echo It::baseUrl(); ?>/js/arctic/jquery.arcticmodal-0.3.min.js"></script>
    <link rel="stylesheet" href="<?php echo It::baseUrl(); ?>/js/arctic/jquery.arcticmodal-0.3.css">
    <link rel="stylesheet" href="<?php echo It::baseUrl(); ?>/js/arctic/themes/simple.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<!-- header -->
    <div id="header">    	
    	<div id="logo">
    		<div style="float:left;">
    			<img src="<?php echo It::baseUrl(); ?>/images/head.png" />
    		</div>
    		<div style="float:left; padding-top: 20px; padding-left: 45px;">
    			<a href="#"><?php echo CHtml::encode(Yii::app()->name); ?></a>
    		</div>
    		<div class="clear"></div>	
		</div>
        <div id="menu">
            <ul>
				<?php if(!It::isGuest() AND ((It::getState('user_role') == '1') OR (It::getState('head') == '1'))): ?>
            	<li>
            		<a href="<?php echo It::baseUrl(); ?>/admin/managers" <?php if((Yii::app()->controller->module->id == 'admin') && (Yii::app()->controller->id == 'managers')): ?>class="active"<?php endif; ?>>Users</a>
            	</li>
            	<?php endif; ?>
                <?php if(!It::isGuest() AND (It::getState('user_role') == '1')): ?>
                <li>
                    <a href="<?php echo It::baseUrl(); ?>/admin/default/settings" <?php if((Yii::app()->controller->module->id == 'admin') && (Yii::app()->controller->id == 'default')): ?>class="active"<?php endif; ?>>Settings</a>
                </li>
                <?php endif; ?>
            	<?php if(It::getState('user_role') == '1'):?>
           		<li>
           			<a href="<?php echo It::baseUrl(); ?>/admin/projects" <?php if((Yii::app()->controller->module->id == 'admin') && (Yii::app()->controller->id == 'projects')): ?>class="active"<?php endif; ?>>Projects</a>
           		</li>
            	<?php endif; ?>
            	<?php if(!It::isGuest() AND (It::getState('user_role') !== '1')): ?>
            	<li>
            		<a href="<?php echo It::baseUrl(); ?>/manager/projects" <?php if((Yii::app()->controller->module->id == 'manager') && (Yii::app()->controller->id == 'projects') && (Yii::app()->controller->action->id == 'index')): ?>class="active"<?php endif; ?>>For signing</a>
            	</li>
            	<?php endif; ?>
            	<?php if(!It::isGuest() AND (It::getState('user_role') !== '1')): ?>
           		<li>
           			<a href="<?php echo It::baseUrl(); ?>/manager/projects/my" <?php if((Yii::app()->controller->module->id == 'manager') && (Yii::app()->controller->id == 'projects') && (Yii::app()->controller->action->id == 'my')): ?>class="active"<?php endif; ?>>My projects</a>
           		</li>
            	<?php endif; ?>
            	<?php if(It::isGuest()):?>
            	<li>
            		<a href="<?php echo It::baseUrl(); ?>/main/default/login" <?php if(It::isGuest()): ?>class="active"<?php endif; ?>>Login</a>
            	</li>
            	<?php else: ?>
           		<li>
           			<a href="<?php echo It::baseUrl(); ?>/main/default/logout">Logout</a>
           		</li>
            	<?php endif; ?>
        	</ul>
        </div>
    </div>
    <!--end header -->
    <!-- main -->
<!-- container -->
<div id="container">
    <div id="main">
    	<?php echo $content; ?>

		<div class="clear"></div>
		<div id="garant"></div>
    </div>
    <!-- end main -->
</div>
<!-- end container -->
    <!-- footer -->    
    <div id="footer">
    <div id="left_footer">Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
	</div>
    <div id="right_footer"><?php echo Yii::powered(); ?></div>
    </div>
    <!-- end footer -->
</body>
</html>
