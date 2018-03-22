<?php ?>
<div class="modal fade modal-default" id="permitFormModal" role="dialog">
    <div class="modal-dialog modal-lg">
        Modal content
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <?php echo $this->Form->create('PermitForm', array('url' => 'javascript:void(0);', 'id' => 'frmPermitForm', 'type' => 'post', 'class' => 'form-horizontal frmPermitForm', 'enctype' => 'multipart/form-data','name'=>'frmPermitForm')); ?>
                    <div class="documentsfields inp-permit-form-block">
                        <!-- Html will append here  -->
                    </div>

                    <div class="col-sm-12 col-xs-12  padding-top-10 clearfix">
                    <?php echo $this->Form->button('Submit', array('type' => 'submit', 'class' => 'btn btn-default subPermitForm')); ?>                      
                    </div>

<?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!--This is use for form upload--> 

<div class="inp-permit-form-block-html hide" >
    <div class="inp-permit-form-field">
        <div class="row padding-top-20">
            <div class="form-group">
                <label for="formUpload" class="col-sm-3 control-label">
                    <a class="label label-danger permit-form-remove"><i class="fa fa-minus"></i></a>
                    <a class="label label-success permit-form-add"><i class="fa fa-plus"></i></a>
                    Form <span class="inp-field-count">1</span>
                </label>
                <div class="col-sm-5">
                    <?php
                    echo $this->Form->input('PermitForm[1][name]', array(
                        'placeholder' => 'Form Name',
                        'class' => 'form-control required inp-permit-form inp-permit-form-name',
                        'label' => false,
                    ));
                    ?>
                </div>
                <div class="col-sm-4">
                    <?php
                    echo $this->Form->file('PermitForm[1][file]', array(
                        'class' => 'required inp-permit-form inp-permit-form-file',
                        'label' => false,
                    ));
                    ?>
                    <?php
                    echo $this->Form->hidden('PermitForm[1][id]', array(
                        'label' => false,
                        'class' => 'inp-permit-form inp-permit-form-id',
                    ));
                    ?>


                </div>

            </div>
        </div>
        <div class="row padding-top-10">
            <div class="form-group">
                <label for="formUploadHelping" class="col-sm-3 control-label">
                    Form <span class="inp-field-count">1</span> Helping Documents
                </label>

                <div class="col-sm-9">
                    <?php
                    echo $this->Form->file('PermitForm[1][sample].', array(
                        'class' => 'inp-permit-form inp-permit-form-sample',
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