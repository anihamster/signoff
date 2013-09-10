<?php

/**
 * This is the model class for table "ATTACHES".
 *
 * The followings are the available columns in table 'ATTACHES':
 * @property integer $ID
 * @property string $ATTACH_TYPE
 * @property integer $ATTACH_TO
 * @property integer $ATTACH_FILE
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 */
class Attaches extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Attaches the static model class
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
		return 'ATTACHES';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ATTACH_TO', 'numerical', 'integerOnly'=>true),
			array('ATTACH_TYPE', 'length', 'max'=>1020),
			array('CREATED_AT, UPDATED_AT', 'safe'),
            array('ATTACH_TYPE', 'file', 'allowEmpty' => true, 'types' => 'doc,pdf,ppt,txt,jpg,gif,png', 'on' => 'add'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, ATTACH_TYPE, ATTACH_TO, ATTACH_FILE, CREATED_AT, UPDATED_AT', 'safe', 'on'=>'search'),
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
			'ATTACH_TYPE' => 'Attach Type',
			'ATTACH_TO' => 'Attach To',
			'ATTACH_FILE' => 'Attach File',
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
		$criteria->compare('ATTACH_TYPE',$this->ATTACH_TYPE,true);
		$criteria->compare('ATTACH_TO',$this->ATTACH_TO);
		$criteria->compare('ATTACH_FILE',$this->ATTACH_FILEAG);
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