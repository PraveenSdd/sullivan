 <?php  ?>
<div class="login-box">
            <?= $this->Flash->render()?>
    <div class="login-logo">
        <b> <?php echo $this->Html->image('logo/logo-color-bold.png',array('escape' => false,'alt'=>'Sullivan PC','style'=>'max-width:90%')); ?></b>

    </div>
    <div class="login-box-body">
            <?php  echo $this->Flash->render('auth') ?>
        <p class="login-box-msg">Sign in to start your session</p>
            <?php echo $this->Form->create('Users', ['url' => '/admin/users/login', 'id' => 'loginform', 'class' => 'form-signin']) ?>
        <div class="form-group has-feedback">
                <?php echo $this->Form->input('email', array('type' => 'email', 'class' => 'form-control required', 'placeholder' => 'Email', 'label' => false, 'maxlength' => 30, 'autocomplete' => "off")); ?>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
                <?php echo $this->Form->input('password', array('type' => 'password', 'class' => 'form-control required', 'placeholder' => 'Password', 'label' => false,  'maxlength' => 20, 'autocomplete' => "off")); ?>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">

                        <?php if(!empty($this->request->data['email'])){
                             echo $this->Form->input('remember_me', ['hiddenField' => false, 'label' => false, 'div' => false, 'type' => 'checkbox', 'value' => 0, 'checked' => 'checked']);    
                        }else{
                            echo $this->Form->input('remember_me', ['hiddenField' => false, 'label' => false, 'div' => false, 'type' => 'checkbox', 'value' => 1]);
                        }
                        
                        
                        ?> 
                    <label for="checkbox">Remember Me</label>

                </div>
            </div>
            <div class="col-xs-4">
 <?php echo $this->Form->button('Sign In', array('type'=>'submit','class'=>'btn btn-primary btn-block btn-flat')); ?>
            </div>
        </div>
            <?php echo $this->Form->end(); ?>

            <?php //echo $this->Html->link('I forgot my password', ['controller' => 'Users', 'action' => 'forgotPassword']); ?>
        <br>
    </div>
</div>
<?= $this->Html->script(['user']);?>