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
        <?php if(!empty($form['alerts'])){ 
            foreach($form['alerts'] as $alerts){ ?>
        <tr>
            <td class="text-left"> <?php echo $alerts['alert']['title'];?>
            </td>

            <td class="text-left"><?php echo $this->Custom->dateTime($alerts['modified'])?></td>
            <td>

                <?php echo $this->Html->link($this->Html->image('icons/edit.png'),'javascript:void(0);',array('escape' => false,'title'=>'edit', 'data-title'=>'Edit Alert','data-formId'=>$alerts['form_id'],'data-alertId'=>$alerts['alert']['id'],'data-formAlertId'=>$alerts['id'],'data-notes'=>$alerts['alert']['notes'],'data-alertType'=> $alerts['alert']['alert_type_id'],'data-date'=>$alerts['alert']['date'],'data-time'=>$alerts['alert']['time'],'data-alertTitle'=>$alerts['alert']['title'],'data-toggle'=>"modal", 'data-target'=>"#permitAlertModel",'class'=>"permitAlert")); ?> 
            </td>
        </tr>
        <?php }
        
        }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>

