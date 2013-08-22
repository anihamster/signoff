<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionSettings() {

        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(It::getState('user_role') !== '1')
            throw new CDbException('You have not access to this page');

        $this->render('settings');
    }
}