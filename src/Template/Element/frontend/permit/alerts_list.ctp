 <?php   ?>
<table class="table table-responsive">
    <thead>
        <tr>
            <th>Title</th>

            <th>Last Update</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($form['alert_permits'])){ 
            foreach($form['alert_permits'] as $alerts){  ?>
        <tr>
            <td class="text-left"> <?php echo $alerts['alert']['title'];?>
            </td>

            <td class="text-left"><?php echo $this->Custom->dateTime($alerts['modified'])?></td>
            <td>

                <?php if($subAdminEdit ==1){  echo $this->Html->link($this->Html->image('icons/edit.png'),'javascript:void(0);',array('escape' => false,'title'=>'edit', 'data-title'=>'Edit Alert','data-formId'=>$alerts['form_id'],'data-alertId'=>$alerts['alert']['id'],'data-formAlertId'=>$alerts['id'],'data-notes'=>$alerts['alert']['notes'],'data-alertType'=> $alerts['alert']['alert_type_id'],'data-date'=>date('d-m-Y', strtotime($alerts['alert']['date'])),'data-time'=>date('h:i:a', strtotime($alerts['alert']['time'])),'data-alertTitle'=>$alerts['alert']['title'],'data-toggle'=>"modal", 'data-target'=>"#permitAlertModel",'class'=>"permitAlert")); }?> &nbsp;
                
                 <?php if($subAdminDelete ==1){ echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>"/admin/forms/edit/".$this->Encryption->encode( $alerts['form_id']), 'data-title'=>$alerts['alert']['title'],'data-modelname'=>'Alerts','data-id'=> $alerts['alert_id'],'data-subModelname'=>'AlertPermits','data-foreignId'=> 'alert_id','class'=>"myalert-delete")); } ?> 
            </td>
        </tr>
        <?php }
        
        }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>

