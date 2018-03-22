<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border padding-top-5">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12 bg-primary clearfix text-center">
                            <?php echo $this->Form->hidden('Alert.name', array('data-id'=>$alerts->id,'value'=>htmlentities($alerts->name),'class'=>'form-control inp-alert-name')) ?>
                            <h3>  <?php echo ucfirst(htmlentities($alerts->title));?></h3>
                            <div style="text-align: left">
                                    <?php echo htmlentities($alerts->notes); ?>
                            </div>
                            <div>&nbsp;</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Alert Type :</label>
                            <div class="">
                                <?php echo htmlentities($alerts->alert_type->name);?>
                            </div>
                        </div>
                        <?php if(!empty($alerts['alert_operations'])){ ?>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Operations :</label>
                            <div class="">
                            <?php foreach($alerts['alert_operations'] as $alertsOperation){ 
                                     $operations[] = htmlentities($alertsOperation['operation']['name']);
                                    }
                                 
                                     if($operations) echo implode(', &nbsp;', $operations);
                                ?>
                            </div>
                        </div>
                       <?php }?>
                        <?php if(!empty($alerts['alert_companies'])){ ?>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Companies :</label>
                            <div class="">
                            <?php 
                                    foreach($alerts['alert_companies'] as $alertsCompany){
                                    $comapny[] = htmlentities($alertsCompany['user']['company']);
                                    }
                                     if($comapny) echo implode(', &nbsp;', $comapny);
                                
                            ?>
                            </div>
                        </div>
                       <?php }?>
                        <?php if($alerts['alert_staffs']){ ?>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Staffs :</label>
                            <div class="">
                            <?php  foreach($alerts['alert_staffs'] as $alertsStaff){
                                    $staffs[] = htmlentities($alertsStaff['user']['first_name']).' '.htmlentities($alertsStaff['user']['last_name']);
                                    }
                                      if($staffs) echo implode(', &nbsp;', $staffs);
                            ?>
                            </div>
                        </div>
                       <?php }?>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Date :</label>
                            <div class="">
                                 <?php echo $alerts->date; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Time :</label>
                            <div class="">
                        <?php  echo $alerts->time; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">End Date :</label>
                            <div class="">
                                 <?php echo $alerts->alert_end_date; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Repetition :</label>
                            <div class="">
                                <?php if($alerts->is_repeated) { 
                                    echo 'Yes - '.$alerts->interval_value.'/'.$alerts->interval_type;
                                } else {
                                    echo 'No';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Last Modified :</label>
                            <div class="">
                 <?php echo $this->Custom->DateTime($alerts->modified);?>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer button-form-sub">
                        <?php if(!$alertNotificationId) {
                            if($alerts->is_admin == 1){
                                     if( $LoggedRoleId==1 || ($LoggedRoleId==4 && $LoggedPermissionId==2) || ($LoggedRoleId==4 &&  $LoggedCompanyId != $alerts->added_by)){
                            echo $this->Html->link('Edit',['controller'=>'alerts','action'=>'edit',$alertId],array('class'=>'btn btn-primary','escape' => false));
                                     }
                            }
                            echo '&nbsp;&nbsp;';
                            echo $this->Html->link('Cancel',['controller'=>'alerts','action'=>'index'],array('class'=>'btn btn-warning','escape' => false));
                        } else {
                            echo $this->Html->link('Back',['controller'=>'alerts','action'=>'notification'],array('class'=>'btn btn-warning','escape' => false));
                        } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?= $this->Html->script(['category']);?>



