<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
    <div class="form-default clearfix">
        <h5><?= $this->Flash->render() ?></h5>
           <?php  echo $this->Form->create('Aleets', array('url' => array('controller' => 'alerts', 'action' => 'add'),'id'=>'add_alerts',' method'=>'post')); ?>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
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

            <div class="col-sm-6 col-xs-6 multi-des-outer">
                <label>Staff</label>
                 <?php 
                                echo $this->Form->input('staff_id', array(
                                'type' => 'select',
                                'options' => $userslist,
                                'label' => false,
                                'multiple' => true,
                                'class'=> 'form-control select2 category formlist custm-multidrop',
                                'id'=>'mult-drop1',
                                'disabled'=>'disabled',
                                ));
                             ?>

            </div>

        </div>

        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Permits</label>
                          <?php 
                            echo $this->Form->input('form_id', array(
                               'type' => 'select',
                               'options' => @$formsList,
                                'empty'=>'Please select permit',
                                'label' => false,
                                'class'=> 'form-control select2 required',

                                ));
                             ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label>Title<span class="text-danger">*</span></label>
                          <?php echo $this->Form->input('title', array(
                                                  'placeholder'=>'Title',
                                                  'class'=>'form-control required',
                                                  'label' => false,
                                                 ));  
                                              ?>

            </div>
        </div>
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
                <label>Time<span class="text-danger">*</span></label>
                          <?php echo $this->Form->input('time', array(
                                                  'placeholder'=>'hh:mm',
                                                  'class'=>'form-control time',
                                                  'label' => false,
                                                 ));  
                                              ?>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Notes<span class="text-danger">*</span></label>
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
            <div class="col-sm-6 col-xs-6">
                <label>Repetition</label>

                                 <?php echo $this->Form->input('is_repeated', array(
                                                'type'=>'checkbox',
                                                  'class'=>'checkbox',
                                                  'label' => false,
                                                    'div'=>false,
                                                    'legend'=>false,
                                                    'id'=>'chkRepetition',
                                                    'hiddenField'=>false,
                                                    'style'=>'margin-top:15px;'
                                                    
                                                 ));  
                                              ?>

                <div class="col-sm-5">
                                 <?php echo $this->Form->input('interval', array(
                                                  'placeholder'=>'hh:mm',
                                                  'class'=>'col-sm-12',
                                                  'label' => false,
                                                   'disabled'=>'disabled',
                                                    'id'=>'interval'
                                                 ));  
                                              ?>
                </div>
                <div class="col-sm-2">
                              <?php 
                                    echo $this->Form->input('interval_type', array(
                                       'type' => 'select',
                                       'options' => array('Days'=>'Days','Weeks'=>'Weeks','Months'=>'Months'),
                                        'label' => false,
                                        'disabled','disabled',
                                        'class'=> 'form-control select2',
                                        'id'=>'intervalType',
                                     
                                        ));
                                     ?>
                </div>

            </div>
        </div>
        <div class="col-sm-12 col-xs-12 clearfix">
             <?php echo $this->Html->link('Cancel',['controller'=>'staffs','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-primary')); ?>

        </div>
    </div>
    <?php echo $this->Form->end();?>
</div>

<?php echo $this->Html->script(['alerts']);?>




