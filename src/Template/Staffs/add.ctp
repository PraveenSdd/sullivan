<?php ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
    <div class="form-default clearfix">
        <h5><?= $this->Flash->render() ?></h5>
           <?php  echo $this->Form->create('Staffs', array('url' => array('controller' => 'staffs', 'action' => 'add'),'id'=>'add_user',' method'=>'post')); ?>
            <div class="row">
                <div class="col-sm-6 col-xs-6">
                    <label>First Name<span class="text-danger">*</span></label>
                              <?php echo $this->Form->input(
                                    'first_name', array(
                                    'placeholder'=>'First Name',
                                    'class'=>'form-control',
                                    'label' => false,
                                   ));  
                                ?>
                </div>

                <div class="col-sm-6 col-xs-6">
                    <label>Last Name</label>
                              <?php echo $this->Form->input(
                                    'last_name', array(
                                    'placeholder'=>'Last Name',
                                    'class'=>'form-control',
                                    'label' => false,
                                   ));  
                                ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-xs-6">
                    <label>Email<span class="text-danger">*</span></label>
                             <?php echo $this->Form->input(
                                    'email', array(
                                    'placeholder'=>'Email',
                                    'class'=>'form-control',
                                    'label' => false,
                                    'data-id'=>'',
                                    'data-parentId'=>'',
                                   ));  
                                ?>
                </div>
                <div class="col-sm-6 col-xs-6">
                    <label>Phone<span class="text-danger">*</span></label>
                             <?php echo $this->Form->input(
                                    'phone', array(
                                    'placeholder'=>'Phone',
                                    'class'=>'form-control inp-phone',
                                    'label' => false,
                                   ));  
                                ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-xs-6">
                    <label>Password<span class="text-danger">*</span></label>
                               <?php echo $this->Form->password(
                                    'password', array(
                                    'placeholder'=>'Password',
                                    'class'=>'form-control password ',
                                    'label' => false,
                                     'id'=>'password'
                                   ));  
                                ?>
                </div>
                <div class="col-sm-6 col-xs-6">
                    <label>Confirm Password<span class="text-danger">*</span></label>
                               <?php echo $this->Form->password(
                                    'confirm_password', array(
                                    'placeholder'=>'Confirm Password',
                                    'class'=>'form-control password ',
                                    'label' => false,
                                   ));  
                                ?>
                </div>
            </div>

            <div class="col-sm-12 col-xs-12 clearfix">
                <?php echo $this->Html->link('Cancel',['/Staffs'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
     <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-default')); ?>
            </div>
         <?php echo $this->Form->end();?>
    </div>
             
</div>

<?= $this->Html->script(['user']);?>
