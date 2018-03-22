<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border padding-top-10">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12 bg-primary clearfix text-center">
                            <?php echo $this->Form->hidden('Agency.name', array('data-id'=>$agency->id,'value'=>htmlentities($agency->name),'class'=>'form-control inp-agency-name')) ?>
                            <h3>  <?php echo ucfirst(htmlentities($agency->name));?></h3>
                            <?php if(isset($agency->address->address1) && !empty($agency->address->address1)) { ?>
                                <div style="text-align: left">
                                    <div style="display: inline-block; width: 10%; vertical-align: top;text-align: right;margin-right: 1%;font-size: 16px;font-style: italic;">Address: </div>
                                    <div style="display: inline-block; width: 80%;">
                                        <p><?php echo  htmlentities($agency->address->address1). ' '.htmlentities($agency->address->address2); ?></p>
                                        <p><?php echo  htmlentities($agency->address->city).', '.htmlentities($statesList[$agency->address->state_id]); ?></p>  
                                       
                                    </div>        
                                </div>
                            <?php } ?>
                            <?php if(isset($agency->description) && !empty($agency->description)) { ?>
                                <div style="text-align: left">
                                    <div style="display: inline-block; width: 10%; vertical-align: top;text-align: right;margin-right: 1%;font-size: 16px;font-style: italic;">Description: </div>
                                    <div style="display: inline-block; width: 80%;">
                                        <p><?php echo  htmlentities($agency->description); ?></p>
                                    </div>        
                                </div>
                            <?php } ?>
                             <div>&nbsp;</div>   
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer button-form-sub text-right">
                    <?php echo $this->Html->link('Edit',['controller'=>'agencies','action'=>'edit',$agencyId],array('class'=>'btn btn-primary','escape' => false)); ?> &nbsp;&nbsp;
                    <?php echo $this->Html->link('Cancel',['controller'=>'agencies','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?>
           </div>
              <?php echo $this->element('backend/agency/attributes_menus'); ?>
        </div>
    </div>
</div>
<?php echo $this->Html->script(['backend/agency']);?>






