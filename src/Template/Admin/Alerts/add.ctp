<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border padding-top-5">
                <?php echo $this->Form->create('Alert', array('url' => array('controller' => 'alerts', 'action' => 'add'), 'id' => 'frmAlert', ' method' => 'post', 'class' => 'form-horizontal frmAlert')); ?>
                <div class="col-md-12">
                    <div class="box-body">
                        <div class="row margin-top-15">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="CategoryName" class="col-sm-3 control-label">Alert Type<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                    <?php 
                                      echo $this->Form->input('Alert.alert_type_id', array(
                                         'type' => 'select',
                                         'options' => $alertTypeList,
                                          'empty'=>'Please select alert type',
                                          'label' => false,
                                          'class'=> 'form-control select2 required inp-alert-type',

                                          ));
                                       ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="usersName" class="col-sm-3 control-label">Sullivan Staffs</label>
                                    <div class="col-sm-9">
                                <?php 
                                    echo $this->Form->input('Alert.staff_id', array(
                                       'type' => 'select',
                                       'options' => $subAdminList,
                                        'multiple'=>true,
                                        'label' => false,
                                        'disabled','disabled',
                                        'class'=> 'form-control select2 inp-alert-staff',
                                        'data-alert-staff-id'=>''
                                     
                                        ));
                                     ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin-top-15">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="CategoryName" class="col-sm-3 control-label">Company</label>
                                    <div class="col-sm-9">
                                 <?php 
                                    echo $this->Form->input('Alert.company_id', array(
                                       'type' => 'select',
                                       'options' => $companyList,
                                        'multiple'=>true,
                                        'label' => false,
                                        'disabled','disabled',
                                        'class'=> 'form-control select2  inp-alert-company',
                                      'data-alert-company-id'=>''
                                        ));
                                     ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="CategoryName" class="col-sm-3 control-label">Operations</label>
                                    <div class="col-sm-9">
                                <?php 
                                    echo $this->Form->input('Alert.operation_id', array(
                                       'type' => 'select',
                                       'options' => $operationList,
                                        'multiple'=>true,
                                        'label' => false,
                                        'disabled','disabled',
                                        'class'=> 'form-control select2 inp-alert-operation',
                                     'data-alert-operation-id'=>''
                                        ));
                                     ?>

                                    </div>
                                </div>  
                            </div>
                        </div>
                        <div class="row margin-top-15">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="CategoryName" class="col-sm-3 control-label">Title<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                            <?php echo $this->Form->input('Alert.title', array(
                                                  'placeholder'=>'Title',
                                                  'class'=>'form-control required inp-alert-title',
                                                  'label' => false,
                                                  'maxlength'=>40,
                                                 ));  
                                              ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="CategoryName" class="col-sm-3 control-label">Date</label>
                                    <div class="col-sm-9">
                                <?php echo $this->Form->input('Alert.date', array(
                                                  'placeholder'=>'MM-DD-YYYY',
                                                  'class'=>'form-control inp-date-picker inp-alert-date',
                                                  'label' => false,
                                                 ));  
                                              ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin-top-15">
                            <div class="col-sm-6">
                                <div class="form-group">

                                    <label for="CategoryName" class="col-sm-3 control-label">Time</label>
                                    <div class="col-sm-9">
                                <?php echo $this->Form->input('Alert.time', array(
                                                  'placeholder'=>'HH:MM AM/PM',
                                                  'class'=>'form-control inp-time-picker  inp-alert-time',
                                                  'label' => false,
                                                 ));  
                                              ?>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="CategoryName" class="col-sm-3 control-label">Is Repeat</label>
                                    <div class="col-sm-9">
                                        <div class="col-sm-1">
                                            <?php
                                            echo $this->Form->input('Alert.is_repeated', array(
                                                'type' => 'checkbox',
                                                'class' => 'inp-alert-repeat',
                                                'label' => false,
                                            ));
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                <?php 
                                        echo $this->Form->input('Alert.interval_value', array(
                                                  'label' => false,
                                                  //'disabled'=>'disabled',
                                                   'class'=>'form-control inp-integer inp-alert-interval',
                                                   'maxlength'=>2
                                                 ));  
                                              ?>
                                        </div>
                                        <div class="col-sm-6">
                                     <?php 
                                        echo $this->Form->input('Alert.interval_type', array(
                                       'type' => 'select',
                                        'label' => false,
                                        //'disabled'=>'disabled',
                                        'options' => ['Days'=>'Days','Weeks'=>'Weeks','Months'=>'Months'],
                                         'class'=>'form-control  inp-alert-interval-type'   
                                        
                                        ));
                                     ?>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <div class="row margin-top-15">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="CategoryName" class="col-sm-3 control-label">Notes<span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                <?php echo $this->Form->textarea(
                                        'Alert.notes',
                                        array(
                                            'placeholder'=>'Notes',
                                            'class'=>'form-control inp-alert-notes',
                                            'label' => 'false',
                                              'rows'=>"5",
                                            'maxlength'=>160,
                                           ));  
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="CategoryName" class="col-sm-3 control-label">End Date</label>
                                    <div class="col-sm-9">
                                <?php echo $this->Form->input('Alert.alert_end_date', array(
                                                  'placeholder'=>'MM-DD-YYYY',
                                                  'class'=>'form-control inp-date-picker inp-alert-end-date',
                                                  'label' => false,
                                                 ));  
                                              ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer button-form-sub">
                          <?php echo $this->Html->link('Cancel',['controller'=>'alerts','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-primary')); ?>

                        </div>
                    </div>
                </div>
             <?php echo $this->Form->end();?>

            </div>
        </div>
    </div>
</div>
<?= $this->Html->script(['backend/alert']);?>






