<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border padding-top-5">
            <?php  echo $this->Form->create('Faqs', array('url' => array('controller' => 'Faqs', 'action' => 'add'),'id'=>'add_category',' method'=>'post','class'=>'form-horizontal')); ?>
                <div class=" pull-right ">
                             <?php if($subAdminEdit == 1){  echo $this->Html->link('Edit',['controller'=>'users','action'=>'profileEdit'],array('class'=>'btn btn-primary','escape' => false)); } ?>
                    </span>
                </div>
                <div class="col-md-12">
                    <div class="col-md-8">

                        <div class="box-body">
                        <?php if($profile->user_id != 0){ 
                              $comanyName = $this->Custom->gitCompanyName($profile->user_id); ?>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Company Name : </label>
                                <div class="col-sm-9 padding_top_20 profile-label"><?php echo htmlentities($comanyName->company);?> </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">First Name : </label>
                                <div class="col-sm-9 padding_top_20 profile-label"> <?php echo htmlentities($profile->first_name);?></div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Last Name : </label>
                                <div class="col-sm-9 padding_top_20 profile-label"><?php if($comanyName->last_name){ echo htmlentities($profile->last_name); }?>  </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Email:</label>
                                <div class="col-sm-9 padding_top_20 profile-label">  <?php  echo htmlentities($comanyName->email); ?> </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Phone :</label>
                                <div class="col-sm-9 padding_top_20 profile-label"> <?php  echo $comanyName->phone; ?></div>
                            </div>
                        <?php }else{?>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Company Name :</label>
                                <div class="col-sm-9 padding_top_20 profile-label"><?php   echo htmlentities($profile->company);?></div>
                            </div>
                        

                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">First Name :</label> 
                                   <div class="col-sm-9 padding_top_20 profile-label"><?php echo htmlentities($profile->first_name);?>
                                   </div>
                            </div>
                          
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Last Name :</label>
                                <div class="col-sm-9 padding_top_20 profile-label"><?php if($profile->last_name){ echo htmlentities($profile->last_name); }?></div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-3 control-label">Email :</label>
                                <div class="col-sm-9 padding_top_20 profile-label"><?php  echo htmlentities($profile->email); ?> </div>

                            </div>
                             <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Phone :</label>
                                <div class="col-sm-3 padding_top_20 profile-label profile-label"><?php  echo $profile->phone; ?> </div>

                            
                            <div class="col-sm-2 padding_top_20 phone-ext">
                                <label for="" class="col-sm-2 control-label">Extension</label>
                                
                            </div>
                            <div class="col-sm-3 padding_top_20 profile-label">
                              <?php  echo $profile->phone_extension; ?>
                                
                            </div>
                            
                        </div>
                            <div class="box-footer button-form-sub">
                                <?php echo $this->Html->link('Cancel',['controller'=>'users','action'=>'profile'],array('class'=>'btn btn-warning','escape' => false)); ?>
                            </div>
                        <?php }?>
                        </div>
                    </div>
                    <?php echo $this->Form->end();?>
                    <div class="col-md-4">
                            <div class="profile-userpic">
                                        <?php if(isset($profile['profile_image'])){
                                                $img = $profile['profile_image'];
                                            }else{
                                                $img = 'img/profile/profile.jpg';
                                            }
                                        echo $this->Html->image('/'.$img,array('class'=>'img-responsive'));?>
                                <label  class="btn btn-primary browser-btn" data-toggle='modal'data-target= '#profileImageModel'>Change Photo</label>
                            </div>

    <?php echo $this->element('backend/users/profile_images'); ?>

                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


