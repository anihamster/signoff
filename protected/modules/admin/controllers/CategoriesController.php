<?php

class CategoriesController extends Controller {

    public function actionIndex() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(!(It::getState('user_role') == '1'))
            throw new CDbExeption('You have not access to this function');

        $cats = Categories::model()->findAll();

        $this->render('index', array('cats' => $cats));
    }

    public function actionEdit() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(!(It::getState('user_role') == '1'))
            throw new CDbExeption('You have not access to this function');

        $form = new Categories;
        $cats = array();
        $cats[0] = 'Main category';
        $categories = Categories::model()->getCategories();
        $cats = array_merge($cats, $categories);

        if(!empty($_POST['Categories'])) {
            $form->attributes = $_POST['Categories'];
            $form->scenario = 'edit';

            if($form->validate()) {
                $form->save(false);
                $this->redirect(It::baseUrl() . '/admin/categories/index');
            }
        }

        $this->render('edit', array('form' => $form, 'cats' => $cats));
    }
}