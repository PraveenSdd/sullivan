<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <!-- left column -->
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border padding-top-5">
            <?php  echo $this->Form->create('Faqs', array('url' => array('controller' => 'Faqs', 'action' => 'add'),'id'=>'add_category',' method'=>'post','class'=>'form-horizontal')); ?>
                <div class="col-md-8">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Question</label>
                            <div class="col-sm-9">
                  <?php echo @$faq->question;?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Answer</label>
                            <div class="col-sm-9">
                  <?php echo @$faq->answer;?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Created</label>
                            <div class="col-sm-9">
                 <?php echo $this->Custom->DateTime($faq->created);?>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer button-form-sub">
                        <a href="/admin/faqs" class="btn btn-warning">Cancel</a>
                    </div>
                </div>
             <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script(['category']);?>



