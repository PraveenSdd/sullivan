 <?php   ?>
<table class="table table-responsive tbl-border-bottom">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Last Update</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(isset($permitDeadline) && !empty($permitDeadline)){ 
                if($permitDeadline['is_admin'] == 0){
                                 $color = 'alert-yellow';
                             }elseif($permitDeadline['added_by'] ==$LoggedCompanyId){
                                 $color = 'alert-red';
                             }else{
                                 $color = 'alert-green';
                             }
                ?>
        <tr class="<?php echo $color;?> tr-related-permit-deadline">
            <td class="text-left"> <?php echo $permitDeadline['date'];?>
            </td>
            <td class="text-left">
                     <?php echo htmlentities($permitDeadline['time']); ?> 
            </td>
            <td class="text-left"><?php echo $this->Custom->dateTime($permitDeadline['modified'])?></td>
            <td>

                 <?php echo $this->Html->link($this->Html->image('icons/edit.png'),'javascript:void(0);',array('escape' => false,'title'=>'Edit','data-title'=>'Edit Deadline','data-deadline-id'=>$permitDeadline['id'],'data-deadline-date'=> $permitDeadline['date'],'data-deadline-time'=> $permitDeadline['time'], 'class' => "btnPermitDeadlineModal")); ?> &nbsp;&nbsp;

                 <?php if($LoggedPermissionId !=3){
                    echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($permitDeadline['id'])],['data'=>['model_name'=>'Deadlines','module_name'=>'Permit Deadline','table_name'=>'deadlines','title'=>('Deadline ('.$permitDeadline['date'].' '.$permitDeadline['time'].')'),'redirect_url'=>$redirectHere,'foreignId'=>'','subModel'=>''], 'escape'=>false, 'class'=>'deleteConfirm']);
                 } ?> 


            </td>
        </tr>
        <?php 
        }else{ ?>
        <tr>
            <td colspan="6"> Record not found </td></tr>
       <?php } ?>
    </tbody>
</table>
