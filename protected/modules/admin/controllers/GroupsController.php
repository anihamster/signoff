<?php

class GroupsController extends Controller {

    public function actionIndex() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(It::getState('user_role') !== '1')
            throw new CDbExeption('You have not access to this page');

        $groups = DeptGroups::model()->with('parent')->findAll();

        $this->render('index', array('groups' => $groups));
    }

    public function actionEdit() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(It::getState('user_role') !== '1')
            throw new CDbExeption('You have not access to this page');

        $form = new DeptGroups;
        $groups = DeptGroups::model()->findAll();
        $grps = array();
        $grps[0] = 'Main group';
        foreach($groups as $group) {
            $grps[$group->ID] = $group->GROUP_NAME;
        }

        if(!empty($_POST['DeptGroups'])) {
            $form->attributes = $_POST['DeptGroups'];
            $form->scenario = 'edit';

            if($form->validate()) {
                $form->save(false);
                $this->redirect(It::baseUrl() . '/admin/groups');
            }
        }

        $this->render('edit', array('form' => $form, 'grps' => $grps));
    }

}