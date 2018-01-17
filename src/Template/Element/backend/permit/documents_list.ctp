 <?php   ?>
<table class="table table-responsive">
    <thead>
        <tr>
            <th>Form Name</th>
            <th>Samples</th>
            <th>Last Update</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($form['form_attachments'])){ 
            $number = 1;
foreach($form['form_attachments'] as $documentAttachments){ ?> 
        <tr>
            <td class="text-left">
                   <?=ucfirst($documentAttachments['name']); ?>
            </td>

            <td>
                 <?php $no = 1; 
                   foreach($documentAttachments['form_attachment_samples'] as $attachmentsSample){
                       if(!empty($attachmentsSample['path'])){ ?>
                <div class="inner-bx-group-list permt-comn-inner-list permit-attachment-sample-list">
                    <p class="">
                        <a title="<?php echo 'Sample-'.$no; ?>" tooltip="<?php echo 'Sample-'.$no; ?>" href="javascript:void(0);" class="btn-attachment-viewer viewdata" data-attachment-src="<?php echo BASE_URL.'/webroot/'.$attachmentsSample['path']; ?>" data-attachment-name="<?php echo 'Sample- '.$no; ?>" data-attachment-id="<?php echo $attachmentsSample['id']; ?>"><?php echo 'Sample-'.$no;?></a>
                    </p>
                </div>
                       <?php } 
                       $no++; ?>                                        
                   <?php } ?>

            </td>      
            <td class="text-left"><?php echo $this->Custom->dateTime($documentAttachments['modified'])?></td>

            <td class="text-left">

                <?php echo $this->Html->link($this->Html->image('icons/edit.png'),'javascript:void(0);',array('escape' => false,'title'=>'Edit','data-title'=>'Edit Document','data-documentName'=> ucfirst($documentAttachments['name']),'data-formId'=> $documentAttachments['form_id'],'class'=>"permitFormsModel",'data-documentId'=>$documentAttachments['id'],'data-toggle'=>'modal','data-target'=>'#permitDocumentsModel','class'=>'permitAttachment' )); ?> 
            </td>
        </tr>
        <?php }
            }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>


