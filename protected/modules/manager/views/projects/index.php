<?php Yii::app()->clientScript->registerScriptFile(It::baseUrl() . '/js/user_signs_off.js') ?>
<?php Yii::app()->clientScript->registerScriptFile(It::baseUrl() . '/js/effects.js') ?>
<?php Yii::app()->clientScript->registerScriptFile(It::baseUrl() . '/js/hide_show.js') ?>
<?php Yii::app()->clientScript->registerScriptFile(It::baseUrl() . '/js/comments.js') ?>
<?php if(Yii::app()->user->getState('user_role') == '3'): ?>
    <?php Yii::app()->clientScript->registerScriptFile(It::baseUrl() . '/js/user_signs.js') ?>
<?php endif; ?>

<div id="wrapper" class="grid">

    <div id="content-wrapper" class="c3" style="width: 100%">

        <div id="content">
            <h1>Assigned projects</h1>
            <?php if(!empty($prgs)): ?>
            You need to confirm your sign for this projects: <br /><br />
            <?php foreach($prgs as $p_k => $p_v): ?>
                <?php $this->renderPartial('_project', array('p_v' => $p_v)); ?>
            <?php endforeach; ?>
            <?php else: ?>
                You're not assigned to any project yet.
            <?php endif; ?>
        </div>
    </div>



</div>		