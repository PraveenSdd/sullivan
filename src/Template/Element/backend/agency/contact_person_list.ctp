 <?php ?>
<table class="table table-responsive">
    <thead>
        <tr>
            <th>Name</th>
            <th>Position</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php  if(!empty($agencyContacts)){ 
            foreach($agencyContacts as $agencyContact){ ?>
        <tr>
            <td class="text-left">
                 <?php echo $this->Html->link(htmlentities($agencyContact['name']),'javascript:void(0);',array('escape' => false,'data-agency-contact-id'=> $agencyContact['id'],'class'=>"btnViewContactPersonModal")); ?> 
            </td>
            <td class="text-left"><?=htmlentities($agencyContact['position'])?></td>
            <td class="text-left"><?=$agencyContact['email']?></td>
            <td class="text-left"><?=$agencyContact['phone']?></td>
            <th>

            <?php 
            echo $this->Html->link($this->Html->image('icons/edit.png'),'javascript:void(0);',array('escape' => false,'title'=>'Edit','data-title'=>'Edit Contact Person','data-agency-contact-id'=>$agencyContact['id'], 'data-agency-contact-name'=>htmlentities($agencyContact['name']), 'data-agency-contact-position'=>htmlentities($agencyContact['position']), 'data-agency-contact-email'=>$agencyContact['email'],'data-agency-contact-phone'=>$agencyContact['phone'], 'data-agency-contact-phone-extension'=>$agencyContact['phone_extension'],'data-agency-contact-address'=>(($agencyContact['addresses']) ? 1 : 0),'class'=>"btnAgencyContactPersonModal"));
       
            echo '&nbsp;&nbsp;';
             if($LoggedPermissionId !=3){
                 echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($agencyContact['id'])],['data'=>['model_name'=>'AgencyContacts','module_name'=>'Agency Contact','table_name'=>'agency_contacts','title'=>htmlentities($agencyContact['name']),'redirect_url'=>$redirectHere,'foreignId'=>'','subModel'=>''], 'escape'=>false, 'class'=>'deleteConfirm']);
             }
             ?> 

            </th>
        </tr>
       <?php }
        
        }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>