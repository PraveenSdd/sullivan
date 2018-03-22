 <?php   ?>
<table class="table table-responsive tbl-border-bottom">
    <thead>
        <tr>
            <th>Agency Name</th>
            <th>Contact Person</th>
            <th>Last Update</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($permitAgencies)){ 
           ?>
        <tr class="tr-related-permit-agency">
            <td class="text-left">
                <?php echo $this->Html->link(htmlentities($permitAgencies['agency']['name']),['controller'=>'agencies','action'=>'view',$this->Encryption->encode($permitAgencies['agency']['id'])],array('title'=>'View','escape' => false)); ?>
             </td>
            <td class="text-left">
                <?php 
                $agencyContactId =[];
                $agencyContactCount = 1;
                foreach($permitAgencies['permit_agency_contacts'] as $permitAgenciesContact){ ?>
                    <div >
                        <?php echo $agencyContactCount.'. ';
                        echo $this->Html->link(htmlentities($permitAgenciesContact['agency_contact']['name']),'javascript:void(0);',array('escape' => false,'data-agency-contact-id'=> $permitAgenciesContact['agency_contact']['id'],'class'=>"btnViewContactPersonModel"));
                    echo '&nbsp;&nbsp;';
                    if($LoggedPermissionId !=3){                         
                        echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($permitAgenciesContact['id'])],['data'=>['model_name'=>'PermitAgencyContacts','module_name'=>'Permit Agency Contacts','table_name'=>'permit_agency_contacts','title'=>htmlentities($permitAgenciesContact['agency_contact']['name']),'redirect_url'=>$redirectHere,'foreignId'=>'','subModel'=>''], 'escape'=>false, 'class'=>'deleteConfirm']);                     
                    }
                    ?>
                    </div>
                    <?php $agencyContactId[] =   $permitAgenciesContact['agency_contact_id']; ?>
                    <?php  $agencyContactCount++; ?>
               <?php  } ?>

               <?php $agencyContactId = implode(',', $agencyContactId); ?>
            </td>
            <td class="text-left"><?php echo $this->Custom->dateTime($permitAgencies['modified'])?></td>
            <td class="text-left">
              <?php 
                echo $this->Html->link($this->Html->image('icons/edit.png'),'javascript:void(0);',array('escape' => false,'title'=>'Edit','data-title'=>'Edit Agency','data-permit-agency-id'=>$permitAgencies['id'],'data-agency-id'=>$permitAgencies['agency_id'],'data-agency-contact-id'=>$agencyContactId,'class'=>"btnPermitAgencyModal"));
                echo '&nbsp;&nbsp;';
                 if($LoggedPermissionId !=3){                     
                echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($permitAgencies['id'])],['data'=>['model_name'=>'PermitAgencies','module_name'=>'Permit Agencie','table_name'=>'permit_agencies','title'=>htmlentities($permitAgencies['agency']['name']),'redirect_url'=>$redirectHere,'foreignId'=>'permit_agency_id','subModel'=>'PermitAgencyContacts'], 'escape'=>false, 'class'=>'deleteConfirm']);
                 }?> 
            </td>
        </tr>
        <?php
        }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td>
        </tr>
       <?php } ?>
    </tbody>
</table>