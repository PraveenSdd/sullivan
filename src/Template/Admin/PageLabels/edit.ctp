<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
                <!-- general form elements -->
            <?php  echo $this->Form->create('PageLabels', array('url' => array('controller' => 'pageLabels', 'action' => 'edit',$id),'id'=>'pageLabelForm',' method'=>'post','class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
                <div class="col-md-8">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Label Name<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                  <?php echo $this->Form->input('name', array(
                                                  'placeholder'=>'Name',
                                                  'label' => false,
                                                  'class'=>'form-control ',
                                                  'value'=>$pageLabel['name'],
                                                  'disabled'=>true
                                                 ));  
                                              ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Label Value<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                  <?php echo $this->Form->textarea('value', array(
                                                  'class'=>'form-control ',
                                                  'label' => false,
                                                  'row'=>3,
                                                    'value'=>$pageLabel['value'],
                                                 ));  
                                              ?>
                            </div>
                        </div>

                    </div>
                     <?php echo $this->Form->hidden('id', array('value'=>$pageLabel['id']));  
                                              ?>
                    <div class="box-footer button-form-sub">
                         <?php echo $this->Html->link('Cancel',['controller'=>'pageLabels','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-primary')); ?>
                    </div>
                </div>


             <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $("#pageLabelForm").validate({
            debug: false,
            errorClass: "authError",
            onkeyup: false,
            rules: {
                "value": {
                    required: true,
                }
            },
            messages: {
                "value": {
                    required: "Please enter label value.",
                },
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });
</script>



