<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>     
                <!-- general form elements -->
                <?php echo $this->Form->create('Permits', array('url' => array('controller' => 'Permits', 'action' => 'add'), 'id' => 'frmPermit', ' method' => 'post', 'class' => 'form-horizontal frmPermit', 'enctype' => 'multipart/form-data')); ?>
                <div class="col-md-12">
                    <div class="box-body">                    
                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">Permit Name <span class="text-danger">*</span></label>
                            <div class="col-sm-6">
                                <?php
                                echo $this->Form->input('Permit.name', array(
                                    'placeholder' => 'Permit name',
                                    'class' => 'form-control inp-permit-name padding-top-5',
                                    'label' => false,
                                    'data-id' => '',
                                    'data-parentId' => '',
                                    'maxlength' => 120,
                                ));
                                ?>
                                <?php echo $this->Form->hidden('Permit.id', array('class' => 'inp-permit-id')); ?>
                               
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
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="box-footer button-form-sub text-right">
                            <?php echo $this->Html->link('Cancel', ['controller' => 'permits', 'action' => 'index'], array('class' => 'btn btn-warning', 'escape' => false)); ?> &nbsp;&nbsp;
                            <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-primary')); ?>

                        </div>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
                <?php echo $this->element('backend/permit/attributes_menus'); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Html->script(['backend/permit']); ?>




