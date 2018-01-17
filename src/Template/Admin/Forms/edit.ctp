<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
<!-- general form elements -->
            <?php  echo $this->Form->create('Forms', array('url' => array('controller' => 'forms', 'action' => 'edit'),'id'=>'frmPermit',' method'=>'post','class'=>'form-horizontal frmPermit','enctype'=>'multipart/form-data')); ?>
                <div class="col-md-12">
                    <div class="text-right">
                            <?php echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>"/admin/forms/index", 'data-title'=>$form['title'],'data-modelname'=>'Forms','data-id'=> $form['id'],'class'=>"myalert-delete")); ?> 
                    </div>
                    <div class="box-body">                    

                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">Title <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                        <?php echo $this->Form->input('title', array(
                                                  'placeholder'=>'Tile',
                                                  'class'=>'form-control required title inp-permit-title',
                                                  'label' => false,
                                                  'data-id'=>$form['id'],
                                                  'data-parentId'=>'',
                                                'value'=>$form['title']
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
                                                     'value'=>$form['description']
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
                                                
                            <?php   if(empty($form['agencies']->toArray())){
                                 echo $this->Html->link('Add Agency','javascript:void(0);',array('escape' => false,'data-formId'=>($form) ? $form['id']:'', 'data-title'=>"Agencies", 'class'=>"permitAgency  addicons "));
                            }?> 
                                              
                                        </div>
                                    </div>
                                </div>
<!-- Permit Operation Block - START -->
                                <div class="row ">
                                    <div class="form-group">
                                        <div class="col-sm-9">
                                            <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-operation" aria-expanded="true" aria-controls="collapse-operation" >Related Operations</a>
                                            <div id="collapse-operation" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body permit-operation-block">
                                           <?php echo $this->element('backend/permit/operation_list'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                                                                      
                            <?php echo $this->Html->link('Add Operation','javascript:void(0);',array('escape' => false,'data-permitId'=>($form) ? $form['id']:'', 'data-title'=>"Operation", 'class'=>"permitOperation  addicons ")); ?> 
                                              
                                        </div>
                                    </div>
                                </div>

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
                                              <?php echo $this->Html->link('Add Forms','javascript:void(0);',array('escape' => false, 'data-title'=>"Permit Forms",'data-formId'=>($form) ? $form['id']:'', 'class'=>"permitFormsModel  addicons ")); ?> 
                                             
                                            
                                        </div>
                                    </div>
                                </div>
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
                                            <?php echo $this->Html->link('Add Documents','javascript:void(0);',array('escape' => false, 'data-title'=>"Documents", 'data-formId'=>($form) ? $form['id']:'','class'=>"permitAttachment  addicons ")); ?> 
                                            
                                        </div>
                                    </div>
                                </div>
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
                                            <?php echo $this->Html->link('Add Deadline','javascript:void(0);',array('escape' => false, 'data-title'=>"Permit Deadline", 'data-formId'=>($form) ? $form['id']:'','class'=>"permitDeadline  addicons ")); ?> 

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
                    <div class="box-footer button-form-sub">
                          <?php echo $this->Html->link('Cancel',['controller'=>'forms','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-primary')); ?>
                       

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
    <!-- modal operation form for permit -->
<?php echo $this->element('backend/permit_popup/add_operation'); ?>
    <!-- modal file forms for permit -->
<?php echo $this->element('backend/permit_popup/add_forms'); ?>
    <!--/Download forms--> 
    <?php echo $this->element('frontend/modal/download_view_form'); ?>
    <!-- modal add conatct person form -->
<?php echo $this->element('backend/agency/contact_person'); ?>
<?php echo $this->element('backend/agency/view_contact_person'); ?>
    </div>
<?php echo $this->Html->script(['category']);?>
</div>
<?php echo $this->Html->script(['forms','admin_permit']);?>



