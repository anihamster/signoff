<div id="text_full">
    <h1>Project tracker group edit</h1>
    <br />
    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($form); ?>
    <table>
        <tr>
            <td>
                <?php echo CHtml::activeLabel($form, 'GROUP_PARENT'); ?>
            </td>
            <td>
                <?php echo CHtml::activeDropDownList($form, 'GROUP_PARENT', $grps); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo CHtml::activeLabel($form, 'GROUP_NAME'); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($form, 'GROUP_NAME'); ?>
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