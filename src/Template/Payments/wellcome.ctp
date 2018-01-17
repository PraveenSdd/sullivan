<?php ?>
     <!-- main content start here -->
        <div class="inner-page-bx main-content clearfix">
            <div class="container">
                
                <div class="signup-bx-1 div-company-search">
              <div  class="hdd-brdr"><h3>Wellcome To NYCompliance</h3></div>
                    <div class="signup-bx1-in">
                        <p>Thanks for signing up to keep in touch with NYCompliance. You will be first emailing verification. Please check your email account for an active NYCompliance account.  </p>
                        <div class="text-center">
                            <div class="project-btn-1 btn-register-company">
                            <?php echo $this->Html->link('Payment',['controller'=>'payments','action'=>'index',$userId,$amount],array('escape' => false)); ?>
                            </div></div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="clearfix"></div>
