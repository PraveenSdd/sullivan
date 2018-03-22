<?php ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
             <h5><?= $this->Flash->render() ?></h5>
            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col"><?php echo $this->Paginator->sort('name', 'Name'); ?></th>


                            <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                            <th scope="col">Modified By</th>       
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
                             <?php echo $this->Html->link($SubscriptionPlan->name,['controller'=>'homePages','action'=>'ViewSubscriptionPlans',$id],array('title'=>'View','escape' => false)); ?>
                             
                             </td>

                            <td><?= $this->Custom->dateTime($SubscriptionPlan->modified); ?></td>
                            <td><?= @$SubscriptionPlan->user->first_name; ?></td>
                            <td class="center">

                                <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'homePages','action'=>'EditSubscriptionPlans',$id],array('title'=>'Edit','escape' => false)); ?> &nbsp;&nbsp;
                            </td>
                        </tr>
                     
                    <?php } }?>
                    </tbody>
                </table>
                 <?php echo $this->element('layout/backend/default/pagination'); ?>
            </div>
        </div>
    </div>
</div>

