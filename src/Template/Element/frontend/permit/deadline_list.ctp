 <?php  ?>
<table class="table-striped tbl-permit-deadline">
    <thead class="tbl-permit-deadline-thead">
        <tr class="tbl-permit-deadline-tr">
            <th scope="col">Date</th>
            <th scope="col">Time</th>
            <th scope="col">Last Modified</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody class="tbl-permit-deadline-body">
        <?php if(isset($userPermitDeadlines) && !empty($userPermitDeadlines)){
            $userPermitDeadline=$userPermitDeadlines;
                if($userPermitDeadline->is_admin == 1){
                                 $color = 'alert-green';
                             }elseif($userPermitDeadline->added_by == $LoggedCompanyId){
                                 $color = 'alert-red';
                             }else{
                                 $color = 'alert-yellow';
                             }
                ?>
        <tr class="tbl-permit-deadline-tr <?php echo $color;?>">
            <td><?php  echo $userPermitDeadline->date; ?></td>
            <td><?php  echo $userPermitDeadline->time; ?></td>
            <td><?php  echo $userPermitDeadline->modified; ?></td>
            <td>
                <?php 
                if($userPermitDeadline->is_admin == 0){ 
     if( $LoggedRoleId==2 || ($LoggedRoleId==3 && $LoggedPermissionId==4) || ($LoggedRoleId==3 &&  $LoggedCompanyId != $userPermitDeadline->added_by)){
                echo $this->Html->link($this->Html->image('icons/edit.png'),"javascript:void(0);",array('title'=>'Edit Deadline','escape' => false,'class'=>'btnPermitDeadlineModal','data-modal-title'=>'Edit Deadline','data-deadline-id'=>$userPermitDeadline->id,'data-deadline-type'=>'','data-deadline-date'=>$userPermitDeadline->date,'data-deadline-time'=>$userPermitDeadline->time, 'data-deadline-permit-id'=>$userPermitDeadline->permit_id,'data-renewable-value'=>$userPermitDeadline->is_renewable,'data-deadline-document-id'=>"",'data-deadline-permit-form-id'=>"",'escape'=>false)); 
                }}
                ?>
            </td>
        </tr>
        <?php } else { ?>
        <tr class="tbl-permit-deadline-tr">
            <td colspan="6">Data not available!</td>
        </tr>
        <?php } ?>        
    </tbody>
</table>