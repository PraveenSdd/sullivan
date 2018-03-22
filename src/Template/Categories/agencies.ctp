<?php ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
    <div class="main-action-btn pull-right clearfix">
            <?php echo $this->Html->link('Search Here','javascript:void(0);',array('class'=>'action-txt','escape' => false)); ?>
             <?php echo $this->Html->link('Add',['controller'=>'staffs','action'=>'add'],array('class'=>'btn btn-default','escape' => false)); ?>
    </div>
    <div class="clearfix"></div>

    <div class="table-responsive clearfix">
     <?= $this->Flash->render() ?>
        <table class="table-striped">
            <thead>
                <tr>
                    <th scope="col"><?php echo $this->Paginator->sort('first_name', 'Name'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('email', 'Email'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('phone', 'Phone'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('created', 'Created'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('is_active', 'Status'); ?></th>
                    <th scope="col">Action</th>    
                </tr>
            </thead>
            <tbody>
                <?php  if($staffs->count() <= 0 ){  ?>
                <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else {  foreach($agencies as $agency){
             
                        $id = $this->Encryption->encode($agency->id);
                     ?>
                <tr>
                    <td>
                             <?= $agency->title; ?> 
                    </td>

                    <td>
                             <?php $count = $this->Custom->getAgencyIndustryList($agency->id); echo count($count);?> 
                    </td>

                    <td><?= $this->Custom->dateTime($agency->created); ?></td>

                    <td class="center">
                        <?php echo $this->Html->link($this->Html->image("icons/view.png"),['/agency'.$id],array('class'=>'btn btn-default','escape' => false)); ?>

                </tr>    
              <?php } }?>
            </tbody>
        </table>
    </div>