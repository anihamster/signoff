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
                Brand
            </th>
            <th>
                Key user
            </th>
            <th>
                Users func
            </th>
			<th>
				Role
			</th>
            <th>
                TKAM func
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
			</th>
		</tr>
	</thead>
	<tbody>
<?php foreach($users as $u_val): ?>
<?php if((It::getState('user_role') == '3') AND (!empty($u_val['details'])) OR (It::getState('user_role') == '1')): ?>
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
                    if(!empty($u_val['details']->BRAND)) {
                        $brand = Brands::model()->findByPk($u_val['details']->BRAND);
                        $bn = $brand->BRAND_NAME;
                    }
                    if(empty($brand))
                        $bn = 'Incorrect data';

                    echo $brand = (!empty($u_val['details']->BRAND) && ($u_val['details']->BRAND !== '0')) ? $bn : 'General user';
                    ?>
                </td>
                <td>
                    <?php echo $key = ($u_val['details']->KEY_USER == '1') ? 'Yes' : 'No';?>
                </td>
                <td>
                    <?php echo $key = ($u_val['details']->HEAD_USER == '1') ? 'Yes' : 'No';?>
                </td>
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
                <?php echo $key = ($u_val['details']->CAN_ADD == '1') ? 'Yes' : 'No';?>
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
			<?php else: ?>
			<td>
				<a href="<?php echo It::baseUrl(); ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>">-</a>
			</td>
            <td>
                <a href="<?php echo It::baseUrl(); ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>">-</a>
            </td>
            <td>
                <a href="<?php echo It::baseUrl(); ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>">-</a>
            </td>
            <td>
                <a href="<?php echo It::baseUrl(); ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>">-</a>
            </td>
			<td>
				<a href="<?php echo It::baseUrl(); ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>">-</a>
			</td>
			<td>
				<a href="<?php echo It::baseUrl(); ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>">-</a>
			</td>
			<td>
				<a href="<?php echo It::baseUrl(); ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>">-</a>
			</td>
			<td>
				<a href="<?php echo It::baseUrl(); ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>">-</a>
			</td>
            <td>
                <a href="<?php echo It::baseUrl(); ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>">-</a>
            </td>
			<?php endif; ?>
			<td>
				<a href="<?php echo It::baseUrl(); ?>/admin/managers/editdetails/?user_id=<?php echo $u_val->ID; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/edit.png" /></a>
				<a href="<?php echo It::baseUrl(); ?>/admin/managers/deleteuser/?user_id=<?php echo $u_val->ID; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/delete.png" /></a>
			</td>
		</tr>
<?php endif; ?>
<?php endforeach; ?>	
	</tbody>
</table>
<a href="<?php echo It::baseUrl(); ?>/admin/managers/add" class="button orange">Create</a>
<?php else: ?>
There is no department in base. Do you want to <a href="<?php echo It::baseUrl(); ?>/admin/managers/add">create</a> one?
<?php endif;?>
</div>