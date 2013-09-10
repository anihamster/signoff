<div id="text_full">
    <div class="form-container" style="width: 700px;" align="left">
        <?php echo CHtml::beginForm(); ?>
        <?php echo CHtml::errorSummary($form); ?>
        <?php echo CHtml::errorSummary($form2); ?>
        <div class="form-title"><h2>Users add</h2></div>
        <div class="form-title"><?php echo CHtml::activeLabel($form, 'LOGIN'); ?></div>
        <?php echo Chtml::activeTextField($form, 'LOGIN', array('class' => 'form-field')); ?><br />
        <div class="form-title"><?php echo CHtml::activeLabel($form, 'PASSWORD'); ?></div>
        <?php echo Chtml::activeTextField($form, 'PASSWORD', array('class' => 'form-field')); ?><br />
        <?php if(!(It::getState('head') == '1')): ?>
        <div class="form-title"><?php echo CHtml::activeLabel($form, 'TYPE'); ?></div>
        <?php echo CHtml::activeDropDownList($form, 'TYPE', $levels, array('class' => 'form-field', 'style' => 'height: 40px;')); ?><br />
        <div class="form-title"><?php echo CHtml::activeLabel($form2, 'KEY_USER'); ?></div>
        <?php echo CHtml::activeCheckBox($form2, 'KEY_USER', array('class' => 'form-field')); ?><br />
        <div class="form-title"><?php echo CHtml::activeLabel($form2, 'BRAND'); ?></div>
        <?php echo CHtml::activeDropDownList($form2, 'BRAND', $brands, array('class' => 'form-field', 'style' => 'height: 40px;')); ?><br />
        <?php endif; ?>
        <div class="form-title"><?php echo CHtml::activeLabel($form2, 'ROLE_ID'); ?></div>
        <?php echo CHtml::activeDropDownList($form2, 'ROLE_ID', $roles, array('class' => 'form-field', 'style' => 'height: 40px;')); ?><br />
        <div class="form-title"><?php echo CHtml::activeLabel($form2, 'CAN_ADD'); ?></div>
        <?php echo CHtml::activeCheckBox($form2, 'CAN_ADD', array('class' => 'form-field')); ?><br />
        <div class="form-title"><?php echo CHtml::activeLabel($form2, 'HEAD_USER'); ?></div>
        <?php echo CHtml::activeCheckBox($form2, 'HEAD_USER', array('class' => 'form-field')); ?><br />
        <div class="form-title"><?php echo CHtml::activeLabel($form, 'NAME'); ?></div>
        <?php echo Chtml::activeTextField($form2, 'NAME', array('class' => 'form-field')); ?><br />
        <div class="form-title"><?php echo CHtml::activeLabel($form2, 'SURNAME'); ?></div>
        <?php echo Chtml::activeTextField($form2, 'SURNAME', array('class' => 'form-field')); ?><br />
        <div class="form-title"><?php echo CHtml::activeLabel($form2, 'PHONE'); ?></div>
        <?php echo Chtml::activeTextField($form2, 'PHONE', array('class' => 'form-field')); ?><br />
        <div class="form-title"><?php echo CHtml::activeLabel($form2, 'EMAIL'); ?></div>
        <?php echo Chtml::activeTextField($form2, 'EMAIL', array('class' => 'form-field')); ?><br />
        <div class="submit-container">
            <?php echo CHtml::submitButton('Save', array('class' => 'submit-button')); ?>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>