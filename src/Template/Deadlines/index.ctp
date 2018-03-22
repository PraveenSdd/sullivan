<?php ?>

<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
             <?= $this->Flash->render() ?>
    <div class="main-action-btn pull-right clearfix">
        <!--        <a href="javascript:void(0);" class="action-txt">Search Here</a>-->
             <?php //echo $this->Html->link('Add',['controller'=>'deadlines','action'=>'add'],array('class'=>'btn btn-default','escape' => false)); ?>
    </div>
    <div class="clearfix"></div>
    <div class="table-responsive clearfix">

        <table class="table-striped">
            <thead>
                <tr>  
                    <th scope="col">Permit</th>
                    <th scope="col"><?php echo $this->Paginator->sort('date', 'Date'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('time', 'Time'); ?></th>                    
                    <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
<!--                    <th scope="col">Action</th>       -->
                </tr>
            </thead>
            <tbody>
               <?php  if(empty($deadlines)){  ?>
                <tr>
                    <td colspan="7" class="text-center">Record Not Found! </td></tr>
                    <?php } else {
                        foreach($deadlines as $deadline){ 
                             $deadlineId = $this->Encryption->encode($deadline['id']);
                             if($deadline['is_admin'] == 1){
                                 $color = 'alert-green';
                             }elseif($deadline['added_by'] ==$LoggedCompanyId){
                                 $color = 'alert-red';
                             }else{
                                 $color = 'alert-yellow';
                             }
                             ?>
                <tr class="<?php echo $color;?>">
                    <td>
                            <?php echo $deadline['permit']['name'];
                            if($deadline['is_renewable']){
                                echo " <strong>(Renewable)</strong>";
                            }
                            ?>
                    </td>
                    <td>
                            <?php echo $deadline['date'];?>
                    </td>
                    <td>
                            <?php if($deadline['is_renewable']==0){echo $deadline['time'];}else{ echo "NA";} ?>
                    </td>                    
                    <td>
                            <?=$this->Custom->dateTime($deadline['modified']); ?>
                    </td>
                    <td class="center">
 <?php if($deadline['is_admin'] ==0){ 
     if( $LoggedRoleId==2 || ($LoggedRoleId==3 && $LoggedPermissionId==4) || ($LoggedRoleId==3 &&  $LoggedCompanyId != $deadline['added_by'])){
     ?>
                                <?php //echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'deadlines','action'=>'edit',$deadlineId],array('title'=>'Edit','escape' => false)); ?> &nbsp;&nbsp;
     <?php }} ?>    </td>
                </tr>    
                    <?php } }?>
            </tbody>
        </table>
    </div>


