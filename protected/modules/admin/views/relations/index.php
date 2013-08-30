<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/submition.js') ?>

<div id="text_full">
    <h1>Relations settings</h1>
    <br />
    <?php if(!empty($rels)): ?>
        <table>
            <thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Category
                </th>
                <th>
                    Brand
                </th>
                <th>
                    User role
                </th>
                <th>
                    Group
                </th>
                <th>

                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($rels as $r_val): ?>
                <tr>
                    <td>
                        <?php echo $r_val->ID; ?>
                    </td>
                    <td>
                        <?php if(!empty($r_val['cat'])): ?>
                            <?php echo $r_val['cat']->CAT_NAME; ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(!empty($r_val['brnd'])): ?>
                            <?php echo $r_val['brnd']->BRAND_NAME; ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(!empty($r_val['rls'])): ?>
                            <?php echo $r_val['rls']->ROLE_NAME; ?>
                        <?php else: ?>
                            General user
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(!empty($r_val['grp'])): ?>
                            <?php echo $r_val['grp']->GROUP_NAME; ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="#"><img src="<?php echo Yii::app()->baseUrl; ?>/images/ico/edit.png" /></a>
                        <a href="#"><img src="<?php echo Yii::app()->baseUrl; ?>/images/ico/delete.png" /></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a href="<?php echo Yii::app()->baseUrl; ?>/admin/relations/build" class="button orange">Build relations</a>
    <?php else: ?>
        There is no relations in base. Do you want to <a href="<?php echo Yii::app()->baseUrl; ?>/admin/relations/build">create</a> one?
    <?php endif;?>
</div>