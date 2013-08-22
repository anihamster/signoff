<h1>You must sign in to get access to the system</h1>
<br />
<div id="full_text">
<?php echo CHtml::form(); ?>
<?php echo CHtml::errorSummary($form); ?>
<table>
    <tr>
        <td>
            <?php echo Chtml::activeLabel($form, 'login'); ?>
        </td>
        <td>
            <?php echo Chtml::activeTextField($form, 'login'); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo CHtml::activeLabel($form, 'password'); ?>
        </td>
        <td>
            <?php echo CHtml::activePasswordField($form, 'password'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton('Sign in', array('class' => 'button orange')); ?>
        </td>
    </tr>
</table>
<?php echo CHtml::endForm(); ?>
</div>