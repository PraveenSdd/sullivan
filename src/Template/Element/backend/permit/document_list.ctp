 <?php   ?>
<table class="table table-responsive tbl-border-bottom">
    <thead>
        <tr>
            <th>Document Name</th>
            <th>Last Update</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($permitDocuments) && !$permitDocuments->isEmpty()){ 
                
            foreach($permitDocuments as $permitDocument){ ?>
        <tr>
            <td class="text-left">
                <a title="<?php echo ucfirst(htmlentities($permitDocument['document']['name'])); ?>" tooltip="<?php echo ucfirst(htmlentities($permitDocument['document']['name'])); ?>" href="javascript:void(0);" class="btn-attachment-viewer viewdata" data-attachment-src="<?php echo BASE_URL.'/webroot/'.$permitDocument['path']; ?>" data-attachment-name="<?php echo ucfirst(htmlentities($permitDocument['document']['name'])); ?>" data-attachment-id="<?php echo $permitDocument['id']; ?>"><?php echo htmlentities($permitDocument['document']['name']);?></a>
            </td>
                 
            <td class="text-left"><?php echo $this->Custom->dateTime($permitDocument['modified'])?></td>

            <td class="text-left">
                <?php if($LoggedPermissionId !=3){ 
                    echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($permitDocument['id'])],['data'=>['model_name'=>'PermitDocuments','module_name'=>'Permit Document','table_name'=>'permit_documents','title'=>ucfirst(htmlentities($permitDocument['document']['name'])),'redirect_url'=>$redirectHere,'foreignId'=>'','subModel'=>''], 'escape'=>false, 'class'=>'deleteConfirm']);
                } ?> 
            </td>
        </tr>
        <?php }
            }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>

