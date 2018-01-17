<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
                <div class="col-md-8">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-9 padding-top-5">
                  <?php echo ucfirst($home['title']);?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-9 padding-top-5">
                  <?php echo $home['description'];?>
                            </div>
                        </div>
                       
                         <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Created</label>
                            <div class="col-sm-9 padding-top-5">
                            <?php echo $this->Custom->dateTime($home['created']) ; ?>
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Image</label>
                            <div class="col-sm-9 padding-top-5">
                            <?php echo $this->Html->image($home['image'],['style'=>'width: 273px;height: 170px;']); ?>
                            </div>
                        </div>
                    </div>
                   

                    <div class="box-footer button-form-sub">
                            <?php echo $this->Html->link('Cancel',['controller'=>'homePages','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
                    </div>
                </div>
            <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script(['category']);?>



