<?php Yii::app()->clientScript->registerScriptFile(It::baseUrl() . '/js/user_signs_off.js') ?>
<?php Yii::app()->clientScript->registerScriptFile(It::baseUrl() . '/js/hide_show.js') ?>
<?php Yii::app()->clientScript->registerScriptFile(It::baseUrl() . '/js/comments.js') ?>
<?php if(Yii::app()->user->getState('user_role') == '3'): ?>
    <?php Yii::app()->clientScript->registerScriptFile(It::baseUrl() . '/js/user_signs.js') ?>
<?php endif; ?>
<div id="text_full">
    <h1>My projects</h1>
    <?php if(!empty($prgs)): ?>
        <?php foreach($prgs as $p_k => $p_v): ?>
            <?php $this->renderPartial('_project', array('p_v' => $p_v)); ?>
        <?php endforeach; ?>
    <a href="<?php echo It::baseUrl(); ?>/manager/projects/edit" class="button"><img src="<?php echo It::baseUrl() ?>/images/ico/add.png" />&nbsp;&nbsp;Create</a>
    <?php else: ?>
    There is no current projects.<br />
    <a href="<?php echo It::baseUrl(); ?>/manager/projects/edit" class="button"><img src="<?php echo It::baseUrl() ?>/images/ico/add.png" />&nbsp;&nbsp;Create</a>
    <?php endif;?>
</div>
    <div style="display: none;">
        <div class="box-modal" id="approveModal">
            <div class="box-modal_close arcticmodal-close">X</div>
            <input type="hidden" value="" class="task">
            If you have any comments you can write it in form below:
            <textarea class="comment-area"></textarea>
            <br />
            <br />
            <a href="#" class="button orange" id="approve-comment">Send</a>
        </div>
    </div>
    <div style="display: none;">
        <div class="box-modal" id="cancelModal">
            <div class="box-modal_close arcticmodal-close">X</div>
            <input type="hidden" value="" class="task">
            Please write your reason to cancel this project in form below:
            <div class="comment-error"></div>
            <textarea class="comment-area"></textarea>
            <br />
            <br />
            <a href="#" class="button orange" id="cancel-comment">Send</a>
        </div>
    </div>
    <div style="display: none;">
        <div class="box-modal" id="askModal">
            <div class="box-modal_close arcticmodal-close">X</div>
            <input type="hidden" value="" class="task">
            Please write your question in form below:
            <div class="comment-error"></div>
            <textarea class="comment-area"></textarea>
            <br />
            <br />
            <a href="#" class="button orange" id="ask-comment">Ask</a>
        </div>
    </div>
</div>