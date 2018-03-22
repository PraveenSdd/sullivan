<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>
    <div class="form-default clearfix">
        <h5><?= $this->Flash->render() ?></h5>
           <?php  echo $this->Form->create('Permits', array('url' => array('controller' => 'previousPermits', 'action' => 'add'),'id'=>'frmPreviousPermitAdd','type'=>'post','class'=>'form-horizontal')); ?>
        <?php echo $this->Form->hidden('id', array('data-id'=>$previousPermitDetail['permit']['id'],'value'=>$previousPermitDetail['permit']['id'],'class'=>'form-control inp-permit-name')) ?>

        <?php echo $this->Form->hidden('Operation.name', array('data-id'=>$previousPermitDetail['operation_id'],'value'=>'','class'=>'form-control inp-operation-name')) ?>
        <?php echo $this->Form->hidden('Location.name', array('data-id'=>$previousPermitDetail['user_location_id'],'value'=>'','class'=>'form-control inp-location-name')) ?>
        <?php echo $this->Form->hidden('user_permit_id', array('data-id'=>$previousPermitDetail['id'],'value'=>$previousPermitDetail['id'],'class'=>'form-control inp-user-permit-id')) ?>
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Permit Name:</label>
            <div class="col-sm-10">
                <?php
                                echo $this->Form->input('name', array(
                                    'placeholder' => 'Permit name',
                                    'class' => 'form-control inp-previous-permit-name padding-top-5',
                                    'label' => false,
                                    'maxlength' => 120,
                                    'data-id'=>$previousPermitDetail['permit']['id'],
                                    'value'=>$previousPermitDetail['permit']['name']
                                ));
                                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">Description:</label>
            <div class="col-sm-10">
                <?php
                                echo $this->Form->textarea('description', array(
                                    'placeholder' => 'Description',
                                    'class' => 'form-control description inp-previous-permit-description',
                                    'label' => 'false',
                                    'rows' => "5",
                                    'maxlength' => 160,
                                    'value'=>$previousPermitDetail['permit']['description']
                                ));
                                ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="pwd">Location:</label>
            <div class="col-sm-4">          
                <?php
                                echo $this->Form->input('location_id', array(
                                    'type' => 'select',
                                    'options' => $userLocationList,
                                    'empty' => 'Select Location',
                                    'label' => false,
                                    'class' => 'form-control inp-previous-permit-location sel-add-location',
                                    'data-add-count' => '1',
                                    'label' => false,
                                    'default'=>$previousPermitDetail['user_location_id']
                                ));
                                ?>
            </div>
            <label class="control-label col-sm-2" for="pwd">Operation:</label>
            <div class="col-sm-4">          
                <?php
                                echo $this->Form->input('operation_id', array(
                                    'type' => 'select',
                                    'options' => $userOperationList,
                                    'empty' => 'Select Operation',
                                    'label' => false,
                                    'class' => 'form-control inp-previous-permit-operation sel-add-operation',
                                    'data-add-count' => '1',
                                    'label' => false,
                                    'default'=>$previousPermitDetail['operation_id']
                                ));
                                ?>
            </div>
        </div>
        <div class="form-group">

        </div>
        <div class="form-group">   
            <label class="control-label col-sm-2"></label>
            <div class="col-sm-10">
                <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-default')); ?>
                 <?php echo $this->Html->link('Cancel', ['controller' => 'previousPermits', 'action' => 'index'], array('class' => 'btn btn-warning', 'escape' => false)); ?>

            </div>
        </div>
        <?php echo $this->Form->end();?>
        <hr>
        <div class="main-action-btn pull-right clearfix">
            <?php echo $this->Html->link('Upload Document','javascript:void(0);',array('escape' => false,'title'=>'edit', 'data-title'=>'Add Previous Permit Document','data-modal-title'=>'Add Previous Permit Document','data-permit-id'=>$previousPermitDetail['permit']['id'],'data-operation-id'=>$this->Encryption->decode($previousPermitDetail['operation_id']),'data-location-id'=>$this->Encryption->decode($previousPermitDetail['user_location_id']),'data-alert-date'=>'','data-alert-time'=>'','data-alert-type'=> '','data-user-permit-id'=>$previousPermitDetail['id'], 'data-alert-staff-id'=>'', 'class'=>"btnPreviousPermitDocumentModal btn btn-default"));
            ?> 
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="table-responsive previous-permit-list-block">
                <?php echo $this->element('frontend/previous_permit/previous_perimit_list'); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->element('frontend/previous_permit/previous_permit_modal'); ?>
<?php echo $this->element('modal/attachment_view_modal'); ?>
<?php echo $this->element('modal/security_alert_modal'); ?>
<?php echo $this->Html->script(['frontend/previous_permit']);?>