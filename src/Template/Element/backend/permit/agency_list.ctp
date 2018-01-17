 <?php   ?>
<table class="table table-responsive">
    <thead>
        <tr>
            <th>Agency Name</th>
            <th>Conatct Name</th>
            <th>Last Update</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($form['agencies'])){ 
                  if(!empty($form['agencies']->toArray())){
            foreach($form['agencies'] as $agency){  ?>
        <tr>
            <td class="text-left"><?=$agency['category']['name']?></td>
            <td class="text-left">
                     <?php echo $this->Html->link($agency['agency_contact']['name'],'javascript:void(0);',array('escape' => false,'data-id'=> $agency['agency_contact']['id'],'class'=>"viewContact")); ?> 
            </td>
            <td class="text-left"><?php echo $this->Custom->dateTime($agency['modified'])?></td>
            <td>
                 <?php echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>"/admin/forms/edit/".$this->Encryption->encode( $agency['permit_id']), 'data-title'=>$agency['category']['name'],'data-modelname'=>'PermitAgencies','data-id'=> $agency['id'],'class'=>"myalert-delete")); ?> 


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