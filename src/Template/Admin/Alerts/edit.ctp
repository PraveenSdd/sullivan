<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border padding-top-5">
            <?php  echo $this->Form->create('Alerts', array('url' => array('controller' => 'alerts', 'action' => 'edit'),'id'=>'add_alerts',' method'=>'post','class'=>'form-horizontal')); ?>
                <div class="col-md-12">
                    <div class="text-right">
                        <?php echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>"/admin/alerts/index", 'data-title'=>$alert['title'],'data-modelname'=>'Alerts','data-id'=> $alert->id,'class'=>"myalert-delete")); ?> 
                    </div>
                    </div>
                <div class="col-md-8">
                   
                    <div class="box-body">
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Alert Type<span class="text-danger">*</span>                            </label>
                            <div class="col-sm-9">
                                    <?php 
                                      echo $this->Form->input('alert_type_id', array(
                                         'type' => 'select',
                                         'options' => $alertTypesList,
                                          'empty'=>'Please select alert type',
                                          'label' => false,
                                          'class'=> 'form-control required alertType',
                                          'default'=>$alert->alert_type_id
                                          ));
                                       ?>
                            </div>
                        </div>
                        <?php if($alert->alert_type_id == 3){ 
                                foreach($alert['alert_companies'] as $company){
                                    $companyId[] = $company['company_id'];
                                    echo $this->Form->hidden('alert_companies_id.', array(
                                                  'value'=>$company['id'],
                                                 ));  
                                }
                                  $disabledCompany = 'false';
                            }else{
                                $companyId ='';
                                $disabledCompany = 'true';
                            }  
                            ?>
                        <div class="alertTypeCompanyList">
                            <div class="form-group ">
                                <label for="CategoryName" class="col-sm-3 control-label titleAlert">Select Companies</label>
                                <div class="col-sm-9">
                                     <?php 
                                        echo $this->Form->input('company_id', array(
                                           'type' => 'select',
                                           'options' => $companiesLists,
                                            'multiple'=>"multiple",
                                            'label' => false,
                                            'disabled' => $disabledCompany, 
                                            'class'=> 'form-control select2',
                                            'id'=>'companiesList',
                                            'default'=>$companyId,
                                            ));
                                         ?>
                                </div>
                            </div>
                        </div>
                        <?php if($alert->alert_type_id == 4){ 
                            foreach($alert['alert_industries'] as $industry){
                                    $industryId[] = $industry['industry_id'];
                                    echo $this->Form->hidden('alert_industries_id.', array(
                                                  'value'=>$industry['id'],
                                    ));
                                }
                                 $disabledIndustry = 'false';
                                ?>
                        <?php }else{
                                $industryId ='';
                                 $disabledIndustry = 'true';
                            }  ?>
                        <div class="form-group alertTypeIndustryList">
                            <label for="CategoryName" class="col-sm-3 control-label titleAlert">Operations</label>
                            <div class="col-sm-9">
                                <?php 
                                    echo $this->Form->input('industry_id', array(
                                       'type' => 'select',
                                       'options' => $operationsLists,
                                        'multiple'=>"multiple",
                                        'label' => false,
                                        'disabled' => $disabledIndustry, 
                                        'class'=> 'form-control select2',
                                        'id'=>'industriesList',
                                         'default'=>$industryId,
                                        ));
                                     ?>

                            </div>
                        </div>
                        <?php if($alert->alert_type_id == 2){ 
                            foreach($alert['alert_staffs'] as $staff){
                                    $staffId[] = $staff['user_id'];
                                    echo $this->Form->hidden('alert_staff_id.', array(
                                                  'value'=>$staff['id'],
                                    ));
                                }
                                 $disabledStaff = 'false';
                                ?>
                        <?php }else{
                                $staffId ='';
                                 $disabledStaff = 'true';
                            }  ?>
                        <div class="form-group alertTypeIndustryList">
                            <label for="CategoryName" class="col-sm-3 control-label titleAlert">Staffs</label>
                            <div class="col-sm-9">
                                <?php 
                                    echo $this->Form->input('staff_id', array(
                                       'type' => 'select',
                                       'options' => $staffLists,
                                        'multiple'=>"multiple",
                                        'label' => false,
                                        'disabled' => $disabledStaff, 
                                        'class'=> 'form-control select2',
                                        'id'=>'staffList',
                                         'default'=>$staffId,
                                        ));
                                     ?>

                            </div>
                        </div>
                        

                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Title<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                  <?php echo $this->Form->input('title', array(
                                                  'placeholder'=>'Title',
                                                  'class'=>'form-control required',
                                                  'label' => false,
                                                  'value'=>$alert->title,
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
                                             'value'=>$alert->notes,
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
                                                  'value'=> date('m-d-Y',strtotime($alert->date)),
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
                                                  'value'=>$alert->time,
                                                 ));  
                                              ?>
                                
                            </div>
                        </div>
                       
                        
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Repetition</label>
                            <div class="col-sm-9">
                            <div class="col-sm-1">
                                    
                                        <?php if($alert->is_repeated == 1){
                                            $checked = true;
                                        }else{
                                            $checked = false;
                                        } echo $this->Form->input('is_repeated', array(
                                                'type'=>'checkbox',
                                                  'class'=>'checkbox',
                                                    'checked'=>$checked,
                                                  'label' => false,
                                                    'div'=>false,
                                                    'legend'=>false,
                                                    'id'=>'chkRepetition',
                                                    'hiddenField'=>false
                                                 ));  
                                              ?>  
                            </div>
                             <div class="col-sm-2">
                                <?php  if(!empty($alert->interval_alert)){
                                            $disabledInterva = false;
                                        }else{
                                           $disabledInterva = true;
                                        }
                                        echo $this->Form->input('interval', array(
                                                  'label' => false,
                                                  'disabled'=>$disabledInterva,
                                                  'value'=>$alert->interval_alert,
                                                    'id'=>'interval',
                                                 ));  
                                              ?>
                             </div> &nbsp;&nbsp;
                             <div class="col-sm-3" style="margin-left:120px">
                                     <?php 
                                     if(!empty($alert->interval_type)){
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
                                         'default'=>$alert->interval_type,
                                        ));
                                     ?>
                                 </div>
                                </div>
                            </div>
                        
                        


            <?php echo $this->Form->hidden('id', array('value'=>@$alert->id));  
                                              ?>
                        <div class="box-footer button-form-sub">
                            <?php echo $this->Html->link('Cancel',['controller'=>'alerts','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-primary')); ?>
                        </div>
                    </div>
             <?php echo $this->Form->end();?>
                </div>
            </div>
        </div>
    </div>
</div>







