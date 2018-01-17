<?php ?>
<div class="main-content clearfix">
        <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
        </h4>
        <div class="clearfix"></div>
         <div class="clearfix"></div>
        <div class="test-wrap clearfix">
            <div class="row">
                <div class="col-sm-12 bg-primary clearfix">
                    <h3><?php echo ucfirst($form['title']);?></h3>
                </div>
                <div class="col-sm-4 col-xs-12 clearfix">
                    <h3>Previous Permit</h3>
                </div>
                <div class="col-sm-4 col-xs-12 clearfix">
                       <h3><?php   $id = $this->Encryption->encode($form['id']); echo $this->Html->link('Permits to File',['controller'=>'permits','action'=>'details',$id],array('title'=>'View','escape' => false)); ?>  </h3>
                </div>
                <div class="col-sm-4 col-xs-12 clearfix">
                    <h3>Tasks/Alerts Status History</h3>
                </div>
                <div class="col-sm-12 clearfix">
                    <h3>Professional Assistance</h3>
                </div>
            </div>
        </div>
    </div>

 
