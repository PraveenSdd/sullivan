<?php ?>

<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
<!-- form start -->
           <?php  echo $this->Form->create('Operations', array('url' => array('controller' => 'operations', 'action' => 'add'),'id'=>'operationId',' method'=>'post','class'=>'form-horizontal')); ?>

                <div class="col-md-12">
                    <div class="box-body">                    
                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">Operation Type<span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                         <?php echo $this->Form->input('name', array(
                                                  'placeholder'=>'Operation Type',
                                                  'class'=>'form-control inp-operation-name',
                                                  'label' => false,
                                                  'data-id'=>'',
                                                  'data-parentId'=>'',
                                                   'maxlength'=>120, 
                                                 ));  
                                              ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notes" class="col-sm-3 control-label">Notes </label>
                            <div class="col-sm-6">
                                 <?php echo $this->Form->textarea('description', array(
                                                  'placeholder'=>'Notes',
                                                  'class'=>'form-control inp-operation-description',
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
                                            <a href="javascript:void(0);" data-operationId=""  data-title="<?php echo 'Permit';?>" class="addOperationPermit  addicons ">Add Permit</a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="box-body view-permit-outer text-center">                    
                                <!-- Agency conatct person Block - START -->
                                <div class="row">
                                    <div class="col-sm-12 bg-primary clearfix text-center">
                                    </div>
                                </div>
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
                                            <a href="javascript:void(0);" data-operationId=""  data-title="<?php echo 'Alert';?>" class="addOperationAlert  addicons ">Add Alert</a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="box-footer button-form-sub">
                        <a href="/admin/operations" class="btn btn-warning">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-form-submit">Submit</button>

                    </div>

             <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
    <!-- modal Permit Deadlines for permit -->
<?php echo $this->element('backend/operation/add_alert'); ?>
<?php echo $this->element('backend/operation/add_permit'); ?>
</div>
    <?php echo $this->Html->script(['operation']);?>




