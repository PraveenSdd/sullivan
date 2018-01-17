<?php ?>
<div class="modal-body">
    <div class="form-default clearfix">
        <div class="row">
            <div class="col-sm-6 col-xs-6 custom-pop-select2">
                <label >Name </label> : &nbsp;<?=$conatct['name'];?> 

            </div>
            <div class="col-sm-6 col-xs-6 custom-pop-select2">
                <label>Position </label> :&nbsp; <?=$conatct['position'];?> 
            </div>
        </div>
        <div class="row padding-top-10">
            <div class="col-sm-6 col-xs-6">
                <label>Email</label> : &nbsp; <?=$conatct['email'];?> 
            </div>
            <div class="col-sm-6 col-xs-6">
                <div class="phone-block" >
                    <label>Phone Number </label> : &nbsp; <?=$conatct['phone'];?> 
                </div>
                <div class="phone-extension-block" >
                    <label> Extension</label> : &nbsp; <?=$conatct['phone_extension'];?> 
                </div>
            </div>

        </div>
        <div class="addr-rept additional-address-block agency-additional-address-block padding-top-20">
            <?php $i = 1; foreach($conatct['addresses'] as $address){?>
            <div class="additional-address">                                  
                <div class="row col-sm-12">
                    <label class="address-lable">Address-<span class="address-count"><?=$i;?></span>
                    </label>
                </div>
                <div class="row padding-top-10">
                    <div class="col-sm-6 col-xs-6 custom-pop-select2">
                        <label>Address 1</label> : &nbsp; <?=$address['address1'];?> 
                    </div>
                    <div class="col-sm-6 col-xs-6 custom-pop-select2">
                        <label>Address 2</label> : &nbsp; <?=$address['address2'];?> 
                    </div>
                </div>
                <div class="row padding-top-10">
                    <div class="col-sm-6 col-xs-6 custom-pop-select2">
                        <label>City</label> : &nbsp; <?=$address['city'];?> 
                    </div>
                    <div class="col-sm-6 col-xs-6 custom-pop-select2">
                        <label>State</label> : &nbsp; <?=$this->Custom->getStateName($address['state_id'])?>  
                    </div>
                </div>
                <div class="row padding-top-10">
                    <div class="col-sm-6 col-xs-6 custom-pop-select2">
                        <label>Zip Code </label> : &nbsp; <?=$address['zipcode'];?>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                        <div class="phone-block" >
                            <label>Phone Number </label> : &nbsp; <?=$address['phone'];?>
                        </div>
                        <div class="phone-extension-block">
                            <label> Extension</label> : &nbsp; <?=$address['phone_extension'];?>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
         <?php  $i++; } ?>
        </div>    
    </div>
</div>

