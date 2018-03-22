<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>     
                <!-- general form elements -->

                <div class="col-md-12">
                    <div class="text-right">
                            <?php if($subAdminDelete ==1 ){ 
                                echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($permits->id)],['data'=>['model_name'=>'Permits','module_name'=>'Permit','table_name'=>'permits','title'=>$permits->name,'redirect_url'=>"/admin/permits/index",'foreignId'=>'','subModel'=>''], 'escape'=>false, 'class'=>'deleteConfirm']);
                            } ?> 
                    </div>
                    <?php echo $this->Form->create('Permits', array('url' => array('controller' => 'Permits', 'action' => 'edit',$permitId), 'id' => 'frmPermit', ' method' => 'post', 'class' => 'form-horizontal frmPermit', 'enctype' => 'multipart/form-data')); ?>
                    <div class="box-body">                    
                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">Permit Name <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <?php
                                echo $this->Form->input('Permit.name', array(
                                    'placeholder' => 'Permit name',
                                    'class' => 'form-control inp-permit-name padding-top-5',
                                    'label' => false,
                                    'data-parentId' => '',
                                    'data-id' => $permits->id,
                                    'maxlength' => 120,
                                    'value'=>$permits->name,
                                ));
                                ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-6">
                                <?php
                                echo $this->Form->textarea('Permit.description', array(
                                    'placeholder' => 'Description',
                                    'class' => 'form-control description inp-permit-description',
                                    'label' => 'false',
                                    'rows' => "5",
                                    'maxlength' => 160,
                                    'value'=>$permits->description,
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="box-footer button-form-sub text-right">
                            <?php echo $this->Html->link('Cancel', ['controller' => 'permits', 'action' => 'index'], array('class' => 'btn btn-warning', 'escape' => false)); ?> &nbsp;&nbsp;
                            <?php echo $this->Form->button('Update', array('type' => 'submit', 'class' => 'btn btn-primary')); ?>

                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>

                <?php echo $this->element('backend/permit/attributes_menus'); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Html->script(['backend/permit']); ?>




