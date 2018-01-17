<?php ?>
<style>
     .view-permit-outer .bg-primary:focus, .view-permit-outer .bg-primary:hover{color:#fff;}
</style>

<div class="row ">
    <h5 class="msg"><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border padding-top-10">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12 bg-primary clearfix text-center">
                            <h3>  <?php echo ucfirst($operation->name);?></h3>
                            <p><?php echo $operation->description;?></p>
                        </div>
                    </div>
                </div>
            </div>
       
   
                <div class="box-header with-border ">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12 bg-primary clearfix text-center">
                            <h5 class="permitTitle">Permits & Permits</h5>
                        </div>
                    </div>
                    <div class="box-body view-permit-outer text-center">                    
                        <!-- Agency conatct person Block - START -->
                        <div class="row ">
                            <div class="form-group">
                                <div class="col-sm-9">
                                    <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1" >Permits</a>
                                    <div id="collapse-1" class="collapse padding-top-10" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body permit-block">
                                           <?php echo $this->element('backend/operation/permit_list'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <a href="javascript:void(0);" data-operationId="<?=$operation->id?>"  data-title="<?php echo 'Permit';?>" class="addOperationPermit  addicons ">Add Permit</a>
                                </div>
                            </div>
                        </div>
            
                    </div>
                
                    <div class=" view-permit-outer text-center">  
                         <div class="row">
                        <div class="col-sm-12 bg-primary clearfix text-center">
                        </div>
                    </div>
                        <!-- Agency conatct person Block - START -->
                        <div class="row padding-top-15">
                            <div class="form-group">
                                <div class="col-sm-9">
                                    <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-3" aria-expanded="true" aria-controls="collapse-3" >Alerts</a>
                                    <div id="collapse-3" class="collapse padding-top-10" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body operation-alert-block">
                                           <?php echo $this->element('backend/operation/alert_list'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <a href="javascript:void(0);" data-operationId="<?=$operation->id?>"  data-title="<?php echo 'Alert';?>" class="addOperationAlert  addicons ">Add Alert</a>
                                </div>
                            </div>
                        </div>
            
                    </div>
                
                </div>
                    <?php if(!empty($operation->id)){ echo $this->Form->hidden('id',['value'=>$operation->id]); } ?>
            </div>
                

                </div>


            </div>
        </div>
   

<!-- modal Permit Deadlines for permit -->
<?php echo $this->element('backend/operation/add_alert'); ?>
<?php echo $this->element('backend/operation/add_permit'); ?>

    <?php echo $this->Html->script(['industry']);?>
