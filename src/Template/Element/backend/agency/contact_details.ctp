<?php ?>
<?php if ($agencyCoatacts) { ?>
    <div class="row">
        <div class="col-sm-6 col-xs-6 custom-pop-select2">
            <label >Name </label> : &nbsp;<?= htmlentities($agencyCoatacts['name']); ?> 

        </div>
        <div class="col-sm-6 col-xs-6 custom-pop-select2">
            <label>Position </label> :&nbsp; <?= htmlentities($agencyCoatacts['position']); ?> 
        </div>
    </div>
    <div class="row padding-top-10">
        <div class="col-sm-6 col-xs-6">
            <label>Email</label> : &nbsp; <?= htmlentities($agencyCoatacts['email']); ?> 
        </div>
        <div class="col-sm-6 col-xs-6">
            <div class="phone-block" >
                <label>Phone Number </label> : &nbsp; <?= $agencyCoatacts['phone']; ?> 
            </div>
            <div class="phone-extension-block" >
                <label> Extension</label> : &nbsp; <?= $agencyCoatacts['phone_extension']; ?> 
            </div>
        </div>

    </div>
    <?php if ($agencyCoatacts['addresses']) { ?>
        <div class="addr-rept additional-address-block agency-additional-address-block padding-top-20">
            <hr />
            <div class="row col-sm-12">
                <label class="address-lable" style="font-size: 16px;font-style: italic;">
                    <span class="address-count"></span> Addresses
                </label>
            </div>
            <div class="row">
                <?php
                $i = 1;
                foreach ($agencyCoatacts['addresses'] as $address) {
                    ?>
                    <div class="col-sm-6 col-xs-6" style="margin-bottom: 30px;;">
                        <p><?php echo htmlentities($address['address1']) . ' ' . htmlentities($address['address2']); ?></p>
                        <p><?php echo htmlentities($address['city']) . ', ' . htmlentities($statesList[$address['state_id']]); ?></p>  
                        <p><?php echo $address['zipcode']; ?></p>
                    </div>                
                    <?php
                    $i++;
                }
                ?>
            </div> 
        </div>
    <?php } ?>
<?php } ?>

