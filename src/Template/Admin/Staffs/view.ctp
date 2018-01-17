<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border padding-top-5">
            <?php  echo $this->Form->create('Faqs', array('url' => array('controller' => 'Faqs', 'action' => 'add'),'id'=>'add_category',' method'=>'post','class'=>'form-horizontal')); ?>
                <div class=" pull-right ">
                             <?php echo $this->Html->link('Edit',['controller'=>'staffs','action'=>'edot'],array('class'=>'btn btn-primary','escape' => false)); ?>
                    </span>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-sm-3 ">First Name : </label>
                            <div class="col-sm-9 padding_top_20">
                                <?php echo $staff['first_name'];?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-sm-3 ">Last Name : </label>
                            <div class="col-sm-9 padding_top_20">
                          <?php echo $staff['last_name'];?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-sm-3 ">Email : </label>
                            <div class="col-sm-9 padding_top_20">
                                <?php echo $staff['email'];?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-sm-3 ">Phone : </label>
                            <div class="col-sm-9 padding_top_20">
                          <div class="phone-block padding-top-5" >
                                     <?php echo $staff['phone'];?>
                                </div>
                                <div class="phone-extension-block padding-top-5">
                                    <label> Extension </label>
                                    <?php echo $staff['phone_extension'];?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-sm-3 ">Position : </label>
                            <div class="col-sm-9 padding_top_20">
                                <?php echo $staff['position'];?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-sm-3 ">Level : </label>
                            <div class="col-sm-9 padding_top_20">
                            <?php echo $this->Custom->getPermissionName($staff['permission_acces']['permission_id']);?>

                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-sm-3 ">Address 1 : </label>
                            <div class="col-sm-9 padding_top_20">
                                <?php echo $staff['address']['address1'];?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-sm-3 ">Address 2 : </label>
                            <div class="col-sm-9 padding_top_20">
                          <?php echo $staff['address']['address2'];?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-sm-3 ">City : </label>
                            <div class="col-sm-9 padding_top_20">
                                <?php echo $staff['address']['city'];?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-sm-3 ">State : </label>
                            <div class="col-sm-9 padding_top_20">
                          <?php echo $this->Custom->getStateName($staff['address']['state_id']);?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="" class="col-sm-3 ">Zip Code : </label>
                            <div class="col-sm-9 padding_top_20">
                                <?php echo $staff['address']['zipcode'];?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="" class="col-sm-3 ">Phone : </label>
                            <div class="col-sm-9 padding_top_20">
                          <div class="phone-block padding-top-5" >
                                     <?php echo $staff['address']['phone'];?>
                                </div>
                                <div class="phone-extension-block padding-top-5">
                                    <label> Extension </label>
                                    <?php echo $staff['address']['phone_extension'];?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer button-form-sub">
                     <?php echo $this->Html->link('Cancel',['controller'=>'staffs','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?>
                </div>
            </div>
        </div>
    </div>
</div>


