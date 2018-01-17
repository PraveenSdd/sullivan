<?php ?>
<div class="modal fade modal-default" id="contactPersonModel" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <?php  echo $this->Form->create('Forms', array('url' =>'javascript:void(0);' ,'id'=>'AddAgencyPerson',' method'=>'post')); ?>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6 custom-pop-select2">
                            <label>Name <span class="text-danger">*</span></label>
                                    <?php echo $this->Form->input('name', array(
                                                  'placeholder'=>'Name',
                                                  'class'=>'form-control conatctName',
                                                  'label' => false,
                                                  'data-id'=>'',
                                                  'data-parentId'=>'',
                                                  'maxlength'=>40,
                                                  
                                                 ));  
                                              ?>

                        </div>
                        <div class="col-sm-6 col-xs-6 custom-pop-select2">
                            <label>Position <span class="text-danger">*</span></label>
                                    <?php echo $this->Form->input('position', array(
                                                  'placeholder'=>'Position',
                                                  'class'=>'form-control conatctPosition',
                                                  'label' => false,
                                                  'data-id'=>'',
                                                  'data-parentId'=>'',
                                                  'maxlength'=>40,
                                                 ));  
                                              ?>

                        </div>
                    </div>

                    <div class="row padding-top-10">
                        <div class="col-sm-6 col-xs-6">
                            <label>Email <span class="text-danger">*</span></label>
                                      <?php echo $this->Form->input('email', array(
                                                  'placeholder'=>'Email',
                                                  'class'=>'form-control conatctEmail',
                                                  'label' => false,
                                                  'data-id'=>'',
                                                  'data-parentId'=>'',
                                                  'maxlength'=>40,
                                                 ));  
                                              ?>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <div class="phone-block padding-top-5" >
                                <label>Phone Number <span class="text-danger">*</span></label>
                                     <?php echo $this->Form->input('phone', array(
                                                  'placeholder'=>'Phone number ',
                                                  'class'=>'form-control conatctPhone inp-phone' ,
                                                  'label' => false,
                                                  'data-id'=>'',
                                                  'data-parentId'=>'',
                                         
                                                'div'=>false,
                                         'legend' => false
                                                 ));  
                                              ?>

                            </div>
                            <div class="phone-extension-block padding-top-5" >
                                <label> Extension</label>
                                    <?php echo $this->Form->input('phone_extension', array(
                                                    'class'=>'form-control phone-extension',
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
                    <div class="addr-rept additional-address-block agency-additional-address-block">
                        <div class="additional-address">                                  
                            <div class="row col-sm-12">
                                <label class="address-lable">Address-<span class="address-count">1</span>
                                    <small class="remove-address hide"><a href="javascript:void(0);">  Remove</a></small>
                                </label>
                            </div>
                            <div class="row padding-top-10">
                                <div class="col-sm-6 col-xs-6 custom-pop-select2">
                                    <label>Address 1<span class="text-danger">*</span></label>
                                     <?php echo $this->Form->textarea('Address.address1.', array(
                                                  'placeholder'=>'Address1',
                                                  'class'=>'form-control conatctAddress inp-add-address1',
                                                    'label' => false,
                                                    'rows'=>2,
                                                'maxlength'=>80,
                                                    
                                                 ));  
                                              ?>

                                </div>
                                <div class="col-sm-6 col-xs-6 custom-pop-select2">
                                    <label>Address 2</label>
                                     <?php echo $this->Form->textarea('Address.address2.', array(
                                                  'placeholder'=>'Address2',
                                                  'class'=>'form-control conatctAddress inp-add-address2',
                                                 'label' => false,
                                                    'maxlength'=>80,
                                                    'rows'=>2.
                                                   
                                                 ));  
                                              ?>

                                </div>

                            </div>
                            <div class="row padding-top-10">
                                <div class="col-sm-6 col-xs-6 custom-pop-select2">
                                    <label>City <span class="text-danger">*</span></label>
                                    <?php echo $this->Form->input('Address.city.', array(
                                                  'placeholder'=>'City',
                                                  'class'=>'form-control conatctName inp-add-city',
                                                  'label' => false,
                                                  'data-id'=>'',
                                                  'data-parentId'=>'',
                                                  'maxlength'=>40,
                                                  
                                                 ));  
                                              ?>
                                </div>
                                <div class="col-sm-6 col-xs-6 custom-pop-select2">
                                    <label>State <span class="text-danger">*</span></label>
                                    <?php if(empty($statesList)){
                                                $statesList = '';
                                            }
                                      echo $this->Form->input('Address.state_id.', array(
                                         'type' => 'select',
                                         'options' => $statesList,
                                          'empty'=>'Please select state',
                                          'label' => false,
                                          'class'=> 'form-control select2 inp-add-state',
                                           'id'=>'sel-add-state-1',
                                          'data-add-count'=>'1',
                                           'default'=>154,
                                          ));
                                       ?>

                                </div>
                            </div>

                            <div class="row padding-top-10">

                                <div class="col-sm-6 col-xs-6 custom-pop-select2">
                                    <label>Zip Code <span class="text-danger">*</span></label>
                                    <?php echo $this->Form->input('Address.zipcode.', array(
                                                  'placeholder'=>'zip code',
                                                  'class'=>'form-control inp-add-zipcode',
                                                  'label' => false,
                                                    'maxlength'=>10,
                                                  
                                                 ));  
                                              ?>

                                </div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="phone-block padding-top-5" >
                                        <label>Phone Number </label>
                                     <?php echo $this->Form->input('Address.phone.', array(
                                                  'placeholder'=>'Phone number ',
                                                  'class'=>'form-control inp-phone inp-address_phone' ,
                                                  'label' => false,
                                                'div'=>false,
                                                'legend' => false
                                                 ));  
                                              ?>
                                    </div>
                                    <div class="phone-extension-block padding-top-5">
                                        <label> Extension</label>
                                     <?php echo $this->Form->input('Address.phone_extension.', array(
                                                    'class'=>'form-control phone-extension inp-add_address-country_code',
                                                    'id'=>'phone_extension',
                                                     'placeholder'=>'Extension ',
                                                     'maxlength'=>4,
                                                     'label' => false,
                                                     'div'=>false,
                                                     'legend' => false
                                                 ));  
                                              ?>    

                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="add-address text-right">
                        <a href="javascript:void(0);">+ Add More</a></div>
                                <?php 
                                    echo $this->Form->hidden('category_id', array(
                                    'label' => false,
                                    'class'=> 'form-control addCategoryId',
                                    'id'=>'categoryId',
                                    
                                    ));
                                   
                                ?>
                                <?php 
                                    echo $this->Form->hidden('id', array(
                                    'label' => false,
                                    'class'=> 'form-control agencyContactId',
                                    'id'=>'conatctId'
                                    ));
                                   
                                ?>
                                <?php 
                                    echo $this->Form->hidden('permit_id', array(
                                    'label' => false,
                                    'class'=> 'form-control permitId',
                                    'id'=>'permitId'
                                    ));
                                   
                                ?>

                    <div class="col-sm-12 col-xs-12 clearfix padding-top-10">
                         <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-default')); ?>
                    </div>

                     <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>
<!--html for add mode address--> 
<div class="additional-address-html hide">
    <div class="additional-address">  
        <div class="row col-sm-12">
            <label class="address-lable">Address-<span class="address-count">1</span>
                <small class="remove-address "><a href="javascript:void(0);">  Remove</a></small>
            </label>
        </div>
        <div class="row padding-top-10">

            <div class="col-sm-6 col-xs-6 custom-pop-select2">
                <label>Address 1<span class="text-danger">*</span></label>
                    <?php echo $this->Form->textarea('Address.address1.', array(
                                 'placeholder'=>'Address1',
                                 'class'=>'form-control conatctAddress inp-add-address1',
                                   'label' => false,
                                   'rows'=>2,
                               'maxlength'=>80,

                                ));  
                             ?>

            </div>
            <div class="col-sm-6 col-xs-6 custom-pop-select2">
                <label>Address 2</label>
                <?php echo $this->Form->textarea('Address.address2.', array(
                             'placeholder'=>'Address2',
                             'class'=>'form-control conatctAddress inp-add-address2',
                            'label' => false,
                               'maxlength'=>80,
                               'rows'=>2.

                            ));  
                         ?>
            </div>

        </div>

        <div class="row padding-top-10 ">
            <div class="col-sm-6 col-xs-6 custom-pop-select2">
                <label>City <span class="text-danger">*</span></label>
                <?php echo $this->Form->input('Address.city.', array(
                              'placeholder'=>'City',
                              'class'=>'form-control conatctName inp-add-city',
                              'label' => false,
                              'data-id'=>'',
                              'data-parentId'=>'',
                              'maxlength'=>40,

                             ));  
                          ?>
            </div>
            <div class="col-sm-6 col-xs-6 custom-pop-select2">
                <label>State <span class="text-danger">*</span></label>
                <?php 
                  echo $this->Form->input('Address.state_id.', array(
                     'type' => 'select',
                     'options' => $statesList,
                      'empty'=>'Please select state',
                      'label' => false,
                      'class'=> 'form-control inp-add-state sel-add-state',
                      'data-add-count'=>'1',
                       'default'=>154,

                      ));
                   ?>

            </div>
        </div>

        <div class="row padding-top-10">

            <div class="col-sm-6 col-xs-6 custom-pop-select2">
                <label>Zip Code <span class="text-danger">*</span></label>
                <?php echo $this->Form->input('Address.zipcode.', array(
                        'placeholder'=>'zip code',
                        'class'=>'form-control inp-add-zipcode',
                        'label' => false,
                        'data-id'=>'',
                        'data-parentId'=>'',
                        'maxlength'=>10,

                       ));  
                ?>

            </div>
            <div class="col-sm-6 col-xs-6">

                <div class="phone-block padding-top-5" >
                    <label>Phone number </label>

                 <?php echo $this->Form->input('Address.phone.', array(
                            'placeholder'=>'Phone number ',
                            'class'=>'form-control inp-phone inp-address_phone' ,
                            'label' => false,
                            'div'=>false,
                            'legend' => false
                             ));  
                ?>
                </div>
                <div class="phone-extension-block padding-top-5">
                    <label>Extension </label>
                <?php echo $this->Form->input('Address.phone_extension.', array(
                            'class'=>'form-control phone-extension-address inp-add_address-country_code',
                            'id'=>'phone_extension',
                             'placeholder'=>'Extension ',
                             'maxlength'=>4,
                             'label' => false,
                            'div'=>false,
                            'legend' => false
                             ));  
                          ?>

                </div>
            </div>
        </div>
    </div>
</div>
