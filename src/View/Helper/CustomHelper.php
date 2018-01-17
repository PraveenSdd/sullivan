<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\ORM\TableRegistry;

class CustomHelper extends Helper {

    /**
     * @function: gitCompanyName()
     * @Description: Get company name
     * @param type $userId
     * @return type
     * @Date: 17 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function gitCompanyName($userId = null) {
        $usersTable = TableRegistry::get('Users');
        return $usersTable->find()->select(['company', 'email', 'phone', 'first_name', 'last_anme'])->where(['id' => $userId])->first();
    }

    /**
     * @function: countCategory()
     * @Description: count and get agency / category 
     * @param type $userId
     * @return type
     * @Date: 17 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function countCategory($id = null) {
        $categoriesTable = TableRegistry::get('Categories');
        $category = $categoriesTable->find()->where(['is_deleted' => 0])->count('id');
        if ($category > 0) {
            return $category;
        } else {
            return $category = 0;
        }
    }

    /**
     * @function: getCategory()
     * @Description: get and get agency / category 
     * @param type: $id
     * @return type : agency and category name
     * @Date: 18 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getCategory($id = null) {

        $categoriesTable = TableRegistry::get('Categories');
        $categories = $categoriesTable->find('list');
        $categories->hydrate(false)->where(['Categories.id in ' => $id]);
        $category = $categories->toArray();

        if (count($category) > 0) {
            return $category;
        } else {
            return false;
        }
    }

    /**
     * @function: getIndustry()
     * @Description: get and get Industry / operation 
     * @param type: $id
     * @return type : operation and category name
     * @Date: 20 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getIndustry($id = null) {

        $industriesTable = TableRegistry::get('Industries');
        $industries = $industriesTable->find('list');
        $industries->hydrate(false)->where(['Industries.id in ' => $id]);
        $industry = $industries->toArray();
        if (count($industry) > 0) {
            return $industry;
        } else {
            return false;
        }
    }

    /**
     * @function: getAgencyIndustryList()
     * @Description: get and get Industry / operation list related to agency
     * @param type: $agenctId
     * @return type : 
     * @Date: 18 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getAgencyIndustryList($agenctId = null) {
        $AgenyIndustriesTable = TableRegistry::get('AgenyIndustries');
        $industries = $AgenyIndustriesTable->find();
        $industries->hydrate(false)->contain(['Industries'])->where(['AgenyIndustries.category_id in ' => $agenctId]);
        $industry = $industries->toArray();

        if (count($industry) > 0) {
            $countIndustry = $industry;
        } else {
            $countIndustry = 0;
        }
        return $countIndustry;
    }

    /**
     * @function: getIndustryName()
     * @Description: get and get Industry / operation name
     * @param type: $id
     * @return type : 
     * @Date: 18 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getIndustryName($id = null) {
        $industriesTable = TableRegistry::get('Industries');
        $industries = $industriesTable->find()->select(['Industries.name'])->where(['Industries.id ' => $id])->first();
        return $industries;
    }

    /**
     * @function: getIndustryNameList()
     * @Description: get and get Industry / operation name list
     * @param type: $id
     * @return type : 
     * @Date: 25 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getIndustryNameList($id = null) {
        $industriesTable = TableRegistry::get('Industries');

        $industries = $industriesTable->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        $industries->hydrate(false)->where(['Industries.id in ' => $id]);
        $industries = $industries->toArray();
        return $industries;
    }

    /**
     * @function: countForms()
     * @Description: count form/ permit name 
     * @param type: $id
     * @return type : 
     * @Date: 25 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function countForms($id = null) {
        $formsTable = TableRegistry::get('Forms');
        $forms = $formsTable->find()->where(['is_deleted' => 0])->count('id');
        if ($forms > 0) {
            return $forms;
        } else {
            return $forms = 0;
        }
    }

    /**
     * @function: countUsers()
     * @Description: count user related to module name 
     * @param type: $id
     * @return type : 
     * @Date: 26 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function countUsers($id = null) {
        $usersTable = TableRegistry::get('Users');
        $users = $usersTable->find()->where(['is_deleted' => 0, 'role_id' => 2])->count('id');
        if ($users > 0) {
            return $users;
        } else {
            return $users = 0;
        }
    }

    /**
     * @function: getPermissionMenuName()
     * @Description: get Permission menu name 
     * @param type: $id
     * @return type : 
     * @Date: 26 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getPermissionMenuName($id = null) {
        $permissionMenusTable = TableRegistry::get('PermissionMenus');
        $permissionMenu = $permissionMenusTable->find()->select('PermissionMenus.name')->where(['PermissionMenus.id' => $id])->first();
        if ($permissionMenu) {
            return $permissionMenu->name;
        } else {
            return $permissionMenu = 0;
        }
    }

    /**
     * @function: dateTime()
     * @Description: convert date time 
     * @param type: $dateTime
     * @return type : 
     * @Date: 26 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function dateTime($dateTime = null) {
        return date('d-m-Y', strtotime($dateTime));
    }

    /**
     * @function: getHomePageAttribute()
     * @Description: get Home page attribute 
     * @param type: $home_page_id
     * @return type : 
     * @Date: 26 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getHomePageAttribute($home_page_id = null) {
        $homePagesTable = TableRegistry::get('HomePages');
        $homePages = $homePagesTable->find()->hydrate(false)->where(['HomePages.home_page_id' => $home_page_id, 'is_deleted' => 0, 'is_active' => 1])->all();
        return $homePages;
    }

    /**
     * @function: getSubscriptionPlanAttribute()
     * @Description: get subscription plan attribute
     * @param type: $plan_id
     * @return type : 
     * @Date: 26 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getSubscriptionPlanAttribute($plan_id = null) {
        $planAttribute = TableRegistry::get('SubscriptionPlanAttributes');
        $planAttributes = $planAttribute->find()->hydrate(false)->where(['SubscriptionPlanAttributes.subscription_plan_id' => $plan_id, 'is_deleted' => 0, 'is_active' => 1])->all();
        return $planAttributes;
    }

    /**
     * @function: getForms()
     * @Description: get Forms related to operation / industry
     * @param type: $industryId
     * @return type : 
     * @Date: 29 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getForms($industryId = null) {
        $formIndustries = TableRegistry::get('FormIndustries');
        $forms = TableRegistry::get('Forms');
        $formAgencies = TableRegistry::get('FormAgencies');
        $FormId = $formAgencies->find()->select('FormAgencies.form_id')->where(['FormAgencies.category_id' => $industryId])->first();
        if ($FormId) {
            $FormId = $forms->find()->select(['Forms.title', 'Forms.id', 'Forms.title', 'Forms.created'])->where(['Forms.id' => $FormId->form_id])->all();
            if (empty($FormId)) {
                $FormId = null;
            }
        }
        return $FormId;
    }

    /**
     * @function: getLocation()
     * @Description: get location related to users
     * @param type: $id
     * @return type : 
     * @Date: 29 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getLocation($id = null) {
        $userLocation = TableRegistry::get('UserLocations');
        $locations = $userLocation->find()->select(['UserLocations.title', 'UserLocations.id'])->where(['UserLocations.id' => $id])->first();
        return $locations;
    }

    /**
     * @function: getFormStatus()
     * @Description: get form status related to form /permit
     * @param type: $id
     * @return type : 
     * @Date: 29 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getFormStatus($id) {
        $permitStatusTable = TableRegistry::get('PermitStatus');
        $permitStatus = $permitStatusTable->find()->where(['PermitStatus.id ' => $id])->first();
        return $permitStatus;
    }

    /**
     * @function: getPermitDocumentStatus()
     * @Description: get permit document status related to form / permit
     * @param type: $formDocumentId
     * @param type: $userId
     * @return type : 
     * @Date: 29 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getPermitDocumentStatus($formDocumentId = null, $userId = null) {
        $permitDocumentsTable = TableRegistry::get('PermitDocuments');
        $permitStatus = $permitDocumentsTable->find()->where(['PermitDocuments.form_documents_id ' => $formDocumentId, 'PermitDocuments.user_id' => $userId])->first();
        return $permitStatus;
    }

    /**
     * @function: getPermitAttachmentStatus()
     * @Description: get permit attachment status related to form / permit
     * @param type: $formAttachmentId
     * @param type: $userId
     * @return type : 
     * @Date: 30 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getPermitAttachmentStatus($formAttachmentId = null, $userId = null) {
        $permitAttachmentTable = TableRegistry::get('PermitAttachments');
        $permitAttachStatus = $permitAttachmentTable->find()->where(['PermitAttachments.form_attachment_id ' => $formAttachmentId, 'PermitAttachments.user_id' => $userId])->first();
        return $permitAttachStatus;
    }

    /**
     * @function: getFormDocumetSample()
     * @Description: get permit attachment status related to form / permit
     * @param type: $documentId
     * @return type : 
     * @Date: 30 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getFormDocumetSample($documentId = null) {
        $formDocumentSamplesTable = TableRegistry::get('FormDocumentSamples');
        $documentSamples = $formDocumentSamplesTable->find()->select(['path', 'id'])->where(['FormDocumentSamples.form_document_id ' => $documentId])->all();
        return $documentSamples;
    }

    /**
     * @function: getFormAttachments()
     * @Description: get form attachments related to form / permit
     * @param type: $formId
     * @return type : 
     * @Date: 30 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getFormAttachments($formId = null) {
        $formAttachmentsTable = TableRegistry::get('FormAttachments');
        $formAttachments = $formAttachmentsTable->find()->contain(['FormAttachmentSamples'])->where(['FormAttachments.form_id ' => $formId])->all();
        return $formAttachments;
    }

    /**
     * @function: getFormAttachmentSamples()
     * @Description: get form attachment samples related to form / permit
     * @param type: $formAttachmentId
     * @return type : 
     * @Date: 30 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getFormAttachmentSamples($formAttachmentId = null) {
        $formAttachmentSamplesTable = TableRegistry::get('FormAttachmentSamples');
        $formAttachmentSamples = $formAttachmentSamplesTable->find()->where(['FormAttachmentSamples.form_attachment_id' => $formAttachmentId])->all();
        return $formAttachmentSamples;
    }

    /**
     * @function: getPermitAttachments()
     * @Description: get permit attachments  related to attachments
     * @param type: $attachmentId
     * @return type : 
     * @Date: 30 Nov. 2017
     * @By: Ahsan Ahamad
     */
    public function getPermitAttachments($attachmentId = null) {
        $permitAttachmentsTable = TableRegistry::get('PermitAttachments');
        $permitAttachments = $permitAttachmentsTable->find()->where(['PermitAttachments.form_attachment_id ' => $attachmentId])->first();
        return $permitAttachments;
    }

    /**
     * @function: getPermits()
     * @Description: get permit related to alert
     * @param type: $alertId
     * @return type : 
     * @Date: 2 Dec. 2017
     * @By: Ahsan Ahamad
     */
    public function getPermits($alertId = null) {
        $alertPermitsTable = TableRegistry::get('AlertPermits');
        $alertPermits = $alertPermitsTable->find()->contain(['Permits'])->where(['AlertPermits.alert_id ' => $alertId])->all();
        prx($alertPermits);
        return $alertPermits;
    }

    /**
     * @function: getPermitListByIndustry()
     * @Description: get permit list related to industry/ operation
     * @param type: $industyId
     * @return type : 
     * @Date: 4 Dec. 2017
     * @By: Ahsan Ahamad
     */
    public function getPermitListByIndustry($industyId = null) {
        // prx($industyId);
        $agenyIndustriesTable = TableRegistry::get('FormIndustries');
        $permitIndustries = $agenyIndustriesTable->find()->where(['FormIndustries.industry_id' => $industyId, 'FormIndustries.is_deleted' => 0, 'FormIndustries.is_active' => 1])->all();
        $permitIndustry = $permitIndustries->toArray();

        if (!empty($permitIndustry)) {

            return $permitIndustry;
        } else {

            return false;
        }
    }

    /**
     * @function: getAlertListByIndustry()
     * @Description: get form related to Agency/ Category List by Industry Id form front-end Permit
     * @param type: $industyId
     * @return type : 
     * @Date: 6 Dec. 2017
     * @By: Ahsan Ahamad
     */
    public function getAlertListByIndustry($industyId = null) {
        // prx($industyId);
        $alertIndustriesTable = TableRegistry::get('AlertIndustries');
        $alertIndustries = $alertIndustriesTable->find()->where(['AlertIndustries.industry_id' => $industyId, 'AlertIndustries.is_deleted' => 0, 'AlertIndustries.is_active' => 1])->all();
        $alertIndustry = $alertIndustries->toArray();


        if (!empty($alertIndustry)) {
            return $alertIndustry;
        } else {
            return false;
        }
    }

    /**
     * @function: getAgencyByFormId()
     * @Description: get form Agency related to Form/Permit form front-end permit
     * @param type: $industyId
     * @return type : 
     * @Date: 6 Dec. 2017
     * @By: Ahsan Ahamad
     */
    public function getAgencyByFormId($formId = null) {
        $formAgenciesTable = TableRegistry::get('FormAgencies');
        $formAgencies = $formAgenciesTable->find('list', ['keyField' => 'id', 'valueField' => 'Categories.name'])->hydrate(false)->contain(['Categories'])->select(['Categories.name'])->where(['FormAgencies.form_id' => $formId])->all();

        $formAgency = $formAgencies->toArray();
        if (!empty($formAgency)) {
            return $formAgency;
        } else {
            return $formAgency = null;
        }
    }

    /**
     * @function: getAgencyByFormId()
     * @Description: get form deadline related to Form/Permit desc order form forntend 
     * @param type: $formId
     * @return type : 
     * @Date: 10 Dec. 2017
     * @By: Ahsan Ahamad
     */
    public function getPermitDeadline($formId = null) {
        $permitDeadlinesTable = TableRegistry::get('PermitDeadlines');
        $deadline = $permitDeadlinesTable->find()->where(['PermitDeadlines.form_id'])->first();
        return $deadline = $permitDeadlinesTable->find()->where(['PermitDeadlines.form_id'])->order(['PermitDeadlines.id' => 'desc'])->first();
    }

    /**
     * @Function: getStateName()
     * @description: Function use for get state name.
     * @param type $stateId
     * @return type
     * @by : Ahsan Ahamad
     * @date: 15th Jan 2018
     */
    public function getStateName($stateId = null) {
        $statesTable = TableRegistry::get('States');
        $states = $statesTable->find()->where(['States.id' => $stateId])->select(['name'])->first();
        return $states->name;
    }

    /**
     * @Function: getPermissionName()
     * @description: Function use for get leave name of the permissions .
     * @param type $permissionId
     * @return type
     * @by : Ahsan Ahamad
     * @date: 15th Jan 2018
     */
    public function getPermissionName($permissionId = null) {
        $permissionTable = TableRegistry::get('Permissions');
        $ermission = $permissionTable->find()->where(['Permissions.id' => $permissionId])->select(['name'])->first();
        return $ermission->name;
    }

}

?>