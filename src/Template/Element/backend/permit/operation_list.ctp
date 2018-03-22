 <?php   ?>
<table class="table table-responsive tbl-border-bottom">
    <thead>
        <tr>
            <th>Operation Name</th>
            <th>Last Update</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($permitOperations) && !$permitOperations->isEmpty()){ 
            foreach($permitOperations as $permitOperation){  ?>
        <tr>
            <td class="text-left">
                  <?php echo $this->Html->link(htmlentities($permitOperation['operation']['name']),['controller'=>'operations','action'=>'view',$this->Encryption->encode($permitOperation['operation']['id'])],array('title'=>'View','escape' => false)); ?>
            </td>
            <td class="text-left"><?php echo $this->Custom->dateTime($permitOperation['modified'])?></td>
            <th>
                 <?php if($LoggedPermissionId !=3){
                     echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($permitOperation['id'])],['data'=>['model_name'=>'PermitOperations','module_name'=>'Permit Operation','table_name'=>'permit_operations','title'=>htmlentities($permitOperation['operation']['name']),'redirect_url'=>$redirectHere,'foreignId'=>'','subModel'=>''], 'escape'=>false, 'class'=>'deleteConfirm']);
                 }?> 
            </th>
        </tr>
        <?php }
        
        }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>