<div id="text_full">
<h1>Department's add</h1>
<br />
<?php echo CHtml::beginForm(); ?>
<?php echo CHtml::errorSummary($form); ?>
<table>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'DEPT_ARENT'); ?>
		</td>
		<td>
			<?php echo CHtml::activeDropDownList($form, 'DEPT_PARENT', $deps); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'DEPT_NAME'); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($form, 'DEPT_NAME'); ?>
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