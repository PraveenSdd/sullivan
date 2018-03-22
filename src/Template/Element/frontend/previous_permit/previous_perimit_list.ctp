 <?php  ?>
<table class="table-striped tbl-previous-permit">
    <thead class="tbl-previous-permit-thead">
        <tr class="tbl-previous-permit-tr">
            <th scope="col">Name</th>
            <th scope="col">Expiry Date</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody class="tbl-previous-permit-body">
        <?php if(!empty($data)) { ?>
            <?php foreach ($data as $key => $previousPermitData) {?>
        <tr  class="tbl-previous-permit-tr">
            <td>
                <?php echo $previousPermitData->name;?>
            </td>
            <td>
                <?php echo $previousPermitData->expiry_date; ?>
            </td>
            <td>
                <?php echo $this->Html->link('Uploaded',"javascript:void(0);",array('title'=>'View Uploaded Document','escape' => false,'class'=>'btn-attachment-viewer','data-attachment-src'=>(BASE_URL.'/webroot/'.$previousPermitData->file), 'data-attachment-name'=>$previousPermitData->name,'data-permit-document-id'=>$previousPermitData->id, 'data-user-permit-document-id'=>'','data-security-type-id'=>$previousPermitData->security_type_id,'data-attachment-id'=>$previousPermitData->id,'data-attachment-table'=>'user_previous_permit_documents','data-download-pdf-path'=>$previousPermitData->file,'data-file-name'=>$previousPermitData->name.'-Uploaded')); ?> 
            </td>
            <td>
                <?php 
     if( $LoggedRoleId==2 || ($LoggedRoleId==3 && $LoggedPermissionId==4) || ($LoggedRoleId==3 &&  $LoggedCompanyId != $previousPermitData->added_by)){
                echo $this->Html->link($this->Html->image('icons/edit.png'),"javascript:void(0);",array('title'=>'Edit Previous Permit Document','escape' => false,'class'=>'btnPreviousPermitDocumentModal','data-modal-title'=>'Edit Previous Permit Document','data-previous-permit-id'=>$previousPermitData->id,'data-security-type-id'=>$previousPermitData->security_type_id,'data-expiry-date'=>$previousPermitData->expiry_date,'data-previous-permit-name'=>$previousPermitData->name,'escape'=>false)); 
                }
                ?>
                <?php if($LoggedPermissionId !=6){
                    echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($previousPermitData->id)],['data'=>['model_name'=>'UserPreviousPermitDocuments','module_name'=>'Previous Permit','table_name'=>'user_previous_permit_documents','title'=>('Previous Permit'),'redirect_url'=>$redirectHere,'foreignId'=>'','subModel'=>''], 'escape'=>false, 'class'=>'deleteConfirm']);
                }
                echo "&nbsp;";
                echo $this->Html->link('<i class="fa fa-bell-o"></i>','javascript:void(0);',array('title'=>'Add Alert', 'data-title'=>'Add Alert','data-modal-title'=>'Add Alert','data-alert-id'=>'','data-alert-title'=>$previousPermitData->name,'data-alert-notes'=>'','data-alert-date'=>$previousPermitData->expiry_date,'data-alert-time'=>'','data-alert-type'=> '','data-alert-permit-id'=>'', 'data-alert-staff-id'=>'','data-permit-document-id'=>$previousPermitData->id, 'class'=>"btnPermitAlertModal",'escape'=>false));
                echo "&nbsp;";
                echo $this->Html->link($this->Html->tag('i','',array('class'=>'fa fa-download')),"javascript:void(0);",array('title'=>'Download Uploaded Document','escape' => false,'class'=>'btnAttachmentDownload','data-attachment-src'=>(BASE_URL.'/webroot/'.$previousPermitData->file), 'data-attachment-name'=>$previousPermitData->name,'data-permit-document-id'=>$previousPermitData->id, 'data-user-permit-document-id'=>'','data-security-type-id'=>$previousPermitData->security_type_id,'data-attachment-id'=>$previousPermitData->id,'data-attachment-table'=>'user_previous_permit_documents','data-download-pdf-path'=>$previousPermitData->file,'data-file-name'=>$previousPermitData->name.'-Uploaded'));
                ?> 
            </td>
        </tr>

        <?php } ?> 

        <?php } else { ?>
        <tr class="tbl-previous-permit-tr">
            <td colspan="6">Data not available!</td>
        </tr>
        <?php } ?>        
    </tbody>
</table>
<!-- Alert Modal -->
<?php echo $this->element('frontend/permit/alert_modal'); ?>
<?php echo $this->Html->script(['frontend/permit']);?>
<script>
    $(".btnAttachmentDownload").click(function () {
        var attachmentId = $(this).data('attachment-id');
        var attachmentTable = $(this).data('attachment-table');
        var downloadpath = $(this).data('download-pdf-path');
        var documentname = $(this).data('file-name');
        window.open('/customs/download?attachmentId=' + attachmentId + '&attachmentTable=' + attachmentTable + '&path=' + downloadpath + '&documentname=' + documentname);
    });
</script>