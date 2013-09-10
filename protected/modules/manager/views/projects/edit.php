<?php Yii::app()->clientScript->registerScriptFile(It::baseUrl() . '/js/attaches.js') ?>

<div id="text_full">
    <div class="form-container" style="width: 700px;">
        <?php echo CHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data')); ?>
        <?php echo CHtml::errorSummary($form); ?>
        <div class="form-title"><h2>Edit project</h2></div>
        <div class="form-title"><?php echo CHtml::activeLabel($form, 'TITLE'); ?></div>
        <?php echo Chtml::activeTextField($form, 'TITLE', array('class' => 'form-field')); ?><br />
        <div class="form-title"><?php echo CHtml::activeLabel($form, 'PRJ_CAT'); ?></div>
        <?php echo CHtml::activeDropDownList($form, 'PRJ_CAT', $cats, array('class' => 'form-field', 'style' => 'height: 40px;')); ?><br />
        <div class="form-title"><?php echo CHtml::activeLabel($form, 'DESCRIPTION'); ?></div>
        <?php $this->widget('application.extensions.fckeditor.FCKEditorWidget',array(
            "name"          => 'Projects[DESCRIPTION]',
            "value"         => $form['DESCRIPTION'],
            "height"		=> '200px',
            "width"			=> '650px',
            "toolbarSet"    => 'guards',
            "fckeditor"		=>	Yii::app()->basePath."/../fckeditor/fckeditor.php",
            "fckBasePath"	=>	Yii::app()->baseUrl."/fckeditor/",
        )); ?><br />
        <div id="mainFilesForm">
            <table>
                <?php foreach($attach_form as $key => $val) :?>
                    <tr>
                        <td>
                            <?php echo CHtml::activeLabel($attach_form[$key], '['.$key.']ATTACH_FILE'); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeFileField($attach_form[$key], '['.$key.']ATTACH_FILE'); ?>
                            <br/>
                            <font color="red"><?= CHtml::error($attach_form[$key], 'ATTACH_FILE' ) ?></font>
                        </td>
                        <td>
                            <a href="#" onclick="addPictureForms(); return false;" onmousedown="return false;">
                                <img src="<?php echo It::baseUrl(); ?>/images/ico/add.png" />
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="submit-container">
            <?php echo CHtml::submitButton('Save', array('class' => 'submit-button')); ?>
        </div>
        <?php echo CHtml::endForm(); ?>
    </div>
</div>