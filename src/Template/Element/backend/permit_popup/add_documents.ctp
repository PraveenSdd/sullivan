<?php ?>
<div class="modal fade modal-default" id="permitDocumentsModel" role="dialog">
    <div class="modal-dialog modal-lg">
        Modal content
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <?php  echo $this->Form->create('Forms', array('url' =>'javascript:void(0);' ,'id'=>'frmPermitDocuments',' method'=>'post','class'=>'form-horizontalfrmPermitDocuments','enctype'=>'multipart/form-data')); ?>
                    <div class="row">
                        <div class="form-group">
                            <div class="form-group form-required-docs">
                                <label for="formDocument" class="col-sm-3 control-label">
                                    <a class="label label-success form-required-docs-add"><i class="fa fa-plus"></i></a>
                                    Document
                                </label>

                                <div class="col-sm-4">
                                            <?php echo $this->Form->input('form_attachment[1][document_name]', array(
                                                  'placeholder'=>'Document Name',
                                                  'class'=>'form-control form-required-docs-name ',
                                                  'label' => false,                                                  
                                                 ));  
                                              ?>

                                </div>

                            </div>

                        </div>

                    </div>
                    <div class="row padding-top-10">
                        <div class="form-group">
                            <label for="formUploadHelping" class="col-sm-3 control-label">
                                <span class="forms-count">1</span> Helping Documents
                            </label>

                            <div class="col-sm-9">
                 <?php echo $this->Form->file('form_attachment[1][document_sample].', array(
                                                'placeholder'=>'Form document',
                                                'class'=>'form-required-document attachment ',
                                                'label' => false,
                                                'id'=>'form_document1',
                                                 ));  
                                              ?>     
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="form-group">
                            <label for="formUploadHelping" class="col-sm-3 control-label">
                                Is Mandatory
                            </label>

                            <div class="col-sm-9">
                                    <?php echo $this->Form->input('form_attachment[1][is_mandatory]', array(
                                                                   'type'=>'checkbox',
                                                                   'class'=>'form-required-document required',
                                                                   'label' => false,
                                                                   'id'=>'form_document_required1',
                                                                   'style'=>'margin-left:0%!important;'                                                                   ));  
                                                                 ?>     
                            </div>
                        </div>
                    </div>

                    <div class="documentsfields div-form-attachments"></div>

                                <?php 
                                    echo $this->Form->hidden('form_id', array(
                                    'label' => false,
                                    'class'=> 'form-control addFormsformId',
                                    'id'=>'addDocumentformId'
                                    ));
                                   
                                    echo $this->Form->hidden('form_attachment_id', array(
                                    'label' => false,
                                    'class'=> 'form-control',
                                    'id'=>'formAttachmentId'
                                    ));
                                   
                                ?>



                    <div class="col-sm-12 col-xs-12  padding-top-10 clearfix">
                        <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-default subPermitForm')); ?>
                    </div>

                    <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



<div class="form-required-docs-fields hide" >
    <div class="form-group form-required-docs padding-top-10">
        <div class="row">
            <div class="form-group">

                <label for="formDocument" class="col-sm-3 control-label">
                    <a class="label label-success form-required-docs-add"><i class="fa fa-plus"></i></a>
                    <a class="label label-danger form-required-docs-remove"><i class="fa fa-minus"></i></a>
                    Document <span class="docs-count">1</span>
                </label>
                <div class="col-sm-4">
            <?php echo $this->Form->input('form_attachment.document_name', array(
                                                  'placeholder'=>'Document Name',
                                                  'class'=>'form-control form-required-docs-name required',
                                                  'label' => false,                                                  
                                                 ));  
                                              ?>
                </div>

            </div>
        </div>
        <div class="row padding-top-10">
            <div class="form-group">
                <label for="formUploadHelping" class="col-sm-3 control-label">
                    <span class="forms-count">1</span> Helping Documents
                </label>

                <div class="col-sm-9">
                 <?php echo $this->Form->file('form_attachment.document_sample', array(
                                                  'placeholder'=>'Document sample',
                                                  'class'=>'form-required-docs-sample',
                                                   'multiple' => true,
                                                  'label' => false,                                                  
                                                 ));  
                                              ?>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="form-group">
                <label for="formUploadHelping" class="col-sm-3 control-label">
                    Is Mandatory
                </label>

                <div class="col-sm-9">
                    <?php echo $this->Form->input('form_attachment.is_mandatory.', array(
                                                   'type'=>'checkbox',
                                                   'class'=>'fform-required-docs-required required required',
                                                   'label' => false,
                                                   'id'=>'form_document_required1',
                                                   'style'=>'margin-left:0%!important;'                                                                   ));  
                    ?>     
                </div>
            </div>
        </div>
    </div>
</div>
