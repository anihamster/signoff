<div id="full_text" align="center">
    <div class="form-container">
<?php echo CHtml::form(); ?>
<?php echo CHtml::errorSummary($form); ?>
    <div class="form-title"><h2>Sign up*</h2></div>
    <div class="form-title"><?php echo Chtml::activeLabel($form, 'LOGIN'); ?></div>
    <img src="<?php echo It::baseUrl() ?>/images/ico/forms/login.png" />&nbsp;&nbsp;<?php echo Chtml::activeTextField($form, 'LOGIN', array('class' => 'form-field')); ?><br />
    <div class="form-title"><?php echo Chtml::activeLabel($form, 'PASSWORD'); ?></div>
    <img src="<?php echo It::baseUrl() ?>/images/ico/forms/password.png" />&nbsp;&nbsp;<?php echo CHtml::activePasswordField($form, 'PASSWORD', array('class' => 'form-field')); ?><br />
    <div class="submit-container">
        <?php echo CHtml::submitButton('Sign in', array('class' => 'submit-button')); ?>
    </div>
<?php echo CHtml::endForm(); ?>
    </div>
    <br />
<small>* You must to sign in to get access to the system.</small>
</div>