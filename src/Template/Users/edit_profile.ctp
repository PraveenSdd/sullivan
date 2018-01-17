
<?php  ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
    <div class="form-default clearfix">
        <h5><?= $this->Flash->render() ?></h5>

<?php echo $this->Form->create('Users', array('url' => array('controller' => 'users', 'action' => 'edit_profile'),'id'=>'editProfile',' method'=>'post','enctype'=>'multipart/form-data')); ?>
        <h4>Company</h4>
              <?php if($Authuser['role_id'] ==2){ ?>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Name<span class="text-danger">*</span></label>
                <span class="form-control" style="background-color: #cccccc;"> <?php echo $users['company'] ?></span>

            </div>
            <div class="col-sm-6 col-xs-6">
                <label>Logo</label>
                            <?php echo $this->Form->file(
                                'logo', array(
                                'class'=>'form-control ',
                                'label' => false,
                               ));  
                            ?>
            </div>


        </div>
        <div class="row">

            <div class="col-sm-6 col-xs-6">
                <label>Email</label>
                                  <?php echo $this->Form->input(
                                        'Company.email', array(
                                        'placeholder'=>'Email',
                                        'class'=>'form-control',
                                        'label' => false,
                                        'value'=>$users['user_location']['email'],
                                        'data-id'=>$users['id'],
                                        'data-parentId'=>'',
                                       ));  
                                    ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label>Phone<span class="text-danger">*</span></label>
                                 <?php echo $this->Form->input(
                                        'Company.phone', array(
                                        'placeholder'=>'Phone',
                                        'class'=>'form-control inp-phone',
                                        'label' => false,
                                        'value'=>$users['user_location']['phone'],
                                       ));  
                                    ?>
            </div>


        </div>
        <div class="row">

            <div class="col-sm-6 col-xs-6">
                <label>Address 1<span class="text-danger">*</span></label>
                                 <?php echo $this->Form->input(
                                        'Company.address_1', array(
                                        'placeholder'=>'Address 1',
                                        'class'=>'form-control ',
                                        'label' => false,
                                        'value' => $users['user_location']['address1'],
                                       ));  
                                    ?>
            </div>


            <div class="col-sm-6 col-xs-6">
                <label>Address 2<span class="text-danger">*</span></label>
                                 <?php echo $this->Form->input(
                                        'Company.address_2', array(
                                        'placeholder'=>'Address 2',
                                        'class'=>'form-control ',
                                        'label' => false,
                                         'value' => $users['user_location']['address2'],
                                       ));  
                                    ?>
            </div>


                     <?php echo $this->Form->hidden(
                                        'Company.id', array(

                                        'label' => false,
                                        'value' => $users['user_location']['id'],
                                       ));  
                                    ?>
        </div>
              <?php }else{ ?>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Name :</label></div>
                    <div class="info-line-right"> <?php 
                        if($users['role_id']==2){ 
                            echo $users['company'];
                        }else{
                            echo $companyDetails['basic_info']['company'];
                            
                        }?></div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Logo :</label></div>
                    <div class="info-line-right">
                                <?php if($users['role_id']==2){ $logo = $users['logo']; }else{ $logo = $companyDetails['basic_info']['logo'];   } ?> 
                        <img style="width:80px;" src="<?php  echo $this->Html->webroot.'/'.$logo;?>">

                    </div>
                </div>
            </div>



        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Email :</label></div>
                    <div class="info-line-right"> <?php if($users['role_id']==2){ echo $users['user_location']['email'];}else{ echo $companyDetails['basic_info']['email']; }?></div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Phone :</label></div>
                    <div class="info-line-right"> <?php if($users['role_id']==2){
                            echo $users['user_location']['phone'];
                            
                        }else{ 
                            echo $companyDetails['basic_info']['phone']; }?></div>
                </div>
            </div>      


        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="CategoryName" class="control-label">Address 1 :</label></div>
                    <div class="info-line-right"> <?php if($users['role_id']==2){ echo $users['user_location']['address1'];}else{ echo $companyDetails['location_info']['address1']; }?></div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="CategoryName" class="control-label">Address 2 :</label></div>
                    <div class="info-line-right"> <?php if($users['role_id']==2){ echo $users['user_location']['address2'];}else{ echo $companyDetails['location_info']['address2']; }?></div>
                </div>
            </div>
        </div>
              <?php } ?>
        <h4>Contact Details</h4>


        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>First Name<span class="text-danger">*</span></label>
                         <?php echo $this->Form->input(
                                'Contact.first_name', array(
                                'placeholder'=>'First name',
                                'class'=>'form-control ',
                                'label' => false,
                                'value'=>$users['first_name'],
                               ));  
                            ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label>Last Name<span class="text-danger">*</span></label>
                            <?php echo $this->Form->input(
                                'Contact.last_name', array(
                                'placeholder'=>'Last name',
                                'class'=>'form-control ',
                                'label' => false,
                                'value'=>$users['last_name'],
                               ));  
                            ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Position<span class="text-danger">*</span></label>
                         <?php echo $this->Form->input(
                                'Contact.position', array(
                                'placeholder'=>'Position',
                                'class'=>'form-control ',
                                'label' => false,
                                'value'=>$users['position'],
                               ));  
                            ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label>Phone<span class="text-danger">*</span></label>
                            <?php echo $this->Form->input(
                                'Contact.phone', array(
                                'placeholder'=>'phone',
                                'class'=>'form-control inp-phone',
                                'label' => false,
                                'value'=>$users['phone'],
                               ));  
                            ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Email<span class="text-danger">*</span></label>
                         <?php echo $this->Form->input(
                                'Contact.email', array(
                                'placeholder'=>'Email',
                                'class'=>'form-control ',
                                'label' => false,
                                'value'=>$users['email'],
                                'data-id'=>$users['id'],
                                'data-parentId'=>'',
                               ));  
                            ?>
            </div>

            <div class="col-sm-6 col-xs-6">
                <label>Profile Image</label>
                                 <?php echo $this->Form->file(
                                        'profile_image', array(
                                        'class'=>'form-control ',
                                        'label' => false,
                                       ));  
                                    ?>
            </div>


      <?php echo $this->Form->hidden(
                                'Contact.id', array(
                               
                                'label' => false,
                                'value' => $users['id'],
                               ));  
                            ?>
        </div>

        <div class="col-sm-12 col-xs-12 clearfix">
                       <?php echo $this->Html->link('Cancel',['/profile'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('update', array('type'=>'submit','class'=>'btn btn-default')); ?>

        </div>
<?php echo $this->Form->end();?>
    </div>

</div>

<?= $this->Html->script(['signup']);?>
	