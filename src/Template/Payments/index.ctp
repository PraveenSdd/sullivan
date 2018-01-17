
<div class="inner-page-bx  main-content clearfix">
    <div class="container">
        <div class="signup-bx-1 inner-container ">
            <?php if(!$userExists) :
                echo $this->element('frontend/notFound/company');    
            else :
             ?>    
                <div  class="hdd-brdr"><h3>Payment Details</h3></div>
                    <?php if(!$responseData['status']): ?>
                        <p class="font-size-18 color-red padding-left-15"><?php echo 'Error: '.$responseData['msg']; ?></p>
                    <?php endif; ?>
                <div class="form-default tab-content clearfix">  
                    <?php echo $this->Form->create('Payment', array('url' => array('controller' => 'payments', 'action' => 'index',$this->Encryption->encode($userId)), 'id' => 'frmPayment', 'autocomplete' => 'off', ' method' => 'post')); ?> 
                        <div class="row pymnt-amnt-bx">
                            <div class="col-xs-6 col-sm-6">Amount: <strong> $<span class="chargable-amount"><?php echo $amount?></span></strong></div>
                            <div class="col-xs-6 col-sm-6 text-right">Location: <strong><span class="chargable-location"><?php echo $locationCount?></span></strong></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="pro-inpt-bx">
                                    <label>Comapny Email</label>
                                    <?php
                                    echo $this->Form->input('Company.email', array(
                                        'label' => false,
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter company email',
                                        'maxlength' => 40
                                    ));
                                    ?> 

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="pro-inpt-bx">
                                    <label>Card Holder Name</label>
                                    <?php
                                    echo $this->Form->input('Payment.card_holder', array(
                                        'label' => false,
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter card holder name',
                                        'maxlength' => 50
                                    ));
                                    ?> 

                                </div>
                            </div> 
                            <div class="col-xs-12 col-sm-6">
                                <div class="pro-inpt-bx">
                                    <label>Card Number</label>
                                    <?php
                                    echo $this->Form->input('Payment.card_number', array(
                                        'label' => false,
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter card number',
                                        'maxlength' => 16
                                    ));
                                    ?> 

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="pro-inpt-bx">
                                    <label>CVV</label>
                                    <?php
                                    echo $this->Form->password('Payment.cvv', array(
                                        'label' => false,
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter CVV',
                                        'maxlength' => 4
                                    ));
                                    ?> 
                                </div>
                            </div> 
                            <div class="col-xs-12 col-sm-6">
                                <div class="pro-inpt-bx">
                                    <label>Expiry</label>
                                    <?php
                                    echo $this->Form->input('Payment.expiry', array(
                                        'label' => false,
                                        'class' => 'form-control inp-card-expiry',
                                        'placeholder' => 'Enter (MM/YYYY)'      
                                    ));
                                    ?> 
                                </div>
                            </div>
                        </div>
                        <div class="payment-button-container sgnp-back-next-btns">
                        <?php echo $this->Form->button('Proceed Payment', array('type'=>'submit','class'=>'btn-payment pull-right big-nxt-btn','data-button-name'=>'payment')); ?>

                        </div>
                    <div class="clearfix"></div>

                    <?php echo $this->Form->end(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<?= $this->Html->script('payment'); ?>