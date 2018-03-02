<?php 
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components;

use Yii;

/**
 * Description of Validation
 *
 * @author morakot
 */
class Validation {

	public static function validcitizenid($personID){

		if (strlen($personID) != 13) {
 			return false;
		}

		$rev = strrev($personID); 
		$total = 0;
		for($i=1;$i<13;$i++) {
 			$mul = $i +1;
 			$count = $rev[$i]*$mul; 
 			$total = $total + $count; 
		}
		$mod = $total % 11; 
		$sub = 11 - $mod; 
		$check_digit = $sub % 10;

 	if($rev[0] == $check_digit) {
 		return true;
 	} else {
     return false; 
 	}

}

}