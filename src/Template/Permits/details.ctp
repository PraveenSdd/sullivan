<?php

$ecodeUserId = $this->Encryption->encode($Authuser['id']); ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>
   <?= $this->Flash->render() ?>
    <div class="form-default clearfix">
        <div class="col-sm-12 bg-primary clearfix ">
            <h3 class="text-center"><?php echo ucfirst($formDetails->title);?></h3>
            <p>
                <?php  echo $formDetails->description;?>
            </p>
        </div>
        <div class="main-action-btn pull-right clearfix">
            <?php echo $this->Html->link('Alert','javascript:void(0);',array('escape' => false, 'data-formId'=>$formDetails->id,'data-title'=>ucfirst($formDetails->title),'data-toggle'=>'modal','data-target'=>'#alertModal','class'=>"uploadForm btn btn-default")); ?> 
        </div>
        <div class="row">
            <div class="table-responsive col-xs-12 col-sm-12">
                <table class="table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Upload</th>
                            <th scope="col">Modify</th>
                            <th scope="col">Status</th>
                            <th scope="col">Sample</th>
                            <th scope="col">Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td ><span class="pull-left"><b>Forms</b> </span> </td> <td colspan="5" id="statusmsg"></td></tr>
                        <?php  foreach($formDetails->documents as $document){ 
                                   $documentsList[$document->id] = ucfirst($document->name);
                                   $fillDocument = $this->Custom->getPermitDocumentStatus($document->id,$accessPermits->user_id);
                       ?>
                        <tr>
                            <td>
                                <a title="<?php echo ucfirst($document->name); ?>" tooltip="<?php echo ucfirst($document->name); ?>" href="javascript:void(0);" class="btn-attachment-viewer" data-attachment-src="<?php echo BASE_URL.'/webroot/'.$document->path; ?>" data-attachment-name="<?php echo ucfirst($document->name); ?>" data-attachment-id="<?php echo $document->id; ?>"><?php echo ucfirst($document->name); ?></a>

                            </td>
                            <td class="upload<?php echo $document->id;?>">
                                <a href="javascript:void(0);" data-permitDocumentsId="<?php echo @$fillDocument->id;?>" data-documentId="<?php echo $document->id;?>" data-title="<?=$document->name?>" data-formId='<?=$formDetails->id;?>' class="uploadForm" data-toggle="modal" data-target="#uploadPermitDocumentModel"><?=$this->Html->image("icons/upload.png");?></a>
                            </td>
                            <td class="updated<?php echo $document->id; ?>">
                        <?php  if(!$fillDocument){
                                echo $this->Custom->dateTime($accessPermits->modified);
                            }else{ echo $this->Custom->dateTime($fillDocument->modified); }?>
                            </td>
                            <td class="">
                                <a title="<?php echo ucfirst($document->name); ?>" tooltip="<?php echo ucfirst($document->name); ?>" href="javascript:void(0);" class="btn-attachment-viewer hide formStatus<?php echo $document->id;?>" data-attachment-src="<?php echo BASE_URL.'/webroot/'.@$fillDocument->path; ?>" data-attachment-name="<?php echo ucfirst($document->name); ?>" data-attachment-id="<?php if(!empty($formAttachment))echo $formAttachment->id; ?>">Filled</a>

                            <?php  
                                if(!$fillDocument){
                                $formStatus =  $this->Custom->getFormStatus($accessPermits->permit_status_id);
                                echo '<span class="status">'.$formStatus->title.'</span>'; 
                                }else{ ?>
                                <a title="<?php echo ucfirst($document->name); ?>" tooltip="<?php echo ucfirst($document->name); ?>" href="javascript:void(0);" class="btn-attachment-viewer" data-attachment-src="<?php echo BASE_URL.'/webroot/'.$fillDocument->path; ?>" data-attachment-name="<?php echo ucfirst($document->name); ?>" data-attachment-id="<?php echo @$formAttachment->id; ?>">Filled</a>

                            <?php    }
                                ?> 
                            </td>

                    <?php $documentSamples = $this->Custom->getFormDocumetSample($document->id); ?></td>
                            <td>
                         <?php $number = 1;foreach($documentSamples as $samples){

                             ?>
                                <a title="" tooltip="<?= 'Sample-'.$number?>" href="javascript:void(0);" class="btn-attachment-viewer" data-attachment-src="<?php echo BASE_URL.'/webroot/'.$samples->path; ?>" data-attachment-name="<?= 'Sample-'.$number?>" data-attachment-id="<?php echo $document->id; ?>"><?= 'Sample-'.$number?></a> &nbsp;&nbsp;
                          <?php $number++; }?>
                            </td>
                            <td>

                    <?php echo $this->Html->link($this->Html->image("icons/download.png"),['controller'=>'permits','action'=>'downloadPermitDocuments',$document->id],array('title'=>'Details','escape' => false)); ?> 

                            </td>
                        </tr>
                 <?php } ?>
                <?php  $formAttachments = $this->Custom->getFormAttachments($formDetails->id); 
                if(isset($formAttachments)){?>
                        <tr><td colspan="6"><span class="pull-left"><b>Attechments</b></span> </td></tr>
                <?php foreach($formAttachments as $formAttachment){ 
                    $attechmentList[$formAttachment->id] = $formAttachment->name;
                        $fillAttachment = $this->Custom->getPermitAttachmentStatus($formAttachment->id,$accessPermits->user_id);
                      $attechId = $fillAttachment['id'];
                      
                    ?>
                        <tr>
                            <td> 
                                <a title="<?php echo ucfirst($formAttachment->name); ?>" tooltip="<?php echo ucfirst($formAttachment->name); ?>" href="javascript:void(0);" class="btn-attachment-viewer" data-attachment-src="<?php echo BASE_URL.'/webroot/'.$formAttachment->path; ?>" data-attachment-name="<?php echo ucfirst($formAttachment->name); ?>" data-attachment-id="<?php echo $formAttachment->id; ?>"><?php echo ucfirst($formAttachment->name); ?></a>
                            </td>

                            <td class="uploadAttachment<?php echo $formAttachment->id;?>">
                                <a href="javascript:void(0);"  data-documentId="<?php echo $document->id;?>" data-attachmentId="<?= $formAttachment->id?>" data-title="<?=$formAttachment->name?> " data-formId='<?=$formDetails->id;?>' class="uploadFormAttachment" data-toggle="modal" data-target="#uploadPermitAttachmentModel"  data-permitattachmentId="<?php echo $attechId;?>" ><?=$this->Html->image("icons/upload.png");?></a>
                            </td>
                            <td class="updatedAttachment<?php echo $formAttachment->id;?>"><?php $permitAttachments = $this->Custom->getPermitAttachments($formAttachment->id);
                        if(!empty($fillAttachment)){
                          echo $this->Custom->dateTime($fillAttachment->modified);
                        }else{
                             echo $this->Custom->dateTime( $formAttachment->modified);
                        }
                        ?>
                            </td>
                            <td class="statusAttachment<?php echo $formAttachment->id;?>">
                                <?php 
                                if(!empty($fillAttachment)){ ?>
                                <a title="<?php echo ucfirst($formAttachment->name); ?>" tooltip="<?php echo ucfirst($formAttachment->name); ?>" href="javascript:void(0);" class="btn-attachment-viewer" data-attachment-src="<?php echo BASE_URL.'/webroot/'.$fillAttachment->path; ?>" data-attachment-name="<?php echo ucfirst($formAttachment->name); ?>" data-attachment-id="<?php echo $formAttachment->id; ?>">Uploaded</a>
                             <?php }else{ echo 'Pending';} ?>
                            </td>
                            <td>
                             <?php $sr = 1;$formAttachmentSamples = $this->Custom->getFormAttachmentSamples($formAttachment->id);
                                foreach($formAttachmentSamples as $formAttachmentSample){ ?>
                                <a title="<?php echo ucfirst($formAttachment->name); ?>" tooltip="<?php echo ucfirst($formAttachment->name); ?>" href="javascript:void(0);" class="btn-attachment-viewer" data-attachment-src="<?php echo BASE_URL.'/webroot/'.$formAttachmentSample->path; ?>" data-attachment-name="<?php echo ucfirst($formAttachment->name); ?>" data-attachment-id="<?php echo $formAttachmentSample->id; ?>"><?= 'Sample-'.$sr?></a> &nbsp;&nbsp;
                <?php $sr++;} ?>   

                            </td>
                            <td>   <?php echo $this->Html->link($this->Html->image("icons/download.png"),['controller'=>'permits','action'=>'downloadPermitAttachment',$formAttachment->id],array('title'=>'Details','escape' => false)); ?> </td>
                        </tr>
                <?php }
                        } ?>
                    </tbody>

                </table>
            </div>

        </div>

        <div class="col-sm-12 col-xs-12 clearfix">
   <?php echo $this->Html->link('Cancel',['controller'=>'permits','action'=>'permits'],array('class'=>'btn btn-warning','escape' => false)); ?>        </div>
    </div>

</div>
</div>
   <?php echo $this->element('frontend/modal/download_view_form'); ?>

<!-- modal upload document for upload form start here -->
  <?php echo $this->element('frontend/permit_popup/permit_form_upload'); ?>
<!--/modal default end--> 

<!-- modal upload document for upload form start here -->
  <?php echo $this->element('frontend/permit_popup/permit_attachment'); ?>

<!-- modal default Alert start here -->
<?php echo $this->element('frontend/permit_popup/alert_permit'); ?>

<!-- /modal default end -->

<?php echo $this->Html->script(['permit','alerts','datepicker/timepicker','datepicker/bootstrap-datepicker']);?>



