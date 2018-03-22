 <?php   ?>
<table class="table table-responsive tbl-border-bottom">
    <thead>
        <tr>
            <th>Form Name</th>
            <th>Samples</th>
            <th>Last Update</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($permitForms) && !$permitForms->isEmpty()){ 
                
            foreach($permitForms as $permitForm){  ?>
        <tr>
            <td class="text-left">
                <?php echo $this->Html->link(htmlentities($permitForm['name']),"javascript:void(0);",array('title'=>'View Permit Form','escape' => false,'class'=>'btn-attachment-viewer','data-attachment-src'=>(BASE_URL.'/webroot/'.$permitForm['path']), 'data-attachment-name'=>htmlentities($permitForm['name']), 'data-permit-form-id'=>$permitForm['id'],'data-attachment-id'=>$permitForm['id'],'data-attachment-table'=>'permit_forms','data-download-pdf-path'=>$permitForm['path'],'data-file-name'=>htmlentities($permitForm['name']))); ?>
            </td>

            <td class="text-left">
                 <?php $no = 1; 
        foreach($permitForm['permit_form_samples'] as $permitFormSample){
            if(!empty($permitFormSample['path']) && $permitFormSample['is_deleted'] == 0){
               
                ?>
                
                <div class="permit-document-sample-list">
                    <p class="viewdataSmaple">
                        <?php $sampleNo = 'Sample-'.$no;
                        echo $this->Html->link($sampleNo,"javascript:void(0);",array('title'=>'View Form '.$sampleNo,'escape' => false,'class'=>'btn-attachment-viewer','data-attachment-src'=>(BASE_URL.'/webroot/'.$permitFormSample['path']), 'data-attachment-name'=>$sampleNo, 'data-permit-form-sample-id'=>$permitFormSample['id'],'data-attachment-id'=>$permitFormSample['id'],'data-attachment-table'=>'permit_form_samples','data-download-pdf-path'=>$permitFormSample['path'],'data-file-name'=>$permitForm['name'].'-'.$sampleNo));
                        ?>
                        
                    <?php if($LoggedPermissionId !=3){
                        echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);', array('escape' => false,'title'=>'Delete','data-url'=>$redirectHere, 'data-title'=>('Sample-'.$no . ' of '.$permitForm['name']),'data-modelname'=>'PermitFormSamples','data-id'=> $permitFormSample['id'],'class'=>"myalert-delete")); } ?> 
                    </p>
                </div>
    <?php }
    $no++;  } ?>

            </td>      
            <td class="text-left"><?php echo $this->Custom->dateTime($permitForm['modified'])?></td>

            <td class="text-left">
                <?php echo $this->Html->link($this->Html->image('icons/edit.png'),'javascript:void(0);',array('escape' => false,'title'=>'Edit','data-title'=>'Edit Form','data-permit-form-name'=>htmlentities($permitForm['name']),'data-permit-form-id'=> $permitForm['id'],'class'=>"btnPermitFormModal"));?> &nbsp;&nbsp;
                
                <?php if($LoggedPermissionId !=3){ 
                    echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>$redirectHere, 'data-title'=>ucfirst(htmlentities($permitForm['name'])),'data-modelname'=>'PermitForms','data-subModelname'=>'PermitFormSamples','data-foreignId'=> 'permit_form_id','data-id'=> $permitForm['id'],'class'=>"myalert-delete")); } ?> 
            </td>
        </tr>
        <?php }
            }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>

