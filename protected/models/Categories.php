<?php

/**
 * This is the model class for table "CATEGORIES".
 *
 * The followings are the available columns in table 'CATEGORIES':
 * @property integer $ID
 * @property integer $CAT_PARENT
 * @property string $CAT_NAME
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 */
class Categories extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CATEGORIES the static model class
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
		return 'CATEGORIES';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CAT_PARENT', 'numerical', 'integerOnly'=>true),
			array('CAT_NAME', 'length', 'max'=>1020),
			array('CREATED_AT, UPDATED_AT', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, CAT_PARENT, CAT_NAME, CREATED_AT, UPDATED_AT', 'safe', 'on'=>'search'),
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
			'CAT_PARENT' => 'Category Parent',
			'CAT_NAME' => 'Category Name',
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
		$criteria->compare('CAT_PARENT',$this->CAT_PARENT);
		$criteria->compare('CAT_NAME',$this->CAT_NAME,true);
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

    public function getCategories() {
        $criteria = new CDbCriteria;
        $criteria->order = 'ID ASC';
        $cats = Categories::model()->findAll($criteria);
        $result = array();

        foreach($cats as $cat) {
            $result[$cat->ID] = $cat->CAT_NAME;
        }

        return $result;
    }
}