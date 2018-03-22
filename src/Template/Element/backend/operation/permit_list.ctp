 <?php //prx($operation); ?>
<table class="table table-responsive">
    <thead>
    <t>
        <th>Permit Name</th>
        <th>Last Update</th>
        <th>Action</th>
    </t>
</thead>
<tbody>
        <?php if(!empty($operation['permit_operations'])){
            foreach($operation['permit_operations'] as $permit){ ?>
    <tr>
        <td class="text-left">
                <?php echo $this->Html->link(htmlentities($permit['permit']['name']),['controller'=>'permits','action'=>'view',$this->Encryption->encode($permit['permit']['id'])],array('title'=>'View','escape' => false)); ?>
        </td>
        <td class="text-left"><?php echo $this->Custom->dateTime($permit['modified'])?></td>
        <td>
            <?php if($LoggedPermissionId !=3){ 
                echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($permit->id)],['data'=>['model_name'=>'PermitOperations','module_name'=>'Operation Permit','table_name'=>'permit_operations','title'=>htmlentities($permit['permit']['name']),'redirect_url'=>$redirectHere,'foreignId'=>'','subModel'=>''], 'escape'=>false, 'class'=>'deleteConfirm']);
            }?> 

        </td>
    </tr>
        <?php }
        
        }else{ ?>
    <tr>
        <td colspan="6"> Record not found </td></tr>
       <?php } ?>
</tbody>
</table>