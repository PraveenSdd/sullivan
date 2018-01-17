 
<div class="login-box">
           <?= $this->Flash->render()?>
    <div class="login-logo">
        <b> <?php echo $this->Html->image('logo/sullivan-pc-blue-1000px.png',array('escape' => false,'alt'=>'Sullivan PC','style'=>'max-width:90%','id'=>'admin_user')); ?></b>

    </div>
    <div class="login-box-body">
        <p class="login-box-msg">Forgot Password</p>
                <?php echo $this->Form->create('Users', ['url' => '/admin/users/forgotPassword', 'id' => 'loginform', 'class' => 'form-signin']) ?>
        <div class="form-group has-feedback">
            <div class="input email">
              <?php echo $this->Form->input('email', array('type' => 'email', 'class' => 'form-control required', 'placeholder' => 'Email', 'label' => false, 'autocomplete' => "off")); ?>
            </div>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="row">   
            <div class="col-xs-">
                <div class="col-xs-3">
 <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-primary')); ?>
                </div>
                <div class="col-xs-3">
              <?php echo $this->Html->link('Cancel',['controller'=>'users','action'=>'login'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
                </div>  
            </div>
     <?php echo $this->Form->end();?>

        </div>
    </div>

<?= $this->Html->script(['user']);?>