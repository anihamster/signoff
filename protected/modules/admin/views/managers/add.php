<div id="text_full">
<h1>User add</h1>
<br />
<?php echo CHtml::beginForm(); ?>
<?php echo CHtml::errorSummary($form); ?>
<?php echo CHtml::errorSummary($form2); ?>
<table>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'LOGIN'); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($form, 'LOGIN'); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'PASSWORD'); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($form, 'PASSWORD'); ?>
		</td>
	</tr>
	<?php if(!(Yii::app()->user->getState('user_role') == '3')): ?>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'TYPE'); ?>
		</td>
		<td>
			<?php echo CHtml::activeDropDownList($form, 'TYPE', $levels); ?>
		</td>
	</tr>
    <tr>
        <td>
            <?php echo CHtml::activeLabel($form2, 'KEY_USER'); ?>
        </td>
        <td>
            <?php echo CHtml::activeCheckBox($form2, 'KEY_USER'); ?>
        </td>
    </tr>
	<?php endif; ?>
    <tr>
        <td>
            <?php echo CHtml::activeLabel($form2, 'BRAND'); ?>
        </td>
        <td>
            <?php echo CHtml::activeDropDownList($form2, 'BRAND', $brands); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo CHtml::activeLabel($form2, 'ROLE_ID'); ?>
        </td>
        <td>
            <?php echo CHtml::activeDropDownList($form2, 'ROLE_ID', $roles); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo CHtml::activeLabel($form2, 'CAN_ADD'); ?>
        </td>
        <td>
            <?php echo CHtml::activeCheckBox($form2, 'CAN_ADD'); ?>
        </td>
    </tr>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form2, 'NAME'); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($form2, 'NAME'); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form2, 'SURNAME'); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($form2, 'SURNAME'); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form2, 'PHONE'); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($form2, 'PHONE'); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form2, 'EMAIL'); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($form2, 'EMAIL'); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php echo Chtml::submitButton('Save', array('class' => 'button orange')); ?>
		</td>
	</tr>
</table>
<?php echo Chtml::endForm(); ?>
</div>