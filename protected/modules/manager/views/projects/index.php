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
<div style="display: none; margin: 0 auto;">
    <div class="box-modal" id="approveModal">
        <div class="box-modal_close arcticmodal-close">X</div>
        <input type="hidden" value="" class="task">
        If you have any comments you can write it in form below:
        <textarea class="comment-area"></textarea>
        <br />
        <br />
        <a href="#" class="button-secondary" id="approve-comment">Send</a>
    </div>
</div>
<div style="display: none; margin: 0 auto;">
    <div class="box-modal" id="cancelModal">
        <div class="box-modal_close arcticmodal-close">X</div>
        <input type="hidden" value="" class="task">
        Please write your reason to cancel this project in form below:
        <div class="comment-error"></div>
        <textarea class="comment-area"></textarea>
        <br />
        <br />
        <a href="#" class="button-secondary" id="cancel-comment">Send</a>
    </div>
</div>
<div style="display: none; margin: 0 auto;">
    <div class="box-modal" id="askModal">
        <div class="box-modal_close arcticmodal-close">X</div>
        <input type="hidden" value="" class="task">
        Please write your question in form below:
        <div class="comment-error"></div>
        <textarea class="comment-area"></textarea>
        <br />
        <br />
        <a href="#" class="button-secondary" id="ask-comment">Ask</a>
    </div>
</div>