 <?php ?>
<table class="table table-responsive">
    <thead>
    <t>
        <th>Title</th>
        <th>Last Update</th>
        <th>Action</th>
    </t>
</thead>
<tbody>
        <?php if(!empty($operation['alert'])){ 
                  if(!empty($operation['alert']->toArray())){
            foreach($operation['alert'] as $alerts){   ?>
    <tr>
        <td class="text-left"><?=$alerts['alert']['title']?></td>
        <td class="text-left"><?php echo $this->Custom->dateTime($alerts['modified'])?></td>
        <th>
                <?php echo $this->Html->link($this->Html->image('icons/edit.png'),'javascript:void(0);',array('escape' => false,'title'=>'Edit','data-title'=>$alerts['alert']['title'],'data-operationId'=>$contact['id'], 'data-categoryId'=>$alerts['operation_id'], 'data-alertId'=>$alerts['alert']['id'], 'data-operationAlertId'=>$alerts['id'], 'data-notes'=>$alerts['alert']['notes'],'data-alertType'=>$alerts['alert']['alert_type_id'], 'data-toggle'=>"modal" 'data-target'=>"#permitAlertModel",'class'=>"editOperationAlert")); ?> 
            &nbsp;

 <?php echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>"/admin/operations/edit/".$this->Encryption->encode( $alerts['operation_id']), 'data-title'=>$alerts['alert']['title'],'data-modelname'=>'AlertOperations','data-id'=> $alerts->id,'class'=>"myalert-delete")); ?> 

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