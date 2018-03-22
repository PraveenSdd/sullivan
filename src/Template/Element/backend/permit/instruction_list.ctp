 <?php  ?>
<table class="table table-responsive">
    <thead>
        <tr>
            <th>Title</th>
            <th>Instructions</th>
            <th>Last Update</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($permitInstructions) && !$permitInstructions->isEmpty()){ 
            $no = 1;foreach($permitInstructions as $permitInstruction){?>
        <tr>
            <td class="text-left"><?= htmlentities($permitInstruction['name']) ?></td>
            <td class="text-left">
                <?php if($permitInstruction['path']){ ?>
                 <div class="inner-bx-group-list permt-comn-inner-list permit-attachment-sample-list">
                     <?php 
                     $instructionFileName = htmlentities($permitInstruction['name']) .'-Instruction';
                     echo $this->Html->link('Instruction',"javascript:void(0);",array('title'=>'View '.$instructionFileName,'escape' => false,'class'=>'btn-attachment-viewer','data-attachment-src'=>(BASE_URL.'/webroot/'.$permitInstruction['path']), 'data-attachment-name'=>$instructionFileName, 'data-permit-form-id'=>$permitInstruction['id'],'data-attachment-id'=>$permitInstruction['id'],'data-attachment-table'=>'permit_instructions','data-download-pdf-path'=>$permitInstruction['path'],'data-file-name'=>$instructionFileName));
                     ?>                   
                </div>
            <?php } ?>
        </td>
            <td class="text-left"><?php echo $this->Custom->dateTime($permitInstruction['modified'])?></td>
            <td> 
                <?php echo $this->Html->link($this->Html->image('icons/edit.png'), 'javascript:void(0);', array('escape' => false,'title'=>'Edit', 'data-title' => "Add Instruction Document", 'data-permit-instruction-id' => $permitInstruction['id'],'data-permit-instruction-name' => $permitInstruction['id'], 'class' => "btnPermitInstructionModal"));?> &nbsp;&nbsp;
                 <?php if($LoggedPermissionId !=3){ 
                     echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>$redirectHere, 'data-title'=>htmlentities($permitInstruction['name']),'data-modelname'=>'PermitInstructions','data-id'=> $permitInstruction['id'],'class'=>"myalert-delete")); }?>
            </td>
        </tr>
        <?php }
        }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>