<?php ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
    <div class="form-default clearfix">
        <h5><?= $this->Flash->render() ?></h5>
        <?php if($CompanyAdminDelete ==1){ ?>
        <div class="row">
            <div class="col-md-12">
                <div class="text-right">
                    <?php echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($alerts->id)],['data'=>['model_name'=>'Alerts','module_name'=>'Alert Front','table_name'=>'alerts','title'=>htmlentities($alerts->title),'redirect_url'=>'/alerts/index','foreignId'=>'','subModel'=>''], 'escape'=>false, 'class'=>'deleteConfirm']);
                    ?> 
                </div>
            </div>
        </div>
         <?php }?>
        <?php  echo $this->Form->create('Alert', array('url' => array('controller' => 'alerts', 'action' => 'edit',$alertId),'id'=>'frmAlert',' method'=>'post')); ?>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Alert Type</label>
                        <?php 
                            echo $this->Form->input('Alert.alert_type_id', array(
                               'type' => 'select',
                               'options' => $alertTypeList,
                                'empty'=>'Please select alert Type',
                                'label' => false,
                                'class'=> 'form-control select2 inp-alert-type',

                                ));
                        ?>
            </div>

            <div class="col-sm-6 col-xs-6 multi-des-outer custome-multi-check-block custm-multidrop">
                <label>Staff</label>
                <?php
                    # Get Alert-Staff-Id
                    $alertStaffIds = [];
                    foreach ($alerts['alert_staffs'] as $alertStaff) {
                        $alertStaffIds[$alertStaff['user_id']] = $alertStaff['user_id'];
                    }
                    $alertStaffIds = implode(',', $alertStaffIds);
                    ?>
                 <?php 
                    echo $this->Form->input('Alert.staff_id', array(
                    'type' => 'select',
                    'options' => $companyStaffList,
                    'label' => false,
                    'multiple' => true,
                    'class'=> 'form-control select2 inp-alert-multi inp-alert-staff',
                    'disabled'=>'disabled',
                     'data-alert-staff-id'=>$alertStaffIds,   
                    ));
                ?>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Title<span class="text-danger">*</span></label>
                <?php echo $this->Form->input('Alert.title', array(
                    'placeholder'=>'Title',
                    'class'=>'form-control required inp-alert-title',
                    'label' => false,
                   ));  
                ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label>Date</label>
                <?php echo $this->Form->input('Alert.date', array(
                   'placeholder'=>'MM-DD-YYYY',
                   'class'=>'form-control inp-date-picker inp-alert-date',
                   'label' => false,
                  ));  
               ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6 timer">
                <label>Time<span class="text-danger">*</span></label>
                <?php echo $this->Form->input('Alert.time', array(
                    'placeholder'=>'HH:MM AM/PM',
                    'class'=>'form-control inp-time-picker inp-alert-time',
                    'label' => false,
                   ));  
                ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label>Repetition</label>
                <div class="checkbox-wrap col-sm-2">
                    <?php 
                    $checked=false;
                    $disabled = true;
                    if(!empty($this->request->data['Alert']['is_repeated'])){
                        $checked = "checked=checked";
                        $disabled = false;
                    }?>
                    <input type="checkbox" id="chkAlertIsRepeat" name="Alert[is_repeated]" value="1" class="inp-alert-repeat" <?php echo $checked;?>>
                    <label for="chkAlertIsRepeat">&nbsp;</label>
                </div>
                <div class="interval col-sm-5" >
                        <?php echo $this->Form->input('Alert.interval_value', array(
                                      'label' => false,
                                        'div'=>false,
                                        'legend'=>false,                                        
                                        'disabled'=>$disabled,
                                        'class'=>'form-control inp-integer inp-alert-interval'


                                     ));  
                                  ?>
                </div>
                <div class="interwell_type col-sm-5">
                    <?php 
                            echo $this->Form->input('Alert.interval_type', array(
                           'type' => 'select',
                            'label' => false,
                            'disabled'=>$disabled,
                            'options' => array('Days'=>'Days','Weeks'=>'Weeks','Months'=>'Months'),
                            'class'=>'form-control inp-alert-interval-type',
                            ));?>
                </div>
                <label id="interval-error" class="authError" for="interval" style="display: none">Please enter number</label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Notes<span class="text-danger">*</span></label>
                       <?php echo $this->Form->textarea(
                                        'Alert.notes',
                                        array(
                                            'placeholder'=>'Notes',
                                            'class'=>'form-control inp-interval-notes',
                                            'label' => 'false',
                                              'rows'=>"5",
                                           ));  
                                        ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label>Repetition End Date</label>
                                <?php echo $this->Form->input('Alert.alert_end_date', array(
                                     'disabled'=>$disabled,
                                                  'placeholder'=>'MM-DD-YYYY',
                                                  'class'=>'form-control inp-date-picker inp-alert-end-date',
                                                  'label' => false,
                                                 ));  
                                              ?>
            </div>


        </div>
        <div class="col-sm-12 col-xs-12 clearfix">
             <?php echo $this->Html->link('Cancel',['controller'=>'alerts','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-primary')); ?>

        </div>
        <?php echo $this->Form->end();?>
    </div>
</div>
<?php echo $this->Html->script(['frontend/alert']);?>
