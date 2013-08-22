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
                <?php echo CHtml::activeLabel($form, 'DEPT_ID'); ?>
            </td>
            <td>
                <?php echo CHtml::activeDropDownList($form, 'DEPT_ID', Chtml::listData($deps, 'ID', 'DEPT_NAME')); ?>
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