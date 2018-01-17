<?php ?>
<!-- main content start here -->
<div class="inner-page-bx main-content clearfix">
    <div class="container">
        <!-- Search Registred Company Form - START -->
        <div class="signup-bx-1 div-company-search">
                   <?= $this->Flash->render() ?>
            <h3>Sign Up</h3>
            <div class="signup-bx1-in">
                <div class="sinup-srch">
                    <form  method="post" action="javascript:void(0);" id="frmCompanySearcg" role="form" autocomplete="off">
                        <div class="srch-registred-company">
                            <input type="text" class="form-control srchCompanyName" placeholder="Search for company" name="srch-company-name" id="srchCompanyName">
                            <input type="hidden" class="form-control srchCompanyId" name="srch-company-id" id="srchCompanyId">
                            <label id="srchCompanyId-error" class="authError" for="srchCompanyId" style="display:none">Please select company</label>
                            <div class="registred-company-list hide">
                                <ul class="ul-company-list">
                                        <?php foreach ($companyList as $companyId =>$companyName): ?>
                                    <li class="li-company-list">
                                        <label class="lbl-company-list" data-company-id="<?php echo $companyId; ?>"  data-company-name="<?php echo $companyName; ?>">
                                                <?php echo $companyName; ?></label>
                                    </li>
                                        <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="sgnup-srch-btn"><input type="submit" /></div>
                    </form>
                </div>
                <h6 class="text-center company-not-found hide"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Company not found</h6>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco.</p>
                <div class="text-center">
                    <div class="project-btn-1 btn-register-company"><a href="javascript:void(0);" class="">REGISTER MY COMPANY</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Search Registred Company Form - END -->
        <!-- Register Company Staff/Employee Form - START -->
        <div class="div-register-company-employee hide">     
            <div  class="hdd-brdr"><h3>Register Employee</h3></div>
            <div class="clearfix"></div>
            <div id="exTab2" class="registration-wrap">
                <div class="tab-content employee-form-container clearfix">
                            <?php echo $this->Form->create('Employee', array('url' => array('controller' => 'users', 'action' => 'EmployeeSignup'),'id'=>'frmEmployee','autocomplete'=>'off',' method'=>'post')); ?> 
                    <div data-tab-name="sign-up-employee"  class="tab-pane active div-sign-up-employee">
                        <div class="form-default clearfix">
                                        <?php echo $this->Form->input('Employee.company_id', array(
                                                        'type'=>'hidden',
                                                        'label' => false,
                                                        'class'=>'form-control employeeCompanyId',
                                                     ));  
                                                    ?>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>First Name</label>
                                                     <?php echo $this->Form->input('Employee.first_name', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter first name',
                                                        'maxlength' =>30
                                                     ));  
                                                    ?>
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Last Name</label>
                                                     <?php echo $this->Form->input('Employee.last_name', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter Last name',
                                                        'maxlength' =>30
                                                     ));  
                                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Position</label>
                                                    <?php echo $this->Form->input('Employee.position', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter position',
                                                        'maxlength' =>30
                                                     ));  
                                                    ?>
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Email</label>
                                                    <?php echo $this->Form->input('Employee.email', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter Email',
                                                        'maxlength' =>40
                                                     ));  
                                                    ?>                                                
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Phone Number</label>
                                                    <?php echo $this->Form->input('Employee.phone', array(
                                                        'label' => false,
                                                        'class'=>'form-control inp-phone',
                                                        'placeholder'=>'Enter phone number' 
                                                     ));  
                                                    ?>  
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Password</label>
                                                    <?php echo $this->Form->password('Employee.password', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter password',
                                                        'id'=>'employee_password',
                                                        'maxlength' =>30
                                                     ));  
                                                    ?>  

                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Confirm Password</label>

                                                    <?php echo $this->Form->password('Employee.confirm_password', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter Confirm password',
                                                        'id'=>'employee_confirm_password',
                                                     ));  
                                                    ?>  

                                    </div>
                                </div>
                            </div> 
                            <div class="min-char">**Min 8 characters required max.24 characters</div>
                        </div> 
                    </div>
                            <?php echo $this->Form->end();?>
                </div>
                <div class="sign-up-button-container sgnp-back-next-btns">
                    <button class="btn-sign-up btn-sign-up-employee pull-right big-nxt-btn" data-button-name="employee">Sign Up</button>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- Register Company Staff/Employee Form - END -->
        <!-- Register New Company Form - Start -->
        <div class="div-register-company hide">     
            <div  class="hdd-brdr"><h3>Register My Company</h3></div>
            <div class="clearfix"></div>
            <div id="exTab1" class="registration-wrap">
                <ul class="nav nav-pills sign-up-form-wizard-container">
                    <li data-tab-name="sign-up-company" class="li-sign-up li-sign-up-company active"><a data-tab-name="sign-up-company"  id="company_info" class="a-sign-up-company a-sign-up a-sign-up-current"  href="#1a" data-toggle="tab" data-value="15">Company Info</a></li>
                    <li data-tab-name="sign-up-contact"  class="li-sign-up li-sign-up-contact"><a data-tab-name="sign-up-contact"  id="contact_info" class="a-sign-up-contact a-sign-up"  href="#2a" data-toggle="tab" data-value="20">Contact Info</a></li>
                    <li data-tab-name="sign-up-industry"  class="li-sign-up li-sign-up-industry"><a data-tab-name="sign-up-industry"  id="industry_info" class="a-sign-up-industry a-sign-up"  href="#3a" data-toggle="tab" data-value="20">Operation Info</a></li>
                    <li data-tab-name="sign-up-address"  class="li-sign-up li-sign-up-address"><a data-tab-name="sign-up-address"  id="address_info" class="a-sign-up-address a-sign-up"  href="#4a" data-toggle="tab" data-value="20">Address Info</a></li>
                    <li data-tab-name="sign-up-pricing"  class="li-sign-up li-sign-up-pricing"><a data-tab-name="sign-up-pricing"  id="pricing_info" class="a-sign-up-pricing a-sign-up"  href="#5a" data-toggle="tab" data-value="20">Pricing</a></li>
                </ul>
                <div class="tab-content sign-up-form-container clearfix">
                            <?php echo $this->Form->create('Forms', array('url' => array('controller' => 'users', 'action' => 'signup'),'id'=>'frmSignUpExits','autocomplete'=>'off',' method'=>'post')); ?> 
                    <div data-tab-name="sign-up-company"  class="tab-pane active div-sign-up-company div-sign-up div-sign-up-current" id="1a">
                        <div class="form-default clearfix">


                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label>Company Name</label>
                                    <div class="pro-inpt-bx">
                                                    <?php echo $this->Form->input('Company.name', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter company Name',
                                                        'maxlength' =>50
                                                     ));  
                                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="pro-inpt-bx">
                                        <label>Address Line 1</label>
                                                        <?php echo $this->Form->input('Company.address_1', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter address line 1',
                                                        'maxlength' =>80
                                                     ));  
                                                    ?>

                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="pro-inpt-bx">
                                        <label>Address Line 2</label>
                                                   <?php echo $this->Form->input('Company.address_2', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter address line 2',
                                                        'maxlength' =>80
                                                     ));  
                                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="pro-inpt-bx">
                                        <label>Phone</label>
                                                     <?php echo $this->Form->input('Company.phone', array(
                                                        'label' => false,
                                                        'class'=>'form-control inp-phone',
                                                        'placeholder'=>'Enter phone'
                                                     ));  
                                                    ?>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="pro-inpt-bx">
                                        <label>Company Email</label>
                                                    <?php echo $this->Form->input('Company.email', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter email',
                                                        'maxlength' =>40
                                                     ));  
                                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div data-tab-name="sign-up-contact"  class="tab-pane div-sign-up-contact div-sign-up" id="2a">
                        <div class="form-default clearfix">

                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>First Name</label>
                                                     <?php echo $this->Form->input('Contact.first_name', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter first name',
                                                        'maxlength' =>30
                                                     ));  
                                                    ?>
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Last Name</label>
                                                     <?php echo $this->Form->input('Contact.last_name', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter Last name',
                                                        'maxlength' =>30
                                                     ));  
                                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Position</label>
                                                    <?php echo $this->Form->input('Contact.position', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter position',
                                                        'maxlength' =>30
                                                     ));  
                                                    ?>
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Email</label>
                                                    <?php echo $this->Form->input('Contact.email', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter Email',
                                                        'maxlength' =>40
                                                     ));  
                                                    ?>                                                
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Phone Number</label>
                                                    <?php echo $this->Form->input('Contact.phone', array(
                                                        'label' => false,
                                                        'class'=>'form-control inp-phone',
                                                        'placeholder'=>'Enter phone number' 
                                                     ));  
                                                    ?>  
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Password</label>
                                                    <?php echo $this->Form->password('Contact.password', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter password',
                                                        'id'=>'contact_password',
                                                        'maxlength' =>30
                                                     ));  
                                                    ?>  

                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Confirm Password</label>
                                                    <?php echo $this->Form->password('Contact.confirm_password', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter Confirm password',
                                                        'id'=>'contact_confirm_password',                                                        
                                                     ));  
                                                    ?>  

                                    </div>
                                </div>
                            </div> 
                            <div class="min-char">**Min 8 characters required max.24 characters</div>

                        </div>                    
                    </div>
                    <div data-tab-name="sign-up-industry"  class="tab-pane div-sign-up-industry div-sign-up" id="3a">
                        <div class="form-default clearfix">

                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <label>Select Work-Operations</label>

                                    <div class="custm-multidrop">
                                                    <?php 
                                                            echo $this->Form->input('industry_id', array(
                                                            'type' => 'select',
                                                            'options' => $industryList,
                                                            'label' => false,
                                                            'multiple' => true,
                                                            'class'=> 'form-control select2 category formlist',
                                                            'id'=>'mult-drop1'
                                                            ));
                                                         ?>
                                        <label id="mult-drop1-error" class="authError" for="mult-drop1" style="display:none"></label>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div data-tab-name="sign-up-address"  class="tab-pane div-sign-up-address div-sign-up" id="4a">
                        <div class="form-default clearfix">
                            <div class="addr-rept additional-address-block">
                                <div class="additional-address">                                    
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="pro-inpt-bx">
                                                <label>Address Label <small class="remove-address"><a href="javascript:void(0);">- Remove</a></small></label>
                                                <?php echo $this->Form->input('Address.title.', array(
                                                        'label' => false,
                                                        'class'=>'form-control inp-add-title',
                                                        'placeholder'=>'Enter address label',
                                                        'maxlength' =>20 
                                                     ));  
                                                    ?>  

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="pro-inpt-bx">
                                                <label>Address Line 1</label>
                                                            <?php echo $this->Form->input('Address.address_1.', array(
                                                        'label' => false,
                                                        'class'=>'form-control inp-add-line1',
                                                        'placeholder'=>'Enter address line 1' ,
                                                        'maxlength' =>80
                                                     ));  
                                                    ?> 

                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="pro-inpt-bx">
                                                <label>Address Line 2</label>
                                                            <?php echo $this->Form->input('Address.address_2.', array(
                                                        'label' => false,
                                                        'class'=>'form-control inp-add-line2',
                                                        'placeholder'=>'Enter address line 2' ,
                                                        'maxlength' =>80
                                                     ));  
                                                    ?> 

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="pro-inpt-bx">
                                                <label>Phone</label>
                                                            <?php echo $this->Form->input('Address.phone.', array(
                                                                'label' => false,
                                                                'class'=>'form-control inp-phone inp-add-phone',
                                                                'placeholder'=>'Enter phone'

                                                             ));  
                                                            ?> 

                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-xs-12">
                                            <div class="pro-inpt-bx">
                                                <label>Email</label>
                                                            <?php echo $this->Form->input('Address.email.', array(
                                                        'label' => false,
                                                        'class'=>'form-control inp-add-email',
                                                        'placeholder'=>'Enter email',
                                                        'maxlength' =>40
                                                     ));  
                                                    ?> 

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12">
                                            <label>Select Work-Operations</label>

                                            <div class="custm-multidrop">
                                                            <?php 
                                                                    echo $this->Form->input('Address.industry_id.', array(
                                                                    'type' => 'select',
                                                                    'options' => $industryList,
                                                                    'label' => false,
                                                                    'multiple' => true,
                                                                    'class'=> 'form-control select2 category formlist selIndustryList sel-add-industry',
                                                                        'id'=>'sel-add-industry-1',
                                                                        'data-add-count'=>'1'
                                                                    ));
                                                                 ?>
                                                            <?php 
                                                                    echo $this->Form->input('Address.operations.', array(
                                                                    'type' => 'hidden',
                                                                    'multiple' => true,
                                                                    'class'=> 'form-control inp-add-operations',
                                                                    'id'=>'inp-add-operations-1',
                                                                    'data-add-count'=>'1'    
                                                                    ));
                                                                 ?>     
                                                <label id="sel-add-industry-1-error" class="authError sel-add-industry-error" for="sel-add-industry-error" style="display:none"></label>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="add-address"><a href="javascript:void(0);">+ Add More</a></div>


                        </div>
                    </div>
                    <div data-tab-name="sign-up-pricing"  class="tab-pane div-sign-up-pricing div-sign-up" id="5a">
                        <div  class="hdd-brdr"><h3>Payment Details</h3></div>
                        <div class="form-default clearfix">                            
                            <div class="row pymnt-amnt-bx">
                                <div class="col-xs-6 col-sm-6">Amount: <strong> $<span class="chargable-amount">0.00</span></strong></div>
                                <div class="col-xs-6 col-sm-6 text-right">Location: <strong><span class="chargable-location">1</span></strong></div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Card Holder Name</label>
                                                    <?php echo $this->Form->input('Payment.card_holder', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter card holder name',
                                                        'maxlength' =>30 
                                                     ));  
                                                    ?> 

                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Card Number</label>
                                                     <?php echo $this->Form->input('Payment.card_number', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter card number',
                                                        'maxlength' =>16 
                                                     ));  
                                                    ?> 

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>CVV</label>
                                                     <?php echo $this->Form->password('Payment.cvv', array(
                                                        'label' => false,
                                                        'class'=>'form-control',
                                                        'placeholder'=>'Enter CVV',
                                                        'maxlength' =>4 
                                                     ));  
                                                    ?> 
                                    </div>
                                </div> 
                                <div class="col-xs-12 col-sm-6">
                                    <div class="pro-inpt-bx">
                                        <label>Expiry</label>
                                                     <?php echo $this->Form->input('Payment.expiry', array(
                                                        'label' => false,
                                                        'class'=>'form-control inp-card-expiry',
                                                        'placeholder'=>'Enter (MM/YY)' 
                                                     ));  
                                                    ?> 
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                            <?php echo $this->Form->end();?>
                </div>
                <div class="sign-up-button-container sgnp-back-next-btns"  data-current-step="1">
                            <?php echo $this->Form->button('Previous', array('data-button-name'=>'previous','class'=>'btn-sign-up btn-sign-up-previous pull-left big-nxt-btn')); ?>
                            <?php echo $this->Form->button('Next', array('data-button-name'=>'next','class'=>'btn-sign-up btn-sign-up-next pull-right big-nxt-btn')); ?>
                            <?php echo $this->Form->button('Proceed Payment', array('data-button-name'=>'payment','class'=>'btn-sign-up btn-sign-up-payment pull-right big-nxt-btn')); ?>

                </div>
                <div class="additional-address-html hide">
                    <div class="additional-address">                                    
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="pro-inpt-bx">
                                    <label>Address Label <small class="remove-address"><a href="javascript:void(0);">- Remove</a></small></label>

                                            <?php echo $this->Form->input('Address.title.', array(
                                                        'label' => false,
                                                        'class'=>'form-control inp-add-title',
                                                        'placeholder'=>'Enter address label',
                                                        'maxlength' =>20 
                                                     ));  
                                                    ?>  
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="pro-inpt-bx">
                                    <label>Address Line 1</label>
                                                 <?php echo $this->Form->input('Address.address_1.', array(
                                                        'label' => false,
                                                        'class'=>'form-control inp-add-line1',
                                                        'placeholder'=>'Enter address line 2',
                                                        'maxlength' =>80 
                                                     ));  
                                                    ?>                                         </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="pro-inpt-bx">
                                    <label>Address Line 2</label>
                                            <?php echo $this->Form->input('Address.address_2.', array(
                                                        'label' => false,
                                                        'class'=>'form-control inp-add-line2',
                                                        'placeholder'=>'Enter address line 2',
                                                        'maxlength' =>80 
                                                     ));  
                                                    ?>                                         </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="pro-inpt-bx">
                                    <label>Phone</label>
                                                    <?php echo $this->Form->input('Address.phone.', array(
                                                                'label' => false,
                                                                'class'=>'form-control inp-phone  inp-add-phone',
                                                                'placeholder'=>'Enter phone ' 
                                                             ));  
                                                            ?>                                         </div>
                            </div>
                            <div class="col-sm-6 col-xs-12">
                                <div class="pro-inpt-bx">
                                    <label>Email</label>
                                                     <?php echo $this->Form->input('Address.email.', array(
                                                        'label' => false,
                                                        'class'=>'form-control inp-add-email',
                                                        'placeholder'=>'Enter email',
                                                        'maxlength' =>40 
                                                     ));  
                                                    ?>                                        
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <label>Select Work-Operations</label>

                                <div class="custm-multidrop">
                                                            <?php 
                                                                    echo $this->Form->input('Address.industry_id.', array(
                                                                    'type' => 'select',
                                                                    'options' => $industryList,
                                                                    'label' => false,
                                                                    'multiple' => true,
                                                                    'class'=> 'form-control select2 category formlist selIndustryList sel-add-industry',
                                                                        'data-add-count'=>'1'
                                                                    ));
                                                                 ?>
                                                            <?php 
                                                                    echo $this->Form->input('Address.operations.', array(
                                                                    'type' => 'hidden',
                                                                    'multiple' => true,
                                                                    'class'=> 'form-control inp-add-operations',
                                                                     'data-add-count'=>''   
                                                                    ));
                                                                 ?>
                                    <label id="sel-add-industry-error" class="authError sel-add-industry-error" for="sel-add-industry-error" style="display:none"></label>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- Register New Company Form - END -->
    </div>
</div>
<div class="clearfix"></div>
<?= $this->Html->script(['signup']);?>