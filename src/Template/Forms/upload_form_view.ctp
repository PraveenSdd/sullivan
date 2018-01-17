<?php ?>
<div class="col-sm-9 col-sm--3 col-md-12 col-md-offset-2 main">
    <h3 class="page-header">Upload Form | View</h3>
    <h5><?= $this->Flash->render() ?></h5>
   <?php  echo $this->Form->create('Forms', array('url' => array('controller' => 'projects', 'action' => 'create'),'id'=>'project',' method'=>'post','class'=>'form-horizontal')); ?>
    <div class="col-md-8">
        <div class="box-body">
            <div class="form-group">
                <label for="CategoryName" class="col-sm-3 control-label">Project </label>
                <div class="col-sm-9">
                  <?php echo ucfirst(@$form['project']['name']);?>
                </div>
            </div>

            <div class="form-group">
                <label for="CategoryName" class="col-sm-3 control-label">Form </label>
                <div class="col-sm-9">
                  <?php echo ucfirst(@$form['form']['title']);?>
                </div>
            </div>
            <div class="form-group">
                <label for="CategoryName" class="col-sm-3 control-label">Category</label>
                <div class="col-sm-9">
                <?php echo ucfirst(@$form['category']['name']);?>
                </div>
            </div>
            <div class="form-group">
                <label for="CategoryName" class="col-sm-3 control-label">Sub Category</label>
                <div class="col-sm-9">
                <?php echo ucfirst(@$form['sub_category']['name']);?>
                </div>
            </div>

            <div class="form-group">
                <label for="CategoryName" class="col-sm-3 control-label">Description</label>
                <div class="col-sm-9">
                <?php echo $form['description'];?>
                </div>
            </div>
                        <?php if(isset($form['path'])){ ?>
            <div class="form-group">
                <label for="CategoryName" class="col-sm-3 control-label">Form</label>
                <div class="col-sm-9">
                    <div class="permitForm">
    <?php
                 $fileName = explode('/', $form['path']);
                   $id = $this->Encryption->encode($form['id']);
                    $fileName1 = explode('-', $fileName[3]);
                  ?><br />

    <?=$fileName1[1]?>
        <?php echo $this->Html->link($this->Html->image('icons/download.png'),['controller'=>'forms','action'=>'downloadPermitForm',$id],array('escape' => false,'style'=>'color:#fff;')); ?>

                    </div>

                </div>
            </div>
            <div class="form-group">
                <label for="CategoryName" class="col-sm-3 control-label">Created</label>
                <div class="col-sm-9">
                            <?php echo $this->Custom->dateTime($form['created']) ; ?>
                </div>
            </div>
                        <?php }?>
        </div>

        <div class="box-footer button-form-sub" >
              <?php echo $this->Html->link('Cancel',['controller'=>'forms','action'=>'uploadFormsList'],array('class'=>'btn btn-warning','escape' => false)); ?>
          
        </div>
    </div>
    <?php echo $this->Form->end();?>
</div>

<?= $this->Html->script(['forms']);?>
