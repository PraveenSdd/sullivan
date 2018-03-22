
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
                          'class'=>'form-control agencyContactAddress1 inp-add-address1',
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
                          'class'=>'form-control agencyContactAddress2 inp-add-address2',
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
                          'class'=>'form-control agencyContactCity inp-add-city',
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
                  'class'=> 'form-control agencyContactStateId inp-add-state sel-add-state',
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
                          'class'=>'form-control agencyContactZipcode inp-add-zipcode',
                          'label' => false,
                          'data-id'=>'',
                          'data-parentId'=>'',
                          'maxlength'=>10,
                          'value'=>$address['zipcode'],
                         ));  
                      ?>
             <?php 
            echo $this->Form->hidden('Address.id.', array(
            'label' => false,
            'class'=> 'form-control agencyContactid inp-add-id',
            'value'=>$address['id'],
            ));
        ?>

        </div>
    </div>
</div>
<?php $i++; }
}?>
