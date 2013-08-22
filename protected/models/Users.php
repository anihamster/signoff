<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property integer $type
 */
class Users extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
		return 'USERS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('LOGIN, PASSWORD, TYPE', 'required'),
            array('LOGIN', 'unique'),
			array('TYPE', 'numerical', 'integerOnly'=>true),
			array('LOGIN', 'length', 'max'=>30),
			array('PASSWORD', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, LOGIN, PASSWORD, TYPE', 'safe', 'on'=>'search'),
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
			'details' => array(self::HAS_ONE, 'UserDetails', array('USER_ID' => 'ID'), 'alias'=>'d'),
            'roles' => array(self::HAS_ONE, 'Roles', array('ID' => 'ROLE_ID'), 'alias'=>'r'),
			'department'=>array(self::HAS_ONE,'Departments', array('DEPT_ID'=>'ID'),'through'=>'details', 'alias' => 'dp'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'LOGIN' => 'Login',
			'PASSWORD' => 'Password',
			'TYPE' => 'Type',
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
		$criteria->compare('LOGIN',$this->LOGIN,true);
		$criteria->compare('PASSWORD',$this->PASSWORD,true);
		$criteria->compare('TYPE',$this->TYPE);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getAllUsers() {
		$criteria = new CDbCriteria;		
		$criteria->order = '"t"."ID"';
		if(Yii::app()->user->getState('user_role') == '3') {
			$ud = UserDetails::model()->findByAttributes(array('USER_ID' => Yii::app()->user->getId()));
			$result = Users::model()->with(array('details'=>array('scopes'=>array('depart'=>$ud->DEPT_ID))))->findAll($criteria);
		} else {
			$result = Users::model()->with('details')->findAll($criteria);
		}
		
		return $result;
	}
}