 <?php   ?>
<table class="table table-responsive">
    <thead>
        <tr>
            <th>Title</th>
            <th>File</th>
            <th>Last Update</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($form['permit_instructions'])){ 
                  
            $no = 1;foreach($form['permit_instructions'] as $instruction){  ?>
        <tr>
            <td class="text-left"><?=$instruction['title']?></td>
            <td class="text-left">
                <?php if(file_exists(BASE_URL.'/webroot/'.$instruction['file_path'])){ ?>
                 <div class="inner-bx-group-list permt-comn-inner-list permit-attachment-sample-list">
                    <p class="">
                               <?php echo $this->Html->link('Sample','javascript:void(0);',array('escape' => false,'title'=> 'Sample-'.$no,'tooltip'=> 'Sample-'.$no, 'class'=>'btn-attachment-viewer viewdata', 'data-attachment-src'=>BASE_URL.'/webroot/'.$instruction['file_path'], 'data-attachment-name'=>'Sample- '.$no, 'data-attachment-id'=>$instruction['id'])); ?> 
                    </p>
                </div>
            <?php } ?>
                

            </td>
            <td class="text-left"><?php echo $this->Custom->dateTime($instruction['modified'])?></td>
            <td>
                 <?php echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>"/admin/forms/edit/".$this->Encryption->encode( $instruction['permit_id']), 'data-title'=>$instruction['title'],'data-modelname'=>'PermitInstructions','data-id'=> $instruction['id'],'class'=>"myalert-delete")); ?> 


            </td>
        </tr>
        <?php }
        }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>