 <?php   ?>
<table class="table table-responsive">
    <thead>
        <tr>
            <th>Operation Name</th>
            <th>Last Update</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($form['operations'])){ 
                  if(!empty($form['operations']->toArray())){
            foreach($form['operations'] as $operation){  ?>
        <tr>
            <td class="text-left"><?=$operation['operation']['name']?></td>
            <td class="text-left"><?php echo $this->Custom->dateTime($operation['modified'])?></td>
            <th>
                 <?php echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>"/admin/forms/edit/".$this->Encryption->encode( $operation['permit_id']), 'data-title'=>$operation['operation']['name'],'data-modelname'=>'PermitOperations','data-id'=> $operation['id'],'class'=>"myalert-delete")); ?> 

            </th>
        </tr>
        <?php }
        }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } 
        }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>