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
    $tracker = array();
    $tracker_groups = TrackerGroups::model()->getGroups();
    $tracker[0]['title'] = 'Sign off initiated';
    $count = count($tracker_groups);
    foreach($tracker_groups as $key => $val) {
        $tracker[$key]['title'] = $val;
        $subtrack = array();
        $roles = Roles::model()->findAllByAttributes(array('TR_GRP_ID' => $key));

        if(!empty($roles)) {
            foreach($roles as $role) {
                $user = UserDetails::model()->with('brand', 'role')->findByAttributes(array('ROLE_ID' => $role->ID, 'KEY_USER' => '1'));
                if(!empty($user)) {
                    $sign = Signs::model()->findByAttributes(array('USER_ID' => $user->USER_ID, 'PRG_ID' => $p_v['ID']));
                    if(!empty($user['brand']))
                        $subtrack[$role->ID]['brand'] = $user['brand']->BRAND_NAME;
                    else
                        $subtrack[$role->ID]['brand'] = '';

                    if(!empty($user['role']))
                        $subtrack[$role->ID]['role'] = $user['role']->ROLE_NAME;
                    else
                        $subtrack[$role->ID]['role'] = '';

                    if(!empty($sign)) {
                        $subtrack[$role->ID]['sign'] = $sign->FLAG;
                    } else {
                        $subtrack[$role->ID]['sign'] = '6';
                    }
                }
            }
        }

        $tracker[$key]['subs'] = $subtrack;

        $counter = count($subtrack);
        $signed = 0;
        foreach($subtrack as $k => $v) {
            if($v['sign'] == '1')
                $signed = $signed +1;
        }
        if($signed == $counter)
            $tracker[$key]['state'] = '1';
        else
            $tracker[$key]['state'] = '0';
    }
    $tracker[$count + 1]['title'] = 'Final sign off';
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
<div class="folder-toggle">
    <h2><a href="#" onClick="dataLayer.push({'event':'GAevent', 'eventCategory' : '<?php echo $p_v['TITLE']; ?>' , 'eventAction' : 'Show project description' , 'eventLabel' : 'Project description'})"><?php echo $p_v['TITLE']; ?>
            <span>initiated by <?php echo $p_v['NAME']; ?> <?php echo $p_v['SURNAME']; ?> </span>
        </a></h2>
    <section style="display: none; ">
        <div>
            <div>
                <strong>Progress tracker:</strong><br /><br />
                <div class="track" id="<?php echo $p_v['ID']; ?>">
                    <?php if(!empty($tracker)): ?>
                        <?php $ind = count($tracker); ?>
                        <div class="trk">
                        <?php foreach($tracker as $k => $v): ?>
                            <div style="width:150px; display: table-cell; vertical-align: top;" >
                            <div id="<?php echo $k ?>" class="sprite <?php if(!empty($v['state']) && ($v['state'] == 1) || ($k == 0)): ?>signed<?php elseif(empty($v['state']) || ($v['state'] == 0)): ?>head<?php endif; ?>" style="z-index: <?php echo $ind; ?>">
                                <?php echo $v['title']; ?>
                            </div><br />
                            <div class="track_content" align="center;" style="z-index: 50; display: none;">
                                <?php if(!empty($v['subs'])): ?>
                                        <?php foreach($v['subs'] as $vk => $vv): ?>
                                            <div id="<?php echo $vk ?>" class="sprite_child <?php if($vv['sign'] == 1): ?>signed<?php elseif($vv['sign'] == 0): ?>notsigned<?php elseif($vv['sign'] == 2): ?>canceled<?php endif; ?>_child" style="z-index: 1">
                                                <?php echo $vv['brand']; ?> <?php echo $vv['role']; ?>
                                            </div><br />
                                        <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                            <?php $ind = $ind - 1; ?>
                        <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                     <br /><br />
            </div>
            <div>
                <?php if((It::getState('tkam') == '1') || (!empty($asks))): ?>
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
                <?php endif; ?>
                <div class="pr_content">
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
                    <br />
                    <?php if($p_v['USER_ID'] !== It::userId()):?>
                        <?php if($signed == 0): ?>
                            <a href="#" class="button-secondary sign_that" id="<?php echo $p_v['ID']; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/ok.png" />&nbsp;Approve</a>
                        <?php endif; ?> <a href="#" class="button-secondary cancel" id="<?php echo $p_v['ID']; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/cancel.png" />&nbsp;Cancel</a>
                        <a href="#" class="button-secondary ask" id="<?php echo $p_v['ID']; ?>"><img src="<?php echo It::baseUrl(); ?>/images/ico/help.png" />&nbsp;Ask</a>
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
                                                <?php if($comment->COMMENT_TYPE == 'cancel'): ?>
                                                    said when cancel project
                                                <?php elseif($comment->COMMENT_TYPE == 'approve'): ?>
                                                    said when approve project
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php echo $comment->CREATED_AT; ?>
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
        </div>
        <div class="clear">&nbsp;</div>
    </section>
</div>