 <?php ?>
<table class="table table-responsive">
    <thead>
    <t>
        <th>Permit Name</th>
        <th>Last Update</th>
        <th>Action</th>
    </t>
    </thead>
    <tbody>
        <?php if(!empty($operation['permit'])){
            if(!empty($operation['permit']->toArray())){
            foreach($operation['permit'] as $permit){ ?>
        <tr>
            <td class="text-left"><?=$permit['form']['title']?></td>
            <td class="text-left"><?php echo $this->Custom->dateTime($permit['modified'])?></td>
            <td>
                 <?php echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>"/admin/operations/edit/".$this->Encryption->encode( $permit->operation_id), 'data-title'=>$permit['form']['title'],'data-modelname'=>'PermitOperations','data-id'=> $permit->id,'class'=>"myalert-delete")); ?> 
                
            </td>
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