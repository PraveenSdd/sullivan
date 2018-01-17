<?php ?>
<div class="modal fade modal-default" id="permitInstructionsModel" role="dialog">
    <div class="modal-dialog modal-lg">
        Modal content
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <?php  echo $this->Form->create('Forms', array('url' =>'javascript:void(0);' ,'id'=>'frmPermitInstruction',' method'=>'post','class'=>'form-horizontal frmPermitInstructions','enctype'=>'multipart/form-data')); ?>
                    <div class="row">
                        
                        <div class="col-sm-6 col-xs-6">
                            <label class="col-sm-2">Title</label>
                            <div class="col-sm-10">
                                      <?php echo $this->Form->input('title', array(
                                                  'placeholder'=>'Instruction title',
                                                  'class'=>'form-control col-sm-4 ',
                                                  'label' => false,                                                  
                                                 ));  
                                              ?>
                            </div>
                                 
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <label class="col-sm-5"> Helping Documents</label>
                                    <?php echo $this->Form->file('file_path', array(
                                                'class'=>'',
                                                'label' => false,
                                                'id'=>'filePath ',
                                                 ));  
                                              ?>     
                            </div>
                        
                                       </div>
                    

                    <div class="documentsfields div-form-attachments"></div>

                                <?php 
                                    echo $this->Form->hidden('permit_id', array(
                                    'label' => false,
                                    'class'=> 'form-control ',
                                    'id'=>'permitId'
                                    ));
                                   
                                    echo $this->Form->hidden('permit_instruction_id', array(
                                    'label' => false,
                                    'class'=> 'form-control',
                                    'id'=>'permitInstructionId'
                                    ));
                                   
                                ?>



                    <div class="col-sm-12 col-xs-12  padding-top-10 clearfix">
                        <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-default')); ?>
                    </div>

                    <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>
