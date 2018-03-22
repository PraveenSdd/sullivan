<?php ?>        
<div class="inner-page-bx  main-content clearfix">
    <div class="container">
        <div class="signup-bx-1 inner-container ">
            <div  class="hdd-brdr"><h3>Registration</h3></div>
            <div class="signup-bx1-in">
                <?php if(!empty($userEmail)): ?>
                    <p class="font-size-18">Registration is successfully completed. We have sent a email on <strong><?php echo $userEmail; ?></strong> for Verification. Please verify your account.
                    <?php echo $this->Html->link('Resend Verification Email',['controller'=>'users','action'=>'resendVerification',$this->Encryption->encode($userId)],array('escape' => false)); ?>
                    </p>
                    <?php if($registationType == 'company' && $registrationStatus != 'done'): ?>
                        <p class="font-size-18">Payment transaction is not completed, please click on payment link and complete your payment process.
                        <?php echo $this->Html->link('Proceed Payment',['controller'=>'payments','action'=>'index',$this->Encryption->encode($userId)],array('escape' => false)); ?>
                        </p>
                    <?php endif; ?>
                <?php else: ?>    
                    <p class="font-size-18 color-red padding-left-15">
                        Invalid Request! (<?php echo ucwords($registationType); ?> not found..)
                    </p>
                <?php endif; ?>
                <p class="font-size-18">If you have any query, please contact to NYCompliance</p>
                <div class="site-contact-detail">
                    <ul class="clearfix">
                        <li>
                            <p>
                                <i class="fa fa-globe"></i> 
                                <a href="javascript:void(0);">support.nycompliance</a>
                            </p>
                        </li>
                        <li>
                            <p>
                                <i class="fa fa-envelope-o"></i> 
                                <a href="mailto:sales@nycompliance.com">sales@nycompliance</a>
                            </p>
                        </li>
                        <li>
                            <p>
                                <i class="fa fa-map-marker"></i> 7 East 20th Street New York, NY 10003
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="clearfix"></div>



