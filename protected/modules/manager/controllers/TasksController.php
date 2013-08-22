<?php

class TasksController extends Controller {
	
	public function actionIndex() {
		if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->baseUrl . '/main/default/login');
		
		if(Yii::app()->user->getState('user_role') == '1')
			$this->redirect(Yii::app()->baseUrl . '/admin/tasks');
		
		$tasks = array();
		
		if(Yii::app()->user->getState('user_role') == '3') {
			$details = UserDetails::model()->findByAttributes(array('user_id' => Yii::app()->user->getId()));
			$tasks = Tasks::model()->getDeptTasks($details->dept_id);			
		} else {
		
			$criteria = new CDbCriteria;
			$criteria->condition = 'user_id = :id';
			$criteria->params = array(':id' => Yii::app()->user->getId());
			$signs = Signs::model()->findAll($criteria);
					
			if(!empty($signs))
				foreach($signs as $sign) {
					$tasks[] = Tasks::model()->getTask($sign->task_id);
				}
		}
				
		$this->render('index', array('tasks' => $tasks));
	}
	
	public function actionCreate() {
		if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->baseUrl . '/main/default/login');
		
		$deps = Departments::model()->getAllDeps();
		
		$dep = array();
		
		foreach($deps as $dept) {
			$dep[$dept->id] = $dept->name;
		}
		
		$form = new Tasks;
		
		$attach_form = array(new Attach);

		if(!empty($_POST['Tasks'])) {
			$form->attributes = $_POST['Tasks'];
			$form->scenario = 'add';
			if(!empty($_POST['Tasks']['assigned_to']))
				$form->assigned_to = implode(',', $_POST['Tasks']['assigned_to']);			
			if ($form->validate()) {				
				$form->user_id = Yii::app()->user->getId();
				$form->save(false);
				$task = Yii::app()->db->getLastInsertID();
				
				if(!empty($_REQUEST['Attach'])) {
					$valid = true;
						
					foreach($_REQUEST['Attach'] as $i => $item) {
						$attach_form[$i] = new Attach;
						$attach_form[$i]->scenario = 'add';
						$attach_form[$i]->attach_type = 'project';
						$attach_form[$i]->attached_to = $task;
						$attach_form[$i]->attach_file = CUploadedFile::getInstance($attach_form[$i], '['.$i.']attach_file');
				
						$valid = $valid & $attach_form[$i]->validate();
					}
						
					if($valid) {
						foreach($attach_form as $i => $item) {					
							if($item->save())
								if (!is_dir(Yii::getPathOfAlias('webroot').'/uploads/project_' . $task))
									mkdir(Yii::getPathOfAlias('webroot').'/uploads/project_' . $task, 0777);
								$item->attach_file->saveAs(Yii::getPathOfAlias('webroot').'/uploads/project_' . $task . '/'.$item->attach_file);
						}
					}
				}
				
				if(!empty($_POST['Tasks']['assigned_to']))
					foreach($_POST['Tasks']['assigned_to'] as $dept) {
						$department = Departments::model()->findByPk($dept);
						$sign = new Signs;
						$sign->dept_id = $dept;
						$sign->user_id = $department->default_user;
						$sign->task_id = $task;
						$sign->save(false);
					}
				$this->redirect(Yii::app()->baseUrl . "/manager/tasks/");
			}
		}
		
		$this->render('create', array('deps' => $dep, 'form' => $form, 'attach_form' => $attach_form));
	}
	
	public function actionDetails() {
		if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->baseUrl . '/main/default/login');
		
		if(empty($_GET['task_id']))
			$this->redirect(Yii::app()->baseUrl . '/manager/tasks/');
		
		$tid = intval($_GET['task_id']);
		
		$task = Tasks::model()->getTask($tid);
			
		$attaches = Attach::model()->findAllByAttributes(array('attached_to' => $tid, 'attach_type' => 'project'));
		
		$sign = Signs::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'task_id' => $tid));
		
		if(!empty($sign))
			$status = $sign->flag;
		else {
			$user = UserDetails::model()->findByAttributes(array('user_id' => Yii::app()->user->getId()));
			$sign = Signs::model()->findByAttributes(array('dept_id' => $user->dept_id, 'task_id' => $tid));
			$status = $sign->flag;
		}
		
		$dept = 0;
		
		$boss = 0;
		
		if(Yii::app()->user->getState('user_role') == '3') {
			$details = UserDetails::model()->findByAttributes(array('user_id' => Yii::app()->user->getId()));
			$boss = 0;
			foreach($task['assigned_to'] as $key => $d_val) {
				if($details->dept_id == $key)
					$boss = 1;
					$dept = $key;
					
			}
		}
		
		if(($status == 0) OR ($boss == 1 AND $status == 0))
			$signed = 1;
		else
			$signed = 0;
		
		$signs_obj = Signs::model()->findAllByAttributes(array('task_id' => $tid));
		$signs = array();
		if(!empty($signs_obj)) {
			foreach($signs_obj as $s_v) {
				$signs[$s_v->dept_id] = $s_v->flag;
			}
		}
		
		$form = new Comments;
		if(!empty($_POST['Comments'])) {
			$form->attributes = $_POST['Comments'];
			$form->scenario = 'add';
			if ($form->validate()) {
				$form->task_id = $tid;
				$form->user_id = Yii::app()->user->getId();
				$detail = UserDetails::model()->findByAttributes(array('user_id' => Yii::app()->user->getId()));
				$form->dept_id = $detail->dept_id;
				$form->save(false);
				$this->redirect(Yii::app()->baseUrl . "/manager/tasks/details/?task_id=" . $tid);
			}
		}		
		
		$this->render('details', array('task' => $task, 'form' => $form, 'signed' => $signed, 'signs' => $signs, 'dept' => $dept, 'attaches' => $attaches));
	}
	
	public function actionMy() {
		if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->baseUrl . '/main/default/login');
		
		$tasks = Tasks::model()->getManagersTask(Yii::app()->user->getId());
		
		$this->render('my', array('tasks' => $tasks));
	}
}