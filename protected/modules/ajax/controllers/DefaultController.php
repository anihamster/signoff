<?php

class DefaultController extends Controller
{
	public function actionGetUsers()
	{
		if(!Yii::app()->request->isAjaxRequest)
			$this->redirect(Yii::app()->baseUrl);
		
		if(empty($_GET['dept_id']))
			$this->redirect(Yii::app()->baseUrl);
		
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
		if(!Yii::app()->request->isAjaxRequest)
			$this->redirect(Yii::app()->baseUrl);
		
		if(empty($_GET['user_id']) || empty($_GET['task_id']))
			$this->redirect(Yii::app()->baseUrl);
		
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
		if(!Yii::app()->request->isAjaxRequest)
			$this->redirect(Yii::app()->baseUrl);
		
		if(empty($_GET['task_id']))
			$this->redirect(Yii::app()->baseUrl);
		
		$tid = $_GET['task_id'];
		
		$check = Signs::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'task_id' => $tid));
		$boss = Yii::app()->user->getState('user_role');
		
		$result = array();
		
		if(!empty($check)) {
			$check->flag = 1;
			$check->save(false);
			$result['status'] = 'Ok';
			$result['result'] = 'Success!';
		} elseif($boss == '3') {
			$user = UserDetails::model()->findByAttributes(array('user_id' => Yii::app()->user->getId()));
			$dept = $user->dept_id;
			$sign = Signs::model()->findByAttributes(array('dept_id' => $dept, 'task_id' => $tid));
			$sign->flag = '1';
			$sign->save(false);
			$result['status'] = 'Ok';
			$result['result'] = 'Success!';
		} else{
			$result['status'] = 'Failed';
			$result['result'] = 'You can not do that!';
		}
		
		print json_encode($result);
	}
	
	public function actionGetComments() {
		if(!Yii::app()->request->isAjaxRequest)
			$this->redirect(Yii::app()->baseUrl);
		
		if(empty($_GET['dept_id']))
			$this->redirect(Yii::app()->baseUrl);
		if(empty($_GET['task_id']))
			$this->redirect(Yii::app()->baseUrl);
		
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

    public function actionSaveRelations() {
        if(!It::isAjaxRequest())
            $this->redirect(Yii::app()->baseUrl);
        if(empty($_REQUEST))
            $this->redirect(Yii::app()->baseUrl);

        $name = $_REQUEST['name'];
        $role = $_REQUEST['role'];
        $cat = $_REQUEST['cat'];
        $grp = $_REQUEST['grp'];

        $result = array();

        if(!empty($name)) {
            $dept_grp = new DeptGroups();
            $dept_grp->GROUP_NAME = $name;
            $dept_grp->GROUP_PARENT = 0;
            $dept_grp->save(false);
        }
        if(!empty($role) && !empty($cat)) {
            $group = DeptGroups::model()->findByAttributes(array('GROUP_NAME' => $name));
            $rule = new RelationRules;
            $rule->CAT_ID = $cat;
            $rule->GRP_ID = $group->ID;
            $rule->ROLE_ID = $role;
            $rule->save(false);
        }

        foreach($grp as $g_k => $g_v) {
            $dpt = Departments::model()->findByPk($g_v);
            if(!empty($dpt)) {
                $dpt->DEPT_GROUP = $group->ID;
                $dpt->save(false);
            }
        }

        $result['status'] = 'Ok';

        print json_encode($result);
    }
}