<?php ?><div class="modal fade modal-default" id="permitDeadlinesModel" role="dialog">
    <div class="modal-dialog modal-lg">
        Modal content
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <div class="modal-body">
                <div class="form-default clearfix">
                    <form name="" method="get" id="permitdeadline" action="javascript:void(0);">
                        <div class="row">
                            <div class="col-sm-6 col-xs-6">
                                <label>Date</label>
                                     <?php echo $this->Form->input('date', array(
                                                  'placeholder'=>'mm-dd-yyyy',
                                                  'class'=>'form-control datepicker',
                                                  'label' => false,
                                                 ));  
                                              ?>
                            </div>
                            <div class="col-sm-6 col-xs-6">
                                <label>Time</label>
                                    <?php echo $this->Form->input('time', array(
                                                  'placeholder'=>'hh:mm',
                                                  'class'=>'form-control time',
                                                  'label' => false,
                                                 ));  
                                              ?>
                            </div>

                                <?php 
                                    echo $this->Form->hidden('form_id', array(
                                    'label' => false,
                                    'class'=> 'form-control addFormsformId',
                                    'id'=>'formId'
                                    ));
                                    
                                    echo $this->Form->hidden('form_deadline_id', array(
                                    'label' => false,
                                    'class'=> 'form-control',
                                    'id'=>'formDeadlineId'
                                    ));
                                   
                                ?>

                            <div class="col-sm-12 col-xs-12 clearfix padding-top-10">
                         <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-default')); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>