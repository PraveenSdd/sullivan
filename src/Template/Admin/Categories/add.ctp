<?php ?>

<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
                <!-- general form elements -->
           <?php  echo $this->Form->create('Categories', array('url' => array('controller' => 'Categories', 'action' => 'add'),'id'=>'categoryId',' method'=>'post','class'=>'form-horizontal')); ?>
                <div class="col-md-12">
                    <div class="box-body">                    
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="title" class=" control-label padding-top-20">Agency Name <span class="text-danger">*</span></label>
                         <?php echo $this->Form->input('name', array(
                                                  'placeholder'=>'Agency name',
                                                  'class'=>'form-control inp-agency-name padding-top-5',
                                                  'label' => false,
                                                  'data-id'=>'',
                                                  'data-parentId'=>'',
                                                  'maxlength'=>120,
                                                 ));  
                                              ?>

                            </div>
                        </div>

                        <div class="row padding-top-5">
                            <div class="col-sm-6">
                                <label for="title" class=" control-label">Address <span class="text-danger">*</span></label>
                                <?php echo $this->Form->textarea('address1', array(
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
                                <?php echo $this->Form->textarea('address2', array(
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
                                <?php echo $this->Form->input('city', array(
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
                                    echo $this->Form->input('state_id', array(
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
                                <?php echo $this->Form->input('zipcode', array(
                                        'placeholder'=>'Zip Code',
                                        'class'=>'form-control ',
                                        'label' => 'false',
                                         'maxlength'=>10, 
                                         'label' => false,

                                       ));  
                                    ?>

                            </div>
                            <div class="col-sm-6">
                               
                                <div class="phone-block" >
                                     <label>Phone Number </label>
                                     <?php echo $this->Form->input('phone', array(
                                                'placeholder'=>'Phone number ',
                                                'class'=>'form-control inp-phone inp-address_phone' ,
                                                'label' => false,
                                                'div'=>false,
                                                'legend' => false
                                                 ));  
                                    ?>
                                </div>
                                <div class="phone-extension-block">
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
                        </div>

                        <div class="box-header with-border padding-top-20 ">

                            <div class="row">
                                <div class="col-sm-12 bg-primary clearfix text-center">
                                    <h5 class="permitTitle">Contact Person Details</h5>
                                    <p class="description"></p>
                                </div>
                            </div>
                            <div class="box-body view-permit-outer text-center">                    
<!-- Agency related Contact person Block - START -->
                                <div class="row ">
                                    <div class="form-group">
                                        <div class="col-sm-9">
                                            <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1" >Contact Person</a>
                                            <div id="collapse-1" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body permit-agency-block">
                                           <?php echo $this->element('backend/agency/contact_list'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <?php echo $this->Html->link('Add Contact','javascript:void(0);',array('data-categoryId'=>'','escape' => false, 'data-title'=>"Contact", 'class'=>"addConatctPerson  addicons ")); ?> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                       </div>
                        <div class="box-footer button-form-sub">
                             <?php echo $this->Html->link('Cancel',['controller'=>'categories','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-primary')); ?>
                        </div>

             <?php echo $this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
<!-- modal add conatct person form -->
<?php echo $this->element('backend/agency/contact_person'); ?>
    </div>
<?php echo $this->Html->script(['category']);?>



