<div id="text_full">
    <h1>Users roles</h1><br />
    <?php if(!empty($roles)): ?>
        <table>
            <thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Department
                </th>
                <th>
                    Role name
                </th>
                <th>

                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($roles as $role): ?>
                <tr>
                    <td>
                        <?php echo $role->ID; ?>
                    </td>
                    <td>
                        <?php echo $role['department']->DEPT_NAME; ?>
                    </td>
                    <td>
                        <?php echo $role->ROLE_NAME; ?>
                    </td>
                    <td>
                        <a href="<?php echo It::baseUrl(); ?>/admin/roles/edit/?role_id=<?php echo $role->ID; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/edit.png" /></a>
                        <a href="<?php echo It::baseUrl(); ?>/admin/roles/delete/?role_id=<?php echo $role->ID; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/delete.png" /></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a href="<?php echo It::baseUrl(); ?>/admin/roles/edit" class="button orange">Add user role</a>
    <?php else: ?>
        There is no users roles in base. Do you want to <a href="<?php echo It::baseUrl(); ?>/admin/roles/edit">create</a> one?
    <?php endif;?>
</div>