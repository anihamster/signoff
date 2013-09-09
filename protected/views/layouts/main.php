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


	<link rel="stylesheet" type="text/css" href="<?php echo It::baseUrl(); ?>/css/style3.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo It::baseUrl(); ?>/css/screen-nlr.css" />
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
<div id="header">
    <div class="grid">
        <div id="ident">
            <img src="<?php echo It::baseUrl(); ?>/imgs/logo.png" />
        </div>
        <div id="h_title">
            <h2>Sign-off</h2>
        </div>
        <div class="clear"></div>
    </div>
    <div id="menu_panel">
        <div class="grid">
            <div id="mainmenu">
                <ul>
                    <?php if(!It::isGuest() AND ((It::getState('user_role') == '1') OR (It::getState('head') == '1'))): ?>
                        <li>
                            <a href="<?php echo It::baseUrl(); ?>/admin/managers" <?php if((Yii::app()->controller->module->id == 'admin') && (Yii::app()->controller->id == 'managers')): ?>class="current"<?php endif; ?>>Users</a>
                        </li>
                    <?php endif; ?>
                    <?php if(!It::isGuest() AND (It::getState('user_role') == '1')): ?>
                        <li>
                            <a href="<?php echo It::baseUrl(); ?>/admin/default/settings" <?php if((Yii::app()->controller->module->id == 'admin') && (Yii::app()->controller->id == 'default')): ?>class="current"<?php endif; ?>>Settings</a>
                        </li>
                    <?php endif; ?>
                    <?php if(It::getState('user_role') == '1'):?>
                        <li>
                            <a href="<?php echo It::baseUrl(); ?>/admin/projects" <?php if((Yii::app()->controller->module->id == 'admin') && (Yii::app()->controller->id == 'projects')): ?>class="current"<?php endif; ?>>Projects</a>
                        </li>
                    <?php endif; ?>
                    <?php if(!It::isGuest() AND (It::getState('user_role') !== '1')): ?>
                        <li>
                            <a href="<?php echo It::baseUrl(); ?>/manager/projects" <?php if((Yii::app()->controller->module->id == 'manager') && (Yii::app()->controller->id == 'projects') && (Yii::app()->controller->action->id == 'index')): ?>class="current"<?php endif; ?>>For signing</a>
                        </li>
                    <?php endif; ?>
                    <?php if(!It::isGuest() AND (It::getState('user_role') !== '1')): ?>
                        <li>
                            <a href="<?php echo It::baseUrl(); ?>/manager/projects/my" <?php if((Yii::app()->controller->module->id == 'manager') && (Yii::app()->controller->id == 'projects') && (Yii::app()->controller->action->id == 'my')): ?>class="current"<?php endif; ?>>My projects</a>
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
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<div id="maket">
    <?php echo $content; ?>
    <div class="clear"></div>
    <div id="garant"></div>
</div>
<div id="footer">
    <div id="copy">
        <strong>&copy; My company, 2013.</strong>
    </div>
</div>
</body>
</html>
