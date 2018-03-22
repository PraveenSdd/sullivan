 <?php //prx($permitForms);  ?>

<table class="table-striped tbl-permit-form">
    <thead class="tbl-permit-form-thead">
        <tr class="tbl-permit-form-tr">
            <th scope="col">Name</th>
            <th scope="col">Sample</th>
            <th scope="col">Last Modified</th>
            <th scope="col">Status</th>
            <th class="text-center" scope="col">Upload</th>
            <th class="text-center" scope="col">Download</th>
        </tr>
    </thead>
    <tbody class="tbl-permit-form-body">
        <?php if(!empty($permitForms)) { ?>
            <?php foreach ($permitForms as $key => $value) { ?>  
                <tr class="tbl-permit-form-tr">
                    
                     <td>
                        <?php echo $this->Html->link($value->name,"javascript:void(0);",array('title'=>'View Permit Form','escape' => false,'class'=>'btn-attachment-viewer','data-attachment-src'=>(BASE_URL.'/webroot/'.$value->path), 'data-attachment-name'=>$value->name, 'data-permit-form-id'=>$value->id,'data-attachment-id'=>$value->id,'data-attachment-table'=>'permit_forms','data-download-pdf-path'=>$value->path,'data-file-name'=>$value->name)); ?>
                    </td>
                    
                    <td>
                        <?php if(!empty($value->permit_form_samples)) { 
                            $sampleCounter = 1;
                            foreach ($value->permit_form_samples as $keySample => $valueSample) { 
                                $sampleNo = 'Sample-'.$sampleCounter;
                                echo $this->Html->link($sampleNo,"javascript:void(0);",array('title'=>'View Form Sample','escape' => false,'class'=>'btn-attachment-viewer','data-attachment-src'=>(BASE_URL.'/webroot/'.$valueSample['path']), 'data-attachment-name'=>$sampleNo, 'data-permit-form-sample-id'=>$valueSample['id'],'data-attachment-id'=>$valueSample['id'],'data-attachment-table'=>'permit_form_samples','data-download-pdf-path'=>$valueSample['path'],'data-file-name'=>$value->name.'-'.$sampleNo)); 
                                $sampleCounter++;  
                                echo "<br />";
                            }
                        } else {
                            echo "-";
                        } ?>
                    </td>
                    
                    <?php if(!empty($value->user_permit_form)){ ?>
                        <td><?php echo $value->user_permit_form->modified; ?></td>
                        <td>
                           <?php echo $this->Html->link('Filled',"javascript:void(0);",array('title'=>'View Filled Form','escape' => false,'class'=>'btn-attachment-viewer','data-attachment-src'=>(BASE_URL.'/webroot/'.$value->user_permit_form->file), 'data-attachment-name'=>$value->name,'data-permit-form-id'=>$value->id, 'data-user-permit-form-id'=>$value->user_permit_form->id,'data-security-type-id'=>$value->user_permit_form->security_type_id,'data-attachment-id'=>$value->user_permit_form->id,'data-attachment-table'=>'user_permit_forms','data-download-pdf-path'=>$value->user_permit_form->file,'data-file-name'=>$value->name.'-Filled')); ?> 
                        </td>
                        <td align="center">
                            <?php echo $this->Html->link($this->Html->tag('i','',array('class'=>'fa fa-upload')),"javascript:void(0);",array('title'=>'Upload Form','escape' => false,'class'=>'btnPermitFormModal','data-modal-title'=>$value->name,'data-permit-form-id'=>$value->id,'data-security-type-id'=>$value->user_permit_form->security_type_id, 'escape'=>false)); ?>
                        </td>
                    <?php } else { ?>
                        <td>-</td>
                        <td>Pending</td>
                        <td align="center">
                        <?php echo $this->Html->link($this->Html->tag('i','',array('class'=>'fa fa-upload')),"javascript:void(0);",array('title'=>'Upload Form','escape' => false,'class'=>'btnPermitFormModal','data-modal-title'=>$value->name,'data-permit-form-id'=>$value->id,'data-security-type-id'=>'', 'escape'=>false)); ?>
                        </td>
                    <?php } ?>
                        <td align="center">
                            <?php echo $this->Html->link($this->Html->tag('i','',array('class'=>'fa fa-download')),['controller'=>'permits','action'=>'downloadFullForm','?'=>array('permit_id'=>$value->permit_id,'permitFormId'=>$value->id,'userPermitId'=>$userPermitId)],array('title'=>'Download form, sample & filled form','escape' => false,'class'=>'btnDownloadForm1','data-permit-form-id'=>$value->id,'data-file-name'=>$value->name,'data-attachment-table'=>'permit_forms', 'escape'=>false)); ?>
                        </td>   
                </tr>
            <?php } ?>
        <?php } else { ?>
                <tr class="tbl-permit-deadline-tr">
                    <td colspan="6">Data not available!</td>
                </tr>
        <?php } ?>        
    </tbody>
</table>




