<?php ?>

<!-- main content start here -->
<div class="main-content clearfix">
    <h2 class="pull-left"><?php echo $pageHedding; ?></h2>
    <div class="clearfix"></div>
    <div class="main-action-btn pull-right clearfix">
<!--        <a href="javascript:void(0);" class="action-txt">Search Here</a>-->
             <?php  echo $this->Html->link('Add',['controller'=>'locations','action'=>'add'],array('class'=>'btn btn-default','escape' => false)); ?>
    </div>
    <div class="clearfix"></div>
  
    <div class="table-responsive clearfix">
     <?= $this->Flash->render() ?>
        <table class="table-striped">
            <thead>
                <tr>
                    <th scope="col"><?php echo $this->Paginator->sort('title', 'Label'); ?></th>
                    <th scope="col">Operation</th>
                    <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                    <th scope="col">Modified By</th>       
                    <th scope="col">Action</th>       
                </tr>
            </thead>
            <tbody>
                <?php  if($locations->count() <= 0 ){  ?>
                <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else { foreach($locations as $location){
                       
                        $id = $this->Encryption->encode($location->id);
                     ?>
                <tr scope="row">
                    <td><?= $location->title; ?></td>
                    <td><?php $operations =  $this->Location->getOperationListByLocationId($location->id);
                            echo count($operations) .' ('.implode(', ', $operations).')';
                        ?>
                    </td>
                    <td><?= date("d-m-Y", strtotime($location->modified)); ?></td>
                    <td><?= @$location->user->first_name; ?></td>
                    <td class="center">
                                <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'locations','action'=>'edit',$id],array('title'=>'Edit','escape' => false)); ?> &nbsp;&nbsp;
                                 <?php echo $this->Html->link($this->Html->image("icons/view.png",array('width'=>'25px')),['controller'=>'locations','action'=>'view',$id],array('title'=>'View','escape' => false)); ?> &nbsp;&nbsp;
                    </td>
                </tr>
              <?php } 
              
                }?>
            </tbody>
        </table>
    </div>


