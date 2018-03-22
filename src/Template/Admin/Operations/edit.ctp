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

                <div class="col-md-12">
                    <?php if($LoggedPermissionId !=3) {?>
                    <div class="text-right">
                     <?php echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($operation->id)],['data'=>['model_name'=>'Operations','module_name'=>'Operation','table_name'=>'operations','title'=>htmlentities($operation->name),'redirect_url'=>"/admin/operations/index",'foreignId'=>'','subModel'=>''], 'escape'=>false, 'class'=>'deleteConfirm']);?>
                    </div>
                    <?php } ?>
                    <?php  echo $this->Form->create('Operations', array('url' => array('controller' => 'operations', 'action' => 'edit',$operationId),'id'=>'frmOperation',' method'=>'post','class'=>'form-horizontal frmOperation')); ?>
                    <div class="box-body">                    
                        <input type="hidden" name="id" value="<?php echo $operation->id ?>">
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
                    <div class="box-footer button-form-sub text-right">
                        <a href="/admin/operations" class="btn btn-warning">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-form-submit">Update</button>
                    </div>
             <?php echo $this->Form->end();?>
         <?php echo $this->element('backend/operation/attributes_menus'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

