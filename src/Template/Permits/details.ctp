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


        <?php echo $this->Form->hidden('UserPermit.id', array('data-id'=>$accessPermits->id,'data-id-ecrypt'=>$this->Encryption->decode($accessPermits->id),'value'=>'','class'=>'form-control inp-user-permit-id')) ?>
        <div class="main-action-btn pull-right clearfix">
            <?php if(!empty($permitDetails)) { 
            echo $this->Html->link('Alert','javascript:void(0);',array('escape' => false,'title'=>'edit', 'data-title'=>'Add Alert','data-modal-title'=>'Add Alert','data-alert-id'=>'','data-alert-title'=>'','data-alert-notes'=>'','data-alert-date'=>'','data-alert-time'=>'','data-alert-type'=> '','data-alert-permit-id'=>'', 'data-alert-staff-id'=>'', 'class'=>"btnPermitAlertModal btn btn-default"));
            echo '&nbsp&nbsp&nbsp';
            echo $this->Html->link('Download',['controller'=>'permits','action'=>'downloadAllFiles',$this->Encryption->encode($permitDetails->id),$this->Encryption->encode($accessPermits->id)],array('escape' => false,'title'=>'Download all forms and documents','class'=>"btn btn-default"));
            }
            ?> 
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <?php echo $this->element('frontend/permit/attributes_menus'); ?>
            </div>
        </div>
    </div>
</div>

<?php echo $this->Html->script(['frontend/permit']);?>



