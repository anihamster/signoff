<?php

class DefaultController extends Controller
{
 	public function actionIndex() {
        if(Yii::app()->user->isGuest)
			$this->redirect(It::baseUrl() . '/main/default/login');
		
		if(It::getState('user_role') == '1')
			$this->redirect(It::baseUrl() . '/admin/default/settings');
		else
			$this->redirect(It::baseUrl() . '/manager/projects');
    }
	
	public function actionInstall() {
		$level = new UserLevels;
		$level->USER_LEVEL = 'Admin';
		$level->save(false);
		$level = new UserLevels;
		$level->USER_LEVEL = 'Manager';
		$level->save(false);	
		$user = new Users;
		$user->LOGIN = 'admin';
		$user->PASSWORD = sha1(md5('123123'));
		$user->TYPE = '1';
		$user->save(false);
	}

    public function actionLogin() {
        if(!It::isGuest()) {
            $this->redirect('index');
        } else {
            $form = new Login;
            
            if(!empty($_POST['Login'])) {
                $form->attributes = $_POST['Login'];
                $form->scenario = 'login';
                if($form->validate()) {
                    $this->redirect(It::baseUrl() . '/main/default');
                }
            }
        }
        $this->render('login', array('form' => $form));
    }
    
    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(It::baseUrl() . '/main/default');
    }
	
}