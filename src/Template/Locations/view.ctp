<?php ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>
    <h5><?= $this->Flash->render() ?></h5>
    <div class="form-default clearfix">
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Operation :</label></div>
                    <div class="info-line-right">  <?php foreach( $location['location_industries'] as $industry){
                                $industries[] = $industry['industry_id'];
                            }
                            $industry =  $this->Custom->getIndustry($industries);
                            echo implode(', ', $industry) ?>
                    </div>
                </div>
            </div>

        </div>
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

        <div class="col-sm-12 col-xs-12 clearfix">
   <?php echo $this->Html->link('Cancel',['controller'=>'locations','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?>
        </div>
    </div>

</div>


