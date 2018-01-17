<?php ?>
<?php echo $this->Html->css(['matrix.form_common.css',]);?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border padding-top-5">
            <?php  echo $this->Form->create('Users', array('url' => array('controller' => 'users', 'action' => 'changePassword'),'id'=>'changePassword',' method'=>'post','class'=>'form-horizontal')); ?>

                <div class="col-md-8">

                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">New Password</label>
                        <div class="col-sm-9 padding_top_20">
                                <?php echo $this->Form->input(
                                'password', array(
                                    'type'=>'password',
                                'placeholder'=>'Password',
                                'class'=>'form-control',
                                'label' => false,
                               
                               ));  
                            ?>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Confirm password</label>
                        <div class="col-sm-9 padding_top_20">
                                <?php echo $this->Form->password(
                                    'confirm_password', array(
                                    'placeholder'=>'Confirm password',
                                    'class'=>'form-control',
                                    'label' => false,
                                   
                                   ));  
                                ?>

                        </div>
                    </div>

                    <div class="box-footer button-form-sub">
                        <?php echo $this->Html->link('Cancel',['controller'=>'users','action'=>'profile'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Change Password', array('type'=>'submit','class'=>'btn btn-primary')); ?>
                    </div>
                </div>
             <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script(['user']);?>


