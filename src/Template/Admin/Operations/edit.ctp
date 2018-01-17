<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
<!-- form start -->
                 <?php  echo $this->Form->create('Operations', array('url' => array('controller' => 'operations', 'action' => 'edit'),'id'=>'operationId',' method'=>'post','class'=>'form-horizontal')); ?>
                <div class="col-md-12">
                    <div class="text-right">
                     <a  class="myalert-delete" data-url="/admin/operations/index" data-title="Industry" title="Delete" href="javasript:void();" data-id="<?php echo $operation->id?>" data-modelname="Industries"> <?php echo $this->Html->image("icons/delete.png"); ?> </a>
                    </div>
                    <div class="box-body">                    

                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">Operation Type<span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                         <?php echo $this->Form->input('name', array(
                                                  'placeholder'=>'Operation Type',
                                                  'class'=>'form-control inp-operation-name hide-ajax-loader',
                                                  'label' => false,
                                                  'data-id'=>$operation->id,
                                                  'value'=>$operation->name,
                                                   'maxlength'=>120, 
                                                 ));  
                                              ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notes" class="col-sm-3 control-label">Notes</label>
                            <div class="col-sm-6">
                                 <?php echo $this->Form->textarea('description', array(
                                                  'placeholder'=>'Notes',
                                                  'class'=>'form-control inp-operation-description',
                                                  'label' => 'false',
                                                   'rows'=>"5",
                                                    'value'=>$operation->description,
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
                            <h5 class="permitTitle">Permits & Alerts</h5>
                        </div>
                    </div>
                    <div class="box-body view-permit-outer text-center">                    
                        <!-- Agency conatct person Block - START -->
                        <div class="row ">
                            <div class="form-group">
                                <div class="col-sm-9">
                                    <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1" >Permits</a>
                                    <div id="collapse-1" class="collapse padding-top-10" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body permit-block">
                                           <?php echo $this->element('backend/operation/permit_list'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <a href="javascript:void(0);" data-operationId="<?=$operation->id?>"  data-title="<?php echo 'Permit';?>" class="addOperationPermit  addicons ">Add Permit</a>
                                </div>
                            </div>
                        </div>
            
                    </div>
                
                    <div class=" view-permit-outer text-center">  
                         <div class="row">
                        <div class="col-sm-12 bg-primary clearfix text-center">
                           
                        </div>
                    </div>
                        <!-- Agency conatct person Block - START -->
                        <div class="row padding-top-15">
                            <div class="form-group">
                                <div class="col-sm-9">
                                    <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-3" aria-expanded="true" aria-controls="collapse-3" >Alerts</a>
                                    <div id="collapse-3" class="collapse padding-top-10" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body operation-alert-block">
                                           <?php echo $this->element('backend/operation/alert_list'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <a href="javascript:void(0);" data-operationId="<?=$operation->id?>"  data-title="<?php echo 'Alert';?>" class="addOperationAlert  addicons ">Add Alert</a>
                                </div>
                            </div>
                        </div>
            
                    </div>
                
                </div>
                    <?php if(!empty($operation->id)){ echo $this->Form->hidden('id',['value'=>$operation->id]); } ?>
            </div>
                 <div class="box-footer button-form-sub">
                        <a href="/admin/operations" class="btn btn-warning">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-form-submit">Update</button>

                    </div>

             <?php echo $this->Form->end();?>
                      </div>
        </div>
    </div>
</div>
</div>

<!-- modal Permit Deadlines for permit -->
<?php echo $this->element('backend/operation/add_alert'); ?>
<?php echo $this->element('backend/operation/add_permit'); ?>

    <?php echo $this->Html->script(['operation']);?>




