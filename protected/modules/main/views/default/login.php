<h1>Login page*</h1>
<br />
<div id="full_text">
<?php echo CHtml::form(); ?>
<?php echo CHtml::errorSummary($form); ?>
<table>
    <tr>
        <td>
            <?php echo Chtml::activeLabel($form, 'LOGIN'); ?>
        </td>
        <td>
            <?php echo Chtml::activeTextField($form, 'LOGIN'); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo CHtml::activeLabel($form, 'PASSWORD'); ?>
        </td>
        <td>
            <?php echo CHtml::activePasswordField($form, 'PASSWORD'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo CHtml::submitButton('Sign in', array('class' => 'button orange')); ?>
        </td>
    </tr>
</table>
<?php echo CHtml::endForm(); ?>
<small>* You must to sign in to get access to the system.</small>
</div>