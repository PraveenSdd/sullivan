<?php ?>

<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
             <?= $this->Flash->render() ?>
    <div class="main-action-btn pull-right clearfix">
        <a href="javascript:void(0);" class="action-txt">Search Here</a>
             <?php echo $this->Html->link('Add',['controller'=>'alerts','action'=>'add'],array('class'=>'btn btn-default','escape' => false)); ?>
    </div>
    <div class="clearfix"></div>
    <div class="table-responsive clearfix">

        <table class="table-striped">
            <thead>
                <tr>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Alert Type'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Title'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('date', 'Date'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('time', 'Time'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('time', 'Permit'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                    <th scope="col">Action</th>       
                </tr>
            </thead>
            <tbody>
               <?php  if($alerts->count() <= 0 ){  ?>
                <tr>
                    <td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else {
                        foreach($alerts as $alert){ 
                             $id = $this->Encryption->encode($alert->id); ?>
                <tr>
                    <td>
                            <?php echo $alert->alert_type->name;?>
                    </td>
                    <td>
                             <?= $alert->title; ?> 
                    </td>
                    <td>
                            <?php echo $this->Custom->DateTime(@$alert->date);?>

                    </td>
                    <td>
                            <?php echo $alert->time;?>

                    </td>
                    <td>
                            <?php echo @$alert->alert_permit->permit->title;?>

                    </td>
                    <td>
                            <?=$this->Custom->dateTime($alert->modified); ?></td>


                    <td class="center">

                                <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'alerts','action'=>'edit',$id],array('title'=>'Edit','escape' => false)); ?> &nbsp;&nbsp;

                                 <?php echo $this->Html->link($this->Html->image("icons/view.png"),['controller'=>'alerts','action'=>'view',$id],array('title'=>'View','escape' => false)); ?> &nbsp;&nbsp; 
</td>
                </tr>    
                    <?php } }?>
            </tbody>
        </table>

    </div>


