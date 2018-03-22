<?php ?>
<div class="modal fade modal-default" id="permitInstructionModal" role="dialog">
    <div class="modal-dialog modal-lg">
        Modal content
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <?php echo $this->Form->create('PermitInstruction', array('url' => 'javascript:void(0);', 'id' => 'frmPermitInstruction', ' method' => 'post', 'class' => 'form-horizontal frmPermitInstruction', 'enctype' => 'multipart/form-data', 'name' => 'frmPermitInstruction')); ?>
                    <div class="row">

                        <div class="col-sm-6 col-xs-6">
                            <label class="col-sm-2">Name<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <?php
                                echo $this->Form->hidden('PermitInstruction.permit_instruction_id', array(
                                    'class' => 'form-control  inp-permit-instruction-id',
                                    'id' => 'inpPermitInstructionId',
                                ));
                                echo $this->Form->input('PermitInstruction.name', array(
                                    'placeholder' => 'Instruction name',
                                    'class' => 'form-control col-sm-4 ',
                                    'label' => false,
                                    'id' => 'inpPermitInstructionName'
                                ));
                                ?>
                            </div>

                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <label class="col-sm-5"> Instruction Documents</label>
                            <?php
                            echo $this->Form->file('PermitInstruction.file', array(
                                'class' => '',
                                'label' => false,
                                'data-is-required' => 1,
                                'id' => 'inpPermitInstructionFile'
                            ));
                            ?>     
                        </div>

                    </div>
                    <div class="col-sm-12 col-xs-12  padding-top-10 clearfix">
                        <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-default subPermitInstruction')); ?>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
