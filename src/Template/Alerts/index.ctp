<?php ?>

<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
             <?= $this->Flash->render() ?>
    <div class="main-action-btn pull-right clearfix">
<!--        <a href="javascript:void(0);" class="action-txt">Search Here</a>-->
             <?php echo $this->Html->link('Add',['controller'=>'alerts','action'=>'add'],array('class'=>'btn btn-default','escape' => false)); ?>
    </div>
    <div class="clearfix"></div>
    <div class="table-responsive clearfix">

        <table class="table-striped">
            <thead>
                <tr>                    
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Title'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Alert Type'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('date', 'Date'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('time', 'Time'); ?></th>                    
                    <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                    <th scope="col">Modified By</th>       
                    <th scope="col">Action</th>       
                </tr>
            </thead>
            <tbody>
               <?php  
               if(empty($alerts)){  ?>
                <tr>
                    <td colspan="7" class="text-center">Record Not Found! </td></tr>
                    <?php } else {
                        foreach($alerts as $alert){ 
                             $alertId = $this->Encryption->encode($alert->id); 
                             if($alert->is_admin == 1){
                                 $color = 'alert-green';
                             }elseif($alert->added_by ==$LoggedCompanyId){
                                 $color = 'alert-red';
                             }else{
                                 $color = 'alert-yellow';
                             }
                             ?>
                <tr class="<?php echo $color;?>">
                    <td>
                        <?php echo $this->Html->link($alert->title,['controller'=>'alerts','action'=>'view',$alertId],array('title'=>'View','escape' => false)); ?>
                    </td>
                    <td>
                            <?php echo (!empty($alert->alert_type->name))?$alert->alert_type->name:'';?>
                    </td>

                    <td>
                            <?php echo $alert->date;?>

                    </td>
                    <td>
                            <?php echo $alert->time; ?>

                    </td>                    
                    <td>
                            <?=$this->Custom->dateTime($alert->modified); ?></td>
                    <td><?= @$alert->user->first_name; ?></td>


                    <td class="center">
 <?php if($alert->is_admin ==0){ 
     if( $LoggedRoleId==2 || ($LoggedRoleId==3 && $LoggedPermissionId==4) || ($LoggedRoleId==3 &&  $LoggedCompanyId != $alert->added_by)){
     ?>
                                <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'alerts','action'=>'edit',$alertId],array('title'=>'Edit','escape' => false)); ?> &nbsp;&nbsp;
     <?php }} ?>

                    </td>
                </tr>    
                    <?php } }?>
            </tbody>
        </table>
        <?php if(!empty($alerts)){echo $this->element('layout/frontend/default/pagination'); }?>
    </div>


