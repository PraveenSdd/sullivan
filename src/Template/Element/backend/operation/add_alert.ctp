<?php ?>
<div class="modal fade modal-default" id="operationAlertModel" role="dialog">
    <div class="modal-dialog modal-lg">
        Modal content
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
 <?php  echo $this->Form->create('Forms', array('url' =>'javascript:void(0);' ,'id'=>'frmOperationAlert',' method'=>'post','class'=>'form-horizontalfrmPermitAlert')); ?>                     
                    <div class="row">
                        <div class="col-sm-6 col-xs-6 custom-pop-select2">
                            <label>Alert Type <span class="text-danger">*</span></label>
                                    <?php 
                                      echo $this->Form->input('alert_type_id', array(
                                         'type' => 'select',
                                         'options' => $alertTypesList,
                                          'empty'=>'Please select alert Type',
                                          'label' => false,
                                          'class'=> 'form-control select2 alertType',

                                          ));
                                       ?>
                        </div>
                        <div class="col-sm-6 col-xs-6 custom-pop-select2">
                            <label>Company </label>
                                  <?php 
                                    echo $this->Form->input('company_id', array(
                                       'type' => 'select',
                                       'options' => $companiesLists,
                                        'multiple'=>true,
                                        'label' => false,
                                        'disabled','disabled',
                                         'empty' =>'',
                                        'class'=> 'form-control select2 alertStaff',
                                        'id'=>'companiesList',
                                      
                                        ));
                                     ?>
                        </div>
                    </div>
                    <div class="row padding-top-10">

                        <div class="col-sm-6 col-xs-6 custom-pop-select2">
                            <label>Sullivan Staffs</label>
                                  <?php 
                                    echo $this->Form->input('staff_id', array(
                                       'type' => 'select',
                                       'options' => $staffLists,
                                        'multiple'=>true,
                                        'label' => false,
                                        'disabled','disabled',
                                        'empty' =>'',
                                        'class'=> 'form-control select2 alertStaff',
                                        'id'=>'staffList',
                                     
                                        ));
                                     ?>

                        </div>
                        <div class="col-sm-6 col-xs-6">
                            <label>Title <span class="text-danger">*</span></label>
                                <?php echo $this->Form->input('title', array(
                                            'placeholder'=>'Title',
                                            'class'=>'form-control required alertTitle',
                                            'label' => false,
                                              'maxlength'=>40, 
                                           ));  
                                        ?>
                        </div>
                    </div>
                    <div class="row padding-top-10">

                        <div class="col-sm-6 col-xs-6">
                            <label>Date <span class="text-danger">*</span></label>
                                     <?php echo $this->Form->input('date', array(
                                                  'placeholder'=>'mm-dd-yyyy',
                                                  'class'=>'form-control datepicker alertDate',
                                                  'label' => false,
                                                    'id'=>'datepicker',
                                                 ));  
                                              ?>
                        </div>

                        <div class="col-sm-6 col-xs-6">
                            <label>Time </label>
                                      <?php echo $this->Form->input('time', array(
                                                  'placeholder'=>'hh:mm',
                                                  'class'=>'form-control time alertTime',
                                                  'label' => false,
                                                 ));  
                                              ?>

                        </div>
                    </div>
                    <div class="row padding-top-10">
                        <div class="col-sm-12 col-xs-12">
                            <label>Notes <span class="text-danger">*</span></label>
                                    <?php echo $this->Form->textarea(
                                        'notes',
                                        array(
                                            'placeholder'=>'Notes',
                                            'class'=>'form-control alertNotes',
                                            'label' => 'false',
                                              'rows'=>"2",
                                            'maxlength'=>160, 
                                           ));  
                                        ?>
                        </div>
                    </div>
                        <?php 
                           echo $this->Form->hidden('operation_alert_id', array(
                           'label' => false,
                           'class'=> 'form-control addOperationAlertId',
                           'id'=>'addOperationAlertId'
                           ));

                        ?>
                        <?php 
                            echo $this->Form->hidden('operation_id', array(
                            'label' => false,
                            'class'=> 'form-control addOperationId',
                            'id'=>'addOperationId',

                            ));

                        ?>

                        <?php 
                            echo $this->Form->hidden('alert_id', array(
                            'label' => false,
                            'class'=> 'form-control alertId',
                            'id'=>'alertId'
                            ));

                        ?>

                    <div class="col-sm-12 col-xs-12 clearfix padding-top-10">
                         <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-default')); ?>
                    </div>

                   <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>