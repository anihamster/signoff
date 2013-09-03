<?php

/**
 * This is the model class for table "user_details".
 *
 * The followings are the available columns in table 'user_details':
 * @property integer $ID
 * @property integer $USER_ID
 * @property integer $ROLE_ID
 * @property integer $BRAND
 * @property string $PHONE
 * @property string $EMAIL
 * @property string $NAME
 * @property string $SURNAME
 * @property integer $KEY_USER
 * @property integer $CAN_ADD
 * @property integer $HEAD_USER
 *
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
			array('BRAND, ROLE_ID, PHONE, EMAIL, NAME, SURNAME', 'required'),
			array('USER_ID, BRAND, ROLE_ID, KEY_USER, CAN_ADD, HEAD_USER', 'numerical', 'integerOnly'=>true),
			array('PHONE', 'length', 'max'=>30),
			array('EMAIL, NAME, SURNAME', 'length', 'max'=>255),
			array('EMAIL', 'email'),
			array('PHONE', 'match', 'pattern' => '/^((((\(\d{3}\))|(\d{3}-))\d{3}-\d{4})|(\+?\d{1,3}((-| |\.)(\(\d{1,4}\)(-| |\.|^)?)?\d{1,8}){1,5}))(( )?(x|ext)\d{1,5}){0,1}$/', 'message' => 'Incorrect phone format'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, USER_ID, ROLE_ID, BRAND, PHONE, EMAIL, NAME, SURNAME, KEY_USER, CAN_ADD, HEAD_USER', 'safe', 'on'=>'search'),
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
			'brand' => array(self::HAS_ONE, 'Brands', array('ID' => 'BRAND'), 'alias'=>'b'),
            'role' => array(self::HAS_ONE, 'Roles', array('ID' => 'ROLE_ID'), 'alias'=>'r'),
		);
	}
	
	public function branded($dept) {
		$this->getDbCriteria()->mergeWith(array('condition'=>'BRAND=:dept', 'params'=>array(':dept'=>$dept),));
	
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
			'BRAND' => 'Brand',
            'ROLE_ID' => 'Role',
			'PHONE' => 'Phone',
			'EMAIL' => 'Email',
			'NAME' => 'Name',
			'SURNAME' => 'Surname',
            'KEY_USER' => 'Key user',
            'CAN_ADD' => 'TKAM Functions',
            'HEAD_USER' => 'Users management functions',
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
		$criteria->compare('BRAND',$this->BRAND);
        $criteria->compare('ROLE_ID',$this->ROLE_ID);
		$criteria->compare('PHONE',$this->PHONE,true);
		$criteria->compare('EMAIL',$this->EMAIL,true);
		$criteria->compare('NAME',$this->NAME,true);
		$criteria->compare('SURNAME',$this->SURNAME,true);
        $criteria->compare('KEY_USER',$this->KEY_USER);
        $criteria->compare('CAN_ADD',$this->CAN_ADD);
        $criteria->compare('HEAD_USER',$this->HEAD_USER);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}