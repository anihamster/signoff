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
class Login extends CActiveRecord
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
            array('LOGIN,PASSWORD', 'required'),
            array('PASSWORD', 'authenticate'),				
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

		$criteria->compare('ID',$this->id);
		$criteria->compare('LOGIN',$this->login,true);
		$criteria->compare('PASSWORD',$this->password,true);
		$criteria->compare('TYPE',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors()) {
			$login = $this->LOGIN;
			$pass = sha1(md5($this->PASSWORD));
			$identity = new UserIdentity($login, $pass);
			$identity->authenticate();
	
			switch($identity->errorCode) {
				case UserIdentity::ERROR_NONE: {
					Yii::app()->user->login($identity, 0);
					break;
				}
				case UserIdentity::ERROR_USERNAME_INVALID: {
					$this->addError('LOGIN','Incorrect username!');
					break;
				}
				case UserIdentity::ERROR_PASSWORD_INVALID: {
					$this->addError('PASSWORD','Incorrect password!');
					break;
				}
			}
		}
	}
}