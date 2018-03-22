<?php ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>
    <h5><?= $this->Flash->render() ?></h5>
    <div class="form-default clearfix">        
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Label :</label></div>
                    <div class="info-line-right"> <?= $location['title']?></div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Email :</label></div>
                    <div class="info-line-right">      <?=  $location['email']?></div>
                </div>
            </div>

        </div>

        <div class="row">

            <div class="col-xs-12 col-sm-12">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Phone :</label></div>
                    <div class="info-line-right">  <?= $location['phone']?></div>
                </div>
            </div>      


        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="CategoryName" class="control-label">Address 1 :</label></div>
                    <div class="info-line-right">      <?= $location['address1']?></div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="CategoryName" class="control-label">Address 2 :</label></div>
                    <div class="info-line-right">      <?= $location['address2']?></div>
                </div>
            </div>
        </div>
        <?php if($location['is_operation'] == 1) : ?>
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Operation :</label></div>
                    <div class="info-line-right">
                        <?php $operationList =  $this->Location->getOperationListByLocationId($location['id']); ?>
                        <?php $count =1; ?>
                        <?php foreach ($operationList as $key=>$value): ?>
                            <p>
                                <?php echo $count .'. '.$this->Html->link($value,'javascript:void(0);',array('escape' => false)); ?>
                            </p>
                            <?php $count++; ?>
                        <?php endforeach; ?>  
                    </div>
                </div>
            </div>

        </div>
        <?php endif; ?>

        <div class="col-sm-12 col-xs-12 clearfix">
   <?php echo $this->Html->link('Cancel',['controller'=>'locations'],array('class'=>'btn btn-warning','escape' => false)); ?>
        </div>
    </div>

</div>


