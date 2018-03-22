<section class="section-default section-pricing section-pricing-other text-center clearfix">
    <div class="container">
        <div class="row">
            <div class="pricing-item-wrap clearfix" style="color:#6f6f6f;">
                <?php foreach ($subscriptionPlans as $subscriptionPlan) { ?>
                    <div class="col-md-4 col-sm-4 text-center">
                        <div class="panel panel-pricing panel-pricing-<?php echo $subscriptionPlan['id']; ?>" data-plan-id="<?php echo $subscriptionPlan['id']; ?>" data-plan-price="<?php echo $subscriptionPlan['price'] ?>">
                            <div class="panel-heading">
                                <h4><?php echo $subscriptionPlan['name']; ?></h4>
                                <p><?php echo $subscriptionPlan['description'] ?></p>
                                <h3 class="sp-rate"><sup>$</sup><?php echo $subscriptionPlan['price'] ?><small>Yearly</small></h3>
                            </div>
                            <div class="panel-body text-center">
                                <p><strong>Whats Included?</strong></p>
                            </div>
                            <ul class="list-group text-left">
                                <li class="list-group-item">
                                    <?php
                                    foreach ($subscriptionPlan['attributes'] as $subscriptionPlanAttribute) {
                                        ?>
                                        <i class="fa fa-check text-success"></i> <?php echo $subscriptionPlanAttribute['attribute'] ?><br>
                                    <?php } ?>
                                </li>
                            </ul>
                            <div class="panel-footer">
                                <a class="btn btn-lg btn-block btn-subscription-plan" href="javascript:void(0);" data-plan-price="<?php echo $subscriptionPlan['price'] ?>" data-plan-id="<?php echo $subscriptionPlan['id']; ?>" data-plan-id-encode="<?php echo $this->Encryption->encode($subscriptionPlan['id']); ?>">Available</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
