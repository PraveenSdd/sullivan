<?php ?>
<div class="modal fade modal-default" id="permitActionModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
 <?php  echo $this->Form->create('PermitAlert', array('url' =>'javascript:void(0);' ,'id'=>'frmPermitAlert',' method'=>'post','class'=>'form-horizontalfrmPermitAlert')); ?>                                       <div class="row">
                        <div class="col-sm-6 col-xs-6">
                            <label>Notes <span class="text-danger">*</span></label>
                                    <?php echo $this->Form->textarea('PermitAlert.notes',
                                        array(
                                            'placeholder'=>'Notes',
                                            'class'=>'form-control alertNotes inp-alert-notes',
                                            'label' => 'false',
                                              'rows'=>"2",
                                           ));  
                                        ?>
                        </div>
                    </div>

                    <div class="col-sm-12 col-xs-12 clearfix padding-top-10">
                         <?php echo $this->Form->button('Submit', array('type'=>'type','class'=>'btn btn-default subPermitAlert')); ?>
                    </div>
                   <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>