<?php

/**
 * This is the model class for table "BRANDS".
 *
 * The followings are the available columns in table 'BRANDS':
 * @property integer $ID
 * @property string $BRAND_NAME
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 */
class Brands extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Brands the static model class
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
		return 'BRANDS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('BRAND_NAME', 'length', 'max'=>1020),
			array('CREATED_AT, UPDATED_AT', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, BRAND_NAME, CREATED_AT, UPDATED_AT', 'safe', 'on'=>'search'),
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
			'BRAND_NAME' => 'Brand Name',
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
		$criteria->compare('BRAND_NAME',$this->BRAND_NAME,true);
		$criteria->compare('CREATED_AT',$this->CREATED_AT,true);
		$criteria->compare('UPDATED_AT',$this->UPDATED_AT,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getBrands() {
        $criteria = new CDbCriteria;
        $criteria->order = 'ID ASC';
        $brands = Brands::model()->findAll($criteria);
        $result = array();

        foreach($brands as $brand) {
            $result[$brand->ID] = $brand->BRAND_NAME;
        }

        return $result;
    }
}