<?php $comments = Comments::model()->with('details')->findAllByAttributes(array('PRJ_ID' => $p_v['ID']));?>
<?php $attaches = Attaches::model()->findAllByAttributes(array('ATTACH_TO' => $p_v['ID'], 'ATTACH_TYPE' => 'project')); ?>
<?php
$sign = Signs::model()->findByAttributes(array('USER_ID' => Yii::app()->user->getId(), 'PRG_ID' => $p_v['ID']));

if(!empty($sign))
    $status = $sign->FLAG;
else
    $status = 0;

if($status == 1)
    $signed = 1;
else
    $signed = 0;
?>

<?php
$signs_obj = Signs::model()->findAllByAttributes(array('PRG_ID' => $p_v['ID']));
$signs = array();
if(!empty($signs_obj)) {
    foreach($signs_obj as $s_v) {
        $user = UserDetails::model()->with('brand', 'role')->findByAttributes(array('USER_ID' => $s_v->USER_ID));

        if(!empty($user['brand']))
            $signs[$s_v->USER_ID]['brand'] = $user['brand']->BRAND_NAME;
        else
            $signs[$s_v->USER_ID]['brand'] = '';
        if(!empty($user['role']))
            $signs[$s_v->USER_ID]['role'] = $user['role']->ROLE_NAME;
        else
            $signs[$s_v->USER_ID]['role'] = '';
        $signs[$s_v->USER_ID]['user'] = $s_v->USER_ID;
        $signs[$s_v->USER_ID]['flag'] = $s_v->FLAG;
    }
}?>
<?php
    $asks = array();
    if(!empty($comments)) {
        foreach($comments as $comment) {
            if(($comment->COMMENT_TYPE == 'ask') || ($comment->COMMENT_TYPE == 'answer')) {
                $asks[$comment->ID]['ID'] = $comment->ID;
                $asks[$comment->ID]['TYPE'] = $comment->COMMENT_TYPE;
                $asks[$comment->ID]['COMMENT_TEXT'] = $comment->COMMENT_TEXT;
                if(!empty($comment['details'])) {
                    $asks[$comment->ID]['NAME'] = $comment['details']->NAME;
                    $asks[$comment->ID]['SURNAME'] = $comment['details']->SURNAME;
                } else {
                    $asks[$comment->ID]['NAME'] = 'Someone';
                    $asks[$comment->ID]['SURNAME'] = 'Someone';
                }
            }
        }
    }
?>
<div class="project">
    <div class="project_title">
        <a class="closed"><?php echo $p_v['TITLE']; ?></a></div>
    <div class="project_details" id="<?php echo $p_v['ID']; ?>" style="display: none;">
        <div class="right">
            <?php if(It::getState('tkam') == '1'): ?>
                <div class="tkam">
                    <a href="Javascript:void[0]" class="show"><strong>Tech management</strong></a>
                    <div class="prj" id="<?php echo $p_v['ID']; ?>" style="display: none;">
                        <a href="Javascript:void[0]" class="techlist">Select tech</a>
                        <div class="usrs"></div>
                    </div>
                </div>
            <?php endif;?>
            <?php if(!empty($asks)): ?>
                <div class="aq">
                    <a href="Javascript:void[0]" class="show"><strong>Questions</strong></a>
                    <div class="prj" id="<?php echo $p_v['ID']; ?>" style="display: none;">
                        <?php foreach($asks as $a_k => $a_v): ?>
                            <p class="triangle-border <?php if($a_v['TYPE'] == 'ask'): ?>arr_left<?php elseif($a_v['TYPE'] == 'answer'): ?>arr_right<?php endif; ?>">
                                <?php echo $a_v['NAME']; ?> <?php echo $a_v['SURNAME']; ?><br />
                                <?php if($a_v['TYPE'] == 'ask'): ?>asks<?php elseif($a_v['TYPE'] == 'answer'): ?>answers<?php endif; ?>:<br />
                                <?php echo($a_v['COMMENT_TEXT']);  ?>
                            </p>
                        <?php endforeach; ?>
                        <?php if($p_v['USER_ID'] == It::userId()): ?>
                            <input type="hidden" class="ans_task" value="<?php echo $p_v['ID']; ?>">
                            <textarea class="answer_text"></textarea><br />
                            <a href="Javascript:void[0]" class="button answer_button">Answer</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="content">
            <strong>Project proposal:</strong> <?php echo $p_v['TITLE']; ?><br /><br />
            <strong>Initiated by:</strong> <?php echo $p_v['NAME']; ?> <?php echo $p_v['SURNAME']; ?><br />
            <strong>Contacts:</strong> <?php echo $p_v['PHONE']; ?>, <?php echo $p_v['EMAIL']; ?><br />
            <strong>Description:</strong><br />
            <?php echo $p_v['DESCRIPTION']; ?>
            <br />
            <?php if(!empty($attaches)): ?>
                <strong>Attached files:</strong><br />
                <?php foreach($attaches as $attach): ?>
                    <a href="<?php echo IT::baseUrl(); ?>/uploads/project_<?php echo $p_v['ID']; ?>/<?php echo $attach->ATTACH_FILE; ?>">
                        <img src="<?php echo IT::baseUrl(); ?>/images/ico/attach.png" /><?php echo $attach->ATTACH_FILE; ?>
                    </a><br />
                <?php endforeach; ?>
            <?php endif; ?>
            <strong>Progress tracker:</strong><br /><br />
            <div class="ProgressBar">
                <?php if(!empty($signs)): ?>
                    <?php $z = count($signs) + 1; ?>
                    <div class="Step" style="width: *; color: #000000 ; background-color: #00ff00; z-index: <?php echo $z + 1; ?>;">
                        <div style="padding-left: 25px; padding-right: 15px;">Initiated</div>
                        <div class="Arrow">
                            <div class="Arrow-Head">
                                <div style="border-color: transparent transparent transparent #00ff00;"></div>
                            </div>
                        </div>
                    </div>
                    <?php foreach($signs as $s_k => $s_v): ?>
                        <div class="Step" style="width: *; color: #000000 ; background-color: <?php if($s_v['flag'] == '0'): ?>#ff0000<?php elseif($s_v['flag'] == '1'): ?>#00ff00<?php elseif($s_v['flag'] == '2'): ?>#00ffff<?php endif; ?>; z-index: <?php echo $z; ?>;">
                            <div style="padding-left: 25px; padding-right: 15px;">
                            <?php if(!empty($s_v['brand'])): ?>
                                <?php echo $s_v['brand']; ?>
                            <?php endif; ?>
                            <?php if(!empty($s_v['role'])): ?>
                                <?php echo $s_v['role']; ?>
                            <?php endif; ?>
                            </div>
                            <div class="Arrow">
                                <div class="Arrow-Head">
                                    <div style="border-color: transparent transparent transparent <?php if($s_v['flag'] == '0'): ?>#ff0000<?php elseif($s_v['flag'] == '1'): ?>#00ff00<?php elseif($s_v['flag'] == '2'): ?>#00ffff<?php endif; ?>;"></div>
                                </div>
                            </div>
                        </div>
                        <?php $z = $z - 1;?>
                    <?php endforeach; ?>
                    <div class="Step" style="width: *%; color: #000000 ; background-color: #00ff00; z-index: 0;">
                        <div style="padding-left: 25px; padding-right: 15px;">Finished</div>
                        <div class="Arrow">
                            <div class="Arrow-Head">
                                <div style="border-color: transparent transparent transparent #00ff00;"></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <br />
            <?php if($p_v['USER_ID'] !== It::userId()):?>
            <?php if($signed == 0): ?>
                <a href="#" class="button sign_that" id="<?php echo $p_v['ID']; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/ok.png" />&nbsp;Approve</a>
            <?php endif; ?> <a href="#" class="button cancel" id="<?php echo $p_v['ID']; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/cancel.png" />&nbsp;Cancel</a>
            <a href="#" class="button ask" id="<?php echo $p_v['ID']; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/help.png" />&nbsp;Ask</a>
            <?php endif; ?>
            <br /><br />
            <div id="comment_area" style="width: 600px;">
                <?php if(!empty($comments)): ?>
                    <table>
                        <?php foreach($comments as $comment): ?>
                            <?php if(!($comment->COMMENT_TYPE == 'ask') && !($comment->COMMENT_TYPE == 'answer')): ?>
                            <tr>
                                <td>
                                    <?php if(!empty($comment['details'])): ?>
                                        <?php echo $comment['details']->NAME; ?>  <?php echo $comment['details']->SURNAME; ?>
                                    <?php else: ?>
                                        Someone
                                    <?php endif; ?>
                                    on  <?php echo $comment->CREATED_AT; ?>
                                    <?php if($comment->COMMENT_TYPE == 'cancel'): ?>
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
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>