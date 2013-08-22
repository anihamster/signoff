<?php
/*
	Class with common helpers functions
*/

class It {

    public static function setSatate($attr, $val) {
        Yii::app()->user->setState($attr, $val);
        return true;
    }

    public static function getState($attr) {
        return Yii::app()->user->getState($attr);
    }

	public static function userId() {
		return Yii::app()->user->getId();
	}

	public static function baseUrl($suffix='') {
		return Yii::app()->getBaseUrl(true).$suffix;
	}

	public static function isGuest() {
        	return Yii::app()->user->isGuest;
	}

	public static function isAdmin() {
		return Yii::app()->user->getState('is_admin');
	}

	public static function memStatus($status_code)
	{
	    //unset($_SESSION['status_code']);
	    if (!$_SESSION['status_code']) {
	        $_SESSION['status_code'] = array();
	    }
	    $_SESSION['status_code'][] = $status_code;
	}
	public static function setMem($param,$value)
	{
        if (!isset($_SESSION['memory'])) {
            $_SESSION['memory'] = array();
        }
        $_SESSION['memory'][$param] = $value;
	}

	public function redirect($url, $andExit=true) {
		if ($url=='referer'){
			$url = $_SERVER['HTTP_REFERER'];
		}
		elseif(substr($url,0,4)!='http') {
			$url = It::baseUrl().$url;
		}
		CController::redirect( $url, $andExit );
	}

	// get value form GET or POST or SESSION (and store to Session from Request)
	public static function forceValue($name, $namespace) {
		$value = null;
		if (isset($_REQUEST[$name])) {
			$value = $_REQUEST[$name];
			$_SESSION[$namespace][$name] = $_REQUEST[$name];
		}
		elseif (isset($_SESSION[$namespace][$name])) {
			$value = $_SESSION[$namespace][$name];
		}
		return $value;
	}

	public static function isPostRequest() {
		return Yii::app()->request->isPostRequest;
	}

	public static function isAjaxRequest() {
		return Yii::app()->request->isAjaxRequest;
	}

	public function getOptionsMonates() {
		return array(
			''=>'Select month',
			'01'=>'January',
			'02'=>'February',
			'03'=>'March',
			'04'=>'April',
			'05'=>'May',
			'06'=>'June',
			'07'=>'July',
			'08'=>'August',
			'09'=>'September',
			'10'=>'October',
			'11'=>'November',
			'12'=>'December',
		);
	}

	public function stripArrayEmptyValues($array = array())
	{
	    $result = array();
	    if ($array) {
	        $result = array_map('trim', $array);
			foreach ($result as $key => $value) {
				if (empty($value))
					unset($result[$key]);
			}
	    }
	    return $result;
	}

    public function createTextPreview($text, $limit = 35, $replacement = '')
    {
        if (strlen($text) <= $limit)
            return $text;

        $leave = $limit - strlen($replacement);
        return mb_substr($text, 0, $limit).$replacement;
        //return substr_replace($text, $replacement, $leave);
    }
}
