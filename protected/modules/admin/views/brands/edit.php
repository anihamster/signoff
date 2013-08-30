<div id="text_full">
    <h1>Brands edit</h1>
    <br />
    <?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::errorSummary($form); ?>
    <table>
        <tr>
            <td>
                <?php echo CHtml::activeLabel($form, 'BRAND_NAME'); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($form, 'BRAND_NAME'); ?>
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