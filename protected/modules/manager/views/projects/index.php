<div id="text_full">
    <h1>Assigned projects</h1>
    <br />
    <?php if(!empty($prgs)): ?>
        You need to confirm your sign for this projects:
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
                    Status
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($prgs as $p_k => $p_v): ?>
                <tr>
                    <td>
                        <?php echo $p_v['ID']; ?>
                    </td>
                    <td>
                        <a href="<?php echo It::baseUrl(); ?>/manager/projects/details/?task_id=<?php echo $p_v['ID']; ?>"><?php echo $p_v['TITLE']; ?></a>
                    </td>
                    <td>
                        <?php echo $p_v['CREATED']; ?>
                    </td>
                    <td>
                        <?php echo $p_v['SURNAME']; ?> <?php echo $p_v['NAME']; ?>
                    </td>
                    <td>
                        <?php echo $p_v['EMAIL']; ?>, <?php echo $p_v['PHONE']; ?>
                    </td>
                    <td>
                        <?php if($p_v['STATUS'] == '0'): ?>
                            On submition
                        <?php elseif($p_v['STATUS'] == '1'): ?>
                            In progress
                        <?php elseif($p_v['STATUS'] == '2'): ?>
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