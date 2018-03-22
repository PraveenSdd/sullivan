<?php ?><div class="modal fade modal-default" id="permitDeadlineModal" role="dialog">
    <div class="modal-dialog modal-lg">
        Modal content
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <form name="" method="post" id="frmPermitDeadline" action="javascript:void(0);">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">
                                <label>Date <span class="text-danger">*</span></label>
                                <?php
                                echo $this->Form->hidden('PermitDeadline.deadline_id', array(
                                       'class'=> 'form-control  inp-deadline-id',
                                        ));
                                echo $this->Form->input('PermitDeadline.date', array(
                                    'placeholder' => 'MM-DD-YYYY',
                                    'class' => 'form-control inp-deadline-date inp-date-picker',
                                    'id'=>'inpPermitDeadlineDate',
                                    'label' => false,
                                ));
                                ?>
                            </div>
                            <div class="col-sm-6 col-xs-6 timerdeadline">
                                <label>Time <span class="text-danger">*</span></label>
                                <?php
                                echo $this->Form->input('PermitDeadline.time', array(
                                    'placeholder' => 'HH:MM AM/PM',
                                    'class' => 'form-control inp-deadline-time inp-time-picker',
                                    'id'=>'inpPermitDeadlineTime',
                                    'label' => false,
                                ));
                                ?>
                            </div>

                            <div class="col-sm-12 col-xs-12 clearfix padding-top-10">
<?php echo $this->Form->button('Submit', array('type' => 'type', 'class' => 'btn btn-default subPermitDeadline')); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>