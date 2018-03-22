<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border padding-top-5">
                <div class="col-md-12">                    
                    <div class="box-body">
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Message :</label>
                            <div class="">
                                <?php echo htmlentities($activityLogs->message);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Activity :</label>
                            <div class="">
                                <?php echo htmlentities($activityLogs->activity);?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Module :</label>
                            <div class="">
                                <?php echo htmlentities($activityLogs->module_name);
                                if($activityLogs->sub_module_name){
                                    echo " (".htmlentities($activityLogs->sub_module_name).")";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Modified Date :</label>
                            <div class="">
                                 <?php echo $this->Custom->HumanReadable($activityLogs->date); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Modified By :</label>
                            <div class="">
                                <?php echo htmlentities($activityLogs->added_by->first_name.' '.$activityLogs->added_by->last_name);
                                if (!in_array($LoggedCompanyId, array(1, 4))) {
                                    echo " (".htmlentities($activityLogs->users->company).")";
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer button-form-sub">
                        <?php echo $this->Html->link('Back',['controller'=>'activityLogs','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?>
                    </div>
                </div>
        
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script(['category']);?>



