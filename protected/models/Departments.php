<?php

/**
 * This is the model class for table "DEPARTMENTS".
 *
 * The followings are the available columns in table 'DEPARTMENTS':
 * @property integer $ID
 * @property integer $DEPT_PARENT
 * @property integer $DEPT_GROUP
 * @property integer $DEF_USER
 * @property string $DEPT_NAME
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 */
class Departments extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Departments the static model class
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
		return 'DEPARTMENTS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('DEPT_PARENT, DEPT_GROUP, DEF_USER', 'numerical', 'integerOnly'=>true),
			array('DEPT_NAME', 'length', 'max'=>1020),
			array('CREATED_AT, UPDATED_AT', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, DEPT_PARENT, DEPT_GROUP, DEPT_NAME, DEF_USER, CREATED_AT, UPDATED_AT', 'safe', 'on'=>'search'),
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
			'DEPT_PARENT' => 'Dept Parent',
			'DEPT_GROUP' => 'Dept Group',
			'DEPT_NAME' => 'Dept Name',
            'DEF_USER' => 'Default user',
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
		$criteria->compare('DEPT_PARENT',$this->DEPT_PARENT);
		$criteria->compare('DEPT_GROUP',$this->DEPT_GROUP);
		$criteria->compare('DEPT_NAME',$this->DEPT_NAME,true);
        $criteria->compare('DEF_USER',$this->DEF_USER);
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

    public function getAllDeps() {
        $criteria = new CDbCriteria;
        $criteria->order = 'ID ASC';
        $result = Departments::model()->findAll($criteria);

        return $result;
    }

    public function getDeps() {
        $deps = Departments::model()->findAll();

        $result = array();
        foreach($deps as $dept) {
            $result[$dept->ID] = $dept->DEPT_NAME;
        }

        return $result;
    }

}