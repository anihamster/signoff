<div id="text_full">
    <h1>Categories</h1><br />
    <?php if(!empty($cats)): ?>
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
                    Category
                </th>
                <th>
                    Brand specific category
                </th>
                <th>

                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($cats as $c_val): ?>
                <tr>
                    <td>
                        <?php echo $c_val->ID; ?>
                    </td>
                    <td>
                        <?php
                        if($c_val->CAT_PARENT !== '0')
                            $c_par = Categories::model()->findByPk($d_val->CAT_PARENT);
                        ?>
                        <?php echo $root = ($c_val->CAT_PARENT == '0') ? 'Main' : $d_par->CAT_NAME; ?>
                    </td>
                    <td>
                        <?php echo $c_val->CAT_NAME; ?>
                    </td>
                    <td>
                        <?php echo $root = ($c_val->BRAND_SPEC == '1') ? 'Yes' : 'No'; ?>
                    </td>
                    <td>
                        <a href="<?php echo It::baseUrl(); ?>/admin/categories/edit/?cat_id=<?php echo $c_val->ID; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/edit.png" /></a>
                        <a href="<?php echo It::baseUrl(); ?>/admin/categories/delete/?cat_id=<?php echo $c_val->ID; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/delete.png" /></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a href="<?php echo It::baseUrl(); ?>/admin/categories/edit" class="button orange">Add category</a>
    <?php else: ?>
        There is no categories in base. Do you want to <a href="<?php echo It::baseUrl(); ?>/admin/categories/edit">create</a> one?
    <?php endif;?>
</div>