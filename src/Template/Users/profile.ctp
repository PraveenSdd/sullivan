<?php

$ecodeUserId = $this->Encryption->encode($Authuser['id']); ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>
    <h5><?= $this->Flash->render() ?></h5>
    <div class="form-default clearfix">
        <div class="row">
            <div class="col-xs-12 col-sm-12"> <span class="pull-left"><b>Company</b></span> 
                <span class="pull-right">
                    <?php echo $this->Html->link('Location',['controller'=>'locations','action'=>'add'],array('escape' => false)); ?>&nbsp;/ &nbsp;
                <?php echo $this->Html->link('Edit',['controller'=>'users','action'=>'edit_profile',$ecodeUserId    ],array('escape' => false)); ?>
                </span>
            </div>
        </div> 
        <hr/>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Name :</label></div>
                    <div class="info-line-right">
                        <?php 
                        if($users['role_id']==2){ 
                            echo $users['company'];
                        }else{
                            echo $companyDetails['basic_info']['company'];
                        }?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Logo :</label></div>
                    <div class="info-line-right">
                                <?php if($users['role_id']==2){ $logo = $users['logo']; }else{ $logo = $companyDetails['basic_info']['logo'];   } ?> 
                        <?php echo ($this->Html->image($logo,array('style'=>'width:80px;')));?>
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
        <div class="row"><div class="col-xs-12 col-sm-12"> <span class="pull-left"><b>Conatct Details</b></span> </div>
        </div>  
        <hr/>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">First Name :</label></div>
                    <div class="info-line-right"> <?= $users['first_name']?></div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Last Name :</label></div>
                    <div class="info-line-right">  <?= $users['last_name']?></div>
                </div>
            </div>


        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Position :</label></div>
                    <div class="info-line-right">    <?= $users['position']?></div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Phone :</label></div>
                    <div class="info-line-right">  <?= $users['phone']?></div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Email :</label></div>
                    <div class="info-line-right">     <?= $users['email']?></div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">&nbsp;</label></div>
                    <div class="info-line-right">
                        <?php echo ($this->Html->image($users['profile_image'],array('style'=>'width:100px;')));?>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12 clearfix">
                <a href="/projects" class="btn btn-warning">Cancel</a>
            </div>
        </div>

    </div>
</div>

