<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border padding-top-5">
            <?php  echo $this->Form->create('Alerts', array('url' => array('controller' => 'alerts', 'action' => 'add'),'id'=>'add_alerts',' method'=>'post','class'=>'form-horizontal')); ?>
                <div class="col-md-8">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Alert Type<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                    <?php 
                                      echo $this->Form->input('alert_type_id', array(
                                         'type' => 'select',
                                         'options' => $alertTypesList,
                                          'empty'=>'Please select alert type',
                                          'label' => false,
                                          'class'=> 'form-control select2 required alertType',

                                          ));
                                       ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Company</label>
                            <div class="col-sm-9">
                                 <?php 
                                    echo $this->Form->input('company_id', array(
                                       'type' => 'select',
                                       'options' => $companiesLists,
                                        'multiple'=>true,
                                        'label' => false,
                                        'disabled','disabled',
                                        'class'=> 'form-control select2',
                                        'id'=>'companiesList',
                                      
                                        ));
                                     ?>
                            </div>
                        </div>
                   
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Operations</label>
                            <div class="col-sm-9">
                                <?php 
                                    echo $this->Form->input('industry_id', array(
                                       'type' => 'select',
                                       'options' => $operationsLists,
                                        'multiple'=>true,
                                        'label' => false,
                                        'disabled','disabled',
                                        'class'=> 'form-control select2',
                                        'id'=>'industriesList',
                                     
                                        ));
                                     ?>

                            </div>
                        </div>
                        <?php if($Authuser['role_id']==1){?>
                        <div class="form-group">
                            <label for="usersName" class="col-sm-3 control-label">Sullivan Staffs</label>
                            <div class="col-sm-9">
                                <?php 
                                    echo $this->Form->input('staff_id', array(
                                       'type' => 'select',
                                       'options' => $staffLists,
                                        'multiple'=>true,
                                        'label' => false,
                                        'disabled','disabled',
                                        'class'=> 'form-control select2',
                                        'id'=>'staffList',
                                     
                                        ));
                                     ?>

                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Title<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                            <?php echo $this->Form->input('title', array(
                                                  'placeholder'=>'Title',
                                                  'class'=>'form-control required',
                                                  'label' => false,
                                                 ));  
                                              ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Notes<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
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
                        </div>
                        
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Date</label>
                            <div class="col-sm-9">
                                <?php echo $this->Form->input('date', array(
                                                  'placeholder'=>'mm-dd-yyyy',
                                                  'class'=>'form-control datepicker',
                                                  'label' => false,
                                                 ));  
                                              ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Time</label>
                            <div class="col-sm-9">
                                <?php echo $this->Form->input('time', array(
                                                  'placeholder'=>'hh:mm',
                                                  'class'=>'form-control time',
                                                  'label' => false,
                                                 ));  
                                              ?>
                                
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Repetition</label>
                            <div class="col-sm-9">
                                <div class="col-sm-1">
                                 <?php echo $this->Form->input('is_repeated', array(
                                                'type'=>'checkbox',
                                                  'class'=>'checkbox',
                                                  'label' => false,
                                                    'div'=>false,
                                                    'legend'=>false,
                                                    'id'=>'chkRepetition',
                                                    'hiddenField'=>false
                                     
                                                    
                                                 ));  
                                              ?>
                                
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
                            </div>
                        </div>
                    <div class="box-footer button-form-sub">
                          <?php echo $this->Html->link('Cancel',['controller'=>'alerts','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-primary')); ?>
                       
                    </div>
                </div>
             <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script(['alerts']);?>





