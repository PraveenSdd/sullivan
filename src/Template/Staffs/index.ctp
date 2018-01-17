    <?php //pr();exit;?>

<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
    <div class="main-action-btn pull-right clearfix">
        <a href="javascript:void(0);" class="action-txt">Search Here</a>
             <?php echo $this->Html->link('Add',['controller'=>'staffs','action'=>'add'],array('class'=>'btn btn-default','escape' => false)); ?>
    </div>
    <div class="clearfix"></div>
    <div class="advance-search-panel hide clearfix">
        <a href="javascript:void(0);" class="asp-control"><i class="fa fa-close"></i></a>

    </div>
    <div class="table-responsive clearfix">
     <?= $this->Flash->render() ?>
        <table class="table-striped">
            <thead>
                <tr>
                    <th scope="col"><?php echo $this->Paginator->sort('first_name', 'Name'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('email', 'Email'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('phone', 'Phone'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                    <th scope="col">Action</th>    
                </tr>
            </thead>
            <tbody>
                <?php  if($staffs->count() <= 0 ){  ?>
                <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else {  foreach($staffs as $staff){
             
                        $id = $this->Encryption->encode($staff['id']);
                     ?>
                <tr>
                    <td>
                                <?php echo $this->Html->link($staff['first_name'],['controller'=>'staffs','action'=>'view',$id],array('title'=>'View','escape' => false)); ?> 

                    </td>
                    <td>
                             <?= @$staff['email'];; ?> 
                    </td>
                    <td>
                             <?= @$staff['phone'];; ?> 
                    </td>

                    <td><?= $this->Custom->dateTime(@$staff->modified); ?></td>
                    <td class="center">
                                <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'staffs','action'=>'edit',$id],array('title'=>'Edit','escape' => false)); ?> &nbsp;&nbsp;

                                 <?php echo $this->Html->link($this->Html->image("icons/view.png"),['controller'=>'staffs','action'=>'view',$id],array('title'=>'View','escape' => false)); ?> &nbsp;&nbsp; 

                    <?php if($Authuser['role_id']==2 && $staff->is_verify != 1){ ?>
                        <a  class="myalert-delete" title="Verify" data-title="Verify" href="javasript:void();" data-id="<?php echo $staff->id?>" data-modelname="Users"><?php echo $this->Html->image('icons/active.png'); ?> </a>
                    <?php } ?>

                    </td>
                </tr>    
              <?php } }?>
            </tbody>
        </table>
    </div>