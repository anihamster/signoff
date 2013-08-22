<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/user_signs_off.js') ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/comments.js') ?>
<?php if(Yii::app()->user->getState('user_role') == '3'): ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/user_signs.js') ?>
<?php endif; ?>
<div id="leftbar">
	<h2>Progress tracker</h2>
	<div id="<?php echo $task['ID']; ?>" class="progress_bar">
		<div class="progress finished">
			Project initiated
		</div>
		<center><img src="<?php echo Yii::app()->baseUrl; ?>/images/ico/arrow-down.png" /></center>
		<?php if(!empty($task['assigned_to'])): ?>
			<?php foreach($task['assigned_to'] as $d_k => $d_v): ?>
			<?php $i = 1 ;?>
			<div <?php if(empty($signs) || !isset($signs[$d_k]) || ($signs[$d_k] == '0')): ?>class="progress inprogress"<?php elseif($signs[$d_k] == '1'): ?>class="progress finished"<?php endif; ?> id="<?php echo $d_k; ?>">
				<?php echo $d_v; ?>
			</div>
			<center><img src="<?php echo Yii::app()->baseUrl; ?>/images/ico/arrow-down.png" /></center>
			<?php $i = $i + 1; ?>
			<?php endforeach; ?>
			<?php endif; ?>
		<div class="progress finished">
			Finished
		</div>
	</div>	
	<br />
	<h2>Legend</h2>
	<table>
		<tr>
			<td style="width:15px; background: #0f0;">
			
			</td>
			<td>
				Finished
			</td>
		</tr>
		<tr>
			<td style="width:15px; background: #f00;">
			
			</td>
			<td>
				In progress
			</td>
		</tr>
		<tr>
			<td style="width:15px; background: #0ff;">
			
			</td>
			<td>
				Cancelled
			</td>
		</tr>
	</table>
</div>
<?php if(Yii::app()->user->getState('user_role') == '3'): ?>
<div id="sidebar">
	<h2>Users management</h2>
	<table id="<?php echo $task['ID']; ?>">
		<tr>
			<td>
				<input value="<?php echo $dept; ?>" type="hidden"><a href="Javascript:void[0]" id="userlist" class="button orange">Users</a>
				<div id="usrs"></div>
			</td>
		</tr>
	</table>	
</div>
<?php endif;?>
<div id="text_details">
	<b>Project proposal:</b> <?php echo $task['TITLE']; ?><br /><br />
	<b>Initiated by:</b> <?php echo $task['NAME']; ?> <?php echo $task['SURNAME']; ?><br />
	<b>Contacts:</b> <?php echo $task['PHONE']; ?>, <?php echo $task['EMAIL']; ?><br />
	<b>Project name:</b> <?php echo $task['TITLE']; ?><br />
	<b>Description:</b><br />
	<?php echo $task['DESCRIPTION']; ?><br />
	<?php if(!empty($attaches)): ?>
		<b>Attached files:</b><br />
		<?php foreach($attaches as $attach): ?>
			<a href="<?php echo Yii::app()->baseUrl; ?>/uploads/project_<?php echo $task['ID']; ?>/<?php echo $attach->ATTACH_FILE; ?>">
				<img src="<?php echo Yii::app()->baseUrl; ?>/images/ico/attach.png" /><?php echo $attach->ATTACH_FILE; ?>
			</a><br />
		<?php endforeach; ?>
	<?php endif; ?>
	<br />                     
   	<?php if($signed == 1): ?>
   	<input type="hidden" value="<?php echo $task['ID']; ?>">
   	<a href="#" class="button orange" id="sign_that">Approve</a>
	<?php endif; ?> <a href="#" class="button orange" id=cancel">Cancel</a>
	<br /><br />
	<div id="comment_area" style="display: none;"></div>
        <textarea>
            Write comment here
        </textarea>
</div>