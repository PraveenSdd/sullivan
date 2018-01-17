<?php ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
             <h5><?= $this->Flash->render() ?></h5>
            <div class="box-header">
                    <!-- filters starts-->
                    <div class="UserAdminIndexForm">
                        <div class="box-body">	
                            <div class="row">
			        <?php  echo $this->Form->create('HomePages', array('url' => array('controller' => 'HomePages', 'action' => 'index'),'id'=>'CategoryIndexForm',' method'=>'get')); ?>
                            <div class='col-xs-3 col-md-2'>
                                        <?php echo $this->Form->input('name', array(
                                                  'placeholder'=>'Name',
                                                  'class'=>'form-control btm-search',
                                                  'label' => false,
                                                 ));  
                                              ?>                                </div>								
                            <div class='col-xs-12 col-md-3'>
                                <?php echo $this->Html->link('Cancel',['controller'=>'homePages','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
                                 <?php echo $this->Form->button('Search', array('type'=>'submit','class'=>'btm-search btn bg-olive')); ?>
                            </div>	
                            <?php echo $this->Form->end();?>
                            </div>
                        </div>	

                    </div>
               
                <div style="clear:both;"></div>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col"><?php echo $this->Paginator->sort('name', 'Name'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                            <th scope="col">Action</th>       
                        </tr>
                    </thead>
                    <tbody>
                        
                    <?php  if($SubscriptionPlans->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else { foreach($SubscriptionPlans as $SubscriptionPlan){ 
                            $id = $this->Encryption->encode($SubscriptionPlan->id);
                             ?>
                        <tr>
                            <td>
                             <?= $SubscriptionPlan->name; ?> 
                             </td>
                            <td><?= $this->Custom->dateTime($SubscriptionPlan->modified); ?></td>
                            <td class="center">

                                <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'homePages','action'=>'EditSubscriptionPlans',$id],array('title'=>'Edit','escape' => false)); ?> &nbsp;&nbsp;
                                 <?php echo $this->Html->link($this->Html->image("icons/view.png"),['controller'=>'homePages','action'=>'ViewSubscriptionPlans',$id],array('title'=>'View','escape' => false)); ?> &nbsp;&nbsp; 

                            </td>
                        </tr>
                     
                    <?php } }?>
                    </tbody>
                </table>
                 <?php echo $this->element('pagination'); ?>
            </div>
        </div>
    </div>
</div>

