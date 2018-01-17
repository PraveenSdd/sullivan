<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Utility\Inflector;

class PermitsController extends AppController {
    /*
     * $paginate is use for ordering and limit data from data base
     * By @Ahsan Ahamads
     * Date : 2nd Nov. 2017
     */

    public $companyId;
    public $emaployeeId;
    public $userId;

    public function initialize() {
        parent::initialize();

        if ($this->Auth->user('user_id') != 0) {
            $this->companyId = $this->Auth->user('user_id');
            $this->userId = $this->Auth->user('user_id');
        } else {
            $this->emaployeeId = $this->Auth->user('id');
            $this->userId = $this->Auth->user('id');
        }
        $this->loadComponent('Paginator');
        $this->loadComponent('Upload');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    /*
     * Function: permitDetails()
     * Description: use for show all details of permit releted to specefic permit
     * @param type $formId
     * By @Ahsan Ahamad
     * Date : 12th DEC. 2017
     */

    public function details($formId = null) {
        $this->viewBuilder()->setLayout('dashboard');
        $pageTitle = 'Permit';
        $pageHedding = 'Permit';
        $breadcrumb = array(
            array('label' => 'Permit Details'),
        );
        $user_id = $this->Auth->user('id');
        $breadcrumbBottam = array(
            array('label' => 'Permit'),
        );

        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $formId = $this->Encryption->decode($formId);
        $this->loadModel('Permits');
        $this->loadModel('Forms');

        $accessPermits = $this->Permits->find()->where(['Permits.user_id' => $this->userId, 'Permits.form_id' => $formId])->first();
        $this->loadModel('AlertTypes');
        $alertTypes = $this->AlertTypes->find('list');
        $alertTypes->hydrate(false)->where(['AlertTypes.is_user' => 1, 'AlertTypes.is_deleted' => 0, 'AlertTypes.is_active' => 1]);
        $alertTypesList = $alertTypes->toArray();

        $formDetails = $this->Forms->formDetails($accessPermits->form_id);
        $this->set(compact('accessPermits', 'formDetails', 'alertTypesList'));
    }

    /*
     * Function: uloadPermit()
     * Description: use for upload permit permit 
     * By @Ahsan Ahamads
     * Date : 13th Dec. 2017
     */

    public function uploadPermitDocument() {
        $this->autoRender = false;
        $responce['flag'] = false;
        $responce['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('PermitDocuments');
            $pathDocument = 'files/permit/documents';
            $permitFiles = $this->Upload->uploadOtherFile($this->request->data['form_documet'], $pathDocument);
            $permitData['path'] = $permitFiles;
            $permitData['notes'] = $this->request->data['notes'];
            $permitData['form_id'] = $this->request->data['form_id'];
            $permitData['form_documents_id'] = $this->request->data['form_documents_id'];
            $permitData['is_complated'] = 1;
            $permitData['user_id'] = $this->userId;
            if (!empty($this->request->data['permit_documents_id'])) {
                $permits = $this->PermitDocuments->get($this->request->data['permit_documents_id']);
            } else {
                $permits = $this->PermitDocuments->newEntity();
            }
            $permitss = $this->PermitDocuments->patchEntity($permits, $permitData, ['validate' => 'UploadPermit']);
            if (!$permitss->errors()) {
                if ($success = $this->PermitDocuments->save($permits)) {
                    $path = BASE_URL . '/webroot/' . $success->path;
                    $result['status'] = 'Filled';
                    $result['updated'] = date('d-m-Y', strtotime($success->modified));
                    $responce['flag'] = true;
                    $responce['data'] = $result;
                    $responce['id'] = $success->id;
                    $responce['path'] = $path;
                    $responce['msg'] = 'Permit has been uploaded successfully';
                } else {
                    $responce['msg'] = 'Permit could not uploaded';
                }
            } else {
                $responce['msg'] = $this->Custom->multipleFlash($categories->errors());
            }
        } else {
            $responce['msg'] = 'Permit could not post';
        }
        echo json_encode($responce);
        exit;
    }

    /*
     * Function: uloadPermit()
     * Description: use for upload permit permit 
     * By @Ahsan Ahamads
     * Date : 13th Dec. 2017
     */

    public function uploadPermitAttachment() {
        $this->autoRender = false;
        $responce['flag'] = false;
        $responce['msg'] = '';
        if ($this->request->is('post')) {
            // prx($this->request->data);
            $this->loadModel('PermitAttachments');
            $pathDocument = 'files/permit/attachment';
            $permitFiles = $this->Upload->uploadOtherFile($this->request->data['form_attechment'], $pathDocument);
            $permitData['path'] = $permitFiles;
            $permitData['notes'] = $this->request->data['notes'];
            $permitData['form_id'] = $this->request->data['form_id'];
            $permitData['form_documents_id'] = $this->request->data['form_documents_id'];
            $permitData['form_attachment_id'] = $this->request->data['form_attachment_id'];

            $permitData['privacy'] = $this->request->data['privacy'];
            $permitData['is_complated'] = 1;
            $permitData['user_id'] = $this->userId;

            if (!empty($this->request->data['permit_attachment_id'])) {
                $permits = $this->PermitAttachments->get($this->request->data['permit_attachment_id']);
            } else {
                $permits = $this->PermitAttachments->newEntity();
            }
            $permitss = $this->PermitAttachments->patchEntity($permits, $permitData, ['validate' => 'UploadPermitAttachment']);
            if (!$permitss->errors()) {
                if ($success = $this->PermitAttachments->save($permits)) {
                    $result['status'] = 'Filled';
                    $result['updated'] = date('d-m-Y', strtotime($success->modified));
                    $responce['flag'] = true;
                    $responce['data'] = $result;
                    $responce['id'] = $success->id;

                    $responce['msg'] = 'Permit attach document has been uploaded successfully';
                } else {
                    $responce['msg'] = 'Permit attach document could not uploaded';
                }
            } else {
                $responce['msg'] = $this->Custom->multipleFlash($categories->errors());
            }
        } else {
            $responce['msg'] = 'Permit attach document could not post';
        }
        echo json_encode($responce);
        exit;
    }

    public function createZip($id) {

        $zip = new ZipArchive();
        $zip_name = time() . ".zip"; // Zip name
        $zip->open($zip_name, ZipArchive::CREATE);
        foreach ($files as $file) {
            echo $path = "uploadpdf/" . $file;
            if (file_exists($path)) {
                $zip->addFromString(basename($path), file_get_contents($path));
            } else {
                echo"file does not exist";
            }
        }
        $zip->close();
    }

    /*
     * Function: downloadPermitDocuments()
     * Description: use for download all permit document in zip folder.
     * @param type $documentId
     * By @Ahsan Ahamads
     * Date : 13th Dec. 2017
     */

    public function downloadPermitDocuments($documentId = null) {
        $this->autoRender = false;
        $this->loadModel('Documents');
        $this->loadModel('FormDocumentSamples');
        $formDocument = $this->Documents->find()->where(['Documents.id' => $documentId])->first();
        $formDocumentSamples = $this->FormDocumentSamples->find()->where(['FormDocumentSamples.form_document_id' => $formDocument->id])->all();
        if (!empty($formDocument)) {
            $proInfo = $formDocument->path;
            $formName = Inflector::slug($formDocument->name, '_');
            $zipName = WWW_ROOT . $proInfo . '_permit.zip';
            /* this code for zip file name */
            $downloadname = $formName . '_permit.zip';
            $zipContent = new \ZipArchive;
            $zipContent->open($zipName, \ZipArchive::CREATE);

            /* PATHINFO_EXTENSION this code for file EXTENSION */
            $ext = pathinfo($formDocument->path, PATHINFO_EXTENSION);
            $path = WWW_ROOT . $formDocument->path;
            if (is_file($path)) {
                /* this code for add file in zip folder */
                if (file_exists($path)) {
                    $zipContent->addFromString(basename($formName . '.' . $ext), file_get_contents($path));
                }
            }
            if (!empty($formDocumentSamples)) {
                $number = 1;
                foreach ($formDocumentSamples as $formDocumentSample) {
                    $pathAttachment = WWW_ROOT . $formDocumentSample->path;
                    $ext = pathinfo($formDocumentSample->path, PATHINFO_EXTENSION);
                    if (file_exists($pathAttachment)) {
                        $zipContent->addFromString(basename($formName . '-sample-' . $number . '.' . $ext), file_get_contents($pathAttachment));
                    }
                    $number++;
                }
            }

            $zipContent->close();
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . $downloadname);
            header('Content-Length: ' . filesize($zipName));
            readfile($zipName);
            unlink($zipName);
        } else {
            $this->Flash->error("Image not found");
            $this->redirect($this->referer());
        }
    }

    /*
     * Function: downloadPermitAttachment
     * Description: use for download all permit attech file in zip folder.
     * @param type $formAttachmentId
     * By @Ahsan Ahamads
     * Date : 13th Dec. 2017
     */

    public function downloadPermitAttachment($formAttachmentId = null) {
        $this->autoRender = false;
        $this->loadModel('FormAttachments');
        $this->loadModel('FormAttachmentSamples');
        $formAttachments = $this->FormAttachments->find()->where(['FormAttachments.id' => $formAttachmentId])->first();

        $formAttachmentSamples = $this->FormAttachmentSamples->find()->where(['FormAttachmentSamples.form_attachment_id' => $formAttachments->id])->all();

        if (!empty($formAttachments)) {
            $proInfo = $formAttachments->name;
            $formName = Inflector::slug($formAttachments->name, '_');
            $zipName = WWW_ROOT . $proInfo . '_permit.zip';
            /* this code for zip file name */
            $downloadname = $formName . '_permit.zip';
            $zipContent = new \ZipArchive;
            $zipContent->open($zipName, \ZipArchive::CREATE);

            if (!empty($formAttachmentSamples)) {

                $number = 1;
                foreach ($formAttachmentSamples as $formAttachmentSample) {
                    $pathAttachment = WWW_ROOT . $formAttachmentSample->path;
                    $ext = pathinfo($formAttachmentSample->path, PATHINFO_EXTENSION);
                    if (file_exists($pathAttachment)) {
                        $zipContent->addFromString(basename($formName . '-attachment-' . $number . '.' . $ext), file_get_contents($pathAttachment));
                    }
                    $number++;
                }
            }

            $zipContent->close();
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . $downloadname);
            header('Content-Length: ' . filesize($zipName));
            readfile($zipName);
            unlink($zipName);
        } else {
            $this->Flash->error("Image not found");
            $this->redirect($this->referer());
        }
    }

    /*
     * Function: addAlerts()
     * Description: use for add alerts of the permit 
     * By @Ahsan Ahamads
     * Date : 13th Dec. 2017
     */

    public function addAlerts() {
        if ($this->request->is('post')) {
            $this->loadModel('AlertPermitAttachments');
            $this->loadModel('AlertPermitDocuments');
            $this->loadModel('AlertPermits');
            $this->loadModel('Alerts');
            $formId = $this->request->data['form_id'];
            $alertTypleId = $this->request->data['alert_type_id'];
            $this->request->data['title'] = ucfirst($this->request->data['title']);
            $this->request->data['date'] = date('Y-m-d', strtotime($this->request->data['date']));
            $this->request->data['user_id'] = $this->userId;
            if (!empty($this->request->data['interval'])) {
                $this->request->data['interval_alert'] = (int) $this->request->data['interval'];
            }
            $alerts = $this->Alerts->newEntity();
            $this->Alerts->patchEntity($alerts, $this->request->data, ['validate' => 'Add']);
            if (!$alerts->errors()) {
                if ($success = $this->Alerts->save($alerts)) {
                    $permit['user_id'] = $this->userId;
                    $permit['alert_id'] = $success->id;
                    $permit['form_id'] = $formId;
                    $permit['alert_type_id'] = $this->request->data['alert_type_id'];
                    $permit['created'] = date('Y-m-d');
                    if ($this->request->data['alert_type'] == 'document') {
                        $permit['form_document_id'] = $this->request->data['form_document_id'];
                        $alertPermitDocuments = $this->AlertPermitDocuments->newEntity();
                        $this->AlertPermitDocuments->patchEntity($alertPermitDocuments, $permit);
                        $this->AlertPermitDocuments->save($alertPermitDocuments);
                    }
                    if ($this->request->data['alert_type'] == 'permit') {
                        $permits = $this->AlertPermits->newEntity();
                        $this->AlertPermits->patchEntity($permits, $permit);
                        $successAlert = $this->AlertPermits->save($permits);
                    }
                    if ($this->request->data['alert_type'] == 'attachment') {
                        $permit['form_attachment_id'] = $this->request->data['form_attachment_id'];
                        $alertPermitAttachments = $this->AlertPermitAttachments->newEntity();
                        $this->AlertPermitAttachments->patchEntity($alertPermitAttachments, $permit);
                        $this->AlertPermitAttachments->save($alertPermitAttachments);
                    }
                    $this->Flash->success(__('Alerts has been updated successfully.'));
                } else {
                    $this->Flash->error(__('Alerts could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($alerts->errors())));
            }
            return $this->redirect($this->referer());
        }
    }

}
