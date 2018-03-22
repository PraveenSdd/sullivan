<?php ?>
<div class="modal fade modal-default" id="permitDocumentAddModal" role="dialog">
    <div class="modal-dialog modal-lg custom-modal-wdth">
        Modal content
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <?php echo $this->Form->create('Document', array('url' => 'javascript:void(0);', 'id' => 'frmPermitDocumentAdd', ' method' => 'post', 'class' => 'form-horizontal frmPermitDocumentAdd', 'enctype' => 'multipart/form-data', 'name' => 'frmPermitDocumentAdd')); ?> 
                    <div class="row">
                        <div class="col-sm-12 col-xs-12  padding-top-10 clearfix">
                            <div class="documentsfields inp-permit-document-block">
                                <!-- Html will append here  -->
                            </div>

                        </div>

                        <div class="col-sm-12 col-xs-12  padding-top-10 clearfix">
                        <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-default subPermitDocumentAdd')); ?>
                        </div>

                    <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="inp-permit-document-block-html hide" >
    <div class="inp-permit-document-field">
        <div class="row padding-top-10">
            <div class="form-group">

                <label for="formDocument" class="col-sm-3 control-label">
                    <a class="label label-danger permit-document-remove"><i class="fa fa-minus"></i></a>
                    <a class="label label-success permit-document-add"><i class="fa fa-plus"></i></a>
                    Document <span class="inp-field-count">1</span>
                </label>
                <div class="col-sm-4">
                    <?php
                    echo $this->Form->input('Document[name][]', array(
                        'placeholder' => 'Document Name',
                        'class' => 'form-control required inp-document inp-document-name',
                        'label' => false,
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
