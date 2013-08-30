<?php

class RelationsController extends Controller {

    public function actionIndex() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(It::getState('user_role') !== '1')
            throw new CDbExeption('You have not access to this page');

        $rels = RelationRules::model()->with('cat', 'rls', 'grp', 'brnd')->findAll();

        $this->render('index', array('rels' => $rels));
    }

    public function actionBuild() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(It::getState('user_role') !== '1')
            throw new CDbExeption('You have not access to this page');

        $cats = Categories::model()->getCategories();
        $roles = Roles::model()->getRoles();
        $deps = Departments::model()->getDeps();

        $this->render('build', array('cats' => $cats, 'roles' => $roles, 'deps' => $deps));
    }

}