<?php ?>

<div class="inner-page-bx login-wrap main-content clearfix">
    <div class="container">

        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div class="hdd-brdr">
                    <h3>Reset Password</h3>
                </div>

                <div class="clearfix"></div>
  <?= $this->Flash->render()?>
                <div class="registration-wrap">
                    <div class="form-default clearfix">
                             <?php  echo $this->Form->create('Forms', array('url' => array('controller' => 'users', 'action' => 'resetPassword'),'id'=>'loginform',' method'=>'post')); ?>
                        <div class="addr-rept">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="pro-inpt-bx">
                                        <label>Password</label>
                                 <?php echo $this->Form->input('password', array('type' => 'password', 'class' => 'form-control required', 'placeholder' => 'Password', 'label' => false, 'maxlength' => 20, 'autocomplete' => "off")); ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="addr-rept">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="pro-inpt-bx">
                                        <label>Confirm Password</label>
                                  <?php echo $this->Form->input('confirm_password', array('type' => 'password', 'class' => 'form-control required', 'placeholder' => 'Confirm password', 'label' => false, 'maxlength' => 20, 'autocomplete' => "off")); ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                               <?= $this->Form->hidden('token',['value'=>$token]);?>
                    </div>
                        <?php echo $this->Form->button('Reset Password', array('type'=>'submit','class'=>'pull-right m-t-2 big-nxt-btn')); ?>

                </div>
   <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script(['user']);?>

