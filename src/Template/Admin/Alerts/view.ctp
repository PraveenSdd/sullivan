<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border padding-top-5">
                <div class="col-md-8">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Alert Type</label>
                            <div class="col-sm-9 padding-top-10">
                                <?php echo $alert->alert_type->name;?>
                            </div>
                        </div>
                        <?php if(!empty($alert->alert_industries)){ ?>
                            <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Industries</label>
                            <div class="col-sm-9 padding-top-10">
                            <?php foreach($alert->alert_industries as $alertIndustry){ 
                                     $industry[] = $alertIndustry->industry->name;
                                    }
                                    echo implode(', &nbsp;', $industry);
                                ?>
                                </div>
                        </div>
                       <?php }?>
                        <?php if(!empty($alert->alert_companies)){ ?>
                            <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Companies</label>
                            <div class="col-sm-9 padding-top-10">
                            <?php foreach($alert->alert_companies as $alertCompany){
                                    $comapny[] = $alertCompany->Users->company;
                                    }
                                    echo implode(', &nbsp;', $comapny);
                            ?>
                          </div>
                        </div>
                       <?php }?>
                        <?php if(!empty($alert->alert_staffs)){ ?>
                            <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Staffs</label>
                            <div class="col-sm-9 padding-top-10">
                            <?php foreach($alert->alert_staffs as $alertStaff){
                                    $staffs[] = $alertStaff->user->first_name.' '.$alertStaff->user->last_name;
                                    }
                                    echo implode(', &nbsp;', $staffs);
                            ?>
                          </div>
                        </div>
                       <?php }?>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Title</label>
                            <div class="col-sm-9 padding-top-10">
                  <?php echo @$alert->title;?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Notes</label>
                            <div class="col-sm-9 padding-top-10">
                  <?php echo @$alert->notes;?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Date/Time</label>
                            <div class="col-sm-9 padding-top-10">
                                 <?php echo $this->Custom->DateTime(@$alert->date);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Time</label>
                            <div class="col-sm-9 padding-top-10">
                        <?php echo $alert->time; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Repetition</label>
                            <div class="col-sm-9 padding-top-10">
                                <?php if($alert->is_repeated == 1){ echo 'Yes';}else{ echo 'No';} ?>&nbsp;&nbsp;
                                <?php if($alert->is_repeated == 1){ echo   $alert->interval_alert.'&nbsp;&nbsp;-&nbsp;'. $alert->interval_type ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Created</label>
                            <div class="col-sm-9 padding-top-10">
                 <?php echo $this->Custom->DateTime(@$alert->created);?>
                            </div>
                        </div>

                    </div>

                    <div class="box-footer button-form-sub">
                        <?php echo $this->Html->link('Cancel',['controller'=>'alerts','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
                    </div>
                </div>
        
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script(['category']);?>



