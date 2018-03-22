<?php ?>
<div class="col-md-12">
    <div class="row">
        <div class="col-sm-12 bg-primary clearfix text-center">
            <h5 class="permitTitle">Details</h5>
            <p class="description"></p>
        </div>
    </div>
    <div class="box-body view-permit-outer text-center"> 

        <!-- Permit Agency Block - START -->
        <div class="row ">
            <div class="form-group">
                <div class="col-sm-9">
                    <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-permit-agency" aria-expanded="true" aria-controls="collapse-permit-agency" >Related Agency</a>
                    <div id="collapse-permit-agency" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body permit-agency-block">
                            <?php echo $this->element('backend/permit/agency_list'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <?php echo $this->Html->link('Add Agency', 'javascript:void(0);', array('escape' => false, 'data-title' => "Add Agency", 'data-agency-id' => '', 'data-agency-contact-id' => '', 'data-permit-agency-id' => '', 'data-modal-type' => 'add', 'class' => "btnPermitAgencyModal  addicons "));?> 

                </div>
            </div>
        </div>
    </div>
    <!-- Permit Agency Block - END -->

    <!-- Permit Operation Block - START -->
    <div class="box-body view-permit-outer text-center">      
        <div class="row">
            <div class="form-group ">
                <div class="col-sm-9">
                    <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-permit-operation" aria-expanded="true" aria-controls="collapse-permit-operation" >Related Operations</a>
                    <div id="collapse-permit-operation" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body permit-operation-block">
                            <?php echo $this->element('backend/permit/operation_list'); ?>
                        </div>
                    </div>
                </div>   
                <div class="col-sm-3">
                    <?php echo $this->Html->link('Add Operations', 'javascript:void(0);', array('escape' => false,'data-title'=>'Add Operation','data-operation-name'=>'','data-permit-operation-id'=> '','class'=>"btnPermitOperationModal addicons"));?>
                </div>
            </div>
        </div>
    </div>
    <!-- Permit Form Operation - END -->

    <!-- Permit Form Block - START -->
    <div class="box-body view-permit-outer text-center">      
        <div class="row">
            <div class="form-group ">
                <div class="col-sm-9">
                    <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-permit-form" aria-expanded="true" aria-controls="collapse-permit-form" >Related Forms</a>
                    <div id="collapse-permit-form" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body permit-form-block">
                            <?php echo $this->element('backend/permit/form_list'); ?>
                        </div>
                    </div>
                </div>   
                <div class="col-sm-3">
                    <?php echo $this->Html->link('Add Forms', 'javascript:void(0);', array('escape' => false,'data-title'=>'Add Form','data-permit-form-name'=>'','data-permit-form-id'=> '','class'=>"btnPermitFormModal addicons"));?>
                </div>
            </div>
        </div>
    </div>
    <!-- Permit Form Block - END -->

    <!-- Permit instruction Block - START -->
    <div class="box-body view-permit-outer text-center"> 
        <div class="row">
            <div class="form-group ">
                <div class="col-sm-9 ">
                    <a  class="collapsed control-label hadding" data-toggle="collapse" href="#collapse-permit-instruction" aria-expanded="true" aria-controls="collapse-permit-instruction" >Related Instruction Documents</a>
                    <div id="collapse-permit-instruction" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body permit-instruction-block">
                            <?php echo $this->element('backend/permit/instruction_list'); ?>
                        </div>
                    </div>
                </div> 
                <div class="col-sm-3">
                    <?php echo $this->Html->link('Add Instruction Document', 'javascript:void(0);', array('escape' => false, 'data-title' => "Add Instruction Document", 'data-permit-instruction-id' => '','data-permit-instruction-name' => '', 'class' => "btnPermitInstructionModal addicons"));
                    ?>                                           
                </div>
            </div>
        </div>
    </div>
    <!-- Permit instruction Block - END -->

    <!-- Permit Document Block - START -->
    <div class="box-body view-permit-outer text-center">  
        <div class="row">
            <div class="form-group ">
                <div class="col-sm-9">
                    <a  class="collapsed control-label hadding" data-toggle="collapse" href="#collapse-permit-document" aria-expanded="true" aria-controls="collapse-permit-document" >Related Documents</a>
                    <div id="collapse-permit-document" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body permit-document-block">
                            <?php echo $this->element('backend/permit/document_list'); ?>
                        </div>
                    </div>
                </div> 
                <div class="col-sm-3">
                    <?php echo $this->Html->link('Add Documents', 'javascript:void(0);', array('escape' => false,'data-title'=>'Add Document','data-permit-document-name'=>'','data-permit-document-id'=> '','data-permit-document-is-mandatory'=> '0','class'=>"btnPermitDocumentModal addicons"));?>
                </div>
            </div>
        </div>
    </div>
    <!-- Permit Document Block - END -->

    <!-- Permit Deadline Block - START -->
    <div class="box-body view-permit-outer text-center">  
        <div class="row">
            <div class="form-group ">
                <div class="col-sm-9">
                    <a  class="collapsed control-label hadding" data-toggle="collapse" href="#collapse-permit-deadline" aria-expanded="true" aria-controls="collapse-permit-deadline" >Overall Deadline</a>
                    <div id="collapse-permit-deadline" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body permit-deadline-block">
                            <?php echo $this->element('backend/permit/deadline_list'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <?php 
                    if(!empty($permitDeadline)){
                        echo $this->Html->link('Edit Deadline', 'javascript:void(0);', array(
                        'escape' => false,'title'=>'Edit Deadline','data-title'=>'Edit Deadline','data-deadline-id'=>$permitDeadline['id'],'data-deadline-date'=> $permitDeadline['date'],'data-deadline-time'=> $permitDeadline['time'], 'class' => "btnPermitDeadlineModal addicons"));
                    }else{
                        echo $this->Html->link('Add Deadline', 'javascript:void(0);', array(
                        'escape' => false,'title'=>'Add Deadline','data-title'=>'Add Deadline','data-deadline-id'=>'','data-deadline-date'=> '','data-deadline-time'=> '', 'class' => "btnPermitDeadlineModal addicons"));
                    }
                 ?> 
                </div>
            </div> 
        </div>
    </div>      
    <!-- Permit Deadline Block - END -->

    <!-- Permit Alert Block - START -->
    <div class="box-body view-permit-outer text-center"> 
        <div class="row">
            <div class="form-group ">
                <div class="col-sm-9">
                    <a  class="collapsed control-label hadding" data-toggle="collapse" href="#collapse-permit-alert" aria-expanded="true" aria-controls="collapse-permit-alert" >Overall Alert</a>
                    <div id="collapse-permit-alert" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body permit-alert-block">
                            <?php echo $this->element('backend/permit/alert_list'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <?php echo $this->Html->link('Add Alert', 'javascript:void(0);', array('escape' => false, 'data-title' => "Add Alert",'data-alert-id'=>'','data-alert-title'=>'','data-alert-notes'=>'','data-alert-date'=>'','data-alert-time'=>'','data-alert-type'=> '','data-alert-permit-id'=>'', 'data-alert-staff-id'=>'', 'data-alert-company-id'=>'', 'data-alert-operation-id'=>'',  'class' => "btnPermitAlertModal  addicons "));?> 
                </div>
            </div> 
        </div>
    </div>
    <!-- Permit Alert Block - END -->


</div>
<style>
    .tbl-border-bottom{border-bottom: 1px solid #ddd;}
</style>
<!-- Agency Modal -->
<?php echo $this->element('backend/permit/agency_modal'); ?>
<!-- View-Agency-Contact-Person Modal -->
<?php echo $this->element('backend/agency/view_contact_person_modal'); ?>
<!-- Operation Modal -->
<?php echo $this->element('backend/permit/operation_modal'); ?>
<!-- Form Modal -->
<?php echo $this->element('backend/permit/form_modal'); ?>
<!-- Instruction Modal -->
<?php echo $this->element('backend/permit/instruction_modal'); ?>
<!-- Document Modal -->
<?php echo $this->element('backend/permit/document_modal'); ?>
<!-- Add New Document Modal -->
<?php echo $this->element('backend/permit/document_add_modal'); ?>
<!-- Deadline Modal -->
<?php echo $this->element('backend/permit/deadline_modal'); ?>
<!-- Deadline Modal -->
<?php echo $this->element('backend/permit/alert_modal'); ?>

<!--/Download forms--> 
<?php echo $this->element('modal/attachment_view_modal'); ?>

