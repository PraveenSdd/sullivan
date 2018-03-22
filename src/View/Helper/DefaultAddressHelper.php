<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\ORM\TableRegistry;

class DefaultAddressHelper extends Helper {
 //Please add our office address as a default, I don't want to type our office address all the time when I add an employee. It should be changeable, but please let's make a default address: 
    //7 East 20th Street, New York, NY 10003
 public function getAddress(){
     $address = [];
     $address['zipcode'] = 10003;
     $address['state_id'] = 154;
     $address['city'] = 'New York';
     $address['address1'] = '7 East 20th Street';
     $address['address2'] = '';
     return $address;
 }

}

?>