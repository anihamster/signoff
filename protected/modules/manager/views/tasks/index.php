<div id="text_full">
<h1>Assigned projects</h1>
<br />
<?php if(!empty($tasks)): ?>
You need to confirm your sign for this tasks:
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
		</tr>
	</thead>
	<tbody>
<?php foreach($tasks as $t_k => $t_v): ?>
	<tr>
			<td>
				<?php echo $t_v['id']; ?>
			</td>
			<td>
				<a href="<?php echo Yii::app()->baseUrl; ?>/manager/tasks/details/?task_id=<?php echo $t_v['id']; ?>"><?php echo $t_v['title']; ?></a>
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
		</tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php else: ?>
You're not assigned to any project yet.
<?php endif; ?>
</div>