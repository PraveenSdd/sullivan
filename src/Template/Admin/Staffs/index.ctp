<?php ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <h5><?= $this->Flash->render() ?></h5>
            <div class="box-header">
                <div class="UserAdminIndexForm">
                    <div class="box-body">	
                        <div class="row">
                             <?php  echo $this->Form->create('Users', array('url' => array('controller' => 'staffs', 'action' => 'index'),' method'=>'get')); ?>
                            <div class='col-xs-3 col-md-2'>
                                        <?php echo $this->Form->input('name', array(
                                                  'placeholder'=>'Name',
                                                  'class'=>'form-control btm-search',
                                                  'label' => false,
                                                 ));  
                                              ?>                                
                            </div>								
                            <div class='col-xs-12 col-md-3'>
                                <?php echo $this->Form->button('Search', array('type'=>'submit','class'=>'btm-search btn bg-olive')); ?>&nbsp;&nbsp;
                                <?php echo $this->Html->link('Cancel',['controller'=>'users','action'=>'companies'],array('class'=>'btn btn-warning','escape' => false)); ?> 
                                 
                            </div>	
                            <?php echo $this->Form->end();?>
                        </div>
                    </div>	
                </div>

                <div style="clear:both;"></div>
            </div>
            <div class=" padding_btm_20" style="padding-top:10px">
                <div class="col-xs-12 margin-top-20">
                    <span class="pull-right">
                    <?php echo $this->Html->link('Add',['controller'=>'staffs','action'=>'add'],array('class'=>'btn btn-primary','escape' => false)); ?> 
                    </span>
                </div>
            </div>
           <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col"><?php echo $this->Paginator->sort('first_name', 'Company'); ?></th>
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
                             <?php echo ($staff['email'])?$staff['email']:'' ?> 
                            </td>
                            <td> <?php echo ($staff['phone'])?$staff['phone']:'' ?> 
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
                 <?php //echo $this->element('pagination'); ?>
            </div>
        </div>
    </div>
</div>