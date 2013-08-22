<?php

/**
 * This is the model class for table "RELATION_RULES".
 *
 * The followings are the available columns in table 'RELATION_RULES':
 * @property integer $ID
 * @property integer $CAT_ID
 * @property integer $GRP_ID
 * @property integer $ROLE_ID
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 */
class RelationRules extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RelationRules the static model class
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
		return 'RELATION_RULES';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CAT_ID, GRP_ID, ROLE_ID', 'numerical', 'integerOnly'=>true),
			array('CREATED_AT, UPDATED_AT', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, CAT_ID, GRP_ID, ROLE_ID, CREATED_AT, UPDATED_AT', 'safe', 'on'=>'search'),
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
            'cat' => array(self::HAS_ONE, 'Categories', array('ID' => 'CAT_ID'), 'alias'=>'c'),
            'rls' => array(self::HAS_ONE, 'Roles', array('ID' => 'ROLE_ID'), 'alias'=>'r'),
            'grp' => array(self::HAS_ONE, 'DeptGroups', array('ID' => 'GRP_ID'), 'alias'=>'g'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'CAT_ID' => 'Cat',
			'GRP_ID' => 'Grp',
			'ROLE_ID' => 'Role',
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
		$criteria->compare('CAT_ID',$this->CAT_ID);
		$criteria->compare('GRP_ID',$this->GRP_ID);
		$criteria->compare('ROLE_ID',$this->ROLE_ID);
		$criteria->compare('CREATED_AT',$this->CREATED_AT,true);
		$criteria->compare('UPDATED_AT',$this->UPDATED_AT,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}