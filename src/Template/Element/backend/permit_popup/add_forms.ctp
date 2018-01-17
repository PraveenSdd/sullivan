<?php ?>
<div class="modal fade modal-default" id="permitFormsModel" role="dialog">
    <div class="modal-dialog modal-lg">
        Modal content
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <?php  echo $this->Form->create('Forms', array('url' =>'javascript:void(0);' ,'id'=>'frmPermitForm',' method'=>'post','class'=>'form-horizontalfrmPermitForm','enctype'=>'multipart/form-data')); ?>
                    <div class="documentsfields div-form-upload">
                        <div class="form-required">
                            <div class="row">
                                <div class="form-group">
                                    <label for="formUpload" class="col-sm-3 control-label">
                                        <a class="label label-success form-required-add"><i class="fa fa-plus"></i></a>
                                        <a class="label label-danger form-required-remove"><i class="fa fa-minus"></i></a>
                                        Form <span class="forms-count">1</span>
                                    </label>
                                    <div class="col-sm-5">
             <?php echo $this->Form->input(
                                'form[1][form_name]', array(
                                    'placeholder'=>'Form Name',
                                    'class'=>'form-control form-required-name required',
                                    'label' => false,
                                    'id'=>'form_name',
                                   ));  
                                ?>
                                    </div>
                                    <div class="col-sm-4">
                <?php echo $this->Form->file('form[1][form_document]', array(
                                                'placeholder'=>'Form document',
                                                'class'=>'form-required-document formDocument required',
                                                'label' => false,
                                                'id'=>'form_document1',
                                                 ));  
                                              ?>      
                                    </div>

                                </div>
                            </div>
                            <div class="row padding-top-10">
                                <div class="form-group">
                                    <label for="formUploadHelping" class="col-sm-3 control-label">
                                        Form <span class="forms-count">1</span> Helping Documents
                                    </label>

                                    <div class="col-sm-9">
                <?php echo $this->Form->file('form[1][form_sample].', array(
                                                  'placeholder'=>'Form sample',
                                                  'class'=>'form-required-sample',
                                                   'multiple' => true,
                                                  'label' => false,                                                  
                                                 ));  
                                              ?>     
                                    </div>
                                </div>
                            </div>
                        </div>

                                <?php 
                                    echo $this->Form->hidden('form_id', array(
                                    'label' => false,
                                    'class'=> 'form-control addFormsformId',
                                    'id'=>'addFormsformId'
                                    ));
                                   
                                ?>

                                <?php 
                                    echo $this->Form->hidden('form_document_id', array(
                                    'label' => false,
                                    'class'=> 'form-control',
                                    'id'=>'documentid',
                                    ));
                                   
                                ?>
                        <div class="documentsfields button-form-sub "></div>
                    </div>

                    <div class="col-sm-12 col-xs-12  padding-top-10 clearfix">
                        <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-default subPermitForm')); ?>                          
                    </div>

                    <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--This is use for form upload--> 

<div class="form-required-fields hide" >
    <div class="form-required">
        <div class="row padding-top-20">
            <div class="form-group">
                <label for="formUpload" class="col-sm-3 control-label">
                    <a class="label label-success form-required-add"><i class="fa fa-plus"></i></a>
                    <a class="label label-danger form-required-remove"><i class="fa fa-minus"></i></a>
                    Form <span class="forms-count">1</span>
                </label>
                <div class="col-sm-5">
            <?php echo $this->Form->input('forms.form_name', array(
                                                  'placeholder'=>'Form Name',
                                                  'class'=>'form-control form-required-name required',
                                                  'label' => false,                                                  
                                                 ));  
                                              ?>
                </div>
                <div class="col-sm-4">
            <?php echo $this->Form->file('forms.form_document', array(
                                                  'placeholder'=>'Form document',
                                                  'class'=>'form-required-document',
                                                  'label' => false,                                                  
                                                 ));  
                                              ?>

                </div>

            </div>
        </div>
        <div class="row padding-top-10">
            <div class="form-group">
                <label for="formUploadHelping" class="col-sm-3 control-label">
                    Form <span class="forms-count">1</span> Helping Documents
                </label>

                <div class="col-sm-9">
            <?php echo $this->Form->file('forms.form_sample.', array(
                                                  'placeholder'=>'Form sample',
                                                  'class'=>'form-required-sample',
                                                   'multiple' => true,
                                                  'label' => false,                                                  
                                                 ));  
                                              ?>

                </div>
            </div>
        </div>
    </div>
</div>

<!--End for form uplad-->