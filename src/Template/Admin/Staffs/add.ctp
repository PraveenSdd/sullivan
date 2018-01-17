<?php ?>

<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
                <!-- general form elements -->
           <?php  echo $this->Form->create('Staff', array('url' => array('controller' => 'staffs', 'action' => 'add'),'id'=>'addStaff',' method'=>'post','class'=>'form-horizontal')); ?>
                <div class="col-md-12">
                    <div class="box-body">                    

                        <div class="row padding-top-5">
                            <div class="col-sm-6">
                                <label for="title" class=" control-label">First Name <span class="text-danger">*</span></label>
                                 <?php echo $this->Form->input(
                                'first_name', array(
                                'placeholder'=>'First Name',
                                'class'=>'form-control required',
                                'label' => false,
                                    'maxlength'=>40,
                               ));  
                            ?>

                            </div>
                            <div class="col-sm-6">
                                <label for="title" class=" control-label">Last Name </label>
                                <?php echo $this->Form->input(
                                'last_name', array(
                                'placeholder'=>'Last Name',
                                'class'=>'form-control',
                                'label' => false,
                                    'maxlength'=>40,
                               ));  
                            ?>

                            </div>
                        </div>
                        <div class="row padding-top-5">
                            <div class="col-sm-6">
                                <label for="title" class=" control-label">Email <span class="text-danger">*</span></label>
                                <?php echo $this->Form->input(
                                'email', array(
                                'placeholder'=>'Email',
                                'class'=>'form-control required',
                                'label' => false,
                                'data-id'=>'',
                                'data-parentId'=>'',
                                    'maxlength'=>40,
                               ));  
                            ?>

                            </div>
                            <div class="col-sm-6">

                                <div class="phone-block padding-top-5" >
                                    <label>Phone Number <span class="text-danger">*</span></label>
                                     <?php echo $this->Form->input('phone', array(
                                                'placeholder'=>'Phone number ',
                                                'class'=>'form-control inp-phone inp-address_phone' ,
                                                'label' => false,
                                                'div'=>false,
                                                'legend' => false
                                                 ));  
                                    ?>
                                </div>
                                <div class="phone-extension-block padding-top-5">
                                    <label> Extension </label>

                                    <?php echo $this->Form->input('phone_extension', array(
                                                'class'=>'form-control phone-extension-address inp-add_address-country_code',
                                                'id'=>'phone_extension',
                                                 'placeholder'=>'Extension ',
                                                 'maxlength'=>4,
                                                'div'=>false,
                                                'legend' => false,
                                        'label' => false,
                                                 ));  
                                              ?>
                                </div>

                            </div>
                        </div>
                        <div class="row padding-top-5">
                            <div class="col-sm-6">
                                <label for="title" class=" control-label">Position <span class="text-danger">*</span></label>
                                 <?php echo $this->Form->input(
                                'position', array(
                                'placeholder'=>'Position',
                                'class'=>'form-control required',
                                'label' => false,
                                'maxlength'=>40,
                               ));  
                            ?>

                            </div>
                            <div class="col-sm-6">
                                <label for="title" class=" control-label">Level<span class="text-danger">*</span> </label>
                                <?php 
                                    echo $this->Form->input('permission_id', array(
                                       'type' => 'select',
                                       'options' => $permissionsList,
                                        'empty'=>'Please select level',
                                        'label' => false,
                                        'class'=> 'form-control inp-add-state sel-add-state',
                                        
                                        'label' => false,

                                        ));
                                ?>

                            </div>
                        </div>

                        <div class="row padding-top-5">
                            <div class="col-sm-6">
                                <label for="title" class=" control-label">Address <span class="text-danger">*</span></label>
                                <?php echo $this->Form->textarea('Address.address1', array(
                                        'placeholder'=>'Address',
                                        'class'=>'form-control inp-agency-description',
                                        'label' => 'false',
                                        'rows'=>"2",
                                         'maxlength'=>80, 
                                         'label' => false,

                                       ));  
                                    ?>

                            </div>
                            <div class="col-sm-6">
                                <label for="title" class=" control-label">Address2 </label>
                                <?php echo $this->Form->textarea('Address.address2', array(
                                        'placeholder'=>'Address',
                                        'class'=>'form-control inp-agency-description',
                                        'label' => 'false',
                                        'rows'=>"2",
                                         'maxlength'=>80, 
                                         'label' => false,

                                       ));  
                                    ?>

                            </div>
                        </div>

                        <div class="row padding-top-5">
                            <div class="col-sm-6">
                                <label for="" class=" control-label">City <span class="text-danger">*</span></label>
                                <?php echo $this->Form->input('Address.city', array(
                                        'placeholder'=>'City',
                                        'class'=>'form-control ',
                                        'label' => 'false',
                                         'maxlength'=>40,
                                         'label' => false,

                                       ));  
                                    ?>

                            </div>
                            <div class="col-sm-6">
                                <label for="" class=" control-label">State </label>
                                <?php 
                                    echo $this->Form->input('Address.state_id', array(
                                       'type' => 'select',
                                       'options' => $statesList,
                                        'empty'=>'Please select state',
                                        'label' => false,
                                        'class'=> 'form-control inp-add-state sel-add-state',
                                        'data-add-count'=>'1',
                                         'default'=>154,
                                        'label' => false,

                                        ));
                                ?>

                            </div>
                        </div>

                        <div class="row padding-top-5">
                            <div class="col-sm-6">
                                <label for="" class=" control-label">Zip Code <span class="text-danger">*</span></label>
                                <?php echo $this->Form->input('Address.zipcode', array(
                                        'placeholder'=>'Zip Code',
                                        'class'=>'form-control ',
                                        'label' => 'false',
                                         'maxlength'=>10, 
                                         'label' => false,

                                       ));  
                                    ?>

                            </div>
                            <div class="col-sm-6">

                                <div class="phone-block padding-top-5" >
                                    <label>Phone Number </label>
                                     <?php echo $this->Form->input('Address.phone', array(
                                                'placeholder'=>'Phone number ',
                                                'class'=>'form-control inp-phone inp-address_phone' ,
                                                'label' => false,
                                                'div'=>false,
                                                'legend' => false
                                                 ));  
                                    ?>
                                </div>
                                <div class="phone-extension-block padding-top-5">
                                    <label> Extension </label>

                                    <?php echo $this->Form->input('Address.phone_extension', array(
                                                'class'=>'form-control phone-extension-address inp-add_address-country_code',
                                                'id'=>'phone_extension',
                                                 'placeholder'=>'Extension ',
                                                 'maxlength'=>4,
                                                'div'=>false,
                                                'legend' => false,
                                        'label' => false,
                                                 ));  
                                              ?>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="box-footer button-form-sub">
                    <?php echo $this->Html->link('Cancel',['controller'=>'staffs','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-primary')); ?>
                    </div>

             <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php echo $this->Html->script(['staff']);?>



