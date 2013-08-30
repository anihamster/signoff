<?php
/**
 * Created by JetBrains PhpStorm.
 * User: SoulTaker
 * Date: 28.08.13
 * Time: 10:39
 * To change this template use File | Settings | File Templates.
 */

class RelationsController extends Controller {

    public function actionGetCatProp() {
        if(!It::isAjaxRequest())
            $this->redirect(It::baseUrl());

        $result=array();

        if(empty($_GET['cat_id'])) {
            $result['status'] = 'failed';
            $result['message'] = 'Empty category identifier';
            $result['response'] = '';
        } else {
            $cid = intval($_GET['cat_id']);
            $cat = Categories::model()->findByPk($cid);
            if(empty($cat)) {
                $result['status'] = 'failed';
                $result['message'] = 'Wrong category identifier';
                $result['response'] = '';
            } else {
                $cat_prop = array();
                $cat_prop['id'] = $cat->ID;
                $cat_prop['name'] = $cat->CAT_NAME;
                $cat_prop['spec'] = $cat->BRAND_SPEC;

                $result['status'] = 'ok';
                $result['message'] = 'Category read successfully';
                $result['response'] = $cat_prop;
            }
        }
        print json_encode($result);
    }

    public function actionGetTypicalRoles() {
        if(!It::isAjaxRequest())
            $this->redirect(It::baseUrl());

        $result=array();

        $roles = Roles::model()->findAllByAttributes(array('SPEC' => '1', 'TECH' => '0'));
        if(empty($roles)) {
            $result['status'] = 'failed';
            $result['message'] = 'There is no roles in base';
            $result['response'] = '';
        } else {
            $rls = array();

            foreach($roles as $role) {
                $rls[$role->ID]['id'] = $role->ID;
                $rls[$role->ID]['name'] = $role->ROLE_NAME;
            }

            $result['status'] = 'ok';
            $result['message'] = 'Roles read successfully';
            $result['response'] = $rls;
        }
        print json_encode($result);
    }

    public function actionGetEnv() {
        if(!It::isAjaxRequest())
            $this->redirect(It::baseUrl());

        $result=array();

        $env = array();
        $env['deps'] = array();
        $env['brands'] = array();

        $deps = Roles::model()->findAllByAttributes(array('SPEC' => '0', 'TECH' => '0'));
        $brands = Brands::model()->findAll();

        if(empty($brands) && empty($deps)) {
            $result['status'] = 'failed';
            $result['message'] = 'There is no departments of brands in base';
            $result['response'] = '';
        } else {
            if(!empty($deps)) {
                foreach($deps as $dept) {
                    $env['deps'][$dept->ID]['id'] = $dept->ID;
                    $env['deps'][$dept->ID]['name'] = $dept->ROLE_NAME;
                }
            }

            if(!empty($brands)) {
                foreach($brands as $brand) {
                    $env['brands'][$brand->ID]['id'] = $brand->ID;
                    $env['brands'][$brand->ID]['name'] = $brand->BRAND_NAME;
                }
            }

            $result['status'] = 'ok';
            $result['message'] = 'Environment read successfully';
            $result['response'] = $env;
        }

        print json_encode($result);
    }

    public function actionSaveGeneralRelations() {
        if(!It::isAjaxRequest())
            $this->redirect(It::baseUrl());

        if(!empty($_REQUEST['rel']) && !empty($_REQUEST['name']) && !empty($_REQUEST['cat'])) {
            $group = new RelGroups;
            $group->GROUP_NAME = $_REQUEST['name'];
            $group->GROUP_PARENT = 0;
            $group->save(false);

            $grp = RelGroups::model()->findByAttributes(array('GROUP_NAME' => $_REQUEST['name']));

            foreach ($_REQUEST['general'] as $key => $val) {
                if($val['state'] == 1) {
                    $rel = new RelationRules;
                    $rel->CAT_ID = $_REQUEST['cat'];
                    $rel->ROLE_ID = $val['id'];
                    $rel->GRP_ID = $grp->ID;
                    $rel->BRAND_ID = 0;
                    $rel->save(false);
                }
            }

            foreach ($_REQUEST['rel'] as $key => $val) {
                if($val['state'] == 1) {
                    $rel = new RelationRules;
                    $rel->CAT_ID = $_REQUEST['cat'];
                    $rel->ROLE_ID = $val['id'];
                    $rel->GRP_ID = $grp->ID;
                    $rel->BRAND_ID = 0;
                    $rel->save(false);
                }
            }



        } else {
            if(empty($_REQUEST['rel'])) {

            }
            if(empty($_REQUEST['name'])) {

            }
        }
    }

    public function actionSaveNonGeneralRelations() {
        if(!It::isAjaxRequest())
            $this->redirect(It::baseUrl());

        if(!empty($_REQUEST['general']) && !empty($_REQUEST['brands']) && !empty($_REQUEST['name']) && !empty($_REQUEST['cat'])) {
            $group = new RelGroups;
            $group->GROUP_NAME = $_REQUEST['name'];
            $group->GROUP_PARENT = 0;
            $group->save(false);

            $grp = RelGroups::model()->findByAttributes(array('GROUP_NAME' => $_REQUEST['name']));

            foreach ($_REQUEST['general'] as $key => $val) {
                if($val['state'] == 1) {
                    $rel = new RelationRules;
                    $rel->CAT_ID = $_REQUEST['cat'];
                    $rel->ROLE_ID = $val['id'];
                    $rel->GRP_ID = $grp->ID;
                    $rel->BRAND_ID = 0;
                    $rel->save(false);
                }
            }

            foreach($_REQUEST['brands'] as $key => $val) {
                foreach($val['selection'] as $key2 => $val2) {
                    if($val2['state'] == 1) {
                        $rel = new RelationRules;
                        $rel->CAT_ID = $_REQUEST['cat'];
                        $rel->ROLE_ID = $val2['id'];
                        $rel->GRP_ID = $grp->ID;
                        $rel->BRAND_ID = $val['brand'];
                        $rel->save(false);
                    }
                }
            }

        } else {
            if(empty($_REQUEST['rel'])) {

            }
            if(empty($_REQUEST['name'])) {

            }
        }

        print_r($_REQUEST);
    }

}