<?php

/**
 * This is the model class for table "tasks".
 *
 * The followings are the available columns in table 'tasks':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $assigned_to
 * @property integer $status
 * @property integer $user_id
 * @property string $created
 * @property string $updated
 */
class Tasks extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Tasks the static model class
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
		return 'tasks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, description, assigned_to', 'required'),
			array('status, user_id', 'numerical', 'integerOnly'=>true),
			array('title, assigned_to', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, assigned_to, status, user_id, created, updated', 'safe', 'on'=>'search'),
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
			'details' => array(self::HAS_ONE, 'UserDetails', array('user_id' => 'user_id'), 'alias'=>'d'),		
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'description' => 'Description',
			'assigned_to' => 'Assigned To',
			'status' => 'Status',
			'user_id' => 'User',
			'created' => 'Created',
			'updated' => 'Updated',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('assigned_to',$this->assigned_to,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave()
	{
		if ($this->isNewRecord) {
			$this->created = date('Y-m-d G:i:s');
			$this->updated = date('Y-m-d G:i:s');
		}
		$this->updated = date('Y-m-d G:i:s');
	
		return true;
	}
	
	public function getAllTasks() {
		$criteria = new CDbCriteria;
		$criteria->order = 't.id';
		
		$tasks = Tasks::model()->with('details')->findAll($criteria);
		
		$result = array();
		
		foreach($tasks as $task) {
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
		
		return $result;
	}
	
	public function getTask($id) {
		$task = Tasks::model()->with('details')->findByPk($id);
		
		$result = array(); 
		
		if(!empty($task)) {
			$result = array();
			$result['id'] = $task->id;
			$result['title'] = $task->title;
			$result['description'] = $task->description;
			$result['created'] = $task->created;
			$result['updated'] = $task->updated;
			$result['status'] = $task->status;
			if(!empty($task['details'])) {
				$result['name'] = $task['details']->name;
				$result['surname'] = $task['details']->surname;
				$result['email'] = $task['details']->email;
				$result['phone'] = $task['details']->phone;
			} else {
				$result['name'] = '';
				$result['surname'] = '';
				$result['email'] = '';
				$result['phone'] = '';
			}
			if(!empty($task->assigned_to)) {
				$deps = array();
				$depts = array();
				$deps = explode(',', $task->assigned_to);
				foreach($deps as $d_v) {					
					$tmp = Departments::model()->findByPk($d_v);
					$depts[$tmp->id] = $tmp->name;
				}
				$result['assigned_to'] = $depts;
			} else {
				$result['assigned_to'] = '';
			}
		}
		
		return $result;
	}
	
	public function getManagersTask($id) {
		$criteria = new CDbCriteria;
		$criteria->condition = 't.user_id = :id';
		$criteria->params = array(':id' => $id);
		$criteria->order = 't.id';
		
		$tasks = Tasks::model()->with('details')->findAll($criteria);
		
		$result = array();
		
		foreach($tasks as $task) {
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
		
		return $result;
	}
	
	public function getDeptTasks($dept_id) {
		$criteria = new CDbCriteria;
		$criteria->condition = 'status <> 3';
		$criteria->order = 't.id';
		$tasks = Tasks::model()->with('details')->findAll($criteria);
		
		$result = array();
		
		if(!empty($tasks)) {
			foreach($tasks as $task) {
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