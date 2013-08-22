<div id="full_text">
<h1>My projects</h1>
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
				Status
			</th>
		</tr>
	</thead>
	<tbody>
<?php foreach($tasks as $t_k => $t_v): ?>
		<tr>
			<td>
				<?php echo $t_v['ID']; ?>
			</td>
			<td>
				<a href="<?php echo It::baseUrl(); ?>/manager/projects/details/?task_id=<?php echo $t_v['ID']; ?>"><?php echo $t_v['TITLE']; ?></a>
			</td>
			<td>
				<?php echo $t_v['CREATED']; ?>
			</td>
			<td>
				<?php if($t_v['STATUS'] == '0'): ?>
					On submition
				<?php elseif($t_v['STATUS'] == '1'): ?>
					In progress
				<?php elseif($t_v['STATUS'] == '2'): ?>
					Finished
				<?php endif; ?>
			</td>
		</tr>
<?php endforeach; ?>	
	</tbody>
</table>
<a href="<?php echo It::baseUrl(); ?>/manager/projects/edit" class="button orange">Create</a>
<?php else: ?>
There is no current projects. Do you want to <a href="<?php echo It::baseUrl(); ?>/manager/projects/edit">create</a> one?
<?php endif;?>
</div>