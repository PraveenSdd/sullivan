<?php ?><div class="modal fade modal-default" id="permitAddOperationModel" role="dialog">
    <div class="modal-dialog modal-lg custom-modal-wdth">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
\                <div class="form-default clearfix">
                    <form name="" method="get" id="permitAddOperation" action="javascript:void(0);">
                       
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 custom-pop-select2">
                                <label>Operations <span class="text-danger">*</span></label>
                                     <?php 
                                    echo $this->Form->input('operation_id', array(
                                       'type' => 'select',
                                       'options' => $operationsList,
                                        'multiple'=>"multiple",
                                        'label' => false,
                                        'class'=> 'form-control select2 operationId',
                                        'id'=>'operationId',
                                        
                                        ));
                                     ?>
                            </div>



                                <?php 
                                    echo $this->Form->hidden('permit_id', array(
                                    'label' => false,
                                    'class'=> 'form-control permitId',
                                    'id'=>'permitId'
                                    ));
                                   
                                ?>
                                <?php 
                                    echo $this->Form->hidden('id', array(
                                    'label' => false,
                                    'class'=> 'form-control',
                                    'id'=>'permitOperationId'
                                    ));
                                   
                                ?>
                               

                            <div class="col-sm-12 col-xs-12 clearfix padding-top-10">
                                 <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-default')); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>