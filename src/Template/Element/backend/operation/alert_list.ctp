 <?php   ?>
<table class="table table-responsive">
    <thead>
        <tr>
            <th>Title</th>
            <th>Date</th>
            <th>Time</th>
            <th>Last Update</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($alertOperations) && !$alertOperations->isEmpty()){ 
            foreach($alertOperations as $alertOperation){  
                if($alertOperation['alert']['is_admin'] == 0){
                                 $color = 'alert-yellow';
                             }elseif($alertOperation['alert']['added_by'] ==$LoggedCompanyId){
                                 $color = 'alert-red';
                             }else{
                                 $color = 'alert-green';
                             }
                ?>
        <tr class="<?php echo $color;?>">
            <td class="text-left"> <?php echo htmlentities($alertOperation['alert']['title']);?>
            </td>
            <td class="text-left"> <?php echo htmlentities($alertOperation['alert']['date']);?>
            </td>
            <td class="text-left"> <?php echo $alertOperation['alert']['time'];?>
            </td>

            <td class="text-left"><?php echo $this->Custom->dateTime($alertOperation['modified'])?></td>
            <td>
                <?php
                # Get Alert-Staff-Id
                $alertStaffIds = [];
                foreach ($alertOperation['alert']['alert_staffs'] as $alertStaff) {
                    $alertStaffIds[$alertStaff['user_id']] = $alertStaff['user_id'];
                }
                $alertStaffIds = implode(',', $alertStaffIds);
                
                # Get Alert-Company-Id
                $alertCompanyIds = [];
                foreach ($alertOperation['alert']['alert_companies'] as $alertCompany) {
                    $alertCompanyIds[$alertCompany['user_id']] = $alertCompany['user_id'];
                }
                $alertCompanyIds = implode(',', $alertCompanyIds);
                ?>

                <?php 
                    echo $this->Html->link($this->Html->image('icons/edit.png'),'javascript:void(0);',array('escape' => false,'title'=>'edit', 'data-title'=>'Edit Alert','data-alert-id'=>$alertOperation['alert_id'],'data-alert-title'=>htmlentities($alertOperation['alert']['title']),'data-alert-notes'=>htmlentities($alertOperation['alert']['notes']),'data-alert-date'=>$alertOperation['alert']['date'],'data-alert-time'=>$alertOperation['alert']['time'],'data-alert-type'=> $alertOperation['alert']['alert_type_id'], 'data-alert-staff-id'=>$alertStaffIds, 'data-alert-company-id'=>$alertCompanyIds, 'data-alert-operation-id'=>$alertOperation['operation_id'],'data-alert-repeat'=>$alertOperation['alert']['is_repeated'],'data-alert-interval'=>$alertOperation['alert']['interval_value'],'data-alert-interval-type'=>$alertOperation['alert']['interval_type'],'data-alert-end-date'=>(empty($alertOperation['alert']['alert_end_date']))?'':$alertOperation['alert']['alert_end_date'], 'class'=>"btnOperationAlertModal"));?> &nbsp;

                 <?php if($LoggedPermissionId !=3){
                     echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($alertOperation['alert_id'])],['data'=>['model_name'=>'Alerts','module_name'=>'Operation Alert','table_name'=>'alerts','title'=>htmlentities($alertOperation['alert']['title']),'redirect_url'=>$redirectHere,'foreignId'=>'alert_id','subModel'=>'AlertOperations'], 'escape'=>false, 'class'=>'deleteConfirm']);
                     } ?> 
            </td>
        </tr>
        <?php }
        
        }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>

