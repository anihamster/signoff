<?php

/**
 * This is the model class for table "attach".
 *
 * The followings are the available columns in table 'attach':
 * @property integer $attach_id
 * @property string $attach_type
 * @property integer $attached_to
 * @property string $attach_file
 * @property string $created
 */
class Attach extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Attach the static model class
	 */
	var $attach_rule;
	
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
			array('attach_type, attached_to, attach_file', 'required'),
			array('attached_to', 'numerical', 'integerOnly'=>true),
			array('attach_type, attach_file', 'length', 'max'=>255),
			array('attach_type', 'file', 'allowEmpty' => true, 'types' => 'doc,pdf,ppt,txt,jpg,gif,png', 'on' => 'add'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('attach_id, attach_type, attached_to, attach_file, created', 'safe', 'on'=>'search'),
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
			'attach_id' => 'Attach',
			'attach_type' => 'Attach Type',
			'attached_to' => 'Attached To',
			'attach_file' => 'Attach File',
			'created' => 'Created',
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

		$criteria->compare('attach_id',$this->attach_id);
		$criteria->compare('attach_type',$this->attach_type,true);
		$criteria->compare('attached_to',$this->attached_to);
		$criteria->compare('attach_file',$this->attach_file,true);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave()
	{
		if ($this->isNewRecord)
			$this->created = date('Y-m-d G:i:s');
	
		return true;
	}
}