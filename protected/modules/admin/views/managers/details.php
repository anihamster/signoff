<div id="text_full">
<h1>Edit user info</h1>
<br />
<?php echo CHtml::beginForm(); ?>
<?php echo CHtml::errorSummary($form); ?>
<table>
    <tr>
        <td>
            <?php echo CHtml::activeLabel($form, 'KEY_USER'); ?>
        </td>
        <td>
            <?php echo CHtml::activeCheckBox($form, 'KEY_USER'); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo CHtml::activeLabel($form, 'BRAND'); ?>
        </td>
        <td>
            <?php echo CHtml::activeDropDownList($form, 'BRAND', $brands); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo CHtml::activeLabel($form, 'ROLE_ID'); ?>
        </td>
        <td>
            <?php echo CHtml::activeDropDownList($form, 'ROLE_ID', $roles); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo CHtml::activeLabel($form, 'CAN_ADD'); ?>
        </td>
        <td>
            <?php echo CHtml::activeCheckBox($form, 'CAN_ADD'); ?>
        </td>
    </tr>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'NAME'); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($form, 'NAME'); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'SURNAME'); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($form, 'SURNAME'); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'PHONE'); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($form, 'PHONE'); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'EMAIL'); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($form, 'EMAIL'); ?>
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