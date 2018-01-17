<?php ?>
<!-- banner start here -->
<div class="banner">
    <div class="container">
        <div class="banner-content">
            <h1>Regulatory Compliance: <strong>Sure, Organized &amp; simple</strong></h1>
            <small>One Place to Process and Manage Your Permitting</small>
            <div class="banner-action-btn clearfix">
                <a href="javascript:void(0);" class="btn">See plans</a>
                <a href="javascript:void(0);" class="btn">Tour</a>
            </div>
        </div>
    </div>
</div><!-- /banner end -->

<!-- main index start here -->
<div class="main-index clearfix">
    <img src="<?php echo $this->Html->webroot;?>frontend/home/img/logo-color.png" alt="Sullivan PC" class="main-logo" />
    <!-- our banifit section start here -->
    <section class="section-default section-benefit clearfix">
        <div class="container">
            <h2><?php echo $home[0]['title']; ?></h2>
            <p class="para para-subhead"><?php echo $home[0]['description']; ?></p>
            <div class="benefit-item-wrap clearfix">
                <div class="row">
                        <?php  $attributes =  $this->Custom->getHomePageAttribute($home[0]['id']);
                        foreach($attributes as $attribute){ ?>
                            <div class="col-md-4 col-xs-12">
                                <picture>
                                    <source media="(min-width: 650px)" srcset="<?php echo $this->Html->webroot.'/'.$attribute['image'] ?>">
                                    <source media="(min-width: 465px)" srcset="<<?php echo $this->Html->webroot.'/'.$attribute['image'] ?>">
                                    <img src="<?php echo $this->Html->webroot.'/'.$attribute['image'] ?>" class="img-responsive" alt="Flowers" style="width:auto;">
                                </picture>
                                <h3><?php echo $attribute['title']; ?></h3>
                                <p class="para"><?php echo $attribute['description']; ?></p>
                            </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section><!-- /our banifit section end -->

    <!-- psm section start here -->
    <section class="section-default section-psm clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <img src="<?php echo $this->Html->webroot.'/'.$home[1]['image'] ?>" class="img-responsive" alt="" />
                </div>
                <div class="col-md-6 col-xs-12">
                    <h3><?php echo $home[1]['title']; ?></h3>
                    <p class="para"><?php echo $home[1]['description']; ?></p>
                </div>
            </div>
        </div>
    </section><!-- /psm section end -->

    <!-- avoidBigCost section start here -->
    <section class="section-default section-avoidBigCost clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <h3><?php echo $home[2]['title']; ?></h3>
                    <p class="para"><?php echo $home[2]['description']; ?></p>
                </div>
                <div class="col-md-6 col-xs-12 text-right">
                    <img src="<?php echo $this->Html->webroot.'/'.$home[2]['image'] ?>" class="img-responsive" alt="" />
                </div>
            </div>
        </div>
    </section><!-- /avoidBigCost section end -->

    <!-- opm section start here -->
    <section class="section-default section-opm clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <img src="<?php echo $this->Html->webroot.'/'.$home[3]['image'] ?>" class="img-responsive" alt="" />
                </div>
                <div class="col-md-6 col-xs-12">
                    <h3><?php echo $home[3]['title']; ?></h3>
                    <p class="para"><?php echo $home[3]['description']; ?></p>
                </div>
            </div>
        </div>
    </section><!-- /opm section end -->

    <!-- pricing section start here -->
    <section class="section-default section-pricing text-center clearfix">
        <div class="container">
            <div class="row">
                <h2><?php echo $home[4]['title']; ?></h2>
                <p class="para para-subhead"><?php echo $home[4]['description']; ?></p>
                <div class="pricing-item-wrap clearfix">
                    <!-- item -->
                        <?php foreach($subscriptionPlans as $subscriptionPlan){ ?>
                    <div class="col-md-4 col-sm-4 text-center">
                        <div class="panel panel-pricing">
                            <div class="panel-heading">
                                <h4><?php echo $subscriptionPlan['name']; ?></h4>
                                <p><?php echo $subscriptionPlan['description'] ?></p>
                                <h3><sup>$</sup><?php echo $subscriptionPlan['price'] ?><small>Monthly</small></h3>
                            </div>
                            <div class="panel-body text-center">
                                <p><strong>Whats Included?</strong></p>
                            </div>
                            <ul class="list-group text-left">
                                <li class="list-group-item">
                                          <?php  $subscriptionPlanAttributes =  $this->Custom->getSubscriptionPlanAttribute($subscriptionPlan['id']);
                                   foreach($subscriptionPlanAttributes as $subscriptionPlanAttribute){
                            ?>
                                    <i class="fa fa-check text-success"></i> <?php echo $subscriptionPlanAttribute['attribute'] ?>.<br>
                                   <?php }?>
                                </li>
                            </ul>
                            <div class="panel-footer">
                                <a class="btn btn-lg btn-block" href="#">Start now!</a>
                            </div>
                        </div>
                    </div>
                        <?php } ?>
                </div>
            </div>
        </div>
    </section><!-- /pricing section end -->


</div>
<!-- /main index end -->
<!-- contact strip start here -->
<div class="contact-strip clearfix">
    <div class="container">
        <p class="para">Have any questions?  We are here to help you! <a href="javascript:void(0);">Contact Us</a></p>
    </div>
</div><!-- /contact strip end -->

