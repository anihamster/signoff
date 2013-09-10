<?php

/**
 * This is the model class for table "PROJECTS".
 *
 * The followings are the available columns in table 'PROJECTS':
 * @property integer $ID
 * @property string $TITLE
 * @property string $DESCRIPTION
 * @property integer $PRJ_CAT
 * @property integer $PRJ_STATUS
 * @property integer $BRAND_ID
 * @property integer $USER_ID
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 */
class Projects extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Projects the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'PROJECTS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('PRJ_CAT, PRJ_STATUS, BRAND_ID, USER_ID', 'numerical', 'integerOnly'=>true),
			array('TITLE', 'length', 'max'=>1020),
			array('DESCRIPTION', 'length', 'max'=>4000),
			array('CREATED_AT, UPDATED_AT', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, TITLE, DESCRIPTION, PRJ_CAT, PRJ_STATUS, CREATED_AT, UPDATED_AT, BRAND_ID, USER_ID', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'details' => array(self::HAS_ONE, 'UserDetails', array('USER_ID' => 'USER_ID'), 'alias'=>'d'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'TITLE' => 'Title',
			'DESCRIPTION' => 'Description',
			'PRJ_CAT' => 'Prj Cat',
			'PRJ_STATUS' => 'Prj Status',
			'CREATED_AT' => 'Created At',
			'UPDATED_AT' => 'Updated At',
            'BRAND_ID' => 'Users Brand',
            'USER_ID' => 'User ID',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ID',$this->ID);
		$criteria->compare('TITLE',$this->TITLE,true);
		$criteria->compare('DESCRIPTION',$this->DESCRIPTION,true);
		$criteria->compare('PRJ_CAT',$this->PRJ_CAT);
		$criteria->compare('PRJ_STATUS',$this->PRJ_STATUS);
		$criteria->compare('CREATED_AT',$this->CREATED_AT,true);
		$criteria->compare('UPDATED_AT',$this->UPDATED_AT,true);
        $criteria->compare('BRAND_ID',$this->BRAND_ID);
        $criteria->compare('USER_ID',$this->USER_ID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->CREATED_AT = new CDbExpression("TO_DATE('" . date('d/m/y') . "', 'DD/MM/YYYY')");
        }
        $this->UPDATED_AT = new CDbExpression("TO_DATE('" . date('d/m/y') . "', 'DD/MM/YYYY')");

        return true;
    }

    public function getAllTasks() {
        $criteria = new CDbCriteria;
        $criteria->order = '"t"."ID"';

        $tasks = Projects::model()->with('details')->findAll($criteria);

        $result = array();

        foreach($tasks as $task) {
            $result[$task->ID]['ID'] = $task->ID;
            $result[$task->ID]['USER_ID'] = $task->USER_ID;
            $result[$task->ID]['TITLE'] = $task->TITLE;
            $result[$task->ID]['DESCRIPTION'] = $task->DESCRIPTION;
            $result[$task->ID]['CREATED'] = $task->CREATED_AT;
            $result[$task->ID]['UPDATED'] = $task->UPDATED_AT;
            $result[$task->ID]['STATUS'] = $task->PRJ_STATUS;
            if(!empty($task['details'])) {
                $result[$task->ID]['NAME'] = $task['details']->NAME;
                $result[$task->ID]['SURNAME'] = $task['details']->SURNAME;
                $result[$task->ID]['EMAIL'] = $task['details']->EMAIL;
                $result[$task->ID]['PHONE'] = $task['details']->PHONE;
            } else {
                $result[$task->ID]['NAME'] = '';
                $result[$task->ID]['SURNAME'] = '';
                $result[$task->ID]['EMAIL'] = '';
                $result[$task->ID]['PHONE'] = '';
            }
            if(!empty($task['attaches'])) {
                $result[$task->ID]['ATTACHES'] = array();
                foreach($task['attaches'] as $attach) {
                    $result[$task->ID]['ATTACHES'][$attach->ID]['FILENAME'] = $attach->ATTACH_FILE;
                }
            }
        }

        return $result;
    }

    public function getTask($id) {
        $task = Projects::model()->with('details')->findByPk($id);


        if(!empty($task)) {
            $result = array();
            $result['ID'] = $task->ID;
            $result['USER_ID'] = $task->USER_ID;
            $result['TITLE'] = $task->TITLE;
            $result['DESCRIPTION'] = $task->DESCRIPTION;
            $result['CREATED'] = $task->CREATED_AT;
            $result['UPDATED'] = $task->UPDATED_AT;
            $result['STATUS'] = $task->PRJ_STATUS;
            if(!empty($task['details'])) {
                $result['NAME'] = $task['details']->NAME;
                $result['SURNAME'] = $task['details']->SURNAME;
                $result['EMAIL'] = $task['details']->EMAIL;
                $result['PHONE'] = $task['details']->PHONE;
            } else {
                $result['NAME'] = '';
                $result['SURNAME'] = '';
                $result['EMAIL'] = '';
                $result['PHONE'] = '';
            }
            if(!empty($task['attaches'])) {
                $result[$task->ID]['ATTACHES'] = array();
                foreach($task['attaches'] as $attach) {
                    $result[$task->ID]['ATTACHES'][$attach->ID]['FILENAME'] = $attach->ATTACH_FILE;
                }
            }
        }

        return $result;
    }

    public function getManagersTask($id) {
        $criteria = new CDbCriteria;
        $criteria->condition = '"t"."USER_ID" = :id';
        $criteria->params = array(':id' => $id);
        $criteria->order = '"t"."ID"';

        $tasks = Projects::model()->with('details')->findAll($criteria);

        $result = array();

        foreach($tasks as $task) {
            $result[$task->ID]['ID'] = $task->ID;
            $result[$task->ID]['USER_ID'] = $task->USER_ID;
            $result[$task->ID]['TITLE'] = $task->TITLE;
            $result[$task->ID]['DESCRIPTION'] = $task->DESCRIPTION;
            $result[$task->ID]['CREATED'] = $task->CREATED_AT;
            $result[$task->ID]['UPDATED'] = $task->UPDATED_AT;
            $result[$task->ID]['STATUS'] = $task->PRJ_STATUS;
            if(!empty($task['details'])) {
                $result[$task->ID]['NAME'] = $task['details']->NAME;
                $result[$task->ID]['SURNAME'] = $task['details']->SURNAME;
                $result[$task->ID]['EMAIL'] = $task['details']->EMAIL;
                $result[$task->ID]['PHONE'] = $task['details']->PHONE;
            } else {
                $result[$task->ID]['NAME'] = '';
                $result[$task->ID]['SURNAME'] = '';
                $result[$task->ID]['EMAIL'] = '';
                $result[$task->ID]['PHONE'] = '';
            }
            if(!empty($task['attaches'])) {
                $result[$task->ID]['ATTACHES'] = array();
                foreach($task['attaches'] as $attach) {
                    $result[$task->ID]['ATTACHES'][$attach->ID]['FILENAME'] = $attach->ATTACH_FILE;
                }
            }
        }

        return $result;
    }

	public function getBrandTasks($brand_id) {
        $criteria = new CDbCriteria;
        $criteria->select = '"t".PRG_ID, "t".BRAND_ID';
        $criteria->condition = 'BRAND_ID = :brand';
        $criteria->params = array(':brand' => $brand_id);
        $criteria->group = '"t".PRG_ID, "t".BRAND_ID';

        $cs = Signs::model()->findAll($criteria);

        $result = array();

        if(!empty($cs)) {
            foreach($cs as $sign) {
                $task = Projects::model()->getTask($sign->PRG_ID);

                if(!empty($task)) {
                    $result[$task['ID']]['ID'] = $task['ID'];
                    $result[$task['ID']]['USER_ID'] = $task['USER_ID'];
                    $result[$task['ID']]['TITLE'] = $task['TITLE'];
                    $result[$task['ID']]['DESCRIPTION'] = $task['DESCRIPTION'];
                    $result[$task['ID']]['CREATED'] = $task['CREATED'];
                    $result[$task['ID']]['UPDATED'] = $task['UPDATED'];
                    $result[$task['ID']]['STATUS'] = $task['STATUS'];
                    $result[$task['ID']]['NAME'] = $task['NAME'];
                    $result[$task['ID']]['SURNAME'] = $task['SURNAME'];
                    $result[$task['ID']]['EMAIL'] = $task['EMAIL'];
                    $result[$task['ID']]['PHONE'] = $task['PHONE'];
                }
            }
        }
		
		return $result;
	}
}