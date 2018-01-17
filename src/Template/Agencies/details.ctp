<?php

$ecodeUserId = $this->Encryption->encode($Authuser['id']); ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>
   <?= $this->Flash->render() ?>

    <div class="form-default clearfix">
        <div class="col-sm-12 bg-primary clearfix ">
            <h3 class="text-center"><?php echo ucfirst($agency->name);?></h3>
            <p>
                        <?php echo $agency->short_description;?>
            </p>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="info-line-bx">
                    <div class="col-xs-2">
                        <label for="" class="control-label">Operations :</label>
                    </div>
                    <div class="col-sm-10"> 
                             <?php $operations = $this->Custom->getAgencyIndustryList($agency->id);
                                    if($operations != 0){
                                       foreach($operations as $operation){
                                           $arrOperation[] = $operation['industry']['name'];
                                       }
                                        echo implode(' ,  ', $arrOperation);
                                    }
                             ?> 
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="table-responsive col-xs-12 col-sm-12">
                <table class="table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Status</th>
                    </thead>
                    <tbody>
                        <tr><td ><span class="pull-left"><b>Forms</b> </span> </td> <td colspan="5" id="statusmsg"></td></tr>
                 <?php $permits =  $this->Custom->getForms($agency->id);
                    if($permits != null){
                    foreach($permits as $permit){
                 ?>
                        <tr>
                            <td><?=$permit->title?></td>
                            <td><?php $deadLine =  $this->Custom->getPermitDeadline($permit->id);
                            if(!empty($deadLine)){
                                echo $this->Custom->dateTime($deadLine->date).', '.$deadLine->time;
                            }?> 
                            </td>
                            <td><?php $formStatus =  $this->Custom->getFormStatus(1);
                                echo $formStatus->title; ?> 
                            </td>

                        </tr>

                    <?php } } ?>
                    </tbody>

                </table>
            </div>

        </div>

        <div class="col-sm-12 col-xs-12 clearfix">
             <?php echo $this->Html->link('Cancel',['controller'=>'agencies','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?>

        </div>
    </div>

</div>
</div>


