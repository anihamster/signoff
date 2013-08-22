<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/submition.js') ?>

<div id="text_full">
    <h1>Relations settings</h1>
    <br />
    <?php if(!empty($cats) && !empty($roles) && !empty($deps)): ?>
        <label for="grp_name">Relation name: </label>
        <input type="text" name="grp_name" id="grp_name" /><br /><br />
        <select id="category">
            <option value="" selected>Select project category</option>
            <?php foreach($cats as $c_k => $c_v): ?>
                <option value="<?php echo $c_k; ?>"><?php echo $c_v; ?></option>
            <?php endforeach; ?>
        </select>
        <select id="role">
            <option value="" selected>Select user role</option>
            <?php foreach($roles as $r_k => $r_v): ?>
                <option value="<?php echo $r_k; ?>"><?php echo $r_v; ?></option>
            <?php endforeach; ?>
        </select>
        <br /><br />
        <?php $i = 0; ?>
        <b>Select departments which will be included in relation group:</b><br />
        <?php foreach($deps as $d_k => $d_v): ?>
            <div style="width:33%; display: table-cell;">
                <input type="checkbox" name="<?php echo $d_k; ?>" /> <?php echo $d_v; ?>
            </div>
            <?php $i = $i + 1; ?>
            <?php if(!($i % 3)): ?>
                <br />
            <?php endif; ?>
        <?php endforeach; ?>
        <br />
        <a href="#" onclick="return false;" class="button orange" id="relations">Save relations</a>
    <?php else: ?>
        <b>You must to create categories, departments and user roles before building relations!</b>
    <?php endif; ?>
</div>