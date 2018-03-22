<?php ?><div class="modal fade modal-default" id="operationPermitModel" role="dialog">
    <div class="modal-dialog modal-lg custom-modal-wdth">
        Modal content
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <form name="" method="get" id="AddOperationPermit" action="javascript:void(0);">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 custom-pop-select2">
                                <label>Permits</label>
                                     <?php 
                                    echo $this->Form->input('permit_id', array(
                                       'type' => 'select',
                                       'options' => $permitsList,
                                        'multiple'=>"multiple",
                                        'label' => false,
                                        'class'=> 'form-control select2 formId permitOperations',
                                        'id'=>'categotyId',
                                        ));
                                     ?>
                            </div>

                            <!--operation_id is a industry_id-->
                                <?php 
                                    echo $this->Form->hidden('operation_id', array(
                                    'label' => false,
                                    'class'=> 'form-control addOperationId',
                                    'id'=>'addOperationId'
                                    ));
                                ?>
                            <div class="col-sm-12 col-xs-12 clearfix padding-top-20">
                         <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-default')); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>