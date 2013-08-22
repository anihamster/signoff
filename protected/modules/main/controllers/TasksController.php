<?php

class TasksController extends Controller {
	
	public function actionIndex() {
		if(Yii::app()->user->isGuest)
			$this->redirect(It::baseUrl() . '/main/default/login');
		
		if(It::getState('user_role') == '1')
			$this->redirect(It::baseUrl() . '/admin/projects');
		else
			$this->redirect(It::baseUrl() . '/manager/projects');
	}	
}