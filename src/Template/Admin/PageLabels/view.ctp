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
                            <label for="CategoryName" class="col-sm-3 control-label">Title : </label>
                            <div class="col-sm-9 padding-top-5">
                  <?php echo ucfirst($howItWork['title']);?>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Description : </label>
                            <div class="col-sm-9 padding-top-5">
                  <?php echo $howItWork['description'];?>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Last Modification : </label>
                            <div class="col-sm-9 padding-top-5">
                            <?php echo $this->Custom->dateTime($howItWork['modified']) ; ?>
                            </div>
                        </div>
                        
                         
                    </div>
                   

                    <div class="box-footer button-form-sub">
                            <?php echo $this->Html->link('Cancel',['controller'=>'HowItWorks','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
                    </div>
                </div>
            <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>




