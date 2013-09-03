<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property integer $ID
 * @property integer $PRJ_ID
 * @property integer $USER_ID
 * @property integer $COMMENT_TYPE
 * @property string $COMMENT_TEXT
 * @property string $CREATED
 * @property string $UPDATED
 */
class Comments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comments the static model class
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
		return 'COMMENTS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('COMMENT_TEXT', 'required'),
			array('PRJ_ID, USER_ID', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, PRJ_ID, USER_ID, COMMENT_TYPE, COMMENT_TEXT, CREATED, UPDATED', 'safe', 'on'=>'search'),
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
			'PRJ_ID' => 'Task',
			'USER_ID' => 'User',
			'COMMENT_TYPE' => 'Comment type',
			'COMMENT_TEXT' => 'Comment',
			'CREATED_AT' => 'Created',
			'UPDATED_AT' => 'Updated',
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
		$criteria->compare('PRJ_ID',$this->PRJ_Id);
		$criteria->compare('USER_ID',$this->USER_ID);
        $criteria->compare('COMMENT_TYPE',$this->COMMENT_TYPE,true);
		$criteria->compare('COMMENT_TEXT',$this->COMMENT_TEXT,true);
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
}