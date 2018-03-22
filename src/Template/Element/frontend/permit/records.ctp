<?php ?>
<div class="row" style="padding:10px;">
        <?php  echo $this->Form->create('Users', array('url' => array('controller' => 'permits', 'action' => 'current'),'type'=>'get')); ?>
    <div class="col-md-3">
                                        <?php 
                                            echo $this->Form->input('location_id', array(
                                               'type' => 'select',
                                               'options' => $userLocationList,
                                                'empty'=>'Select Location',
                                                'label' => false,
                                                'class'=> 'form-control inp-add-state sel-add-state',
                                                'data-add-count'=>'1',
                                                'label' => false,
                                                  'default'=>'',
                                                ));
                                        ?>
    </div>
    <div class="col-md-3">
        <?php 
                                            echo $this->Form->input('operation_id', array(
                                               'type' => 'select',
                                               'options' => $userOperationList,
                                                'empty'=>'Select Operation',
                                                'label' => false,
                                                'class'=> 'form-control inp-add-state sel-add-state',
                                                'data-add-count'=>'1',
                                                'label' => false,
                                                  'default'=>'',
                                                ));
                                        ?>
    </div>    
    <div class="col-md-3">
            <?php echo $this->Form->button('Search', array('type'=>'submit','class'=>'btn btn-primary')); ?>
            <?php echo $this->Html->link('Clear',array('controller'=>'permits','action'=>'current') ,array('class'=>'btn btn-primary')); ?>
    </div>
        <?php echo $this->Form->end();?>
</div>
<table class="table-striped tbl-permit">
    <thead>
        <tr>
            <th scope="col" style="width: 25%">Permit</th>
            <th scope="col" style="width: 25%">Agency</th>
            <th scope="col" style="width: 15%">Location</th>
            <th scope="col" style="width: 15%">Operation</th>
            <th scope="col" style="width: 10%">Deadline</th>
            <th scope="col">Last Modification</th>
            <th scope="col">Modified By</th>
            <th scope="col">Action</th>       
        </tr>
    </thead>
    <tbody>
               <?php  if($data->isEmpty()){  ?>
        <tr>
            <td colspan="4" class="text-center">Record Not Found! </td>
        </tr>
                    <?php } else { foreach($data as $permitOperation){ 
                            
                            foreach ($permitOperation->operation->permit_operations as $key => $value) {
                            $permitId = $this->Encryption->encode($value->permit_id);
                            $agencyIdId = (isset($value->permit->permit_agency)) ? $value->permit->permit_agency->agency_id : null;
                            $agencyIdId = $this->Encryption->encode($agencyIdId);
                            $operationId = $this->Encryption->encode($permitOperation->operation->id);
                            $location_id = $this->Encryption->encode($permitOperation->user_location->id); 
                            $permitDates = $this->Permit->getPermitDates($value->permit_id,$permitOperation->operation->id,$permitOperation->user_location->id);
                          ?>
        <tr>
            <td>
                        <?php //echo $value->permit->name; ?>

                        <?php echo $this->Html->link(htmlentities(strip_tags($value->permit->name)),['controller'=>'permits','action'=>'view',$permitId,$operationId,$location_id],array('title'=>'View','escape' => false)); ?>
            </td>
            </td>
            <td>
                        <?php 
                        echo (isset($value->permit->permit_agency->agency->name)) ? $value->permit->permit_agency->agency->name : '&nbsp;'; ?>
            </td>

            <td><?php echo $permitOperation->user_location->title ?></td>
            <td><?php echo $permitOperation->operation->name ?></td>
            <td><?php echo $permitDates['deadline']; ?></td>
            <td>
                <?php 
                if($permitDates['modified_at'] == 'NA' || $permitDates['modified_at'] == ''){
                    echo $permitDates['modified_at'];
                } else {
                    echo $this->Custom->dateTime($permitDates['modified_at']);  
                }
                ?>

            </td>
            <td>
                <?php echo $permitDates['modified_by']; ?>
            </td>

            <td>
                <?php 
                    $currentPermitStatus = $this->Permit->getCurrentPermitStatusId($value->permit_id,$permitOperation->operation->id,$permitOperation->user_location->id);
                    echo $this->Form->input('operation_id', array(
                                               'type' => 'select',
                                               'options' => $permitStatusses,
                                                'label' => false,
                                                'class'=> 'form-control change-status',
                                                'permit_id'=>$value->permit_id,
                                                'user_location_id'=>$permitOperation->user_location->id,
                                                'operation_id'=>$permitOperation->operation->id,
                                                'label' => false,
                                                'value'=>$currentPermitStatus,
                                                ));
                ?>
            </td>


        </tr>    

                <?php 
            }
            } ?> 
                    <?php  }?>
    </tbody>
</table>
<?php echo $this->element('frontend/permit/status_modal'); ?>