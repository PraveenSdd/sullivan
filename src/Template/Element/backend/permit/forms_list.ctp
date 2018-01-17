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
        <?php if(!empty($form['documents'])){ 
                
            foreach($form['documents'] as $documents){  ?>
        <tr>
            <td class="text-left">
                <a title="<?php echo ucfirst($documents['name']); ?>" tooltip="<?php echo ucfirst($documents['name']); ?>" href="javascript:void(0);" class="btn-attachment-viewer viewdata" data-attachment-src="<?php echo BASE_URL.'/webroot/'.$documents['path']; ?>" data-attachment-name="<?php echo ucfirst($documents['name']); ?>" data-attachment-id="<?php echo $documents['id']; ?>"><?php echo $documents['name'];?></a>
            </td>

            <td>
                 <?php $no = 1; 
        foreach($documents['form_document_samples'] as $documentSample){
            if(!empty($documentSample['path'])){ ?>
                <div class="permit-document-sample-list">
                    <p class="viewdataSmaple">
                        <a title="<?php echo 'Sample-'.$no; ?>" tooltip="<?php echo 'Sample-'.$no; ?>" href="javascript:void(0);" class="btn-attachment-viewer viewdata" data-attachment-src="<?php echo BASE_URL.'/webroot/'.$documents['path']; ?>" data-attachment-name="<?php echo 'Sample- '.$no; ?>" data-attachment-id="<?php echo $documentSample['id']; ?>"><?php echo 'Sample-'.$no;?>
                        </a>
                    </p>
                </div>
    <?php }
    $no++;  } ?>

            </td>      
            <td class="text-left"><?php echo $this->Custom->dateTime($documents['modified'])?></td>

            <td class="text-left">
                <?php echo $this->Html->link($this->Html->image('icons/edit.png'),'javascript:void(0);',array('escape' => false,'title'=>'Edit','data-title'=>'Edit Document','data-formName'=>ucfirst($documents['name']),'data-formId'=> $documents['form_id'],'class'=>"permitFormsModel",'data-documentId'=>$documents['id'],'data-toggle'=>'modal','data-target'=>'#permitFormsModel' )); ?> 
            </td>
        </tr>
        <?php }
            }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>

