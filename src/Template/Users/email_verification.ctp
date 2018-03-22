<?php ?>        
<div class="inner-page-bx  main-content clearfix">
    <div class="container">
        <div class="signup-bx-1 inner-container ">
            <div  class="hdd-brdr"><h3>Email Verification</h3></div>
            <div class="signup-bx1-in">
                <?php if(!empty($verificationData)): ?>                    
                    <?php if($responseFlag): ?>
                        <p class="font-size-18">Email verification is successfully completed.
                        <?php echo $this->Html->link('Sign In',['controller'=>'users','action'=>'login'],array('escape' => false)); ?>
                        </p>
                    <?php else: ?>    
	                    <p class="font-size-18 color-red padding-left-15">
	                        Some internal error! Please try once again.
	                    </p>
	                <?php endif; ?>
                <?php else: ?>    
                    <p class="font-size-18 color-red padding-left-15">
                        Invalid Request! (Verification link has been expired..)
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



