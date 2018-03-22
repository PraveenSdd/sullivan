<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
<!-- general form elements -->
            <?php  echo $this->Form->create('HomePages', array('url' => array('controller' => 'homePages', 'action' => 'edit'),'id'=>'edit_home',' method'=>'post','class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
                <div class="col-md-8">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Tile<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                  <?php echo $this->Form->input('title', array(
                                                  'placeholder'=>'Title',
                                                  'class'=>'form-control ',
                                                  'label' => false,
                                                  'value'=>$home['title'],
                                                  'data-id'=>$home['id'],
                                                  'data-parentId'=>'',
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
                                                    'value'=>$home['description'],    
                                                 ));  
                                              ?>
                            </div>
                        </div>
                    </div>
                     <?php echo $this->Form->hidden('id', array('value'=>$home['id']));  
                                              ?>
                    <div class="box-footer button-form-sub">
                         <?php echo $this->Html->link('Cancel',['controller'=>'homePages','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-primary')); ?>
                    </div>
                </div>


             <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>




