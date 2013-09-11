<?php

/**
 * This is the model class for table "TRACKER_GROUPS".
 *
 * The followings are the available columns in table 'TRACKER_GROUPS':
 * The followings are the available columns in table 'TRACKER_GROUPS':
 * @property integer $ID
 * @property integer $GROUP_PARENT
 * @property string $GROUP_NAME
 * @property string $CREATED_AT
 * @property string $UPDATED_AT
 */
class TrackerGroups extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RelGroups the static model class
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
		return 'TRACKER_GROUPS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('GROUP_PARENT', 'numerical', 'integerOnly'=>true),
			array('GROUP_NAME', 'length', 'max'=>1020),
            array('GROUP_NAME', 'unique'),
			array('CREATED_AT, UPDATED_AT', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, GROUP_PARENT, GROUP_NAME, CREATED_AT, UPDATED_AT', 'safe', 'on'=>'search'),
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
            'parents' => array(self::HAS_ONE, 'TrackerGroups', array('ID' => 'GROUP_PARENT'), 'alias'=>'p'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'GROUP_PARENT' => 'Group Parent',
			'GROUP_NAME' => 'Group Name',
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
		$criteria->compare('GROUP_PARENT',$this->GROUP_PARENT);
		$criteria->compare('GROUP_NAME',$this->GROUP_NAME,true);
		$criteria->compare('CREATED_AT',$this->CREATED_AT,true);
		$criteria->compare('UPDATED_AT',$this->UPDATED_AT,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getGroups() {
        $grps = TrackerGroups::model()->findAll();

        $result = array();
        foreach($grps as $grp) {
            $result[$grp->ID] = $grp->GROUP_NAME;
        }

        return $result;
    }
}