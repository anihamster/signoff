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
        <br />
        <div id="relation_html"></div>
        <br />
    <?php else: ?>
        <b>You must to create categories, departments and user roles before building relations!</b>
    <?php endif; ?>
</div>