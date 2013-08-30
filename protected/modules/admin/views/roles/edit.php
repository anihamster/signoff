<div id="text_full">
    <h1>Edit users role</h1>
    <br />
    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($form); ?>
    <table>
        <tr>
            <td>
                <?php echo CHtml::activeLabel($form, 'ROLE_NAME'); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($form, 'ROLE_NAME'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo CHtml::activeLabel($form, 'ROLE_PARENT'); ?>
            </td>
            <td>
                <?php echo CHtml::activeDropDownList($form, 'ROLE_PARENT', $parents); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo CHtml::activeLabel($form, 'SPEC'); ?>
            </td>
            <td>
                <?php echo CHtml::activeCheckBox($form, 'SPEC'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo CHtml::activeLabel($form, 'TECH'); ?>
            </td>
            <td>
                <?php echo CHtml::activeCheckBox($form, 'TECH'); ?>
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