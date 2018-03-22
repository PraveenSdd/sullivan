<?php ?>
<div class="modal fade modal-default" id="operationAlertModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
 <?php  echo $this->Form->create('OperationAlert', array('url' =>'javascript:void(0);' ,'id'=>'frmOperationAlert',' method'=>'post','class'=>'form-horizontal frmOperationAlert')); ?>                     
                    <div class="row margin-top-15">
                        <div class="col-sm-6 col-xs-6 custom-pop-select2">
                            <label>Alert Type <span class="text-danger">*</span></label>
                                    <?php 
                                    echo $this->Form->hidden('OperationAlert.alert_id', array(
                                    'label' => false,
                                    'class'=> 'form-control inp-alert-id',
                                    'id'=>'inptAlertId'
                                    ));
                                ?>
                                    <?php 
                                      echo $this->Form->input('OperationAlert.alert_type_id', array(
                                         'type' => 'select',
                                         'options' => $alertTypeList,
                                          'empty'=>'Please select alert Type',
                                          'label' => false,
                                          'class'=> 'form-control select2 alertType inp-alert-type',

                                          ));
                                       ?>
                        </div>
                        <div class="col-sm-6 col-xs-6 custom-pop-select2">
                            <label>Sullivan Staffs</label>
                                  <?php 
                                    echo $this->Form->input('OperationAlert.staff_id', array(
                                       'type' => 'select',
                                       'options' => $subAdminList,
                                        'multiple'=>true,
                                        'label' => false,
                                        'disabled','disabled',
                                        'class'=> 'form-control select2 alertStaff inp-alert-staff',
                                        'data-alert-staff-id'=>''
                                        ));
                                     ?>

                        </div>
                        
                    </div>
                    <div class="row margin-top-15">
                        <div class="col-sm-6 col-xs-6 custom-pop-select2">
                            <label>Company</label>
                                  <?php 
                                    echo $this->Form->input('OperationAlert.company_id', array(
                                       'type' => 'select',
                                       'options' => $companyList,
                                        'multiple'=>true,
                                        'label' => false,
                                        'disabled','disabled',
                                        'class'=> 'form-control select2 alertStaff inp-alert-company',
                                        'data-alert-company-id'=>''
                                      
                                        ));
                                     ?>
                        </div>
                        <div class="col-sm-6 col-xs-6 custom-pop-select2">
                            <label>Operation</label>
                                    <?php 
                                    echo $this->Form->input('OperationAlert.operation_id', array(
                                       'type' => 'select',
                                       'options' => $operationList,
                                        'multiple'=>true,
                                        'label' => false,
                                        'disabled','disabled',
                                        'class'=> 'form-control select2 alertIndustry inp-alert-operation',
                                        'data-alert-operation-id'=>''
                                        ));
                                     ?>

                        </div>
                        
                    </div>



                    <div class="row margin-top-15">
                        <div class="col-sm-6 col-xs-6">
                            <label>Title <span class="text-danger">*</span></label>
                                      <?php echo $this->Form->input('OperationAlert.title', array(
                                                  'placeholder'=>'Title',
                                                  'class'=>'form-control required alertTitle inp-alert-title',
                                                  'label' => false,
                                                 ));  
                                              ?>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <label>Date <span class="text-danger">*</span></label>
                                     <?php echo $this->Form->input('OperationAlert.date', array(
                                                  'placeholder'=>'MM-DD-YYYY',
                                                  'class'=>'form-control inp-date-picker alertDate inp-alert-date',
                                                  'label' => false,
                                                 ));  
                                              ?>
                        </div>

                    </div>


                    <div class="row margin-top-15">
                        <div class="col-sm-6 col-xs-6 timer">
                            <label>Time</label>
                                      <?php echo $this->Form->input('OperationAlert.time', array(
                                                  'placeholder'=>'HH:MM AM/PM',
                                                  'class'=>'form-control inp-time-picker alertTime inp-alert-time',
                                                  'label' => false,
                                                 ));  
                                              ?>

                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <label>Notes <span class="text-danger">*</span></label>
                                    <?php echo $this->Form->textarea('OperationAlert.notes',
                                        array(
                                            'placeholder'=>'Notes',
                                            'class'=>'form-control alertNotes inp-alert-notes',
                                            'label' => 'false',
                                              'rows'=>"2",
                                           ));  
                                        ?>
                        </div>

                    </div> 
                    <div class="row margin-top-15">
                        <div class="col-sm-6 col-xs-6">
                            <label>Is Repeat</label>
                            <div class="col-sm-12">
                                <div class="col-sm-1">
                                            <?php
                                            echo $this->Form->input('OperationAlert.is_repeated', array(
                                                'type' => 'checkbox',
                                                'class' => 'inp-alert-repeat',
                                                'label' => false,
                                            ));
                                            ?>
                                </div>
                                <div class="col-sm-4">
                                <?php 
                                        echo $this->Form->input('OperationAlert.interval_value', array(
                                                  'label' => false,
                                                  'disabled'=>'disabled',
                                                   'class'=>'form-control inp-integer inp-alert-interval',
                                                   'maxlength'=>2
                                                 ));  
                                              ?>
                                </div>
                                <div class="col-sm-6">
                                     <?php 
                                        echo $this->Form->input('OperationAlert.interval_type', array(
                                       'type' => 'select',
                                        'label' => false,
                                        'disabled'=>'disabled',
                                        'options' => ['Days'=>'Days','Weeks'=>'Weeks','Months'=>'Months'],
                                         'class'=>'form-control  inp-alert-interval-type'   
                                        
                                        ));
                                     ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <label>End Date <span class="text-danger">*</span></label>
                                     <?php echo $this->Form->input('OperationAlert.alert_end_date', array(
                                                  'placeholder'=>'MM-DD-YYYY',
                                                  'class'=>'form-control inp-date-picker alertDate inp-alert-end-date',
                                                  'label' => false,
                                                 ));  
                                              ?>
                        </div>
                    </div>

                    <div class="col-sm-12 col-xs-12 clearfix padding-top-10">
                         <?php echo $this->Form->button('Submit', array('type'=>'type','class'=>'btn btn-default subOperationAlert')); ?>
                    </div>

                   <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>