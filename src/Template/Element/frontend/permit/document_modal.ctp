<?php ?>
<div class="modal fade modal-default" id="permitDocumentModal" role="dialog">
    <div class="modal-dialog modal-lg">
        Modal content
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <?php echo $this->Form->create('PermitDocument', array('url' => 'javascript:void(0);', 'id' => 'frmPermitDocument', ' method' => 'post', 'class' => 'form-horizontal frmPermitDocument', 'enctype' => 'multipart/form-data', 'name' => 'frmPermitDocument')); ?>  
                    <div class="documentsfields inp-permit-document-block">
                        <div class="inp-permit-form-field">
                            <div class="row padding-top-20">
                                <div class="form-group">
                                   <label for="formUpload" class="col-sm-3 control-label">security type</label>
                                    <div class="col-sm-5">

                                        <?php 
                                         echo $this->Form->input('PermitDocument.security_type_id', array(
                                         'type' => 'select',
                                         'options' => $securityTypes,
                                          'empty'=>'Please select security type',
                                          'label' => false,
                                          'class'=> 'form-control',
                                          ));
                                       ?>
                                    </div>
                                   </div>
                                <div class="form-group">
                                    <label for="formUpload" class="col-sm-3 control-label">Form</label>
                                    <div class="col-sm-5">
                                        <div class="input-group" style="width:100%;">
                                            <label class="input-group-btn igb-permit-document-file">
                                                <span class="btn btn-primary">
                                                    Browse&hellip; 
                                                    <?php
                                                    echo $this->Form->file('PermitDocument.file', array(
                                                        'class' => 'required inp-document-form inp-permit-document-file',
                                                        'label' => false,
                                                        'style'=>'display:none'
                                                    ));
                                                    ?>
                                                </span>
                                            </label>
                                            <input  type="text" name="PermitDocument[file_text]" class="form-control igb-permit-document-file-txt inp-permit-document-file-text" readonly>
                                        </div>
                                        <?php
                                        echo $this->Form->hidden('PermitDocument.id', array(
                                            'label' => false,
                                            'class' => 'inp-permit-document inp-permit-document-id',
                                        ));
                                        ?>
                                        <?php
                                        echo $this->Form->hidden('PermitDocument.document_id', array(
                                            'label' => false,
                                            'class' => 'inp-document inp-document-id',
                                        ));
                                        ?>
                                    </div>

                                </div>
                            </div>
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
