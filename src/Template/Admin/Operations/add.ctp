<?php ?>

<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
<!-- form start -->
           <?php  echo $this->Form->create('Operations', array('url' => array('controller' => 'operations', 'action' => 'add'),'id'=>'frmOperation',' method'=>'post','class'=>'form-horizontal frmOperation')); ?>

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
                 <div class="box-footer button-form-sub text-right">
                        <a href="/admin/operations" class="btn btn-warning">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-form-submit">Submit</button>

                    </div>
                    </div>
             <?php echo $this->Form->end();?>
                             <?php echo $this->element('backend/operation/attributes_menus'); ?>

                </div>
            </div>
        </div>
    </div>
    <!-- modal Permit Deadlines for permit -->

</div>


