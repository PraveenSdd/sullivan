<?php ?>
<!-- accordion -- START   -->
<div id="accordion" class="faq-wrap" role="tablist">



    <!-- accordion Card - Permit-Agency -- START   -->
    <div class="card">
        <div class="card-header" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapse-permit-agency" aria-expanded="true" aria-controls="collapse-permit-agency">Agency Details</a>
            </h5>
        </div>
        <div id="collapse-permit-agency" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <div class="table-responsive permit-agency-block">
                    <?php echo $this->element('/frontend/permit/agency_list',array('permitAgencies'=>$permitDetails->permit_agency)); ?>
                </div>
            </div>
        </div>
    </div>


    <!-- accordion Card - Permit-Agency -- END   -->

    <!-- accordion Card - Permit-Form -- START   -->
    <div class="card">
        <div class="card-header" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapse-permit-form" aria-expanded="true" aria-controls="collapse-permit-form">Forms</a>
            </h5>
        </div>
        <div id="collapse-permit-form" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <div class="table-responsive permit-form-block">
                    <?php echo $this->element('/frontend/permit/form_list',array('permitForms'=>$permitDetails->permit_forms,'permitId'=>$permitDetails->id,'userPermitId'=>$accessPermits->id)); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- accordion Card - Permit-Form -- END   -->

    <!-- accordion Card - Permit-Document -- START   -->
    <div class="card">
        <div class="card-header" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapse-permit-document" aria-expanded="true" aria-controls="collapse-permit-document">Documents</a>
            </h5>
        </div>
        <div id="collapse-permit-document" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <div class="table-responsive  permit-document-block">
                <?php echo $this->element('/frontend/permit/document_list',array('permitDocuments'=>$permitDetails->permit_documents,'permitId'=>$permitDetails->id,'userPermitId'=>$accessPermits->id)); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- accordion Card - Permit-Document -- END   -->

    <!-- accordion Card - Permit-Instruction -- START   -->
    <div class="card">
        <div class="card-header" role="tab" id="headingOne">
            <h5 class="mb-0">
                <a class="collapsed" data-toggle="collapse" href="#collapse-permit-instruction" aria-expanded="true" aria-controls="collapse-permit-instruction">Instructions</a>
            </h5>
        </div>
        <div id="collapse-permit-instruction" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <div class="table-responsive permit-instruction-block">
                    <?php echo $this->element('/frontend/permit/instruction_list',array('permitInstructions'=>$permitDetails->permit_instructions)); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- accordion Card - Permit-Instruction -- END   -->

    <!-- accordion Card - Permit-Deadline -- START   -->
    <div class="card">
        <div class="card-header" role="tab" id="headingOne">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" href="#collapse-permit-deadline" aria-expanded="true" aria-controls="collapse-permit-deadline">Deadline</a>
                    </h5>
                </div>
                <?php 
                if(empty($userPermitDeadlines)){?>
                    <div class="col-md-6 text-right">
                        <?php echo $this->Html->link('Deadline','javascript:void(0);',array('escape' => false,'title'=>'edit', 'data-title'=>'Add Alert','data-modal-title'=>'Add Deadline','data-deadline-id'=>'','data-deadline-date'=>'','data-deadline-time'=>'','data-deadline-type'=> '','data-deadline-permit-id'=>'', 'data-deadline-form-id'=>'','data-renewable-value'=>0, 'data-deadline-document-id'=>'', 'class'=>"btnPermitDeadlineModal btn btn-default"));?>
                    </div>
                <?php }?>
            </div>
        </div>
        <div id="collapse-permit-deadline" class="collapse in" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
            <div class="card-body">
                <div class="table-responsive permit-deadline-block">
                    <?php echo $this->element('/frontend/permit/deadline_list',array('permitDeadlines'=>$permitDetails->deadlines,'userPermitDeadlines'=>$userPermitDeadlines)); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- accordion Card - Permit-Deadline -- END   -->

</div>
<!-- accordion -- END   -->


<!--/Download forms--> 
<?php echo $this->element('modal/attachment_view_modal'); ?>
<!--/Security Type Modal--> 
<?php echo $this->element('modal/security_alert_modal'); ?>
<!-- Alert Modal -->
<?php echo $this->element('frontend/permit/alert_modal'); ?>
<!-- Form Modal -->
<?php echo $this->element('frontend/permit/form_modal'); ?>
<!-- Document Modal -->
<?php echo $this->element('frontend/permit/document_modal'); ?>
<!-- Instruction Modal -->
<?php echo $this->element('frontend/permit/instruction_modal'); ?>
<!-- Deadline Modal -->
<?php echo $this->element('frontend/permit/deadline_modal'); ?>

