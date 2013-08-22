<?php

class ProjectsController extends Controller {

    public function actionIndex() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        if(It::getState('user_role') == '1')
            $this->redirect(It::baseUrl() . '/admin/projects');

        $prgs = array();

        if(It::getState('user_role') == '3') {
            $details = UserDetails::model()->findByAttributes(array('USER_ID' => It::userId()));
            $prgs = Projects::model()->getDeptTasks($details->DEPT_ID);
        } else {
            $criteria = new CDbCriteria;
            $criteria->condition = 'USER_ID = :id';
            $criteria->params = array(':id' => It::userId());
            $signs = Signs::model()->findAll($criteria);

            if(!empty($signs))
                foreach($signs as $sign) {
                    $prgs[] = Projects::model()->getTask($sign->PRG_ID);
                }
        }

        $this->render('index', array('prgs' => $prgs));
    }

    public function actionMy() {
        if(It::isGuest())
            $this->redirect(It::baseUrl() . '/main/default/login');

        $tasks = Projects::model()->getManagersTask(It::userId());

        $this->render('my', array('tasks' => $tasks));
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
                $cats[$category->ID] = $category->CAT_NAME;
            }
        }

        if(!empty($_POST['Projects'])) {
            $form->attributes = $_POST['Projects'];
            $form->scenario = 'edit';
            if($form->validate()) {
                $form->USER_ID = It::userId();
                $form->save(false);

                $prj = Projects::model()->findByAttributes(array('TITLE' => $_POST['Projects']['TITLE'], 'PRJ_CAT' => $_POST['Projects']['PRJ_CAT'], 'USER_ID' => It::userId()));
                $user = UserDetails::model()->findByAttributes(array('USER_ID' => It::userId()));

                $rules = RelationRules::model()->findByAttributes(array('ROLE_ID' => $user->ROLE_ID, 'CAT_ID' => $_POST['Projects']['PRJ_CAT']));
                $deps = Departments::model()->findAllByAttributes(array('DEPT_GROUP' => $rules->GRP_ID));
                foreach($deps as $dep) {
                    if(!empty($dep->DEF_USER)) {
                        $sign = new Signs;
                        $sign->USER_ID = $dep->DEF_USER;
                        $sign->DEPT_ID = $dep->ID;
                        $sign->PRG_ID = $prj->ID;
                        $sign->FLAG = 0;
                        $sign->save(false);
                    }
                }

                $this->redirect(It::baseUrl() . '/manager/projects/index');
            }
        }

        $this->render('edit', array('form' => $form, 'cats' => $cats));
    }

    public function actionDetails() {
        if(Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->baseUrl . '/main/default/login');

        if(empty($_GET['task_id']))
            $this->redirect(Yii::app()->baseUrl . '/manager/tasks/');

        $tid = intval($_GET['task_id']);

        $task = Projects::model()->getTask($tid);

        $attaches = Attaches::model()->findAllByAttributes(array('ATTACH_TO' => $tid, 'ATTACH_TYPE' => 'project'));

        $sign = Signs::model()->findByAttributes(array('USER_ID' => Yii::app()->user->getId(), 'PRG_ID' => $tid));

        if(!empty($sign))
            $status = $sign->FLAG;
        else {
            $user = UserDetails::model()->findByAttributes(array('USER_ID' => Yii::app()->user->getId()));
            $sign = Signs::model()->findByAttributes(array('DEPT_ID' => $user->DEPT_ID, 'PRG_ID' => $tid));
            $status = $sign->FLAG;
        }

        $dept = 0;

        $boss = 0;



        if(($status == 0) OR ($boss == 1 AND $status == 0))
            $signed = 1;
        else
            $signed = 0;

        $signs_obj = Signs::model()->findAllByAttributes(array('PRG_ID' => $tid));
        $signs = array();
        if(!empty($signs_obj)) {
            foreach($signs_obj as $s_v) {
                $signs[$s_v->DEPT_ID] = $s_v->FLAG;
            }
        }

        //$form = new Comments;


        $this->render('details', array('task' => $task, 'signed' => $signed, 'signs' => $signs, 'dept' => $dept, 'attaches' => $attaches));
    }
}