<?php echo $this->Html->css(['matrix.form_common.css',]);

?>
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
            <div class="col-md-12">
                    <div class="text-right">
                      
                      <a  class="myalert-delete "  data-url="/admin/faqs/index" data-title="Faq" title="Delete" href="javasript:void();" data-id="<?php echo $faq->id?>" data-modelname="Faqs"> <?php echo $this->Html->image("icons/delete.png"); ?> </a>
                    </div>
                    </div>
                 <div class="col-md-8">
              <div class="box-body">
                <div class="form-group">
  <label for="CategoryName" class="col-sm-3 control-label">Question<span class="text-danger">*</span></label>
 <div class="col-sm-9">
                  <?php echo $this->Form->input('question', array(
                                                  'placeholder'=>'Question',
                                                  'class'=>'form-control required',
                                                  'label' => false,
                                                  'value'=>@$faq->question,
                                                 ));  
                                              ?>
</div>
                </div>
                <div class="form-group">
                      <label for="CategoryName" class="col-sm-3 control-label">Answer</label>
 <div class="col-sm-9">
                  <?php echo $this->Form->textarea('answer', array(
                                                  'placeholder'=>'Answer',
                                                  'class'=>'form-control',
                                                  'label' => 'false',
                                                   'value'=>@$faq->answer,
                                                    'rows'=>"5",
                                                 ));  
                                              ?>
</div>
                </div>
                 

                
              </div>
            <?php echo $this->Form->hidden('id', array('value'=>@$faq->id));  
                                              ?>
           <div class="box-footer button-form-sub">
                    <a href="/admin/faqs" class="btn btn-warning">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
              
              </div>
                 </div>

             
             <?php echo $this->Form->end();?>
          </div>
        </div>
     </div>
 </div>
<?= $this->Html->script(['faqs']);?>



