<?php echo $this->Html->css(['matrix.form_common.css',]);?>
<div class="row">
            <h5><?= $this->Flash->render() ?></h5>
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
             
              <br>
            <!-- /.box-header -->
            <!-- form start -->
            <?php  echo $this->Form->create('Faqs', array('url' => array('controller' => 'Faqs', 'action' => 'add'),'id'=>'add_faqs',' method'=>'post','class'=>'form-horizontal')); ?>
                 <div class="col-md-8">
              <div class="box-body">
                <div class="form-group">
  <label for="CategoryName" class="col-sm-3 control-label">Question<span class="text-danger">*</span></label>
 <div class="col-sm-9">
                  <?php echo $this->Form->input('question', array(
                                                  'placeholder'=>'Question',
                                                  'class'=>'form-control required',
                                                  'label' => false,
                                                 ));  
                                              ?>
</div>
                </div>
                <div class="form-group">
                      <label for="CategoryName" class="col-sm-3 control-label">Answer<span class="text-danger">*</span></label>
 <div class="col-sm-9">
                  <?php echo $this->Form->textarea('answer', array(
                                                  'placeholder'=>'Answer',
                                                  'class'=>'form-control',
                                                  'label' => 'false',
                                                    'rows'=>"5",
                                                 ));  
                                              ?>
</div>
                </div>
                 

                
              </div>
           <div class="box-footer button-form-sub">
                    <a href="/admin/faqs" class="btn btn-warning">Cancel</a>
                    <button type="submit" class="btn btn-primary">Submit</button>
              
              </div>
                 </div>

             
             <?php echo $this->Form->end();?>
          </div>
        </div>
     </div>
 </div>
<?= $this->Html->script(['faqs']);?>



