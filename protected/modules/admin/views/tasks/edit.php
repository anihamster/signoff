<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/user_signs.js') ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.json-2.2.min.js') ?>

<div id="text">
<h1>Work with project</h1>
<br />
<?php echo CHtml::beginForm(); ?>
<?php echo CHtml::errorSummary($form); ?>
<table id="<?php echo $form->id; ?>">
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
		<td colspan="2">
			<?php echo CHtml::activeLabel($form, 'assigned_to'); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php echo CHtml::activeCheckBoxList($form, 'assigned_to', $deps, array('template'=>'<span>{input} {label} <a href="Javascript:void[0]" class="deplist">Assign user</a></span>')); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<?php echo Chtml::submitButton('Save project', array('class' => 'button orange')); ?>
		</td>
	</tr>
</table>
<?php echo Chtml::endForm(); ?>
</div>
<div id="sidebar">
	<h2>Users management</h2>
	<table id="<?php echo $form->id; ?>">
		<tr>
			<td>
				<div id="usrs"></div>
			</td>
		</tr>
	</table>	
</div>