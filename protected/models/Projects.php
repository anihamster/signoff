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
			array('PRJ_CAT, PRJ_STATUS', 'numerical', 'integerOnly'=>true),
			array('TITLE', 'length', 'max'=>1020),
			array('DESCRIPTION', 'length', 'max'=>4000),
			array('CREATED_AT, UPDATED_AT', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, TITLE, DESCRIPTION, PRJ_CAT, PRJ_STATUS, CREATED_AT, UPDATED_AT', 'safe', 'on'=>'search'),
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
        $criteria->order = 't.id';

        $tasks = Projects::model()->with('details')->findAll($criteria);

        $result = array();

        foreach($tasks as $task) {
            $result[$task->id]['id'] = $task->ID;
            $result[$task->id]['title'] = $task->TITLE;
            $result[$task->id]['description'] = $task->DESCRIPTION;
            $result[$task->id]['created'] = $task->CREATED_AT;
            $result[$task->id]['updated'] = $task->UPDATED_AT;
            $result[$task->id]['status'] = $task->PRJ_STATUS;
            if(!empty($task['details'])) {
                $result[$task->id]['name'] = $task['details']->NAME;
                $result[$task->id]['surname'] = $task['details']->SURNAME;
                $result[$task->id]['email'] = $task['details']->EMAIL;
                $result[$task->id]['phone'] = $task['details']->PHONE;
            } else {
                $result[$task->id]['name'] = '';
                $result[$task->id]['surname'] = '';
                $result[$task->id]['email'] = '';
                $result[$task->id]['phone'] = '';
            }
        }

        return $result;
    }

    public function getTask($id) {
        $task = Projects::model()->with('details')->findByPk($id);


        if(!empty($task)) {
            $result = array();
            $result['ID'] = $task->ID;
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
        }

        return $result;
    }

	public function getDeptTasks($dept_id) {
		$criteria = new CDbCriteria;
		$criteria->condition = 'PRJ_STATUS <> 3';
		$criteria->order = 't.id';
		$tasks = Projects::model()->with('details')->findAll($criteria);
		
		$result = array();
		
		if(!empty($tasks)) {
			foreach($tasks as $task) {
				$cs = Signs::model()->findAllByAttrubytes(array('DEPT_ID' => $dept_id));

$assigned = explode(',', $task->assigned_to);
				if(in_array($dept_id, $assigned)) {
					$result[$task->id]['id'] = $task->id;
					$result[$task->id]['title'] = $task->title;
					$result[$task->id]['description'] = $task->description;
					$result[$task->id]['created'] = $task->created;
					$result[$task->id]['updated'] = $task->updated;
					$result[$task->id]['status'] = $task->status;
					if(!empty($task['details'])) {
						$result[$task->id]['name'] = $task['details']->name;
						$result[$task->id]['surname'] = $task['details']->surname;
						$result[$task->id]['email'] = $task['details']->email;
						$result[$task->id]['phone'] = $task['details']->phone;
					} else {
						$result[$task->id]['name'] = '';
						$result[$task->id]['surname'] = '';
						$result[$task->id]['email'] = '';
						$result[$task->id]['phone'] = '';
					}
					if(!empty($task->assigned_to)) {
						$deps = array();
						$depts = array();
						$deps = explode(',', $task->assigned_to);
						foreach($deps as $d_v) {
							$tmp = Departments::model()->findByPk($d_v);
							$depts[$tmp->id] = $tmp->name;
						}
						$result[$task->id]['assigned_to'] = $depts;
					} else {
						$result[$task->id]['assigned_to'] = '';
					}
				}
			}
		}
		
		return $result;
	}
}