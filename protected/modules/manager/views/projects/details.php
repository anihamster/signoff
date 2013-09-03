<?php Yii::app()->clientScript->registerScriptFile(It::baseUrl() . '/js/user_signs_off.js') ?>
<?php Yii::app()->clientScript->registerScriptFile(It::baseUrl() . '/js/comments.js') ?>
<?php if(Yii::app()->user->getState('user_role') == '3'): ?>
<?php Yii::app()->clientScript->registerScriptFile(It::baseUrl() . '/js/user_signs.js') ?>
<?php endif; ?>
<div id="leftbar">
	<h2>Progress tracker</h2>
	<div id="<?php echo $task['ID']; ?>" class="progress_bar">
		<div class="progress finished">
			Project initiated
		</div>
		<div align="center"><img src="<?php echo It::baseUrl(); ?>/images/ico/arrow-down.png" /></div>
		<?php if(!empty($signs)): ?>
			<?php foreach($signs as $s_k => $s_v): ?>
			<div <?php if($s_v['flag'] == '0'): ?>class="progress inprogress"<?php elseif($s_v['flag'] == '1'): ?>class="progress finished"<?php elseif($s_v['flag'] == '2'): ?>class="progress cancelled"<?php endif; ?> id="<?php echo $s_v['user']; ?>">
				<?php if(!empty($s_v['brand'])): ?>
                    <?php echo $s_v['brand']; ?>
                <?php endif; ?>
                <?php if(!empty($s_v['role'])): ?>
                    <?php echo $s_v['role']; ?>
                <?php endif; ?>
			</div>
            <div align="center"><img src="<?php echo It::baseUrl(); ?>/images/ico/arrow-down.png" /></div>
			<?php endforeach; ?>
			<?php endif; ?>
		<div class="progress finished">
			Finished
		</div>
	</div>	
	<br />
	<h2>Legend</h2>
	<table>
		<tr>
			<td style="width:15px; background: #0f0;">
			
			</td>
			<td>
				Finished
			</td>
		</tr>
		<tr>
			<td style="width:15px; background: #f00;">
			
			</td>
			<td>
				In progress
			</td>
		</tr>
		<tr>
			<td style="width:15px; background: #0ff;">
			
			</td>
			<td>
				Cancelled
			</td>
		</tr>
	</table>
</div>
<?php if(It::getState('tkam') == '1'): ?>
<div id="sidebar">
	<h2>Tech management</h2>
	<table class="prj" id="<?php echo $task['ID']; ?>">
		<tr>
			<td>
				<a href="Javascript:void[0]" id="techlist" class="button orange">Select tech</a>
				<div id="usrs"></div>
			</td>
		</tr>
	</table>	
</div>
<?php endif;?>
<div id="text_details">
	<b>Project proposal:</b> <?php echo $task['TITLE']; ?><br /><br />
	<b>Initiated by:</b> <?php echo $task['NAME']; ?> <?php echo $task['SURNAME']; ?><br />
	<b>Contacts:</b> <?php echo $task['PHONE']; ?>, <?php echo $task['EMAIL']; ?><br />
	<b>Project name:</b> <?php echo $task['TITLE']; ?><br />
	<b>Description:</b><br />
	<?php echo $task['DESCRIPTION']; ?><br />
	<?php if(!empty($attaches)): ?>
		<b>Attached files:</b><br />
		<?php foreach($attaches as $attach): ?>
			<a href="<?php echo IT::baseUrl(); ?>/uploads/project_<?php echo $task['ID']; ?>/<?php echo $attach->ATTACH_FILE; ?>">
				<img src="<?php echo IT::baseUrl(); ?>/images/ico/attach.png" /><?php echo $attach->ATTACH_FILE; ?>
			</a><br />
		<?php endforeach; ?>
	<?php endif; ?>
	<br />                     
   	<?php if($signed == 0): ?>
   	<a href="#" class="button orange" id="sign_that"><img src="<?php echo It::baseUrl(); ?>/images/ico/ok.png" />&nbsp;Approve</a>
    <?php endif; ?> <a href="#" class="button orange" id="cancel"><img src="<?php echo It::baseUrl(); ?>/images/ico/cancel.png" />&nbsp;Cancel</a>
    <a href="#" class="button orange" id="ask"><img src="<?php echo It::baseUrl(); ?>/images/ico/help.png" />&nbsp;Ask</a>
    <br /><br />
	<div id="comment_area">
        <?php if(!empty($comments)): ?>
            <table>
            <?php foreach($comments as $comment): ?>
                <tr class="bordered">
                    <td>
                        <?php if(!empty($comment['details'])): ?>
                            <?php echo $comment['details']->NAME; ?>  <?php echo $comment['details']->SURNAME; ?>
                        <?php else: ?>
                            Someone
                        <?php endif; ?>
                        on  <?php echo $comment->CREATED_AT; ?>
                        <?php if($comment->COMMENT_TYPE == 'ask'): ?>
                            asked
                        <?php elseif($comment->COMMENT_TYPE == 'cancel'): ?>
                            said when cancel project
                        <?php elseif($comment->COMMENT_TYPE == 'approve'): ?>
                            said when approve project
                        <?php endif; ?>
                    </td>
                    <td>
                        #<?php echo $comment->ID; ?>
                    </td>
                </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $comment->COMMENT_TEXT; ?>
                        </td>
                    </tr>
            <?php endforeach; ?>
            </table>
        <?php endif; ?>
	</div>
    <div style="display: none;">
        <div class="box-modal" id="approveModal">
            <div class="box-modal_close arcticmodal-close">X</div>
            <input type="hidden" value="<?php echo $task['ID']; ?>">
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
            <input type="hidden" value="<?php echo $task['ID']; ?>">
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
            <input type="hidden" value="<?php echo $task['ID']; ?>">
            Please write your question in form below:
            <div class="comment-error"></div>
            <textarea class="comment-area"></textarea>
            <br />
            <br />
            <a href="#" class="button orange" id="ask-comment">Ask</a>
        </div>
    </div>
</div>