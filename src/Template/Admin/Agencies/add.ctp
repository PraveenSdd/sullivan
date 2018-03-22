<?php ?>

<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>                
                <?php echo $this->Form->create('Agency', array('url' => array('controller' => 'Agencies', 'action' => 'add'), 'id' => 'frmAgency', ' method' => 'post', 'class' => 'form-horizontal')); ?>
                <div class="col-md-12">
                    <div class="box-body">                    
                        <div class="row margin-top-15">
                            <div class="col-sm-6">
                                <label for="title" class=" control-label padding-top-20">Agency Name <span class="text-danger">*</span></label>
                                <?php
                                echo $this->Form->input('Agency.name', array(
                                    'placeholder' => 'Agency name',
                                    'class' => 'form-control inp-agency-name padding-top-5',
                                    'label' => false,
                                    'data-id' => '',
                                    'data-parentId' => '',
                                    'maxlength' => 120,
                                ));
                                ?>
                                <?php echo $this->Form->hidden('Agency.id', array('class' => 'inp-agency-id',)); ?>

                            </div>
                            <div class="col-sm-6">
                                <label for="title" class=" control-label">Address 1 <span class="text-danger">*</span></label>
                                <?php
                                echo $this->Form->textarea('Address.address1', array(
                                    'placeholder' => 'Address',
                                    'class' => 'form-control inp-agency-address inp-agency-address1',
                                    'rows' => "2",
                                    'maxlength' => 80,
                                    'label' => false,
                                ));
                                ?>

                            </div>
                        </div>
                        <div class="row  margin-top-15">
                            <div class="col-sm-6">
                                <label for="title" class=" control-label">Address 2 </label>
                                <?php
                                echo $this->Form->textarea('Address.address2', array(
                                    'placeholder' => 'Address',
                                    'class' => 'form-control inp-agency-address inp-agency-address2',
                                    'label' => 'false',
                                    'rows' => "2",
                                    'maxlength' => 80,
                                    'label' => false,
                                ));
                                ?>

                            </div>
                            <div class="col-sm-6">
                                <label for="" class=" control-label">City <span class="text-danger">*</span></label>
                                <?php
                                echo $this->Form->input('Address.city', array(
                                    'placeholder' => 'City',
                                    'class' => 'form-control ',
                                    'label' => 'false',
                                    'maxlength' => 40,
                                    'label' => false,
                                ));
                                ?>

                            </div>
                        </div>
                        <div class="row  margin-top-15">

                            <div class="col-sm-6">
                                <label for="" class=" control-label">State </label>
                                <?php
                                echo $this->Form->input('Address.state_id', array(
                                    'type' => 'select',
                                    'options' => $statesList,
                                    'empty' => 'Please select state',
                                    'label' => false,
                                    'class' => 'form-control inp-add-state sel-add-state',
                                    'data-add-count' => '1',
                                    'default' => 154,
                                    'label' => false,
                                ));
                                ?>

                            </div>
                            <div class="col-sm-6">
                                <label for="" class=" control-label">Zip Code <span class="text-danger">*</span></label>
                                <?php
                                echo $this->Form->input('Address.zipcode', array(
                                    'placeholder' => 'Zip Code',
                                    'class' => 'form-control ',
                                    'label' => 'false',
                                    'maxlength' => 10,
                                    'label' => false,
                                ));
                                ?>

                            </div>
                        </div>
                        
                        <div class="row margin-top-15">
                            <div class="col-sm-6">
                                <label for="title" class=" control-label padding-top-20">Description <span class="text-danger">*</span></label>
                                <?php
                                echo $this->Form->textarea('Agency.description', array(
                                    'placeholder' => 'Description',
                                    'class' => 'form-control inp-agency-description',
                                    'label' => 'false',
                                    'rows' => "3",
                                    'maxlength' => 160,
                                    'label' => false,
                                    ));
                                ?>
                            </div>
                        </div>
                        
                    </div>
                    <div class="box-footer button-form-sub text-right">
                        <?php echo $this->Html->link('Cancel', ['controller' => 'agencies', 'action' => 'index'], array('class' => 'btn btn-warning', 'escape' => false)); ?> &nbsp;&nbsp;
                        <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
                <?php echo $this->element('backend/agency/attributes_menus'); ?>

            </div>
        </div>
    </div>
</div>

<?php echo $this->Html->script(['backend/agency']); ?>




