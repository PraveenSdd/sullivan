<?php ?>
<!-- footer start here -->
<footer>
    <!-- footer top start here -->
    <div class="footer-top clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 clearfix">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="ftr-item clearfix">
                                <h4 class="footer-title">About PermitAdmin.com</h4>
                                <ul class="clearfix">
                                    <li><a href="/how-to-works">How it Works</a></li>
                                    <li><a href="javascript:void(0);">Request a Call</a></li>
                                    <li><a href="javascript:void(0);">Company</a></li>
                                    <li><a href="javascript:void(0);">Careers</a></li>
                                    <li><a href="javascript:void(0);">Forum</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 pull-right">
                            <div class="ftr-item clearfix">
                                <h4 class="footer-title">Connect</h4>
                                <ul class="clearfix">
                                    <li><p><i class="fa fa-globe"></i> <a href="javascript:void(0);">support.nycompliance</a></p></li>
                                    <li><p><i class="fa fa-envelope-o"></i> <a href="mailto:sales@nycompliance.com" >sales@nycompliance</a></p></li>
                                    <li><p><i class="fa fa-map-marker"></i> 7 East 20th Street<br>&nbsp; &nbsp; &nbsp; &nbsp;New York, NY 10003</p></li>
                                </ul>
                                <div class="social-wrap clearfix">
                                    <a href="javascript:void(0);" class="sw-fb"><i class="fa fa-facebook-f"></i></a>
                                    <a href="javascript:void(0);" class="sw-tw"><i class="fa fa-twitter"></i></a>
                                    <a href="javascript:void(0);" class="sw-li"><i class="fa fa-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 text-center clearfix">

                </div>
            </div>
        </div>
    </div>
</footer>
<div class="modal fade pro-pop-1 lgn-popup" id="loginModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i></button>
            <div class="modal-body">
                <div id="dlg">
                    <h4>Sign In</h4>
                    <form id='signin'>
                        <span id='msg' class="error authError" style="color:red;"></span>
                        <div class="form-group">
                            <input type="text" class="form-control email" placeholder="Email" name="email" />
                        </div>
                        <div class="form-group">
                            <input  type="password" placeholder="Password" class="form-control" name="password" />
                        </div>                        
                        <div class="lgn-btn-outer">
                            <button class="lgn-btn" name="Sign In" value="Sign In" id='signIn'>Sign In</button></div>
                        <div class="rembr-me custom-checkbx">
                            <input class="custom-checkbx" id="skill-checkbox-3" type="checkbox" value="value2" >
                            <label for="skill-checkbox-3">Remember me</label>

                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <div class="lgn-ftr-btn"><h6>Not a Member?</h6>
                    <div class="signup-btn-outer text-center">
              <?php echo $this->Html->link('Sign Up', ['controller' => 'Users', 'action' => 'signup'],['class'=>'signup-btn login']); ?>
                    </div>
                </div>
                <div class="lgn-popup-logo text-center">
                    <a href="index.html"><img src="img/lgn-logo.png" alt="" /></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script(['signin']);?>