<?php

/**
 * This is the model class for table "user_details".
 *
 * The followings are the available columns in table 'user_details':
 * @property integer $id
 * @property integer $user_id
 * @property integer $dept_id
 * @property string $phone
 * @property string $email
 * @property string $name
 * @property string $surname
 */
class UserDetails extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserDetails the static model class
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
		return 'USER_DETAILS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('DEPT_ID, ROLE_ID, PHONE, EMAIL, NAME, SURNAME', 'required'),
			array('USER_ID, DEPT_ID, ROLE_ID', 'numerical', 'integerOnly'=>true),
			array('PHONE', 'length', 'max'=>30),
			array('EMAIL, NAME, SURNAME', 'length', 'max'=>255),
			array('EMAIL', 'email'),
			array('PHONE', 'match', 'pattern' => '/^((((\(\d{3}\))|(\d{3}-))\d{3}-\d{4})|(\+?\d{1,3}((-| |\.)(\(\d{1,4}\)(-| |\.|^)?)?\d{1,8}){1,5}))(( )?(x|ext)\d{1,5}){0,1}$/', 'message' => 'Incorrect phone format'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, USER_ID, ROLE_ID, DEPT_ID, PHONE, EMAIL, NAME, SURNAME', 'safe', 'on'=>'search'),
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
			'department' => array(self::HAS_ONE, 'Departments', array('DEPT_ID' => 'ID'), 'alias'=>'d'),
		);
	}
	
	public function depart($dept) {
		$this->getDbCriteria()->mergeWith(array('condition'=>'DEPT_ID=:dept', 'params'=>array(':dept'=>$dept),));
	
		return $this;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'USER_ID' => ' User ID',
			'DEPT_ID' => 'Dept',
            'ROLE_ID' => 'Role',
			'PHONE' => 'Phone',
			'EMAIL' => 'Email',
			'NAME' => 'Name',
			'SURNAME' => 'Surname',
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
		$criteria->compare('USER_ID',$this->USER_ID);
		$criteria->compare('DEPT_ID',$this->DEPT_ID);
        $criteria->compare('ROLE_ID',$this->ROLE_ID);
		$criteria->compare('PHONE',$this->PHONE,true);
		$criteria->compare('EMAIL',$this->EMAIL,true);
		$criteria->compare('NAME',$this->NAME,true);
		$criteria->compare('SURNAME',$this->SURNAME,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}