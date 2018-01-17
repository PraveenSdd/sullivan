<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
                <div class="col-md-8">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-9 padding-top-5">
                  <?php echo ucfirst($SubscriptionPlan['name']);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9 padding-top-5">
                  <?php echo $SubscriptionPlan['description'];?>
                            </div>
                        </div>
                      
                    </div>
                    <div class="box-body">
                        <div class="header"><h4><u>Attributes</u></h4></div>
                        <hr>
                        <?php foreach($SubscriptionPlan['attributes'] as $attributes){ ?>
                        
                        <ul>
                            <li>
                                 <?php echo ucfirst($attributes['attribute']);?>
                            </li>
                        </ul>
                         
                        <hr>
                        <?php } ?>
                    </div>

                    <div class="box-footer button-form-sub">
                    <?php echo $this->Html->link('Cancel',['controller'=>'homePages','action'=>'subscriptionPlans'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
                    </div>
                </div>
            <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>




