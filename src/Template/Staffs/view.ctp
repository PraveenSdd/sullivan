<?php ?>

<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>
    <div class="form-default clearfix">
         <div class="col-md-12">
             <div class="row text-right">
                 
                 <?php $id = $this->Encryption->encode($staff['id']);
                 if($LoggedPermissionId==4){
                 echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'staffs','action'=>'edit',$id],array('title'=>'Edit','escape' => false));
                 }
                 ?>
             </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-sm-4 ">First Name : </label>
                            <div class="">
                                <?php echo $staff['first_name'];?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-sm-4 ">Last Name : </label>
                            <div class="">
                          <?php echo $staff['last_name'];?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-sm-4 ">Email : </label>
                            <div class="">
                                <?php echo $staff['email'];?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-sm-4 ">Phone : </label>
                            <div class="">
                                     <?php echo $staff['phone'];?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-sm-4 ">Position : </label>
                            <div class="">
                                <?php echo $staff['position'];?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-sm-4 ">Level : </label>
                            <div class="">
                            <?php echo $this->Custom->getPermissionName($staff['permission_id']);?>

                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-sm-4 ">Address 1 : </label>
                            <div class="">
                                <?php echo $staff['address']['address1'];?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-sm-4 ">Address 2 : </label>
                            <div class="">
                          <?php echo $staff['address']['address2'];?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-sm-4 ">City : </label>
                            <div class="">
                                <?php echo $staff['address']['city'];?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-sm-4 ">State : </label>
                            <div class="">
                          <?php if($staff['address']['state_id']) echo $this->Custom->getStateName($staff['address']['state_id']);?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-sm-4 ">Zip Code : </label>
                            <div class="">
                                <?php echo $staff['address']['zipcode'];?>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-sm-4 ">Created : </label>
                            <div class="">
                                 <?php echo $this->Custom->dateTime($staff['created']) ; ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
        
        <div class="col-sm-12 col-xs-12 clearfix">
            <?php echo $this->Html->link('Cancel',['controller'=>'staffs','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
        </div>
    </div>

</div>
</div>

