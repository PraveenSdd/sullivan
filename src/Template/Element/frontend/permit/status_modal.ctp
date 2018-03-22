<?php ?>
<div class="modal fade modal-default" id="permitActionModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle">Change Permit Status</h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <?php  echo $this->Form->create('UserPermitLogs', array('url' =>'javascript:void(0);' ,'id'=>'frmUserPermitLog',' method'=>'post','class'=>'form-frmUserPermitLog')); ?>                           <div class="row">
                        <div class="col-sm-12 col-xs-12">
                            <label><?php echo $pageLabelsData[3];?></label>
                            <p class='inp-selected-text text-warning font-weight-bold'></p>
                            <?php echo $this->Form->input('UserPermitLogs.status_id',array('type'=>'hidden'));?>

                         <?php echo $this->Form->input('UserPermitLogs.permit_id',array('type'=>'hidden'));?>
                         <?php echo $this->Form->input('UserPermitLogs.user_location_id',array('type'=>'hidden'));?>
                         <?php echo $this->Form->input('UserPermitLogs.operation_id',array('type'=>'hidden'));?>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <label>Notes <span class="text-danger">*</span></label>
                                    <?php echo $this->Form->textarea('UserPermitLogs.notes',
                                        array(
                                            'placeholder'=>'Notes',
                                            'class'=>'form-control inp-permit-log-notes',
                                            'label' => 'false',
                                              'rows'=>"2",
                                           ));  
                                        ?>
                        </div>
                        <div class="col-sm-12 col-xs-12 ren-date hide">
                            <label>Date <span class="text-danger">*</span></label>
                                <?php
                                    echo $this->Form->input('UserPermitLogs.renewable_date', array(
                                    'placeholder' => 'Renewable Date',
                                    'class' => 'form-control inp-permit-renewable-date',
                                    'label' => false,
                                    ));
                                ?>
                        </div>
                        <div class="col-sm-12 col-xs-12 clearfix padding-top-10">
                         <?php echo $this->Form->button('Submit', array('type'=>'type','class'=>'btn btn-default subUserPermitLog')); ?>
                        </div>
                    </div>
                   <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>