<?php

class ProjectsController extends Controller {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionEdit() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(!empty($_GET['pid'])) {
            $pid = intval($_GET['pid']);
            $form = Projects::model()->findByPk($pid);
            if(empty($form))
                $this->redirect(It::baseUrl() . '/manager/project/index');
        } else {
            $form = new Projects;
        }

        $categories = Categories::model()->findAll();

        $cats = array();
        $cats[0] = 'Select category of the project';

        if(!empty($categories)) {
            foreach($categories as $category) {
                $cats[$category->ID] = $category->NAME;
            }
        }

        if(!empty($_POST['Projects'])) {
            $form->attributes = $_POST['Projects'];
            $form->scenario = 'edit';
            if($form->validate()) {
                $form->save(false);
                $this->redirect(It::baseUrl() . '/manager/project/index');
            }
        }

        $this->render('edit', array('form' => $form, 'cats' => $cats));
    }
}