<?php ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <h5><?= $this->Flash->render() ?></h5>
            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col"><?php echo $this->Paginator->sort('title', 'Title'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('modified', 'Date'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('is_readed', 'Read/Un-read'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                 <?php  if($alertNotifications->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                 <?php } else { 
                     foreach($alertNotifications as $alertNotification){
                        $id = $this->Encryption->encode($alertNotification->id);
                        if($alertNotification->alert->is_admin == 0){
                                 $color = 'alert-yellow';
                             }elseif($alertNotification->alert->added_by == $LoggedCompanyId){
                                 $color = 'alert-red';
                             }else{
                                 $color = 'alert-green';
                             }
                     ?>
                        <tr scope="row" class="<?php echo $color;?>">
                            <td>
                                 <?php echo $this->Html->link(htmlentities($alertNotification->alert->title),['controller'=>'alerts','action'=>'view',$this->Encryption->encode($alertNotification->alert_id),$id],array('title'=>'View','escape' => false)); ?> 
                            </td>
                            <td><?php echo $this->Custom->DateTime($alertNotification->created);?></td>
                            <td><?php echo ($alertNotification->is_readed)? 'Readed' : 'Un-readed';?></td>
                        </tr>
                <?php } } ?>
                    </tbody> 
                </table>
                  <?php echo $this->element('layout/backend/default/pagination'); ?>
            </div>
        </div>
    </div>
</div>
