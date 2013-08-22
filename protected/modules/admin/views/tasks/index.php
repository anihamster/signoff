<div id="text_full">
<h1>Projects on submition</h1>
<br />
<?php if(!empty($tasks)): ?>
<table>
	<thead>
		<tr>
			<th>
				ID
			</th>
			<th>
				Title
			</th>
			<th>
				Created
			</th>
			<th>
				Author
			</th>
			<th>
				Contacts
			</th>
			<th>
				Assigned to
			</th>
			<th>
				Status
			</th>
			<th>
			</th>
		</tr>
	</thead>
	<tbody>
<?php foreach($tasks as $t_k => $t_v): ?>
		<tr>
			<td>
				<?php echo $t_v['id']; ?>
			</td>
			<td>
				<a href="<?php echo Yii::app()->baseUrl; ?>/admin/tasks/details/?task_id=<?php echo $t_v['id']; ?>"><?php echo $t_v['title']; ?></a>
			</td>
			<td>
				<?php echo $t_v['created']; ?>
			</td>
			<td>
				<?php echo $t_v['surname']; ?> <?php echo $t_v['name']; ?>
			</td>
			<td>
				<?php echo $t_v['email']; ?>, <?php echo $t_v['phone']; ?>
			</td>
			<td>
				<?php if(!empty($t_v['assigned_to'])): ?>
					<?php echo $deps = implode(', ', $t_v['assigned_to']); ?>
				<?php else: ?>
					<b>Not assigned to any department!</b>
				<?php endif; ?>
			</td>
			<td>
				<?php if($t_v['status'] == '0'): ?>
					On submition
				<?php elseif($t_v['status'] == '1'): ?>
					In progress
				<?php elseif($t_v['status'] == '2'): ?>
					Finished
				<?php endif; ?>
			</td>
			<td>
				<a href="<?php echo Yii::app()->baseUrl; ?>/admin/tasks/edit/?task_id=<?php echo $t_v['id']; ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/images/ico/edit.png" /></a>
				<a href="<?php echo Yii::app()->baseUrl; ?>/admin/tasks/delete/?task_id=<?php echo $t_v['id']; ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/images/ico/delete.png" /></a>
			</td>
		</tr>
<?php endforeach; ?>	
	</tbody>
</table>
<?php else: ?>
There is no projects in base now.
<?php endif;?>
</div>