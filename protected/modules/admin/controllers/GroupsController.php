<?php

class GroupsController extends Controller {

    public function actionIndex() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(It::getState('user_role') !== '1')
            throw new CDbExeption('You have not access to this page');

        $groups = TrackerGroups::model()->with('parents')->findAll();

        $this->render('index', array('groups' => $groups));
    }

    public function actionEdit() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(It::getState('user_role') !== '1')
            throw new CDbExeption('You have not access to this page');

        if(empty($_GET['grp_id']))
            $form = new TrackerGroups;
        else
            $form = TrackerGroups::model()->findByPk(intval($_GET['grp_id']));

        $groups = TrackerGroups::model()->findAll();
        $grps = array();
        $grps[0] = 'Main group';
        foreach($groups as $group) {
            $grps[$group->ID] = $group->GROUP_NAME;
        }

        if(!empty($_POST['TrackerGroups'])) {
            $form->attributes = $_POST['TrackerGroups'];
            $form->scenario = 'edit';

            if($form->validate()) {
                $form->save(false);
                $this->redirect(It::baseUrl() . '/admin/groups');
            }
        }

        $this->render('edit', array('form' => $form, 'grps' => $grps));
    }

}