<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/user_signs_off.js') ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/comments.js') ?>
<?php if(Yii::app()->user->getState('user_role') == '3'): ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/user_signs.js') ?>
<?php endif; ?>

<div id="leftbar">
	<h2>Progress tracker</h2>
	<div id="<?php echo $task['id']; ?>" class="progress_bar">
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
	<table id="<?php echo $task['id']; ?>">
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
	<b>Project proposal:</b> <?php echo $task['title']; ?><br /><br />
	<b>Initiated by:</b> <?php echo $task['name']; ?> <?php echo $task['surname']; ?><br />
	<b>Contacts:</b> <?php echo $task['phone']; ?>, <?php echo $task['email']; ?><br />
	<b>Project name:</b> <?php echo $task['title']; ?><br />
	<b>Description:</b><br />
	<?php echo $task['description']; ?><br />
	<?php 
		$num = count($task['assigned_to']);
		$width = $num + 2;
	?>
	<?php if(!empty($attaches)): ?>
		<b>Attached files:</b><br />
		<?php foreach($attaches as $attach): ?>
			<a href="<?php echo Yii::app()->baseUrl; ?>/uploads/project_<?php echo $task['id']; ?>/<?php echo $attach->attach_file; ?>">
				<img src="<?php echo Yii::app()->baseUrl; ?>/images/ico/attach.png" /><?php echo $attach->attach_file; ?>
			</a><br />
		<?php endforeach; ?>
	<?php endif; ?>
	<br />                     
	<div id="comment_area" style="display: none;"></div>
</div>