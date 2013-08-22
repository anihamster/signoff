<div id="text_full">
<h1>Users management</h1>
<br />
<?php if(!empty($users)): ?>
<table>
	<thead>
		<tr>
			<th>
				ID
			</th>
			<th>
				Login
			</th>
			<th>
				Role
			</th>
			<th>
				Name
			</th>
			<th>
				Surname
			</th>
			<th>
				Phone
			</th>
			<th>
				E-mail
			</th>
			<th>
				Department
			</th>
			<th>
			</th>
		</tr>
	</thead>
	<tbody>
<?php foreach($users as $u_val): ?>
<?php if((Yii::app()->user->getState('user_role') == '3') AND (!empty($u_val['details'])) OR (Yii::app()->user->getState('user_role') == '1')): ?>
		<tr>
			<td>
				<?php echo $u_val->ID; ?>
			</td>
			<td>
				<?php echo $u_val->LOGIN; ?>
			</td>
			<?php if(!empty($u_val['details'])): ?>
            <td>
                <?php
                    $role = Roles::model()->findByPk($u_val['details']->ROLE_ID);
                    if(!empty($role))
                        echo $role->ROLE_NAME;
                    else
                        echo '-';
                ?>
            </td>
			<td>
				<?php echo $u_val['details']->NAME; ?>
			</td>
			<td>
				<?php echo $u_val['details']->SURNAME; ?>
			</td>
			<td>
				<?php echo $u_val['details']->PHONE; ?>
			</td>
			<td>
				<?php echo $u_val['details']->EMAIL; ?>
			</td>
			<td>
				<?php $dept = Departments::model()->findByPk($u_val['details']->DEPT_ID); ?>
				<?php echo $dept->DEPT_NAME;?>
			</td>
			<?php else: ?>
			<td>
				<a href="<?php echo Yii::app()->baseUrl; ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>">-</a>
			</td>
			<td>
				<a href="<?php echo Yii::app()->baseUrl; ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>">-</a>
			</td>
			<td>
				<a href="<?php echo Yii::app()->baseUrl; ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>">-</a>
			</td>
			<td>
				<a href="<?php echo Yii::app()->baseUrl; ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>">-</a>
			</td>
			<td>
				<a href="<?php echo Yii::app()->baseUrl; ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>">-</a>
			</td>
			<?php endif; ?>
			<td>
				<a href="<?php echo Yii::app()->baseUrl; ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/images/ico/edit.png" /></a>
				<a href="<?php echo Yii::app()->baseUrl; ?>/admin/managers/deleteuser/?user_id=<?php echo $u_val->ID; ?>"><img src="<?php echo Yii::app()->baseUrl; ?>/images/ico/delete.png" /></a>
			</td>
		</tr>
<?php endif; ?>
<?php endforeach; ?>	
	</tbody>
</table>
<a href="<?php echo Yii::app()->baseUrl; ?>/admin/managers/add" class="button orange">Create</a>
<?php else: ?>
There is no department in base. Do you want to <a href="<?php echo Yii::app()->baseUrl; ?>/admin/managers/add">create</a> one?
<?php endif;?>
</div>