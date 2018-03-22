<div class="row">
    <div class="col-md-12">
        <?= $this->Flash->render() ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
                <!-- general form elements -->
                <?php echo $this->Form->create($this->request->data, array('method' => 'post', 'class' => 'form-horizontal','id'=>'emailTemplate')); ?>
                <div class="col-md-12">
                    <div class="box-body"> 
                        <div class="row padding-top-5">
                            <div class="col-sm-10">
                                <label for="title" class=" control-label">Subject <span class="text-danger">*</span></label>
                                <?php echo $this->Form->input("EmailTemplates.id", array('class' => 'hidden')) ?>
                                <?php
                                echo $this->Form->input(
                                        'EmailTemplates.subject', array(
                                    'placeholder' => 'Subject',
                                    'class' => 'form-control required',
                                    'label' => false,
                                    'maxlength' => 40,
                                ));
                                ?>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm-10">
                                <label for="title" class=" control-label">Template <span class="text-danger">*</span></label>
                                <?php
                                echo $this->Form->textarea('EmailTemplates.description', array(
                                    'class' => 'form-control inp-agency-description ckeditor',
                                    'label' => 'false',
                                    'rows' => "50",
                                    'label' => false,
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="row padding-top-5">
                            <div class="col-md-6">
                                <?php echo $this->Form->button('Update', array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
                            </div>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?php echo $this->Html->script(['ckeditor/ckeditor','email_template']); ?>
<script>
    //CKEDITOR.config.toolbar = 'Custom';
    CKEDITOR.config.height = '1000';
</script>


