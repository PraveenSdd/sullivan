<?php ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <h5><?= $this->Flash->render() ?></h5>
            <div class="box-header">
                <div class="UserAdminIndexForm">
                    <div class="box-body">	
                        <div class="row">
                            <?php  echo $this->Form->create('Alerts', array('url' => array('controller' => 'alerts', 'action' => 'index'),'id'=>'srchFromAgency','type'=>'get')); ?>
                            <div class='col-xs-3 col-md-3'>
                                     <?php echo $this->Form->input('title', array(
                                                  'placeholder'=>'Title',
                                                  'class'=>'form-control btm-search',
                                                  'label' => false,
                                                 ));  
                                              ?>
                            </div>								

                            <div class='col-xs-12 col-md-3'>
 <?php echo $this->Form->button('Search', array('type'=>'submit','class'=>'btm-search btn bg-olive')); ?>
                                                    <?php echo $this->Html->link('Cancel',['controller'=>'alerts','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;

                            </div>	
   <?php echo $this->Form->end();?> 
                        </div>
                    </div>	

                </div>

                <div style="clear:both;"></div>
            </div>
            <div class="col-xs-12 margin-top-20">
                <span class="pull-right">

                                <?php echo $this->Html->link('Add Alert',['controller'=>'alerts','action'=>'add'],array('class'=>'btn btn-primary','escape' => false)); ?>
                </span>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col"><?php echo $this->Paginator->sort('title', 'Title'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                            <th scope="col">Modified By</th>       
                            <th scope="col">Action</th>       
                        </tr>
                    </thead>
                    <tbody>
                 <?php  if($alerts->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                 <?php } else { 
                     foreach($alerts as $alert){
                        $id = $this->Encryption->encode($alert->id);
                        if($alert->is_admin == 0){
                                 $color = 'alert-yellow';
                             }elseif($alert->added_by ==$LoggedCompanyId){
                                 $color = 'alert-red';
                             }else{
                                 $color = 'alert-green';
                             }
                     ?>
                        <tr scope="row" class="<?php echo $color;?>">
                            <td>
                                 <?php echo $this->Html->link(htmlentities($alert->title),['controller'=>'alerts','action'=>'view',$id],array('title'=>'View','escape' => false)); ?> 
                            </td>
                            <td><?php echo $this->Custom->DateTime($alert->modified);?></td>
                            <td><?= @$alert->user->first_name; ?></td>
                            <td class="center">
                                 <?php 
                                 if($alert->is_admin == 1){
                                     if( $LoggedRoleId==1 || ($LoggedRoleId==4 && $LoggedPermissionId==2) || ($LoggedRoleId==4 &&  $LoggedCompanyId != $alert->added_by)){
                                    echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'alerts','action'=>'edit',$id],array('title'=>'Edit','escape' => false)); 
                                     }
                                 }
                                 
                                 ?> 
                            </td>
                        </tr>
                <?php } } ?>
                    </tbody> 
                </table>
                  <?php echo $this->element('layout/backend/default/pagination'); ?>
            </div>
        </div>
    </div>
</div>
