<?php ?>
<div class="modal fade modal-default" id="previousPermitDocumentModal" role="dialog">
    <div class="modal-dialog modal-md">
        Modal content
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle">Add Previous Permit Document</h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <?php echo $this->Form->create('UserPreviousPermitDocument', array('url' => 'javascript:void(0);', 'id' => 'frmPreviousPermitDocument', ' method' => 'post', 'class' => 'form-horizontal frmPreviousPermitDocument', 'enctype' => 'multipart/form-data','name'=>'frmPreviousPermitDocument')); ?>
                    <div class="documentsfields inp-previous-permit-document-block">
                        <!-- Html will append here  -->
                    </div>
                    <div class="col-sm-12 col-xs-12  padding-top-10 clearfix">
                    <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-default subPreviousPermitDocument')); ?>                      
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--This is use for form upload--> 

<div class="inp-previous-permit-document-block-html hide" >
    <div class="inp-previous-permit-document-field">
        <div class="row padding-top-10">
            <div class="form-group">
                <label for="documentUpload" class="col-sm-4 control-label">
                    <a class="label label-danger previous-permit-document-remove"><i class="fa fa-minus"></i></a>
                    <a class="label label-success previous-permit-document-add"><i class="fa fa-plus"></i></a>
                    Document <span class="inp-field-count">1</span>
                </label>
                <div class="col-sm-7">
                    <?php
                    echo $this->Form->input('UserPreviousPermitDocument[1][name]', array(
                        'placeholder' => 'Document Name',
                        'class' => 'form-control required inp-previous-permit-document inp-previous-permit-document-name',
                        'label' => false,
                    ));
                    ?>
                </div>

            </div>
        </div>
        <div class="row padding-top-10">
            <div class="form-group">
                <label for="formUploadHelping" class="col-sm-4 control-label">
                    Document File
                </label>
                <div class="col-sm-7">
                    <?php
                    echo $this->Form->file('UserPreviousPermitDocument[1][file]', array(
                        'class' => 'required inp-previous-permit-document inp-previous-permit-document-file',
                        'label' => false,
                    ));
                    ?>
                    <?php
                    echo $this->Form->hidden('UserPreviousPermitDocument[1][id]', array(
                        'label' => false,
                        'class' => 'inp-previous-permit-document inp-previous-permit-document-id',
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="row padding-top-10">
            <div class="form-group">
                <label for="formUploadHelping" class="col-sm-4 control-label">
                    Security Type
                </label>
                <div class="col-sm-7">
                    <?php 
                    echo $this->Form->input('UserPreviousPermitDocument[1][security_type_id]', array(
                    'type' => 'select',
                    'options' => $securityTypes,
                     'empty'=>'Please select security type',
                     'label' => false,
                     'class'=> 'required form-control inp-previous-permit-document inp-previous-permit-document-security-type',
                     ));
                    ?>
                </div>
            </div>
        </div>
        <div class="row padding-top-10">
            <div class="form-group">
                <label for="formUploadHelping" class="col-sm-4 control-label">
                    Expiry Date
                </label>

                <div class="col-sm-7">
                    <?php
                    echo $this->Form->input('UserPreviousPermitDocument[1][expiry_date]', array(
                        'placeholder' => 'Expiry Date',
                        'class' => 'form-control inp-previous-permit-document inp-previous-permit-document-expiry-date',
                        'label' => false,
                    ));
                    ?>
                </div>
                
            </div>
        </div>
    </div>
</div>

<!--End for form uplad-->