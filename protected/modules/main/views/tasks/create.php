<h3>Task creation</h3>

<?php echo CHtml::beginForm(); ?>
<?php echo CHtml::errorSummary($form); ?>
<table>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'title'); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($form, 'title'); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'description'); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextArea($form, 'description'); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'assigned_to'); ?>
		</td>
		<td>
		
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php echo Chtml::submitButton('Save'); ?>
		</td>
	</tr>
</table>
<?php echo Chtml::endForm(); ?>