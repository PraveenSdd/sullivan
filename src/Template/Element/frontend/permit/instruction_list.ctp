 <?php  ?>
<table class="table-striped tbl-permit-instruction">
    <thead class="tbl-permit-instruction-thead">
        <tr class="tbl-permit-instruction-tr">
            <th scope="col">Name</th>
            <th scope="col">Last Modified</th>
            <th class="text-center" scope="col">Download</th>
        </tr>
    </thead>
    <tbody class="tbl-permit-instruction-body">
        <?php if(!empty($permitInstructions)) { ?>
            <?php foreach ($permitInstructions as $key => $value) { ?>  
        <tr class="tbl-permit-instruction-tr">
            <td>
                        <?php echo $this->Html->link($value->name,"javascript:void(0);",array('title'=>'Download Document','escape' => false,'class'=>'btn-attachment-viewer','data-modal-title'=>$value->name,'data-attachment-id'=>$value->id,'data-attachment-table'=>'permit_instructions','data-download-pdf-path'=>$value->path,'data-file-name'=>$value->name.'-Uploaded','data-attachment-name'=>$value->name,'data-attachment-src'=>(BASE_URL.'/webroot/'.$value->path),'escape'=>false)); ?>
            </td>
            <td><?php echo $value->modified; ?></td>
            <td align="center">
                        <?php echo $this->Html->link($this->Html->tag('i','',array('class'=>'fa fa-download')),['controller'=>'customs','action'=>'download','?'=>['attachmentId'=>$value->id,'attachmentTable'=>'permit_instructions','path'=>$value->path,'documentname'=>$value->name.'-Uploaded']],array('title'=>'Download document','escape' => false,'class'=>'btnDownloadForm','escape'=>false)); ?>
            </td>
        </tr>
            <?php } ?>
        <?php } else { ?>
        <tr class="tbl-permit-deadline-tr">
            <td colspan="3">Data not available!</td>
        </tr>
        <?php } ?>        
    </tbody>
</table>