<?php ?>
<div class="modal fade modal-default" id="alertModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle">Modal Header</h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                     <?php  echo $this->Form->create('Permits', array('url' => array('controller' => 'permits', 'action' => 'addAlerts'),'id'=>'add_alerts',' method'=>'post')); ?>

                    <div class="row">
                        <div class="col-sm-12 col-xs-6">
                            <div class="col-sm-3 col-xs-6">
                                <label>Permit</label>
                                <div class="input-group">
                                    <div class="radio-wrap">
                                        <input type="radio" id="agent-permit" class="permit"  name="agent">
                                        <label for="agent-permit">Yes</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <label>Forms</label>
                                <div class="input-group">
                                    <div class="radio-wrap">
                                        <input type="radio" id="agent-yes" class="document"  name="agent">
                                        <label for="agent-yes">Yes</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <label>Attachment</label>
                                <div class="input-group">
                                    <div class="radio-wrap">
                                        <input type="radio" id="agent-no" class="attachment" name="agent">
                                        <label for="agent-no">Yes</label>
                                    </div>

                                </div>
                            </div>


                        </div>

                        <div class="col-sm-5 col-xs-6">
                            <label>Alert Type</label>

                                     <?php 
                                      echo $this->Form->input('alert_type_id', array(
                                         'type' => 'select',
                                         'options' => $alertTypesList,
                                          'empty'=>'Please select alert Type',
                                          'label' => false,
                                          'class'=> 'form-control select2 alertTypeFront',

                                          ));
                                       ?>
                        </div>
                        <div class="col-sm-5 col-xs-6">
                            <label>Title</label>

                                     <?php 
                                      echo $this->Form->input('title', array(
                                          'empty'=>'Please enter title',
                                          'label' => false,
                                          'class'=> 'form-control select2 alertTypeFront',

                                          ));
                                       ?>
                        </div>
                        <div class="col-sm-5 col-xs-6">
                            <label>Forms</label>

                                    <?php 
                                      echo $this->Form->input('form_document_id', array(
                                         'type' => 'select',
                                         'options' => $documentsList,
                                          'empty'=>'Please select forms',
                                          'label' => false,
                                         // 'multiple'=>true,
                                          'class'=> 'form-control select2',
                                          'id'=>'document',
                                           'disabled'=>true,

                                          ));
                                       ?>
                        </div>
                        <div class="col-sm-5 col-xs-6">
                            <label>Attachments</label>
                                     <?php 
                                      echo $this->Form->input('form_attachment_id', array(
                                         'type' => 'select',
                                         'options' => $attechmentList,
                                          'empty'=>'Please select attachments',
                                          'label' => false,
                                          'class'=> 'form-control select2 attachment',
                                          'id'=>'attachment',
                                          'disabled'=>true,
                                          ));
                                       ?>
                        </div>

                        <div class="col-sm-5 col-xs-6">
                            <label>Date</label>
                                     <?php echo $this->Form->input('date', array(
                                                  'placeholder'=>'mm-dd-yyyy',
                                                  'class'=>'form-control datepicker',
                                                  'label' => false,
                                                 ));  
                                              ?>
                        </div>

                        <div class="col-sm-5 col-xs-6">
                            <label>Time</label>
                                     <?php echo $this->Form->input('time', array(
                                                  'placeholder'=>'hh:mm',
                                                  'class'=>'form-control time',
                                                  'label' => false,
                                                 ));  
                                              ?>
                        </div>
                        <div class="col-sm-12 col-xs-6">
                            <label>Notes</label>
                                     <?php echo $this->Form->textarea(
                                        'notes',
                                        array(
                                            'placeholder'=>'Notes',
                                            'class'=>'form-control',
                                            'label' => 'false',
                                              'rows'=>"5",
                                           ));  
                                        ?>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <label>Repetition</label>
                            <div class="checkbox-wrap">
                                <input type="checkbox" id="agent-yes-chk"  class="permitRepetition" name="is_repeated">
                                <label for="agent-yes-chk">Yes</label>
                            </div>
                                    <?php echo $this->Form->input('interval', array(
                                                   'class'=>'col-sm-3',
                                                  'label' => false,
                                                    'div'=>false,
                                                    'legend'=>false,
                                                    'id'=>'interval',
                                                    'disabled'=>'disabled'
                                     
                                                    
                                                 ));  
                                              ?>
                            &nbsp;&nbsp;
                                <?php 
                                        echo $this->Form->input('interwell_type', array(
                                       'type' => 'select',
                                        'label' => false,
                                        'disabled'=>'disabled',
                                        'options' => array('Days'=>'Days','Weeks'=>'Weeks','Months'=>'Months'),
                                        'id'=>'enterWellType',
                                        ));?>


                        </div>
                               <?php echo $this->Form->hidden('form_id', array(
                                                  'class'=>'form-control',
                                                  'id'=>'formId',
                                                  'label' => false,
                                                 ));  
                                              ?>
                               <?php echo $this->Form->hidden('alert_type', array(
                                                  'class'=>'form-control ',
                                                  'id'=>'alertType',
                                                  'label' => false,
                                                 ));  
                                              ?>
                    </div>
                    <div class="col-sm-12 col-xs-12 clearfix">
                        <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-default')); ?>
                    </div>
                </div>
            <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>