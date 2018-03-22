<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border padding-top-5">
            <?php  echo $this->Form->create('Users', array('url' => array('controller' => 'users', 'action' => 'profileEdit'),'id'=>'add_user',' method'=>'post','class'=>'form-horizontal')); ?>
                <div class=" pull-right ">
                             <?php echo $this->Html->link('Back',['controller'=>'users','action'=>'profile'],array('class'=>'btn btn-primary','escape' => false)); ?>
                    </span>
                </div>
                <div class="col-md-8">

                    <div class="box-body">
                        <?php if($profile->user_id != 0){ 
                              $comanyName = $this->Custom->gitCompanyName($profile->user_id); ?>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Company Name :</label>
                            <div class="col-sm-9 padding_top_20">
                                <?php echo $comanyName->company;?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">First Name :</label>;
                            <div class="col-sm-9 padding_top_20">
                    <?php echo $comanyName->first_name;?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Last Name :</label>
                            <div class="col-sm-9 padding_top_20">
                    <?php if($comanyName->last_name){ echo $profile->last_name; }?>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Email :</label>
                            <div class="col-sm-9 padding_top_20">
                    <?php  echo $comanyName->email; ?>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Phone :</label>
                            <div class="col-sm-9 padding_top_20">
                    <?php  echo $comanyName->phone; ?>
                            </div>

                        </div>
                        <?php }else{?>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Company Name :</label>
                            <div class="col-sm-9 padding_top_20 profile-label">
                            <?php echo $profile->company;?>

                            </div>
                        </div>
                        <?php }?>

                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">First Name :</label>
                            <div class="col-sm-9 padding_top_20">
                                <?php echo $this->Form->input(
                                'first_name', array(
                                'placeholder'=>'First Name',
                                'class'=>'form-control required',
                                'label' => false,
                                'value'=>$profile->first_name,
                               ));  
                            ?>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Last Name :</label>
                            <div class="col-sm-9 padding_top_20">
                                <?php echo $this->Form->input(
                                    'last_name', array(
                                    'placeholder'=>'Last Name',
                                    'class'=>'form-control required',
                                    'label' => false,
                                    'value'=>$profile->last_name,
                                   ));  
                                ?>

                            </div>

                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Email :</label>
                            <div class="col-sm-9 padding_top_20">
                                 <?php echo $this->Form->email(
                                    'email', array(
                                    'placeholder'=>'Email',
                                    'class'=>'form-control',
                                    'label' => false,
                                    'value'=>$profile->email,
                                   ));  
                                ?>

                            </div>

                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Phone :</label>
                            <div class="col-sm-4 padding_top_20">
                                <?php echo $this->Form->input(
                                    'phone', array(
                                    'placeholder'=>'Phone',
                                    'class'=>'form-control inp-phone',
                                    'label' => false,
                                    'value'=>$profile->phone,
                                   ));  
                                ?>
                            </div>
                            
                            <div class="col-sm-2 padding_top_20 phone-ext">
                                <label for="" class="col-sm-3 control-label">Extension</label>
                                
                            </div>
                            <div class="col-sm-3 padding_top_20 phone-ext">
                               <?php echo $this->Form->input('phone_extension', array(
                                                'class'=>'form-control phone-extension-address inp-add_address-country_code',
                                                'id'=>'phone_extension',
                                                 'placeholder'=>'Extension ',
                                                 'maxlength'=>4,
                                                'div'=>false,
                                                'legend' => false,
                                                'label' => false,
                                                'value'=>$profile->phone_extension,
                                                 ));  
                                              ?>
                                
                            </div>
                            
                        </div>
                        <div class="box-footer button-form-sub">
                        <?php echo $this->Html->link('Cancel',['controller'=>'users','action'=>'profile'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-primary')); ?>
                        </div>
                    </div>
             <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
<?= $this->Html->script(['user']);?>



