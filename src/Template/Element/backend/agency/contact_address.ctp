
<?php $i = 1; if($addresses->toArray()) {
        foreach($addresses as $address){ ?>
<div class="additional-address">  
    <div class="row col-sm-12">
        <label class="address-lable">Address-<span class="address-count"><?php echo $i; ?></span>
            <small class="remove-address <?php (count($addresses) > 1) ? 'hide' : ''; ?>"><a href="javascript:void(0);">  Remove</a></small>
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
                        'value'=>$address['address1'],

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
                            'rows'=>2,
                            'value'=>$address['address2'],

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
                        'value'=>$address['city'],

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
                  'class'=> 'form-control select2 inp-add-state',
                   'id'=>'sel-add-state-1',
                  'data-add-count'=>'1',
                  'default' =>$address['state_id'],
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
                          'value'=>$address['zipcode'],
                         ));  
                      ?>

        </div>
        <div class="col-sm-6 col-xs-6">
            <div class="phone-block" >
                <label>Phone number </label>
                 <?php echo $this->Form->input('Address.phone.', array(
                            'placeholder'=>'Phone number ',
                            'class'=>'form-control inp-phone inp-address_phone' ,
                            'label' => false,
                            'div'=>false,
                            'legend' => false,
                            'value'=>$address['phone'],
                             ));  
                ?>
            </div>
            <div class="phone-extension-block">
                <label>Extension </label>

                <?php echo $this->Form->input('Address.phone_extension.', array(
                            'class'=>'form-control phone-extension-address inp-add_address-country_code',
                            'id'=>'phone_extension',
                             'placeholder'=>'Extension ',
                            'div'=>false,
                            'legend' => false,
                             'label' => false,
                            'maxlength'=>4,
                            'value'=>($address['phone_extension'])? $address['phone_extension'] : '',
                             ));  
                          ?>

            </div>
        </div>
    </div>
         <?php 
            echo $this->Form->hidden('address_id', array(
            'label' => false,
            'class'=> 'form-control agencyContactId',
            'id'=>'conatctId',
            'value'=>$address['id'],
            ));

        ?>
</div>
<?php $i++; }
}else{?>

<div class="additional-address">  
    <div class="row col-sm-12">
        <label class="address-lable">Address-<span class="address-count"><?php echo $i; ?></span>
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
                            'rows'=>2,

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
            <?php 
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
                          'data-id'=>'',
                          'data-parentId'=>'',
                          'maxlength'=>10,
                         ));  
                      ?>

        </div>
        <div class="col-sm-6 col-xs-6">
            <div class="phone-block" >
                <label >Phone number </label>
                 <?php echo $this->Form->input('Address.phone.', array(
                            'placeholder'=>'Phone number ',
                            'class'=>'form-control inp-phone inp-address_phone' ,
                            'label' => false,
                            'div'=>false,
                            'legend' => false
                             ));  
                ?>
            </div>
            <div class="phone-extension-block">
                <label >Extension </label>
                <?php echo $this->Form->input('Address.phone_extension.', array(
                            'class'=>'form-control phone-extension-address inp-add_address-country_code',
                                'placeholder'=>'Extension ',
                            'id'=>'phone_extension',
                            'div'=>false,
                            'maxlength'=>4,
                            'legend' => false
                             ));  
                          ?>

            </div>
        </div>
    </div>
</div>


<?php } ?>

