<div id="text_full">
<h1>Departments</h1><br />
<?php if(!empty($deps)): ?>
<table>
	<thead>
		<tr>
			<th>
				ID
			</th>
			<th>
				Root
			</th>
			<th>
				Department
			</th>
			<th>
				Default manager
			</th>
			<th>
				
			</th>
		</tr>
	</thead>
	<tbody>
<?php foreach($deps as $d_val): ?>
		<tr>
			<td>
				<?php echo $d_val->ID; ?>
			</td>
			<td>
				<?php 
					if($d_val->DEPT_PARENT !== '0')
						$d_par = Departments::model()->findByPk($d_val->DEPT_PARENT);
				?>
				<?php echo $root = ($d_val->DEPT_PARENT == '0') ? 'Main' : $d_par->DEPT_NAME; ?>
			</td>
			<td>
				<?php echo $d_val->DEPT_NAME; ?>
			</td>
			<td>
				<?php 
					if(!empty($d_val->DEF_USER))
						$d_man = UserDetails::model()->findByAttributes(array('USER_ID' => $d_val->DEF_USER));
				?>
				<?php echo $root = (empty($d_val->DEF_USER)) ? 'Not assigned yet' : $d_man->NAME . ' ' . $d_man->SURNAME; ?>
			</td>
			<td>
				<a href="<?php echo Yii::app()->baseUrl; ?>/admin/departments/edit/?dept_id=<?php echo $d_val->ID; ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/images/ico/edit.png" /></a>
				<a href="<?php echo Yii::app()->baseUrl; ?>/admin/departments/delete/?dept_id=<?php echo $d_val->ID; ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/images/ico/delete.png" /></a>
			</td>
		</tr>
<?php endforeach; ?>	
	</tbody>
</table>
<a href="<?php echo Yii::app()->baseUrl; ?>/admin/departments/add" class="button orange">Add department</a>
<?php else: ?>
There is no department in base. Do you want to <a href="<?php echo Yii::app()->baseUrl; ?>/admin/departments/add">create</a> one?
<?php endif;?>
</div>