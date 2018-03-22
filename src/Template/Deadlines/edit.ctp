<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
    <div class="form-default clearfix">
        <h5><?= $this->Flash->render() ?></h5>
           <?php  echo $this->Form->create('Deadlines', array('url' => array('controller' => 'deadlines', 'action' => 'edit',$deadlineId),'id'=>'frmDeadlines',' method'=>'post')); ?>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Permits <span class="text-danger">*</span></label>
                        <?php 
                        $deadlineDocFormId = [];                        
                        foreach($this->request->data['Deadlines']['user_permit_deadlines'] as $pData){
                            if(isset($pData->document_id) && !empty($pData->document_id)){
                                $deadlineDocFormId[$pData->document_id] = $pData->document_id;
                            } else if(isset($pData->permit_form_id) && !empty($pData->permit_form_id)){
                                $deadlineDocFormId[$pData->permit_form_id] = $pData->permit_form_id;
                            }
                        }
                        $listOfDocOrForm =  implode(',', $deadlineDocFormId);
                        $html= '<option value="">Please select permit</option>';
                            foreach($userPermitList as $list){
                                $selected = null;
                                if(!empty($this->request->data['Deadlines']['user_permit_id']) && $list['id'] == $this->request->data['Deadlines']['user_permit_id']){
                                    $selected = 'selected';
                                }
                                $html .= <<<EOD
                                        <option value="{$list['id']}" data-permit-id="{$list['permit_id']}" data-user-permit-id="{$list['id']}" {$selected}> {$list['permit']['name']} ({$list['user_location']['title']} - {$list['operation']['name']}) </option>  
EOD;
                            }
                        ?>
                <select name="Deadlines[user_permit_id]" class="form-control select2 inp-user-permit-id" id="deadlines-user-permit-id"><?php echo $html; ?></select>
            </div>

            <div class="col-sm-6 col-xs-6">
                <label>Deadline Type</label>
                            <?php 
                                echo $this->Form->hidden('Deadlines.permit_id', array(
                                'label' => false,
                                'class'=> 'form-control inp-deadline-permit-id',
                                ));
                              echo $this->Form->input('Deadlines.deadline_type_id', array(
                                 'type' => 'select',
                                 'options' => $deadlineTypeList,
                                  'empty'=>'Please select deadline Type',
                                  'label' => false,
                                  'class'=> 'form-control select2 deadlineType inp-deadline-type',

                                  ));
                            ?>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-6 col-xs-6 custom-pop-select2">
                <label>Document</label>
                                  <?php 
                            echo $this->Form->input('UserPermitDeadlines.document_id', array(
                            'type' => 'select',
                            'options' => '',
                            'label' => false,
                            'multiple' => true,
                            'class'=> 'form-control select2 inp-deadline-multi inp-deadline-document',                    
                            'disabled'=>'disabled',
                            'data-deadline-document-id'=>$listOfDocOrForm,    
                            ));
                        ?>
            </div>

            <div class="col-sm-6 col-xs-6 custom-pop-select2">
                <label>Form</label>
                                  <?php 
                            echo $this->Form->input('UserPermitDeadlines.permit_form_id', array(
                            'type' => 'select',
                            'options' => '',
                            'label' => false,
                            'multiple' => true,
                            'class'=> 'form-control select2 inp-deadline-multi inp-deadline-permit-form',                    
                            'disabled'=>'disabled',
                            'data-deadline-permit-form-id'=>$listOfDocOrForm,    
                            ));
                        ?>
            </div>
        </div>
        <div class="row">
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
                <label>Time <span class="text-danger">*</span></label>
                                      <?php echo $this->Form->input('Deadlines.time', array(
                                                  'placeholder'=>'HH:MM AM/PM',
                                                  'class'=>'form-control inp-time-picker alertTime inp-deadline-time',
                                                  'label' => false,
                                                 ));  
                                              ?>

            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-xs-12 clearfix">
             <?php echo $this->Html->link('Back',['controller'=>'deadlines','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-primary')); ?>
            </div>
        </div>
    </div>
    <?php echo $this->Form->end();?>
</div>
<?php echo $this->Html->script(['frontend/deadline']);?>




