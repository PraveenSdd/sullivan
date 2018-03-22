<?php ?>
<div class="row">
    <h5 class="text-center"><?= $this->Flash->render() ?></h5>
</div>
<h5><?= $this->Flash->render() ?></h5>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>
    <div class="clearfix"></div>
    <div class="test-wrap clearfix">
        <div class="row">
            <div class="col-sm-12 bg-primary clearfix">
                <h3><?php echo ucfirst($permit['name']);?></h3>
            </div>
            <div class="col-sm-4 col-xs-12 clearfix">
                <h3><?php echo $this->Html->link("Previous Permit",['controller'=>'previousPermits','action'=>'view',$permitId,$operationId,$locationId],array('title'=>'View','escape' => false)); ?></h3>
            </div>
            <div class="col-sm-4 col-xs-12 clearfix">
                <h3><?php echo $this->Html->link($pageLabelsData[4],['controller'=>'permits','action'=>'details',$permitId,$operationId,$locationId],array('title'=>'View','escape' => false)); ?></h3>
            </div>
            <div class="col-sm-4 col-xs-12 clearfix">
                <h3><?php echo $this->Html->link($pageLabelsData[5],['controller'=>'permits','action'=>'task_history',$permitId,$operationId,$locationId],array('title'=>'View','escape' => false)); ?></h3>
            </div>
            <!--            <div class="col-sm-12 clearfix">
                            <h3>Professional Assistance</h3>
                        </div>-->
        </div>
    </div>
</div>


