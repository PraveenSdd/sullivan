<?php

// src/Model/Entity/User.php

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class PermitDeadline extends Entity {

// Make all fields mass assignable except for primary key field "id".
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

//    protected function _setDate($date) {
//        if (strlen($date) > 0) {
//            return (string)date('Y-m-d', strtotime($date));
//        }
//    }
//    
//    protected function _getDate($date) {
//        if (strlen($date) > 0) {
//            return date('d-m-Y', strtotime($date));
//        }
//    }
//    
//    protected function _setTime($time) {
//        if (strlen($time) > 0) {
//            return (string)date('H:i', strtotime($time)).':00';
//        }
//    }
//    
//    protected function _getTime($time) {
//        if (strlen($time) > 0) {
//            return date('H:i A', strtotime($time));
//        }
//    }

}

?>
