        
<div class="inner-page-bx  main-content clearfix">
    <div class="container">
        <div class="signup-bx-1 inner-container ">
            <div  class="hdd-brdr"><h3>Resend Verification Email</h3></div>
            <div class="signup-bx1-in">
                <?php if(!empty($verificationData)): ?>                    
                    <?php if($responseFlag): ?>
                        <p class="font-size-18">We have re-sent a email on <strong><?php echo $verificationData->email; ?></strong> for varification. Please verify your account.
                        <?php //echo $this->Html->link('Resend Verification Email',['controller'=>'users','action'=>'resendVerification',$this->Encryption->encode($userId)],array('escape' => false)); ?>
                        </p>
                    <?php else: ?>    
	                    <p class="font-size-18 color-red padding-left-15">
	                        Some internal error! Please 
	                        <?php echo $this->Html->link('Resend Verification Email',['controller'=>'users','action'=>'resendVerification',$this->Encryption->encode($userId)],array('escape' => false)); ?>
	                    </p>
	                <?php endif; ?>
                <?php else: ?>    
                    <p class="font-size-18 color-red padding-left-15">
                        Invalid Request! (Records not found..)
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



