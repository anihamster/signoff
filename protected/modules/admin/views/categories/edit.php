<div id="text_full">
    <h1>Categories edit</h1>
    <br />
    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($form); ?>
    <table>
        <tr>
            <td>
                <?php echo CHtml::activeLabel($form, 'CAT_PARENT'); ?>
            </td>
            <td>
                <?php echo CHtml::activeDropDownList($form, 'CAT_PARENT', $cats); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo CHtml::activeLabel($form, 'CAT_NAME'); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($form, 'CAT_NAME'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo CHtml::activeLabel($form, 'BRAND_SPEC'); ?>
            </td>
            <td>
                <?php echo CHtml::activeCheckBox($form, 'BRAND_SPEC'); ?>
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