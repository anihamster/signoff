<div id="text_full">
    <h1>Project tracker groups</h1><br />
    <?php if(!empty($groups)): ?>
        <table>
            <thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Group parent
                </th>
                <th>
                    Group name
                </th>
                <th>

                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($groups as $group): ?>
                <tr>
                    <td>
                        <?php echo $group->ID; ?>
                    </td>
                    <td>
                        <?php echo $parent = (!empty($group['parent'])) ? $group['parent']->GROUP_NAME : 'Main group'; ?>
                    </td>
                    <td>
                        <?php echo $group->GROUP_NAME; ?>
                    </td>
                    <td>
                        <a href="<?php echo It::baseUrl(); ?>/admin/groups/edit/?grp_id=<?php echo $group->ID; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/edit.png" /></a>
                        <a href="<?php echo It::baseUrl(); ?>/admin/groups/delete/?grp_id=<?php echo $group->ID; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/delete.png" /></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a href="<?php echo It::baseUrl(); ?>/admin/groups/edit" class="button orange">Add group</a>
    <?php else: ?>
        There is no tracker groups in base. Do you want to <a href="<?php echo It::baseUrl(); ?>/admin/groups/edit">create</a> one?
    <?php endif;?>
</div>