<?php ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
    <div class="form-default clearfix">
        <h5><?= $this->Flash->render() ?></h5>
           <?php  echo $this->Form->create('Aleets', array('url' => array('controller' => 'alerts', 'action' => 'edit'),'id'=>'add_alerts',' method'=>'post')); ?>
        <div class="col-md-12">
            <div class="text-right">
                         <?php echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>"/admin/alerts/index", 'data-title'=>$alert['title'],'data-modelname'=>'Alerts','data-id'=> $alert->id,'class'=>"myalert-delete")); ?> 
            </div>
        </div>
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
                                          'value'=>$alert['alert_type_id'],

                                          ));
                                       ?>
            </div>

            <div class="col-sm-6 col-xs-6 multi-des-outer">
                <label>Staff</label>
                 <?php
                 if($alert['alert_type_id'] == 3){
                        foreach($alert['alert_staffs'] as $key=>$value){
                            $staffId[] = $value['user_id'];
                        }
                        if(empty($staffId)){$staffId ='';}
                            $disabledInterva = false;
                        }else{
                             $disabledInterva = true;
                        }
                        echo $this->Form->input('staff_id', array(
                        'type' => 'select',
                        'options' => $userslist,
                        'label' => false,
                        'multiple' => true,
                        'class'=> 'form-control select2 category formlist custm-multidrop',
                        'id'=>'mult-drop1',
                        'disabled'=>$disabledInterva,
                        'default'=>$staffId,
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
                               'options' => $formsList,
                                'empty'=>'Please select permit',
                                'label' => false,
                                'class'=> 'form-control select2 required',
                                'value'=>$alert['alert_permit']['form_id'],

                                ));
                        ?>
            </div>

            <div class="col-sm-6 col-xs-6">
                <label>Title<span class="text-danger">*</span></label>
                          <?php echo $this->Form->input('title',
                                  array(
                                    'placeholder'=>'Title',
                                    'class'=>'form-control required',
                                    'label' => false,
                                    'value'=>$alert['title']
                                   ));  
                                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Date</label>
                         <?php echo $this->Form->input('date', 
                                array(
                                   'placeholder'=>'mm-dd-yyyy',
                                    'class'=>'form-control datepicker',
                                    'label' => false,
                                     'value'=> date('m-d-Y',strtotime($alert['date'])),
                                   ));  
                                ?>
            </div>

            <div class="col-sm-6 col-xs-6">
                <label>Time<span class="text-danger">*</span></label>
                          <?php echo $this->Form->input('time', array(
                                                  'placeholder'=>'hh:mm',
                                                  'class'=>'form-control time',
                                                  'label' => false,
                                                    'value'=>$alert['time'],
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
                                            'value'=>$alert['notes']
                                           ));  
                                        ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label>Repetition</label>

                                 <?php if($alert['is_repeated'] == 1){
                                            $checked = true;
                                        }else{
                                            $checked = false;
                                        } echo $this->Form->input('is_repeated', array(
                                                'type'=>'checkbox',
                                                  'class'=>'checkbox',
                                                  'label' => false,
                                                    'div'=>false,
                                                    'checked'=>$checked,
                                                    'legend'=>false,
                                                    'id'=>'chkRepetition',
                                                    'hiddenField'=>false,
                                                    'style'=>'margin-top:15px;'
                                                    
                                                 ));  
                                              ?>

                <div class="col-sm-5">
                                  <?php  if(!empty($alert['interval_alert'])){
                                            $disabledInterva = false;
                                        }else{
                                           $disabledInterva = true;
                                        }
                                        echo $this->Form->input('interval', array(
                                                  'label' => false,
                                                  'class'=>'col-sm-12',
                                                  'disabled'=>$disabledInterva,
                                                  'value'=>$alert['interval_alert'],
                                                    'id'=>'interval',
                                                 ));  
                                              ?>
                </div>
                <div class="col-sm-2">

                                <?php 
                                     if(!empty($alert['interval_type'])){
                                            $disabledIntervalType = false;
                                        }else{
                                           $disabledIntervalType = true;
                                        }
                                     $data = array('Days'=>'Days','Weeks'=>'Weeks','Months'=>'Months');
                                        echo $this->Form->input('interwell_type', array(
                                       'type' => 'select',
                                        'label' => false,
                                        'disabled'=>$disabledIntervalType,
                                        'options' => $data,
                                        'id'=>'enterWellType',
                                         'default'=>$alert['interval_type'],
                                        ));
                                     ?>

                </div>
                    <?php echo $this->Form->hidden('id', array('value'=>@$alert['id']));  ?>
                    <?php echo $this->Form->hidden('alert_permit_id', array('value'=>@$alert['alert_permit']['id']));  ?>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12 clearfix">
            <?php echo $this->Html->link('Cancel',['controller'=>'alerts','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-primary')); ?>
        </div>
    </div>
              <?php echo $this->Form->end();?>
</div>

<?php echo $this->Html->script(['alerts']);?>

