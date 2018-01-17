<?php ?>
<div class="row ">
    <h5 class="msg"><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border padding-top-10">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12 bg-primary clearfix text-center">
                            <h3> <?php echo ucfirst($form['title']);?></h3>
                            <p><?php echo ucfirst($form['description']);?></p>
                        </div>
                    </div>
                    <div class="box-body view-permit-outer text-center">                    
                        <!-- Permit Agency Block - START -->
                        <div class="row ">
                            <div class="form-group">
                                <div class="col-sm-9">
                                    <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1" >Related Agency</a>
                                    <div id="collapse-1" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body permit-agency-block">
                                           <?php echo $this->element('backend/permit/agency_list'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">

                            <?php echo $this->Html->link('Add Agency','javascript:void(0);',array('escape' => false,'data-formId'=>($form) ? $form['id']:'', 'data-title'=>"Agencies", 'class'=>"permitAgency  addicons ")); ?> 
                                </div>
                            </div>
                        </div>
                        <!-- Permit Agency Block - END -->
                        <!-- Permit Document/Form Block - START -->
                        <div class="row">
                            <div class="form-group padding-top-10">
                                <div class="col-sm-9">
                                    <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-2" aria-expanded="true" aria-controls="collapse-2" >Related Forms</a>
                                    <div id="collapse-2" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body permit-document-block">
                                            <?php echo $this->element('backend/permit/forms_list'); ?>

                                        </div>
                                    </div>
                                </div>   
                                <div class="col-sm-3">
                                    <?php echo $this->Html->link('Add Forms','javascript:void(0);',array('escape' => false, 'data-title'=>"Permit Forms",'data-formId'=>($form) ? $form['id']:'', 'class'=>"permitFormsModel  addicons ")); ?> 
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- Permit Document/Form Block - END -->
                        <!-- Permit Attachment Block - START -->
                        <div class="row">
                            <div class="form-group padding-top-10">
                                <div class="col-sm-9">
                                    <a  class="collapsed control-label hadding" data-toggle="collapse" href="#collapse-3" aria-expanded="true" aria-controls="collapse-3" >Related Documents</a>
                                    <div id="collapse-3" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body permit-attachment-block">
                                            <?php echo $this->element('backend/permit/documents_list'); ?>

                                        </div>
                                    </div>
                                </div> 
                                <div class="col-sm-3">
                                    <?php echo $this->Html->link('Add Documents','javascript:void(0);',array('escape' => false, 'data-title'=>"Documents", 'data-formId'=>($form) ? $form['id']:'','class'=>"permitAttachment  addicons ")); ?> 
                                </div>
                            </div>
                        </div>
                        <!-- Permit Attachment Block - END -->
                        <!-- Permit Deadline Block - START -->
                        <div class="row">
                            <div class="form-group padding-top-10">
                                <div class="col-sm-9">
                                    <a  class="collapsed control-label hadding" data-toggle="collapse" href="#collapse-4" aria-expanded="true" aria-controls="collapse-4" >Overall Deadline</a>
                                    <div id="collapse-4" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body permit-deadline-block">
                                            <?php echo $this->element('backend/permit/deadline_list'); ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                             <?php echo $this->Html->link('Add Deadline','javascript:void(0);',array('escape' => false, 'data-title'=>"Permit Deadline", 'data-formId'=>($form) ? $form['id']:'','class'=>"permitDeadline  addicons ")); ?> 

                                </div>
                            </div> 
                        </div>
                        <!-- Permit Deadline Block - END -->
                        <!-- Permit Alert Block - START -->
                        <div class="row">
                            <div class="form-group padding-top-10">
                                <div class="col-sm-9">
                                    <a  class="collapsed control-label hadding" data-toggle="collapse" href="#collapse-5" aria-expanded="true" aria-controls="collapse-5" >Overall Alert</a>
                                    <div id="collapse-5" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body permit-alert-block">
                                        <?php echo $this->element('backend/permit/alerts_list'); ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                              <?php echo $this->Html->link('Add Alert','javascript:void(0);',array('escape' => false, 'data-title'=>"Permit Alert", 'data-formId'=>($form) ? $form['id']:'','class'=>"permitAlert  addicons ")); ?> 

                                </div>
                            </div> 
                        </div>
                        <!-- Permit Alert Block - END -->
                    </div>
                   <div class="row padding-top-10">
                                <div class="col-sm-12 bg-primary clearfix text-center"> "How To" Documents </div>
                                <div class="row  view-permit-outer text-center">                    
                                    <!-- Permit Agency Block - START -->
                                    <div class="form-group ">
                                        <div class="col-sm-9 ">
                                            <a  class="collapsed control-label hadding" data-toggle="collapse" href="#collapse-6" aria-expanded="true" aria-controls="collapse-6" >Related Documents</a>
                                            <div id="collapse-6" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body permit-instruction-block">
                                                    <?php echo $this->element('backend/permit/permit_instruction_list'); ?>
                                                </div>
                                            </div>

                                        </div> 
                                        <div class="col-sm-3">
                                             <?php echo $this->Html->link('Add Instruction Document','javascript:void(0);',array('escape' => false, 'data-title'=>"Instruction Document", 'data-formId'=>($form) ? $form['id']:'','class'=>"PermiInstruction addicons")); ?>                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal Permit Deadlines for permit -->
<?php echo $this->element('backend/permit_popup/add_deadline'); ?>
<?php echo $this->element('backend/permit_popup/add_alert'); ?>
<?php echo $this->element('backend/permit_popup/add_documents'); ?>

<!--/modal default end--> 


<!-- modal add agency for permit -->
<?php echo $this->element('backend/permit_popup/add_agency'); ?>
<!--/modal default end--> 

<!-- modal Permit forms for permit -->
<?php echo $this->element('backend/permit_popup/add_forms'); ?>
<!--/modal default end--> 
    <?php echo $this->Html->script(['forms','admin_permit','datepicker/timepicker','datepicker/bootstrap-datepicker']);?>
    <?php echo $this->element('frontend/modal/download_view_form'); ?>



