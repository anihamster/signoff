<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/attaches.js') ?>

<div id="text_full">
<h1>Create project</h1>
<br />
<?php echo CHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data')); ?>
<?php echo CHtml::errorSummary($form); ?>
<table>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'title'); ?>
		</td>
		<td>
			<?php echo CHtml::activeTextField($form, 'title', array('style' => 'width: 645px;')); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'description'); ?>
		</td>
		<td>
			<?php $this->widget('application.extensions.fckeditor.FCKEditorWidget',array(
            			"name"          => 'Tasks[description]',
            			"value"         => $form['description'],
            			"height"		=> '200px',
            			"width"			=> '650px',
            			"toolbarSet"    => 'guards',
            			"fckeditor"		=>	Yii::app()->basePath."/../fckeditor/fckeditor.php",
            			"fckBasePath"	=>	Yii::app()->baseUrl."/fckeditor/",
                     )); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($form, 'assigned_to'); ?>
		</td>
		<td>
			<?php echo CHtml::activeCheckBoxList($form, 'assigned_to', $deps); ?>
		</td>
	</tr>
</table>
<div id="mainFilesForm">
<table>
<?php foreach($attach_form as $key => $val) :?>
	<tr>
		<td>
			<?php echo CHtml::activeLabel($attach_form[$key], '['.$key.']attach_file'); ?>
		</td>
		<td>
			<?php echo CHtml::activeFileField($attach_form[$key], '['.$key.']attach_file'); ?>
			<br/>
            <font color="red"><?= CHtml::error($attach_form[$key], 'attach_file' ) ?></font>			
		</td>
		<td>
			<a href="#" onclick="addPictureForms(); return false;" onmousedown="return false;">
				<img src="<?php echo Yii::app()->baseUrl; ?>/images/ico/add.png" />
			</a>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<table>
	<tr>
		<td colspan="2">
			<?php echo Chtml::submitButton('Save', array('class' => 'button orange')); ?>
		</td>
	</tr>
</table>
<?php echo Chtml::endForm(); ?>
</div>