<?php

$ecodeUserId = $this->Encryption->encode($Authuser['id']); ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>
    <h5><?= $this->Flash->render() ?></h5>
    <div class="form-default clearfix">
        <div class="row">
            <div class="col-xs-12 col-sm-12"> <span class="pull-left"><b>Company</b></span> 
                <span class="pull-right">
                    <?php echo $this->Html->link('Location',['controller'=>'locations','action'=>'index'],array('escape' => false)); ?>   &nbsp;/ &nbsp;
                    <?php echo $this->Html->link('Edit',['controller'=>'users','action'=>'edit_profile',$userId],array('escape' => false));?>
                    
                </span>
            </div>
        </div> 
        <hr/>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Name :</label></div>
                    <div class="info-line-right">
                        <?php $userData['basic_info']->company; ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Logo :</label></div>
                    <div class="info-line-right">                                
                        <?php echo ($this->Html->image('/'.$userData['basic_info']->logo,array('style'=>'width:80px;')));?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Email :</label></div>
                    <div class="info-line-right"> <?php echo $userData['location_info']->email; ?></div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Phone :</label></div>
                    <div class="info-line-right"> <?php echo $userData['location_info']->phone; ?></div>
                </div>
            </div>      
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="CategoryName" class="control-label">Address 1 :</label></div>
                    <div class="info-line-right"> <?php echo $userData['location_info']->address1; ?></div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="CategoryName" class="control-label">Address 2 :</label></div>
                    <div class="info-line-right"> <?php echo $userData['location_info']->address2; ?></div>
                </div>
            </div>
        </div>
        <div class="row"><div class="col-xs-12 col-sm-12"> <span class="pull-left"><b>Contact Details</b></span> </div>
        </div>  
        <hr/>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">First Name :</label></div>
                    <div class="info-line-right"> <?= $userData['basic_info']->first_name;?></div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Last Name :</label></div>
                    <div class="info-line-right">  <?= $userData['basic_info']->last_name; ?></div>
                </div>
            </div>


        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Position :</label></div>
                    <div class="info-line-right">    <?= $userData['basic_info']->position; ?></div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Phone :</label></div>
                    <div class="info-line-right">  <?= $userData['basic_info']->phone; ?></div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">Email :</label></div>
                    <div class="info-line-right">     <?= $userData['basic_info']->email; ?></div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6">
                <div class="info-line-bx">
                    <div class="info-line-left"><label for="" class="control-label">&nbsp;</label></div>
                    <div class="info-line-right">
                        <?php echo ($this->Html->image('/'.$userData['basic_info']->profile_image,array('style'=>'width:100px;')));?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

