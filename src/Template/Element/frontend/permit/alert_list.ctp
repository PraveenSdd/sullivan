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
            foreach($alertPermits as $alertPermit){  ?>
        <tr>
            <td class="text-left"> <?php echo $alertPermit['alert']['title'];?>
            </td>
            <td class="text-left"> <?php echo $alertPermit['alert']['date'];?>
            </td>
            <td class="text-left"> <?php echo $alertPermit['alert']['time'];?>
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

                <?php if($subAdminEdit ==1){
                    echo $this->Html->link($this->Html->image('icons/edit.png'),'javascript:void(0);',array('escape' => false,'title'=>'edit', 'data-title'=>'Edit Alert','data-alert-id'=>$alertPermit['alert_id'],'data-alert-title'=>$alertPermit['alert']['title'],'data-alert-notes'=>$alertPermit['alert']['notes'],'data-alert-date'=>$alertPermit['alert']['date'],'data-alert-time'=>$alertPermit['alert']['time'],'data-alert-type'=> $alertPermit['alert']['alert_type_id'],'data-alert-permit-id'=>$alertPermit['id'], 'data-alert-staff-id'=>$alertStaffIds, 'data-alert-company-id'=>$alertCompanyIds, 'data-alert-operation-id'=>$alertOperationIds, 'class'=>"btnPermitAlertModal")); }?> &nbsp;
                
                 <?php if($subAdminDelete ==1){
                     $deleteUrl = "/admin/permits/".$this->request->getParam('action').'/'.$this->Encryption->encode($alertPermit['permit_id']);
                     echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>$deleteUrl, 'data-title'=>$alertPermit['alert']['title'],'data-modelname'=>'Alerts','data-id'=> $alertPermit['alert_id'],'data-subModelname'=>'AlertPermits','data-foreignId'=> 'alert_id','class'=>"myalert-delete")); } ?> 
            </td>
        </tr>
        <?php }
        
        }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>

