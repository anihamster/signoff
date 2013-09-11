<?php

class DefaultController extends Controller
{
	public function actionGetUsers()
	{
		if(!It::isAjaxRequest())
			$this->redirect(It::baseUrl());
		
		if(empty($_GET['dept_id']))
			$this->redirect(It::baseUrl());
		
		$id = intval($_GET['dept_id']);
		
		$criteria = new CDbCriteria;
		$criteria->condition = 'dept_id = :id';
		$criteria->params = array(':id' => $id);
		$details = UserDetails::model()->findAll($criteria);
		$sign = Signs::model()->find($criteria);
		
		$users = array();
		
		foreach($details as $detail) {
			$users[$detail->id]['id'] = $detail->id;
			$users[$detail->id]['user_id'] = $detail->user_id;
			$users[$detail->id]['name'] = $detail->name;
			$users[$detail->id]['surname'] = $detail->surname;
			$users[$detail->id]['phone'] = $detail->phone;
			$users[$detail->id]['email'] = $detail->email;
			if((!empty($sign)) && ($sign->user_id == $detail->user_id))
				$users[$detail->id]['signed'] = '1';
			else
				$users[$detail->id]['signed'] = '0';
		}
		
		$result = array();
		$result['status'] = 'Ok';
		$result['result'] = $users;
		
		print json_encode($result);
	}
	
	public function actionSignUser() {
		if(!It::isAjaxRequest())
			$this->redirect(It::baseUrl());
		
		if(empty($_GET['user_id']) || empty($_GET['task_id']))
			$this->redirect(It::baseUrl());
		
		$id = intval($_GET['user_id']);
		$tid = intval($_GET['task_id']);
		
		$result = array();
		
		$check = Users::model()->with('details')->findByPk($id);
		$task = Tasks::model()->findByPk($tid);
		
		$test_user = Signs::model()->findAllByAttributes(array('user_id' => $id, 'task_id' => $tid));
		
		$test_deps = Signs::model()->with('details')->findAllByAttributes(array('task_id' => $tid));		
		
		$case = 0;
		if(!empty($test_deps)) {
			foreach($test_deps as $dept) {
				if($dept->dept_id == $check['details']->dept_id) {
					$case = 1;
					$dept->user_id = $id;
					$dept->save(false);
				}
			}
		}
		
		if(empty($check) || empty($task)) {
			$result['status'] = 'Fail';
			$result['result'] = 'Unknown user or task!';
		} elseif(!empty($test_user)) {
			$result['status'] = 'Fail';
			$result['result'] = 'User already signed for this task!';
		} elseif($case == 1) {
			$result['status'] = 'Ok';
			$result['result'] = 'User for task successfully changed!';
		} else {
			$sign = new Signs;
			$sign->user_id = $id;
			$sign->dept_id = $check['details']->dept_id;
			$sign->task_id = $tid;
			$sign->flag = 0;
			$sign->save(false);
			
			$task->status = 1;
			$task->save(false);
			
			$result['status'] = 'Ok';
			$result['result'] = 'User added to signs list!';
		}
		
		print json_encode($result);
	}
	
	public function actionSetSign() {
		if(!It::isAjaxRequest())
			$this->redirect(It::baseUrl());
		
		if(empty($_GET['task_id']) || empty($_GET['action']))
			$this->redirect(It::baseUrl());
		
		$tid = $_GET['task_id'];
        $action = $_GET['action'];
		
		$check = Signs::model()->findByAttributes(array('USER_ID' => Yii::app()->user->getId(), 'PRG_ID' => $tid));

		$result = array();
		
		if(!empty($check)) {
            if($action == 'approve')
			    $check->FLAG = 1;
            elseif($action === 'cancel')
                $check->FLAG = 2;
			$check->save(false);
			$result['status'] = 'Ok';
			$result['result'] = 'Success!';
		} else{
			$result['status'] = 'Failed';
			$result['result'] = 'You can not do that!';
		}
		
		print json_encode($result);
	}
	
	public function actionGetComments() {
		if(!It::isAjaxRequest())
			$this->redirect(It::baseUrl());
		
		if(empty($_GET['dept_id']))
			$this->redirect(It::baseUrl());
		if(empty($_GET['task_id']))
			$this->redirect(It::baseUrl());
		
		$tid = intval($_GET['task_id']);
		$did = intval($_GET['dept_id']);
		
		$comments = Comments::model()->with('details')->findAllByAttributes(array('task_id' => $tid, 'dept_id' => $did));
		
		$result = array();
		
		if(empty($comments)) {
			$result['status'] = 'Failed';
			$result['result'] = 'There is no comments from this department';
		} else {
			$response = array();
			$i = 0;
			foreach($comments as $comment) {
				$response[$i]['id'] = $comment->id;
				$response[$i]['comment_text'] = $comment->comment_text;
				$response[$i]['created'] = $comment->created;
				if(!empty($comment['details'])) {
					$response[$i]['name'] = $comment['details']->name;
					$response[$i]['surname'] = $comment['details']->surname;
				} else {
					$response[$i]['name'] = 'unknown';
					$response[$i]['surname'] = 'unknown';
				}
				$i = $i + 1;
			}
			$result['status'] = 'Ok';
			$result['result'] = $response;
		}
		
		print json_encode($result);
	}

    public function actionGetTech() {
        if(!It::isAjaxRequest())
            $this->redirect(It::baseUrl());

        if(!empty($_GET['prj'])) {
            $pid = intval($_GET['prj']);

            $result=array();

            $criteria = new CDbCriteria;
            $criteria->condition = 'TECH = :tech AND ROLE_PARENT != 0';
            $criteria->params = array(':tech' => '1');
            $roles = Roles::model()->findAll($criteria);

            if(empty($roles)) {
                $result['status'] = 'Failed';
                $result['result'] = 'There is no tech roles in base';
            } else {
                $arr = array();
                $signs = Signs::model()->with('details')->findAllByAttributes(array('PRG_ID' => $pid));

                foreach($roles as $role) {
                    $arr[$role->ID]['id'] = $role->ID;
                    $arr[$role->ID]['name'] = $role->ROLE_NAME;
                    if(!empty($signs)) {
                        $arr[$role->ID]['checked'] = 0;
                        foreach($signs as $sign) {
                            if(!empty($sign['details']) && ($sign['details']->ROLE_ID == $role->ID))
                                $arr[$role->ID]['checked'] = 1;
                        }
                    } else
                        $arr[$role->ID]['checked'] = 0;
                }
                $result['status'] = 'Ok';
                $result['result'] = $arr;
            }
        } else
            $this->redirect(It::baseUrl());


        print json_encode($result);
    }

    public function actionSaveTech() {
        if(!It::isAjaxRequest())
            $this->redirect(It::baseUrl());

        if(!empty($_REQUEST['roles']) && !empty($_REQUEST['prj'])) {
            $roles = $_REQUEST['roles'];
            $pid = $_REQUEST['prj'];

            foreach($roles as $key => $val) {
                if($val['state'] == '1') {
                    $users = UserDetails::model()->findAllByAttributes(array('ROLE_ID' => $val['id'], 'KEY_USER' => '1'));

                    if(!empty($users)) {
                        foreach($users as $user) {
                            $check = Signs::model()->findByAttributes(array('PRG_ID' => $pid, 'USER_ID' => $user->USER_ID));
                            if(empty($check)) {
                                $sign = new Signs;
                                $sign->USER_ID = $user->USER_ID;
                                $sign->PRG_ID = $pid;
                                $sign->FLAG = '0';
                                $sign->save(false);
                            }
                        }
                    }
                }
            }
        }
    }

    public function actionSaveComment() {
        if(!It::isAjaxRequest())
            $this->redirect(It::baseUrl());

        if(!empty($_REQUEST['comment']) && !empty($_REQUEST['prj']) && !empty($_REQUEST['type'])) {
            $comment = $_REQUEST['comment'];
            $task = $_REQUEST['prj'];
            $type = $_REQUEST['type'];

            $comments = new Comments;
            $comments->COMMENT_TYPE = $type;
            $comments->COMMENT_TEXT = $comment;
            $comments->USER_ID = It::userId();
            $comments->PRJ_ID = intval($task);
            $comments->save(false);
        }
    }

    public function actionGetSignsPrj() {
        if(!It::isAjaxRequest())
            $this->redirect(It::baseUrl());

        $result = array();
        $arr = array();

        $roles = Roles::model()->findAllByAttributes(array('TR_GRP_ID' => intval($_GET['grp'])));

        if(!empty($roles)) {
            foreach($roles as $role) {
                $user = UserDetails::model()->with('brand', 'role')->findByAttributes(array('ROLE_ID' => $role->ID, 'KEY_USER' => '1'));
                if(!empty($user)) {
                    $sign = Signs::model()->findByAttributes(array('USER_ID' => $user->USER_ID, 'PRG_ID' => intval($_GET['prj'])));
                    if(!empty($user['brand']))
                        $arr[$role->ID]['brand'] = $user['brand']->BRAND_NAME;
                    else
                        $arr[$role->ID]['brand'] = '';

                    if(!empty($user['role']))
                        $arr[$role->ID]['role'] = $user['role']->ROLE_NAME;
                    else
                        $arr[$role->ID]['role'] = '';

                    if(!empty($sign)) {
                        $arr[$role->ID]['sign'] = $sign->FLAG;
                    } else {
                        $arr[$role->ID]['sign'] = '6';
                    }
                }
            }
            $result['code'] = 'Ok';
            $result['status'] = 'Get';
            $result['response'] = $arr;
        } else {
            $result['code'] = 'Fail';
            $result['status'] = 'Get';
            $result['response'] = $arr;
        }

        print json_encode($result);
    }
}