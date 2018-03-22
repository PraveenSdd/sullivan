<?php ?><div class="modal fade modal-default" id="permitOperationModal" role="dialog">
    <div class="modal-dialog modal-lg custom-modal-wdth">
        Modal content
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <form name="" method="post" id="frmPermitOperation" action="javascript:void(0);">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 custom-pop-select2">
                                <label>Operation <span class="text-danger">*</span></label>
                                    <?php 
                                    echo $this->Form->hidden('permit_operation_id', array(
                                       'class'=> 'form-control  inp-permit-operation-id',
                                        'id'=>'inpPermitOperationId',
                                        ));
                                    echo $this->Form->input('PermitOperation.operation_id', array(
                                       'type' => 'select',            
                                        'options'=>[],
                                        'label' => false,
                                        'class'=> 'form-control select2 sel-permit-operation',
                                        'id'=>'selPermitOperation',
                                        'multiple'=>true,
                                        
                                        ));
                                     ?>
                            </div>
                            <div class="col-sm-12 col-xs-12 clearfix padding-top-20">
                         <?php echo $this->Form->button('Submit', array('type'=>'button','class'=>'btn btn-default subPermitOperation')); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>