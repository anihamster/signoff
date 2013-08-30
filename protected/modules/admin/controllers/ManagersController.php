<?php

class ManagersController extends Controller {
	public function actionIndex() {
		if(Yii::app()->user->isGuest)
			$this->redirect(It::baseUrl() . '/main/default/login');
	
		$users = Users::model()->getAllUsers();
		$levels = UserLevels::model()->getLevels();
	
		$this->render('index', array('users' => $users, 'levels' => $levels));
	}
	
	public function actionAdd() {
		if(Yii::app()->user->isGuest)
			$this->redirect(It::baseUrl() . '/main/default/login');
	
		$levels = UserLevels::model()->getLevels();
		
		$nodes = Brands::model()->findAll();
		
		$brands = array();

        $brands[0] = 'General user';

		foreach($nodes as $val) {
			$brands[$val->ID] = $val->BRAND_NAME;
		}

        $roles = Roles::model()->getRoles();
	
		$form = new Users;
		$form2 = new UserDetails;
		
		if(!empty($_POST['Users']) && (!empty($_POST['UserDetails']))) {
			$form->attributes = $_POST['Users'];
			$form2->attributes = $_POST['UserDetails'];
			$form->scenario = 'add';
			$form2->scenario = 'add';
			
			if(Yii::app()->user->getState('user_role') == '3') {
				$form->type = '2';
				$ud = UserDetails::model()->findByAttributes(array('USER_ID' => Yii::app()->user->getId()));
				$form2->DEPT_ID = $ud->DEPT_ID;
			}
			
			$valid=$form->validate();
			$valid=$form2->validate() && $valid;
			
			if ($valid) {
				$form->PASSWORD = sha1(md5($_POST['Users']['PASSWORD']));
                $form->save(false);

                $user = Users::model()->findByAttributes(array('LOGIN' => $_POST['Users']['LOGIN']));

				$form2->USER_ID = $user->ID;
				$form2->save(false);
				
				$this->redirect(It::baseUrl() . "/admin/managers/");
			}
		}
		$this->render('add', array('form' => $form, 'form2' => $form2, 'brands' => $brands, 'levels' => $levels, 'roles' => $roles));
	}
	
	public function actionEditDetails() {
		if(Yii::app()->user->isGuest)
			$this->redirect(It::baseUrl() . '/main/default/login');
		
		if(empty($_GET['user_id']))
			$this->redirect(It::baseUrl() . '/admin/managers/');
		
		$uid = intval($_GET['user_id']);
		
		$user = Users::model()->findByPk($uid);
		
		if(!$user)
			$this->redirect(It::baseUrl() . '/admin/managers/');
		
		$form = UserDetails::model()->findByAttributes(array('USER_ID' => $uid));
		
		if(empty($form))
			$form = new UserDetails;
		
		$nodes = Brands::model()->findAll();
		
		$brands = array();

        $brands[0] = 'General user';
		
		foreach($nodes as $val) {
			$brands[$val->ID] = $val->BRAND_NAME;
		}

        $roles = Roles::model()->getRoles();
		
		if(!empty($_POST['UserDetails'])) {
			$form->attributes = $_POST['UserDetails'];
			$form->scenario = 'add';
			if ($form->validate()) {
				$form->USER_ID = $uid;
				$form->save(false);
				$this->redirect(It::baseUrl() . "/admin/managers/");
			}
		}
		$this->render('details', array('form' => $form, 'brands' => $brands, 'roles' => $roles));
	}
}