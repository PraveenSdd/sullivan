<?php ?>
<div class="login-box">
    <div class="login-logo">
        <a href="javascript:void(0);"><b> <?php echo $this->Html->image('logo/sullivan-pc-blue-1000px.png',array('escape' => false,'alt'=>'Sullivan PC','style'=>'max-width:90%','id'=>'admin_user')); ?></b></a>
    <?= $this->Flash->render()?>
    </div>
    <div class="login-box-body">
            <?php  echo $this->Flash->render('auth') ?>

        <p class="login-box-msg">Reset Password</p>

            <?php echo $this->Form->create('Users', ['url' => '/admin/users/resetPassword', 'id' => 'loginform', 'class' => 'form-signin']) ?>
        <div class="form-group has-feedback">
               <?php echo $this->Form->input('password', array('type' => 'password', 'class' => 'form-control required', 'placeholder' => 'Password', 'label' => false, 'maxlength' => 20, 'autocomplete' => "off")); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">

                 <?php echo $this->Form->input('confirm_password', array('type' => 'password', 'class' => 'form-control required', 'placeholder' => 'Confirm password', 'label' => false, 'maxlength' => 20, 'autocomplete' => "off")); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

        </div>

        <div class="form-actions">

            <span class="pull-right">
                 <?php echo $this->Form->button('Reset Password', array('type'=>'submit','class'=>'btn btn-primary')); ?>
            </span>
        </div>
                 <?= $this->Form->hidden('token',['value'=>$token]);?>

            <?php echo $this->Form->end(); ?>
        <br>
    </div>
</div>
