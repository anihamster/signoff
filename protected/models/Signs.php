<?php

/**
 * This is the model class for table "SIGNS".
 *
 * The followings are the available columns in table 'SIGNS':
 * @property integer $ID
 * @property integer $USER_ID
 * @property integer $PRG_ID
 * @property integer $FLAG
 * @property integer $BRAND_ID
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 */
class Signs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Signs the static model class
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
		return 'SIGNS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('USER_ID, PRG_ID, FLAG, BRAND_ID', 'numerical', 'integerOnly'=>true),
			array('CREATED_AT, UPDATED_AT', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, USER_ID, DEPT_ID, PRG_ID, FLAG, CREATED_AT, UPDATED_AT, BRAND_ID', 'safe', 'on'=>'search'),
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
            'brand' => array(self::HAS_ONE, 'Brands', array('ID' => 'BRAND_ID'), 'alias'=>'b'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'USER_ID' => 'User',
			'PRG_ID' => 'Prg',
			'FLAG' => 'Flag',
            'BRAND_ID' => 'Users brand',
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
		$criteria->compare('USER_ID',$this->USER_ID);
		$criteria->compare('PRG_ID',$this->PRG_ID);
		$criteria->compare('FLAG',$this->FLAG);
        $criteria->compare('BRAND_ID',$this->BRAND_ID);
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

    public function afterSave()
    {
        if ($this->isNewRecord) {
            $users = UserDetails::model()->findAllByAttributes(array('USER_ID' => $this->USER_ID));
            foreach($users as $user) {
                $data = array(
                    'email' => $user->EMAIL,
                    'task'  => $this->PRG_ID,
                );
                Signs::sendNotifocationEmail($data);
            }
        }
        return parent::afterSave();
    }


    public function sendNotifocationEmail($data)
    {
        Yii::app()->setLanguage('en');
        $email = Yii::app()->email;
        $email->from = Yii::app()->params['mailFrom'];
        $email->to = $data['email'];

        $email->subject = Yii::t('project', 'notification_mail_subject');
        $email->message = Yii::t('project', 'notification_mail_body', array(
                '{project_link}' => It::baseUrl().'/manager/projects/details/?task_id='.$data['task'],
            ));

        $email->send();
    }
}