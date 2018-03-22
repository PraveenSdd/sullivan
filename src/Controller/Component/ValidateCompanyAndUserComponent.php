<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Network\Email\Email;
use Cake\ORM\TableRegistry;

class ValidateCompanyAndUserComponent extends Component {
    
    /*Function: validateCompanyProfle()
    /*to validate the company profile*/
    /*for role id 2*/

public function validateCompanyProfle($company){ //prx($company);
  $response = [];
  if( $company['email_verification'] != 1 && $company['is_active'] == 0){
    $response['statusCode'] = 202;
    $response['message'] = "Email verification pending, Please check your email and verify";
  }else if( $company['email_verification'] == 1 && $company['is_active'] == 0 ){
    $response['statusCode'] = 202;
    $response['message'] = "Somehow site-admin suspended company account, Please contact to site-admin for further details";
  }else if( ! $this->checkPaymentDone($company['id']) ){
    $userId = $company['id'];
    //We have no payment plan saved on file from your company. Please complete payment process clicking here >> or call us for help on (212)687-5900
    $userIdEncrypt = base64_encode($userId);
    $response['statusCode'] = 202;
    $response['message'] = <<<EOD
    We have no payment plan saved on file from your company. Please complete payment process <a href="/payments/index/{$userIdEncrypt}"  style="font-size:17px;font-weight:20px;color:red;"><u><i>&nbsp;&nbsp;clicking here&nbsp;&nbsp;</i></u></a> or call us for help on (212)687-5900
EOD;
  }else if($company['email_verification'] == 1 && $company['is_active'] == 1 && $company['email_verification'] == 1){
    $response['statusCode'] = 200;
  }else{
    $response['statusCode'] = 202;
    $response['message'] = "Something went wrong.Please contact to Admin";
  }
  return $response;
}

/*----function check if payment done or not---------------*/

public function checkPaymentDone($user_id){
     $subscriptionTable = TableRegistry::get('Subscriptions');
     $payment = $subscriptionTable->find()->where(['user_id'=>$user_id,'status'=>'active','is_registration'=>1])->count();
     if($payment){
        return true;
     }return false;

}

public function checkParentCompanyActive($parentCompanyId){
    $usersTable = TableRegistry::get('Users');
    $users = $usersTable->find()->where(['id'=>$parentCompanyId,'is_active'=>1])->count();
    if($users){
        return true;
    }return false;
}

public function validateCompanyUserProfle($user){ //prx($user);
  $response = [];
  if( $user['email_verification'] != 1){
    $response['statusCode'] = 202;
    $response['message'] = "Email verification pending, Please check your email and verify.";
  }else if( $user['is_verify'] == 1 && $user['is_active'] == 0 ){
    $response['statusCode'] = 202;
    $response['message'] = "Your account has beed suspended by company, Please contact to company for further details";
  }else if( $user['email_verification'] == 1 && $user['is_active'] == 0 ){
    $response['statusCode'] = 202;
    $response['message'] = "Your account has beed suspended by company, Please contact to company for further details.";
  }else if( $user['is_verify'] == 0 && $user['is_active'] == 1 ){
    $response['statusCode'] = 202;
    $response['message'] = "Account not verfied by comapny, Please contact to company for further details.";
  }else if( ! $this->checkPaymentDone($user['user_id']) ){
    $response['statusCode'] = 202;
    $response['message'] = "Please contact company, Company account is not subscribed.";
  }else if( ! $this->checkParentCompanyActive($user['user_id']) ){
    $response['statusCode'] = 202;
    $response['message'] = "Company account seems suspended.Please contact to company for further details.";
  }else if($user['is_active'] == 0){
    $response['statusCode'] = 202;
    $response['message'] = "Your account has beed suspended by company, Please contact to company for further details.";
  }
  else if($user['is_verify'] == 1 && $user['is_active'] == 1 && $user['email_verification']){
    $response['statusCode'] = 200;
  }else{
    $response['statusCode'] = 202;
    $response['message'] = "Something went wrong.Please contact to your Company";
  }
  return $response;

}
    

}

?>