<?php ?>
<div class="box-header with-border ">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-12 bg-primary clearfix text-center">
                <h5 class="permitTitle">Permits & Alerts</h5>
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
                        <a href="javascript:void(0);" data-operationId=""  data-title="<?php echo 'Permit';?>" class="addOperationPermit  addicons ">Add Permit</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="box-body view-permit-outer text-center">                    
            <!-- Agency conatct person Block - START -->
            <div class="row">
                <div class="col-sm-12 bg-primary clearfix text-center">
                </div>
            </div>
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
                                              <?php
                                            echo $this->Html->link('Add Alert', 'javascript:void(0);', array('escape' => false, 'data-title' => "Add Alert",'data-alert-id'=>'','data-alert-title'=>'','data-alert-notes'=>'','data-alert-date'=>'','data-alert-time'=>'','data-alert-type'=> 4,'data-alert-staff-id'=>'', 'data-alert-company-id'=>'', 'data-alert-operation-id'=>'',  'class' => "btnOperationAlertModal  addicons "));?>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>

<?php echo $this->element('backend/operation/add_permit'); ?>
<?php echo $this->element('backend/operation/alert_modal'); ?>
</div>
       <?php echo $this->Html->script(['backend/operation']);?>