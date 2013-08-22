<?php

class RolesController extends Controller {

    public function actionIndex() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(It::getState('user_role') !== '1')
            throw new CDbExeption('You have not access to this page');

        $roles = Roles::model()->with('department')->findAll();

        $this->render('index', array('roles' => $roles));
    }

    public function actionEdit() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(It::getState('user_role') !== '1')
            throw new CDbExeption('You have not access to this page');

        $form = new Roles;
        $deps = Departments::model()->getAllDeps();

        if(!empty($_POST['Roles'])) {
            $form->attributes = $_POST['Roles'];
            $form->scenario = 'edit';

            if($form->validate()) {
                $form->save(false);
                $this->redirect(It::baseUrl() . '/admin/roles');
            }
        }

        $this->render('edit', array('form' => $form, 'deps' => $deps));
    }
}