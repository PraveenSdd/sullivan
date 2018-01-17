 <?php   ?>
<table class="table table-responsive">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Last Update</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($form['permit_deadlines'])){ 
            foreach($form['permit_deadlines'] as $deadlines){ ?>
        <tr>
            <td class="text-left"> <?php echo $this->Custom->dateTime($deadlines['date']);?>
            </td>
            <td class="text-left">
                     <?php echo $deadlines['time']; ?> 
            </td>
            <td class="text-left"><?php echo $this->Custom->dateTime($deadlines['modified'])?></td>
            <td>

                 <?php echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>"/admin/forms/edit/".$this->Encryption->encode( $deadlines['form_id']), 'data-modelname'=>'PermitDeadlines','data-id'=> $deadlines['id'],'class'=>"myalert-delete")); ?> 


            </td>
        </tr>
        <?php }
        
        }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>
