<?php ?>
<div class="modal fade modal-default" id="agencyContactPersonModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <?php  echo $this->Form->create('AgencyContact', array('url' =>'javascript:void(0);' ,'id'=>'frmAgencyContactPerson',' method'=>'post'));
                    echo $this->Form->hidden('agency_contact_id', array(
                                       'class'=> 'form-control  inp-agency-contact-id',
                                        'id'=>'inpAgencyContactId',
                                        ));
                    ?>
                    <div class="row">
                        <div class="col-sm-6 col-xs-6 custom-pop-select2">
                            <label>Name <span class="text-danger">*</span></label>
                                
                                    <?php echo $this->Form->input('AgencyContact.name', array(
                                                  'placeholder'=>'Name',
                                                  'class'=>'form-control agencyContactName',
                                                  'label' => false,
                                                  'data-id'=>'',
                                                  'data-parentId'=>'',
                                                  'maxlength'=>40,
                                                  
                                                 ));  
                                              ?>

                        </div>
                        <div class="col-sm-6 col-xs-6 custom-pop-select2">
                            <label>Position <span class="text-danger">*</span></label>
                                    <?php echo $this->Form->input('AgencyContact.position', array(
                                                  'placeholder'=>'Position',
                                                  'class'=>'form-control agencyContactPosition',
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
                                      <?php echo $this->Form->input('AgencyContact.email', array(
                                                  'placeholder'=>'Email',
                                                  'class'=>'form-control agencyContactEmail phone-group',
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
                                     <?php echo $this->Form->input('AgencyContact.phone', array(
                                                  'placeholder'=>'Phone number ',
                                                  'class'=>'form-control agencyContactPhone inp-phone phone-group' ,
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
                                    <?php echo $this->Form->input('AgencyContact.phone_extension', array(
                                                    'class'=>'form-control agencyContactPhoneExtension phone-extension',
                                                    'placeholder'=>'Extension ',
                                                    'maxlength'=>4,
                                                    'div'=>false,
                                                    'legend' => false,
                                         'label' => false,
                                                 ));  
                                              ?>     

                            </div>
                            <label id="phone-error" class="authError" for="phone" style="display: none;">Please enter phone number</label>
                        </div>

                    </div>
                    <div class="addr-rept additional-address-block agency-contact-additional-address-block">
                        
                    </div>
                    <hr>
                    <div class="add-address text-right">
                        <a href="javascript:void(0);">+ Add More</a></div>

                    <div class="col-sm-12 col-xs-12 clearfix padding-top-10">
                         <?php echo $this->Form->button('Submit', array('type'=>'button','class'=>'btn btn-default subAgencyContactPerson')); ?>
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
                                 'class'=>'form-control agencyContactAddress1 inp-add-address1',
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
                             'class'=>'form-control agencyContactAddress2 inp-add-address2',
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
                              'class'=>'form-control agencyContactCity inp-add-city',
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
                      'class'=> 'form-control agencyContactStateId inp-add-state sel-add-state',
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
                        'class'=>'form-control agencyContactZipcode inp-add-zipcode',
                        'label' => false,
                        'data-id'=>'',
                        'data-parentId'=>'',
                        'maxlength'=>10,

                       ));  
                ?>
                <?php 
            echo $this->Form->hidden('Address.id.', array(
            'label' => false,
            'class'=> 'form-control agencyContactid inp-add-id',
            'value'=>'',
            ));
        ?>

            </div>
           
        </div>
    </div>
</div>
