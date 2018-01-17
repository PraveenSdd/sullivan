<?php ?>
<div class="inner-page-bx login-wrap main-content clearfix">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div class="hdd-brdr">
                    <h3>Forgot Password</h3>
                </div>

                <div class="clearfix"></div>
  <?= $this->Flash->render()?>
                <div class="registration-wrap">
                    <div class="form-default clearfix">
                             <?php  echo $this->Form->create('Forms', array('url' => array('controller' => 'users', 'action' => 'forgotPassword'),'id'=>'loginform',' method'=>'post')); ?>
                        <div class="addr-rept">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="pro-inpt-bx">
                                        <label>Email</label>
                                            <?php echo $this->Form->input('email', array(
                                                 'placeholder'=>'Enter Email',
                                                 'class'=>'form-control',
                                                 'label' => false,
                                                 'data-id'=>'',
                                                 'data-parentId'=>'',
                                                ));  
                                             ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                     <?php echo $this->Form->button('Send', array('type'=>'submit','class'=>'pull-right m-t-2 big-nxt-btn')); ?>
               </div>
   <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script(['user']);?>