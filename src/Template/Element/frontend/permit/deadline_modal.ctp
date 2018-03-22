<?php ?>
<div class="modal fade modal-default" id="permitDeadlineModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
 <?php  echo $this->Form->create('PermitDeadline', array('url' =>'javascript:void(0);' ,'id'=>'frmPermitDeadline',' method'=>'post','class'=>'form-horizontalfrmPermitDeadline'));
 echo $this->Form->hidden('Deadlines.id', array(
                                'label' => false,
                                'class'=> 'form-control inp-deadline-id',
                                'id'=>'inptDeadlineId'));
     echo $this->Form->hidden('Deadlines.is_renewable', array(
                                'label' => false,
                                'class'=> 'form-control inp-is-renewable',
                                ));
 ?>                     
                    <!--                    <div class="row margin-top-15">
                                            <div class="col-sm-6 col-xs-6 custom-pop-select2">
                                                <label>Deadline Type</label>
                            <?php 
//                              echo $this->Form->input('Deadlines.deadline_type_id', array(
//                                 'type' => 'select',
//                                 'options' => $deadlineTypeList,
//                                  'empty'=>'Please select deadline Type',
//                                  'label' => false,
//                                  'class'=> 'form-control select2 deadlineType inp-deadline-type',
//
//                                  ));
                            ?>
                                            </div>
                                            <div class="col-sm-3 col-xs-3 custom-pop-select2">
                                                <label>Document</label>
                                  <?php 
//                            echo $this->Form->input('UserPermitDeadlines.document_id', array(
//                            'type' => 'select',
//                            'options' => $permitDocumentList,
//                            'label' => false,
//                            'multiple' => true,
//                            'class'=> 'form-control select2 inp-deadline-multi inp-deadline-document',                    
//                            'disabled'=>'disabled',
//                            'data-deadline-document-id'=>'',    
//                            ));
                        ?>
                                            </div>
                                            <div class="col-sm-3 col-xs-3 custom-pop-select2">
                                                <label>Form</label>
                                  <?php 
//                            echo $this->Form->input('UserPermitDeadlines.permit_form_id', array(
//                            'type' => 'select',
//                            'options' => $permitFormList,
//                            'label' => false,
//                            'multiple' => true,
//                            'class'=> 'form-control select2 inp-deadline-multi inp-deadline-permit-form',                    
//                            'disabled'=>'disabled',
//                            'data-deadline-permit-form-id'=>'',    
//                            ));
                        ?>
                                            </div>
                                        </div>-->
                    <div class="row margin-top-15">
                        <div class="col-sm-6 col-xs-6">
                            <label>Date <span class="text-danger">*</span></label>
                                     <?php echo $this->Form->input('Deadlines.date', array(
                                                  'placeholder'=>'MM-DD-YYYY',
                                                  'class'=>'form-control inp-date-picker alertDate inp-deadline-date',
                                                  'label' => false,
                                                 ));  
                                              ?>
                        </div>
                        <div class="col-sm-6 col-xs-6 timer">
                            <label>Time</label>
                                      <?php echo $this->Form->input('Deadlines.time', array(
                                                  'placeholder'=>'HH:MM AM/PM',
                                                  'class'=>'form-control inp-time-picker alertTime inp-deadline-time',
                                                  'label' => false,
                                                 ));  
                                              ?>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12 clearfix padding-top-10">
                         <?php echo $this->Form->button('Submit', array('type'=>'type','class'=>'btn btn-default subPermitDeadline')); ?>
                        </div>
                    </div>
                   <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>