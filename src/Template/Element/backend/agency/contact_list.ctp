 <?php ?>
<table class="table table-responsive">
    <thead>
    <tr>
        <th>Name</th>
        <th>Prosition</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
        <?php if(!empty($category['contact'])){ 
                  if(!empty($category['contact']->toArray())){
            foreach($category['contact'] as $contact){ ?>
    <tr>
        <td><?=$contact['name']?></td>
        <td><?=$contact['position']?></td>
        <td><?=$contact['email']?></td>
        <td><?=$contact['phone']?></td>
        <td><?php echo substr($contact['address'],0,50);?></td>
        <th>
            <?php echo $this->Html->link($this->Html->image('icons/edit.png'),'javascript:void(0);',array('escape' => false,'title'=>'Edit','data-title'=>$contact['name'],'data-contactId'=>$contact['id'], 'data-categoryId'=>$contact['agency_id'], 'data-conatcName'=>$contact['name'], 'data-conatcPosition'=>$contact['position'], 'data-conatcEmail'=>$contact['email'],'data-conatcPhone'=>$contact['phone'], 'data-conatcAddress'=>$contact['address'],'class'=>"editAgencyConatct")); ?> 
            
            <?php echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>"/admin/categories/edit/".$this->Encryption->encode( $contact['agency_id']), 'data-title'=>$contact['name'],'data-modelname'=>'AgencyContacts','data-id'=> $contact['id'],'class'=>"myalert-delete")); ?> 
           
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