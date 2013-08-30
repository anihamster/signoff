<?php

/**
 * This is the model class for table "ROLES".
 *
 * The followings are the available columns in table 'ROLES':
 * @property integer $ID
 * @property integer $ROLE_PARENT
 * @property string $ROLE_NAME
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 * @property integer $SPEC
 */
class Roles extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Roles the static model class
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
		return 'ROLES';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ROLE_PARENT, SPEC, TECH', 'numerical', 'integerOnly'=>true),
			array('ROLE_NAME', 'length', 'max'=>1020),
			array('CREATED_AT, UPDATED_AT', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, ROLE_PARENT, ROLE_NAME, CREATED_AT, UPDATED_AT, SPEC, TECH', 'safe', 'on'=>'search'),
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
            'parents' => array(self::HAS_ONE, 'Roles', array('ID' => 'ROLE_PARENT'), 'alias'=>'p'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'ROLE_PARENT' => 'Role Parent',
			'ROLE_NAME' => 'Role Name',
			'CREATED_AT' => 'Created At',
			'UPDATED_AT' => 'Updated At',
            'SPEC' => 'Brand specified role',
            'TECH' => 'Technical role',
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
		$criteria->compare('ROLE_PARENT',$this->ROLE_PARENT);
		$criteria->compare('ROLE_NAME',$this->ROLE_NAME,true);
		$criteria->compare('CREATED_AT',$this->CREATED_AT,true);
		$criteria->compare('UPDATED_AT',$this->UPDATED_AT,true);
        $criteria->compare('SPEC',$this->SPEC);
        $criteria->compare('TECH',$this->TECH);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getRoles() {
        $roles = Roles::model()->findAll();

        $result = array();
        foreach($roles as $role) {
            $result[$role->ID] = $role->ROLE_NAME;
        }

        return $result;
    }
}