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
        <?php if(isset($alertPermits) && !$alertPermits->isEmpty()){ 
            foreach($alertPermits as $alertPermit){
                if($alertPermit['alert']['is_admin'] == 0){
                                 $color = 'alert-yellow';
                             }elseif($alertPermit['alert']['added_by'] ==$LoggedCompanyId){
                                 $color = 'alert-red';
                             }else{
                                 $color = 'alert-green';
                             }
                ?>
        <tr class="<?php echo $color;?>">
            <td class="text-left"> <?php echo htmlentities($alertPermit['alert']['title']);?>
            </td>
            <td class="text-left"> <?php echo htmlentities($alertPermit['alert']['date']);?>
            </td>
            <td class="text-left"> <?php echo htmlentities($alertPermit['alert']['time']);?>
            </td>

            <td class="text-left"><?php echo $this->Custom->dateTime($alertPermit['modified'])?></td>
            <td>
                <?php
                # Get Alert-Staff-Id
                $alertStaffIds = [];
                foreach ($alertPermit['alert']['alert_staffs'] as $alertStaff) {
                    $alertStaffIds[$alertStaff['user_id']] = $alertStaff['user_id'];
                }
                $alertStaffIds = implode(',', $alertStaffIds);
                
                # Get Alert-Company-Id
                $alertCompanyIds = [];
                foreach ($alertPermit['alert']['alert_companies'] as $alertCompany) {
                    $alertCompanyIds[$alertCompany['user_id']] = $alertCompany['user_id'];
                }
                $alertCompanyIds = implode(',', $alertCompanyIds);
                
                # Get Alert-Operation-Id
                $alertOperationIds = [];
                foreach ($alertPermit['alert']['alert_operations'] as $alertOperation) {
                    $alertOperationIds[$alertOperation['operation_id']] = $alertOperation['operation_id'];
                }
                $alertOperationIds = implode(',', $alertOperationIds);
                ?>

                <?php echo $this->Html->link($this->Html->image('icons/edit.png'),'javascript:void(0);',array('escape' => false,'title'=>'edit', 'data-title'=>'Edit Alert','data-alert-id'=>$alertPermit['alert_id'],'data-alert-title'=>htmlentities($alertPermit['alert']['title']),'data-alert-notes'=>htmlentities($alertPermit['alert']['notes']),'data-alert-date'=>$alertPermit['alert']['date'],'data-alert-time'=>$alertPermit['alert']['time'],'data-alert-type'=> $alertPermit['alert']['alert_type_id'],'data-alert-permit-id'=>$alertPermit['id'], 'data-alert-staff-id'=>$alertStaffIds, 'data-alert-company-id'=>$alertCompanyIds, 'data-alert-operation-id'=>$alertOperationIds,'data-alert-repeat'=>$alertPermit['alert']['is_repeated'],'data-alert-interval'=>$alertPermit['alert']['interval_value'],'data-alert-interval-type'=>$alertPermit['alert']['interval_type'],'data-alert-end-date'=>(empty($alertPermit['alert']['alert_end_date']))?'':$alertPermit['alert']['alert_end_date'], 'class'=>"btnPermitAlertModal"));?> &nbsp;

                 <?php if($LoggedPermissionId !=3){
                     echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($alertPermit['alert_id'])],['data'=>['model_name'=>'Alerts','module_name'=>'Permit Alert','table_name'=>'alerts','title'=>htmlentities($alertPermit['alert']['title']),'redirect_url'=>$redirectHere,'foreignId'=>'alert_id','subModel'=>'AlertPermits'], 'escape'=>false, 'class'=>'deleteConfirm']);
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

