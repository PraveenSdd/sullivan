<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>     
                <!-- general form elements -->
            <?php  echo $this->Form->create('Forms', array('url' => array('controller' => 'forms', 'action' => 'permit'),'id'=>'frmPermit',' method'=>'post','class'=>'form-horizontal frmPermit','enctype'=>'multipart/form-data')); ?>
                <div class="col-md-12">
                    <div class="box-body">                    
                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">Title <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                        <?php echo $this->Form->input('title', array(
                                                  'placeholder'=>'Tile',
                                                  'class'=>'form-control required title inp-permit-title',
                                                  'label' => false,
                                                    'id'=>'title',
                                                  'data-id'=>'',
                                                  'data-parentId'=>'',
                                                   'maxlength'=>120,
                                                  
                                                 ));  
                                              ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-6">
                                <?php echo $this->Form->textarea('description', array(
                                                  'placeholder'=>'Description',
                                                  'class'=>'form-control description inp-permit-description',
                                                  'label' => 'false',
                                                    'rows'=>"5",
                                                      'maxlength'=>160,
                                                 ));  
                                              ?>
                            </div>
                        </div>

                    </div>


                    <div class="box-header with-border ">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-sm-12 bg-primary clearfix text-center">
                                    <h3 class="permitTitle"></h3>
                                    <p class="description"></p>
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
                                     <?php  if($subAdminAdd ==1 ){ echo $this->Html->link('Add Agency','javascript:void(0);',array('escape' => false, 'data-title'=>"Agencies", 'class'=>"permitAgency  addicons "));  }?> 

                                        </div>
                                    </div>
                                </div>
                                <!-- Permit Agency Block - END -->
                                <!-- Permit Document/Form Block - START -->
                                <div class="row">
                                    <div class="form-group ">
                                        <div class="col-sm-9">
                                            <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-2" aria-expanded="true" aria-controls="collapse-2" >Related Forms</a>
                                            <div id="collapse-2" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body permit-document-block">
                                            <?php echo $this->element('backend/permit/forms_list'); ?>

                                                </div>
                                            </div>
                                        </div>   
                                        <div class="col-sm-3">
                                     <?php  if($subAdminAdd ==1 ){ echo $this->Html->link('Add Forms','javascript:void(0);',array('escape' => false, 'data-title'=>"Permit Forms", 'class'=>"permitFormsModel  addicons ")); } ?> 

                                        </div>
                                    </div>
                                </div>
                                <!-- Permit Document/Form Block - END -->
                                <!-- Permit Attachment Block - START -->
                                <div class="row">
                                    <div class="form-group ">
                                        <div class="col-sm-9">
                                            <a  class="collapsed control-label hadding" data-toggle="collapse" href="#collapse-3" aria-expanded="true" aria-controls="collapse-3" >Related Documents</a>
                                            <div id="collapse-3" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body permit-attachment-block">
                                            <?php echo $this->element('backend/permit/documents_list'); ?>

                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-sm-3">
                                    <?php  if($subAdminAdd ==1 ){ echo $this->Html->link('Add Documents','javascript:void(0);',
                                            array('escape' => false,
                                                'data-title'=>"Documents",
                                                'class'=>"permitAttachment addicons")
                                    );  }?> 

                                        </div>
                                    </div>
                                </div>
                                <!-- Permit Attachment Block - END -->
                                <!-- Permit Deadline Block - START -->
                                <div class="row">
                                    <div class="form-group ">
                                        <div class="col-sm-9">
                                            <a  class="collapsed control-label hadding" data-toggle="collapse" href="#collapse-4" aria-expanded="true" aria-controls="collapse-4" >Overall Deadline</a>
                                            <div id="collapse-4" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body permit-deadline-block">
                                            <?php echo $this->element('backend/permit/deadline_list'); ?>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                 <?php  if($subAdminAdd ==1 ){ echo $this->Html->link('Add Deadline','javascript:void(0);',array('escape' => false, 'data-title'=>"Permit Deadline", 'class'=>"permitDeadline  addicons ")); } ?> 

                                        </div>
                                    </div> 
                                </div>
                                <!-- Permit Deadline Block - END -->
                                <!-- Permit Alert Block - START -->
                                <div class="row">
                                    <div class="form-group ">
                                        <div class="col-sm-9">
                                            <a  class="collapsed control-label hadding" data-toggle="collapse" href="#collapse-5" aria-expanded="true" aria-controls="collapse-5" >Overall Alert</a>
                                            <div id="collapse-5" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body permit-alert-block">
                                        <?php echo $this->element('backend/permit/alerts_list'); ?>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                <?php  if($subAdminAdd ==1 ){ echo $this->Html->link('Add Alert','javascript:void(0);',array('data-formId'=>(@$form)? $form['id']:'','escape' => false, 'data-title'=>"Permit Alert", 'class'=>"permitAlert  addicons ")); }?> 
                                        </div>
                                    </div> 
                                </div>
                                <!-- Permit Alert Block - END -->

                                <!-- Permit instruction Block - START -->
                                <div class="form-group ">
                                    <div class="col-sm-9 ">
                                        <a  class="collapsed control-label hadding" data-toggle="collapse" href="#collapse-6" aria-expanded="true" aria-controls="collapse-6" >Related Instruction</a>
                                        <div id="collapse-6" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body permit-instruction-block">
                                                    <?php echo $this->element('backend/permit/permit_instruction_list'); ?>
                                            </div>
                                        </div>

                                    </div> 
                                    <div class="col-sm-3">
                                             <?php if($subAdminAdd ==1 ){ echo $this->Html->link('Add Instruction Document','javascript:void(0);',array('escape' => false, 'data-title'=>"Instruction Document", 'data-formId'=>'','class'=>"PermiInstruction addicons")); } ?>                                           
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="box-footer button-form-sub">
                        <?php echo $this->Html->link('Cancel',['controller'=>'forms','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-primary')); ?>

                        </div>

             <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>


        <!-- modal Deadlines form for the permit -->
<?php echo $this->element('backend/permit_popup/add_deadline'); ?>
        <!-- modal alert form for the permit -->
<?php echo $this->element('backend/permit_popup/add_alert'); ?>
        <!-- modal document for the permit -->
<?php echo $this->element('backend/permit_popup/add_documents'); ?>
        <!-- modal Instruction for the permit -->
<?php echo $this->element('backend/permit_popup/add_permit_instruction'); ?>
        <!-- modal agency form for permit -->
<?php echo $this->element('backend/permit_popup/add_agency'); ?>
        <!-- modal file forms for permit -->
<?php echo $this->element('backend/permit_popup/add_forms'); ?>
        <!--/Download forms--> 
    <?php echo $this->element('frontend/modal/download_view_form'); ?>
    </div>

<?php echo $this->Html->script(['forms','admin_permit']);?>




