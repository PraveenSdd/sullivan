<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
<!-- general form elements -->
            <?php  echo $this->Form->create('HowItWorks', array('url' => array('controller' => 'HowItWorks', 'action' => 'edit',$id),'id'=>'howItWork',' method'=>'post','class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
                <div class="col-md-8">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Title<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                  <?php echo $this->Form->input('title', array(
                                                  'placeholder'=>'Title',
                                                  'class'=>'form-control ',
                                                  'label' => false,
                                                  'value'=>$howItWork['title'],
                                                  'data-id'=>$howItWork['id'],
                                                  'data-parentId'=>'',
                                                   'maxlength'=>40, 
                                                 ));  
                                              ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Description<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                  <?php echo $this->Form->textarea('description', array(
                                                  'placeholder'=>'Description',
                                                  'class'=>'form-control ',
                                                  'label' => 'false',
                                                    'rows'=>"5",
                                                    'value'=>$howItWork['description'],
                                                 ));  
                                              ?>
                            </div>
                        </div>

                    </div>
                     <?php echo $this->Form->hidden('id', array('value'=>$howItWork['id']));  
                                              ?>
                    <div class="box-footer button-form-sub">
                         <?php echo $this->Html->link('Cancel',['controller'=>'HowItWorks','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-primary')); ?>
                    </div>
                </div>


             <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script(['how_it_work']);?>



