<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/attaches.js') ?>

<div id="text_full">
    <h1>Edit project</h1>
    <br />
    <?php echo CHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data')); ?>
    <?php echo CHtml::errorSummary($form); ?>
    <table>
        <tr>
            <td>
                <?php echo CHtml::activeLabel($form, 'TITLE'); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($form, 'TITLE', array('style' => 'width: 645px;')); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo CHtml::activeLabel($form, 'PRJ_CAT'); ?>
            </td>
            <td>
                <?php echo CHtml::activeDropDownList($form, 'PRJ_CAT', $cats); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo CHtml::activeLabel($form, 'DESCRIPTION'); ?>
            </td>
            <td>
                <?php $this->widget('application.extensions.fckeditor.FCKEditorWidget',array(
                    "name"          => 'Projects[DESCRIPTION]',
                    "value"         => $form['DESCRIPTION'],
                    "height"		=> '200px',
                    "width"			=> '650px',
                    "toolbarSet"    => 'guards',
                    "fckeditor"		=>	Yii::app()->basePath."/../fckeditor/fckeditor.php",
                    "fckBasePath"	=>	Yii::app()->baseUrl."/fckeditor/",
                )); ?>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td colspan="2">
                <?php echo Chtml::submitButton('Save', array('class' => 'button orange')); ?>
            </td>
        </tr>
    </table>
    <?php echo Chtml::endForm(); ?>
</div>