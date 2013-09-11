<?php

class RolesController extends Controller {

    public function actionIndex() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(It::getState('user_role') !== '1')
            throw new CDbExeption('You have not access to this page');

        $roles = Roles::model()->with('parents')->findAll();

        $this->render('index', array('roles' => $roles));
    }

    public function actionEdit() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(It::getState('user_role') !== '1')
            throw new CDbExeption('You have not access to this page');

        if(empty($_GET['role_id']))
            $form = new Roles;
        else
            $form = Roles::model()->findByPk(intval($_GET['role_id']));

        $roles = Roles::model()->findAll();
        $groups = TrackerGroups::model()->getGroups();

        $parents = array();
        $parents[0] = 'General role';

        if(!empty($roles)) {
            foreach($roles as $role) {
                $parents[$role->ID] = $role->ROLE_NAME;
            }
        }

        if(!empty($_POST['Roles'])) {
            $form->attributes = $_POST['Roles'];
            $form->scenario = 'edit';

            if($form->validate()) {
                $form->save(false);
                $this->redirect(It::baseUrl() . '/admin/roles');
            }
        }

        $this->render('edit', array('form' => $form, 'parents' => $parents, 'groups' => $groups));
    }
}