<div class="main-content clearfix">
    <h4 class="pull-left"> 
        <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>
    <?= $this->Flash->render() ?>
    <div class="clearfix"></div>
    <div class="table-responsive clearfix">
        <table class="table-striped">
            <thead>
                <tr>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Title'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('created', 'Date'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('is_readed', 'Action'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($alertNotifications->count() <= 0) { ?>
                    <tr>
                        <td colspan="3" class="text-center">Record Not Found! </td></tr>
                        <?php
                    } else {
                        foreach ($alertNotifications as $alertNotification) {
                            $id = $this->Encryption->encode($alertNotification->id);
                            if($alertNotification->alert->is_admin == 1){
                                 $color = 'alert-green';
                             }elseif($alertNotification->alert->added_by == $LoggedCompanyId){
                                 $color = 'alert-red';
                             }else{
                                 $color = 'alert-yellow';
                             }
                            ?>
                            <tr class="<?php echo $color;?>">
                                <td>
                                    <?php echo $this->Html->link($alertNotification->alert->title, ['controller' => 'alerts', 'action' => 'view', $this->Encryption->encode($alertNotification->alert_id), $id], array('title' => 'Edit', 'escape' => false)); ?>
                                </td>
                                <td>
                                    <?php echo $this->Custom->DateTime($alertNotification->created); ?>
                                </td>
                                <td><?php echo ($alertNotification->is_readed)? 'Readed' : 'Un-readed';?></td>
                            </tr>    
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>

    </div>
</div>


