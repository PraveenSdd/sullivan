<?php

//prx($permitDetails);
$ecodeUserId = $this->Encryption->encode($Authuser['id']); ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>
   <?= $this->Flash->render() ?>
    <div class="form-default clearfix">
        <div class="col-sm-12 bg-primary clearfix ">
            <h3 class="text-center"><?php if(!empty($permitDetails)) echo ($permitDetails->name);?></h3>
            <p> <?php if(!empty($permitDetails)) echo $permitDetails->description;?>

            </p>
            <p> <?php if(isset($permitDetails->deadlines[0]) && !empty($permitDetails->deadlines[0]['date'])){
                echo "Agency Deadline: ".$permitDetails->deadlines[0]['date'];               
            } ?>

            </p>
        </div>

        <?php echo $this->Form->hidden('Permit.name', array('data-id'=>$permitDetails->id,'data-id-ecrypt'=>$permitId,'value'=>$permitDetails->name,'class'=>'form-control inp-permit-name')) ?>


        <?php echo $this->Form->hidden('Operation.name', array('data-id'=>$this->Encryption->decode($operationId),'data-id-ecrypt'=>$operationId,'value'=>'','class'=>'form-control inp-operation-name')) ?>
        <?php echo $this->Form->hidden('Location.name', array('data-id'=>$this->Encryption->decode($locationId),'data-id-ecrypt'=>$locationId,'value'=>'','class'=>'form-control inp-location-name')) ?>


        <?php echo $this->Form->hidden('UserPermit.id', array('data-id'=>$accessPermits->id,'data-id-ecrypt'=>$this->Encryption->encode($accessPermits->id),'value'=>'','class'=>'form-control inp-user-permit-id')) ?>
        <div class="main-action-btn pull-right clearfix">
            <?php 
                if(empty($userPermitDeadlines)){?>
                        <?php echo $this->Html->link('Deadline','javascript:void(0);',array('escape' => false,'title'=>'edit', 'data-title'=>'Add Alert','data-modal-title'=>'Add Deadline','data-deadline-id'=>'','data-deadline-date'=>'','data-deadline-time'=>'','data-deadline-type'=> '','data-deadline-permit-id'=>'', 'data-deadline-form-id'=>'', 'data-deadline-document-id'=>'','data-renewable-value'=>1, 'class'=>"btnPermitDeadlineModal btn btn-default removeDeadlineBtn"));?>
                <?php }?>
            <?php if(!empty($permitDetails)) { 
            echo $this->Html->link('Upload Document','javascript:void(0);',array('escape' => false,'title'=>'edit', 'data-title'=>'Add Previous Permit Document','data-modal-title'=>'Add Previous Permit Document','data-permit-id'=>$permitDetails->id,'data-operation-id'=>$this->Encryption->decode($operationId),'data-location-id'=>$this->Encryption->decode($locationId),'data-alert-date'=>'','data-alert-time'=>'','data-alert-type'=> '','data-user-permit-id'=>$accessPermits->id, 'data-alert-staff-id'=>'', 'class'=>"btnPreviousPermitDocumentModal btn btn-default"));}
             echo '&nbsp';
             if(!empty($data)) {
            echo $this->Html->link('Download',['controller'=>'previousPermits','action'=>'downloadAllFiles',$this->Encryption->encode($permitDetails->id),$this->Encryption->encode($accessPermits->id)],array('escape' => false,'title'=>'Download all forms and documents','class'=>"btn btn-default"));
             }
            ?> 
        </div>
        <div class="clearfix"></div>
        <div id="accordion" class="faq-wrap" role="tablist">
            <!-- accordion Card - Permit-Deadline -- START   -->
            <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                    <h5 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" href="#collapse-permit-deadline" aria-expanded="true" aria-controls="collapse-permit-deadline">Deadline</a>
                    </h5>
                </div>
                <div id="collapse-permit-deadline" class="collapse in" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class="table-responsive permit-deadline-block">
                    <?php echo $this->element('/frontend/permit/deadline_list',array('permitDeadlines'=>$permitDetails->deadlines,'userPermitDeadlines'=>$userPermitDeadlines)); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                    <h5 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" href="#collapse-document-list" aria-expanded="true" aria-controls="collapse-permit-deadline">Documents</a>
                    </h5>
                </div>
                <div id="collapse-document-list" class="collapse in" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class="table-responsive previous-permit-list-block">
                        <?php echo $this->element('frontend/previous_permit/previous_perimit_list'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('frontend/previous_permit/previous_permit_modal'); ?>
<?php echo $this->element('modal/attachment_view_modal'); ?>
<?php echo $this->element('modal/security_alert_modal'); ?>
<?php echo $this->element('frontend/permit/deadline_modal'); ?>
<?php echo $this->Html->script(['frontend/previous_permit']);?>
<?php echo $this->Html->script(['frontend/permit']);?>



