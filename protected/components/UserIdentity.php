<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

    
    public function authenticate()
    {
        $record = Users::model()->findByAttributes(array('LOGIN'=>$this->username));
        if($record === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if($record->PASSWORD !== $this->password)
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id=$record->ID;
            
           	Yii::app()->user->setState('user_role', $record->TYPE);

            $details = UserDetails::model()->findByAttributes(array('USER_ID' => $record->ID));

            if(!empty($details)) {
                It::setState('tkam', $details->CAN_ADD);
                It::setState('head', $details->HEAD_USER);
                It::setState('brand', $details->BRAND);
                It::setState('role', $details->ROLE_ID);
            }
            
            $this->errorCode=self::ERROR_NONE;
        }
        return !$this->errorCode;
    }
  
    public function getId()
    {
        return $this->_id;
    }
}