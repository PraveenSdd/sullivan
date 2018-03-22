 <?php ?>
<table class="table table-responsive">
    <thead>
    <t>
        <th>Permit Name</th>
        <th>Contact Person</th>
        <th>Last Update</th>
        <th>Action</th>
    </t>
</thead>
<tbody>
        <?php if(!empty($permitAgencies)){
            $agencyContactId = [];
            foreach($permitAgencies as $permitAgency){ 
        ?>
    <tr>
        <td class="text-left">
            <?php echo $this->Html->link(htmlentities($permitAgency['permit']['name']),['controller'=>'permits','action'=>'view',$this->Encryption->encode($permitAgency['permit']['id'])],array('title'=>'View','escape' => false)); ?>
        </td>
        <td class="text-left">
            <?php 
            $agencyContactId =[];
            $agencyContactCount = 1;
            foreach($permitAgency['permit_agency_contacts'] as $permitAgencyContact){ ?>
            <div >
                    <?php echo $agencyContactCount.'. ';
                    echo $this->Html->link(htmlentities($permitAgencyContact['agency_contact']['name']),'javascript:void(0);',array('escape' => false,'data-agency-contact-id'=> $permitAgencyContact['agency_contact']['id'],'class'=>"btnViewContactPersonModal"));
                echo '&nbsp;&nbsp;';
                if($LoggedPermissionId !=3){ 
                   echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($permitAgencyContact['id'])],['data'=>['model_name'=>'PermitAgencyContacts','module_name'=>'Agency Contact','table_name'=>'permit_agency_contacts','title'=>htmlentities($permitAgencyContact['agency_contact']['name']),'redirect_url'=>$redirectHere,'foreignId'=>'','subModel'=>''], 'escape'=>false, 'class'=>'deleteConfirm']);
                }
                ?>
            </div>
                <?php $agencyContactId[] =   $permitAgencyContact['agency_contact_id']; ?>
                <?php  $agencyContactCount++; ?>
           <?php  } ?>

           <?php $agencyContactId = implode(',', $agencyContactId); ?>
        </td>
        <td class="text-left"><?php echo $this->Custom->dateTime($permitAgency['modified'])?></td>
        <td class="text-left">
              <?php
            echo $this->Html->link($this->Html->image('icons/edit.png'),'javascript:void(0);',array('escape' => false,'title'=>'Edit','data-title'=>'Edit Permit','data-permit-agency-id'=>$permitAgency['id'],'data-permit-id'=>$permitAgency['permit_id'],'data-agency-contact-id'=>$agencyContactId,'class'=>"btnAgencyPermitModal"));
            echo '&nbsp;&nbsp;';
             if($LoggedPermissionId !=3){
                 echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($permitAgency['id'])],['data'=>['model_name'=>'PermitAgencies','module_name'=>'Agencie Permit','table_name'=>'permit_agencies','title'=>htmlentities($permitAgency['permit']['name']),'redirect_url'=>$redirectHere,'foreignId'=>'permit_agency_id','subModel'=>'PermitAgencyContacts'], 'escape'=>false, 'class'=>'deleteConfirm']);
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