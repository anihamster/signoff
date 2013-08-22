<?php

class DepartmentsController extends Controller {
	
	public function actionIndex() {
		if(It::isGuest())
			$this->redirect(It::baseUrl() . '/main/default/login');
		
		$deps = Departments::model()->getAllDeps();
		
		$this->render('index', array('deps' => $deps));		
	}
	
	public function actionAdd() {
		if(It::isGuest())
			$this->redirect(It::baseUrl() . '/main/default/login');
		
		$nodes = Departments::model()->getAllDeps();
		
		$deps = array();
		$deps[0] = 'Main department';
		
		foreach($nodes as $val) {
			$deps[$val->ID] = $val->DEPT_NAME;
		}		
		
		$form = new Departments;
		
		if(!empty($_POST['Departments'])) {
			$form->attributes = $_POST['Departments'];
			$form->scenario = 'add';
			if ($form->validate()) {
				$form->save(false);
				$this->redirect(It::baseUrl() . "/admin/departments/");
			}
		}
		$this->render('add', array('form' => $form, 'deps' => $deps));
	}	
	
	public function actionEdit() {
		if(It::isGuest())
			$this->redirect(It::baseUrl() . '/main/default/login');
	
		$nodes = Departments::model()->getAllDeps();
	
		$deps = array();
		$deps[0] = 'Main department';
	
		foreach($nodes as $val) {
			$deps[$val->ID] = $val->DEPT_NAME;
		}
	
		if(empty($_GET['dept_id']))
			$this->redirect(It::baseUrl() . '/admin/departments/');
	
		$did = intval($_GET['dept_id']);
	
		$users = UserDetails::model()->findAllByAttributes(array('DEPT_ID' => $did));
		$dusers = array();
		if(empty($users))
			$dusers[0] = 'There is no managers in that department';
		else {
			foreach($users as $user) {
				$dusers[$user->USER_ID] = $user->NAME . ' ' . $user->SURNAME;
			}
		}
	
		$form = Departments::model()->findByPk($did);
		
		if(empty($form))
			$this->redirect(It::baseUrl() . '/admin/departments/');
	
		if(!empty($_POST['Departments'])) {
			$form->attributes = $_POST['Departments'];
			$form->scenario = 'add';
			if ($form->validate()) {
				$form->save(false);
				$this->redirect(It::baseUrl() . "/admin/departments/");
			}
		}
		$this->render('edit', array('form' => $form, 'deps' => $deps, 'dep_users' => $dusers));
	}
}