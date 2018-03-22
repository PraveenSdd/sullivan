 <?php   ?>
<table class="table-striped tbl-permit-document">
    <thead class="tbl-permit-document-thead">
        <tr class="tbl-permit-document-tr">
            <th scope="col">Name</th>
            <th scope="col">Last Modified</th>
            <th scope="col">Status</th>
            <th class="text-center" scope="col">Upload</th>
            <th class="text-center" scope="col">Download</th>
        </tr>
    </thead>
    <tbody class="tbl-permit-document-body">
        <?php if(!empty($permitDocuments)) { ?>
            <?php foreach ($permitDocuments as $key => $value) {  ?>  
        <tr class="tbl-permit-document-tr">
            <td><?php echo $value->document->name; ?></td>
                    <?php if(!empty($value->user_permit_document)){ ?>
            <td><?php echo $value->user_permit_document->modified; ?></td>
            <td>
                            <?php echo $this->Html->link('Uploaded',"javascript:void(0);",array('title'=>'View Uploaded Document','escape' => false,'class'=>'btn-attachment-viewer','data-attachment-src'=>(BASE_URL.'/webroot/'.$value->user_permit_document->file), 'data-attachment-name'=>$value->document->name,'data-permit-document-id'=>$value->id, 'data-user-permit-document-id'=>$value->user_permit_document->id,'data-security-type-id'=>$value->user_permit_document->security_type_id,'data-attachment-id'=>$value->user_permit_document->id,'data-attachment-table'=>'user_permit_documents','data-download-pdf-path'=>$value->user_permit_document->file,'data-file-name'=>$value->document->name.'-Uploaded')); ?> 
            </td>
            <td align="center"> 
                            <?php echo $this->Html->link($this->Html->tag('i','',array('class'=>'fa fa-upload')),"javascript:void(0);",array('title'=>'Upload Document','escape' => false,'class'=>'btnPermitDocumentModal','data-modal-title'=>$value->document->name,'data-permit-document-id'=>$value->id,'data-document-id'=>$value->document->id,'data-security-type-id'=>$value->user_permit_document->security_type_id,'escape'=>false)); ?>
            </td>
            <td align="center">
                        <?php echo $this->Html->link($this->Html->tag('i','',array('class'=>'fa fa-download')),['controller'=>'customs','action'=>'download','?'=>['attachmentId'=>$value->user_permit_document->id,'attachmentTable'=>'user_permit_documents','path'=>$value->user_permit_document->file,'documentname'=>$value->document->name.'-Uploaded']],array('data-security-type-id'=>$value->user_permit_document->security_type_id,'title'=>'Download document','escape' => false,'class'=>'btnDownloadForm','data-permit-form-id'=>$value->id,'escape'=>false,'class'=>'checkDocSecurity')); ?>
            </td> 
                    <?php } else { ?>
            <td>-</td>
            <td>Pending</td>
            <td align="center">
                            <?php echo $this->Html->link($this->Html->tag('i','',array('class'=>'fa fa-upload')),"javascript:void(0);",array('title'=>'Upload Document','escape' => false,'class'=>'btnPermitDocumentModal','data-modal-title'=>$value->document->name,'data-permit-document-id'=>$value->id,'data-document-id'=>$value->document->id,'data-security-type-id'=>'','escape'=>false)); ?>
            </td>
            <td align="center">-</td>
                    <?php } ?>

        </tr>
            <?php } ?>
        <?php } else { ?>
        <tr class="tbl-permit-deadline-tr">
            <td colspan="5">Data not available!</td>
        </tr>
        <?php } ?>        
    </tbody>
</table>

