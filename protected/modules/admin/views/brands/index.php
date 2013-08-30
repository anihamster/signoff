<div id="text_full">
    <h1>Brands</h1><br />
    <?php if(!empty($brands)): ?>
        <table>
            <thead>
            <tr>
                <th>
                    ID
                </th>
                <th>
                    Brand Name
                </th>
                <th>

                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($brands as $b_val): ?>
                <tr>
                    <td>
                        <?php echo $b_val->ID; ?>
                    </td>
                    <td>
                        <?php echo $b_val->BRAND_NAME; ?>
                    </td>
                    <td>
                        <a href="<?php echo It::baseUrl(); ?>/admin/brands/edit/?brand_id=<?php echo $b_val->ID; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/edit.png" /></a>
                        <a href="<?php echo It::baseUrl(); ?>/admin/brands/delete/?brand_id=<?php echo $b_val->ID; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/delete.png" /></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a href="<?php echo It::baseUrl(); ?>/admin/brands/edit" class="button orange">Add brand</a>
    <?php else: ?>
        There is no brands in base. Do you want to <a href="<?php echo It::baseUrl(); ?>/admin/brands/edit">create</a> one?
    <?php endif;?>
</div>