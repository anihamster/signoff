<?php
/**
 * Created by JetBrains PhpStorm.
 * User: SoulTaker
 * Date: 28.08.13
 * Time: 9:54
 * To change this template use File | Settings | File Templates.
 */

class BrandsController extends Controller {

    public function actionIndex() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(!(It::getState('user_role') == '1'))
            throw new CDbExeption('You have not access to this function');

        $brands = Brands::model()->findAll();

        $this->render('index', array('brands' => $brands));
    }

    public function actionEdit() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(!(It::getState('user_role') == '1'))
            throw new CDbExeption('You have not access to this function');

        if(empty($_GET['brand_id']))
            $form = new Brands;
        else
            $form = Brands::model()->findByPk(intval($_GET['brand_id']));;

        $brands = array();
        $brands[0] = 'Select brand';
        $brnds = Brands::model()->getBrands();
        $brands = array_merge($brands, $brnds);

        if(!empty($_POST['Brands'])) {
            $form->attributes = $_POST['Brands'];
            $form->scenario = 'edit';

            if($form->validate()) {
                $form->save(false);
                $this->redirect(It::baseUrl() . '/admin/brands/index');
            }
        }

        $this->render('edit', array('form' => $form, 'brands' => $brands));
    }
}