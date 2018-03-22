<?php ?>
<div class="modal fade modal-default" id="permitDocumentModal" role="dialog">
    <div class="modal-dialog modal-lg custom-modal-wdth">
        Modal content
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <?php echo $this->Form->create('PermitDocument', array('url' => 'javascript:void(0);', 'id' => 'frmPermitDocument', ' method' => 'post', 'class' => 'form-horizontal frmPermitDocument', 'enctype' => 'multipart/form-data', 'name' => 'frmPermitDocument')); ?> 
                        <div class="row">
                        <div class="col-sm-12 col-xs-12 custom-pop-select2">
                                <label>Document <span class="text-danger">*</span></label>
                                    <?php 
                                    echo $this->Form->input('PermitDocument.document_id', array(
                                       'type' => 'select',            
                                        'options'=>[],
                                        'label' => false,
                                        'class'=> 'form-control select2 sel-permit-document',
                                        'id'=>'selPermitDocument',
                                        'multiple'=>true,
                                        
                                        ));
                                     ?>
                            </div> 
                        </div>
                        <div class="col-sm-12 col-xs-12  padding-top-10 clearfix">

                            <div class="add-new-document-block text-right">
                                <a class="btnPermitDocumentAddModal" href="javascript:void(0);">+ Add New Document</a>
                            </div>
                        </div>

                    <div class="col-sm-12 col-xs-12  padding-top-10 clearfix">
                        <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-default subPermitDocument')); ?>
                    </div>

                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

