<?php

class TasksController extends Controller {
	
	public function actionIndex() {
		if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->baseUrl . '/main/default/login');
		
		if(Yii::app()->user->getState('user_role') !== '1')
			$this->redirect(Yii::app()->baseUrl . '/manager/tasks');
		
		$tasks = Tasks::model()->getAllTasks();
		
		$this->render('index', array('tasks' => $tasks));
	}
	
	public function actionDetails() {
		if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->baseUrl . '/main/default/login');
		
		if(!(Yii::app()->user->getState('user_role') == '1'))
			$this->redirect(Yii::app()->baseUrl . '/manager/tasks');
		
		if(empty($_GET['task_id']))
			$this->redirect(Yii::app()->baseUrl . '/admin/tasks/');
		
		$tid = intval($_GET['task_id']);
		
		$task = Tasks::model()->getTask($tid);
		
		$sign = Signs::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'task_id' => $tid));
			
		$signs_obj = Signs::model()->findAllByAttributes(array('task_id' => $tid));
		$signs = array();
		if(!empty($signs_obj)) {
			foreach($signs_obj as $s_v) {
				$signs[$s_v->dept_id] = $s_v->flag;
			}
		}
		
		$comments = Comments::model()->findAllByAttributes(array('task_id' => $tid));
		
		$this->render('details', array('task' => $task, 'comments' => $comments, 'signs' => $signs));
	}
	
	public function actionEdit() {
		if(Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->baseUrl . '/main/default/login');
		
		if(!(Yii::app()->user->getState('user_role') == '1'))
			$this->redirect(Yii::app()->baseUrl . '/manager/tasks');
		
		if(empty($_GET['task_id']))
			$this->redirect(Yii::app()->baseUrl . '/admin/tasks/');
		
		$tid = intval($_GET['task_id']);
		
		$task = Tasks::model()->findByPk($tid);
		
		$task->assigned_to = explode(',', $task->assigned_to);
		
		$deps = Departments::model()->getAllDeps();
		
		$dep = array();
		
		foreach($deps as $dept) {
			$dep[$dept->id] = $dept->name;
		}
		
		if(empty($task))
			$this->redirect(Yii::app()->baseUrl . '/admin/tasks/');
		
		$signs = Signs::model()->findAllByAttributes(array('task_id' => $tid));
		
		$managers = Users::model()->getAllUsers();
		
		if(!empty($_POST['Tasks'])) {
			$task->attributes = $_POST['Tasks'];
			$task->scenario = 'add';
			$task->assigned_to = implode(',', $_POST['Tasks']['assigned_to']);
			if ($task->validate()) {
				$task->save(false);
				$this->redirect(Yii::app()->baseUrl . "/admin/tasks/");
			}
		}
		
		$this->render('edit', array('form' => $task, 'deps' => $dep, 'signs' => $signs, 'managers' => $managers));
	}
}