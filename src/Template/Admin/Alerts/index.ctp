<?php ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <h5><?= $this->Flash->render() ?></h5>
            <div class="box-header">
                <div class="UserAdminIndexForm">
                    <div class="box-body">	
                        <div class="row">
                            <?php  echo $this->Form->create('Alerts', array('url' => array('controller' => 'alerts', 'action' => 'index'),'id'=>'CategoryIndexForm',' method'=>'get')); ?>
                            <div class='col-xs-3 col-md-2'>
                                     <?php echo $this->Form->input('title', array(
                                                  'placeholder'=>'Title',
                                                  'class'=>'form-control btm-search',
                                                  'label' => false,
                                                 ));  
                                              ?>
                            </div>								

                            <div class='col-xs-12 col-md-3'>
 <?php echo $this->Form->button('Search', array('type'=>'submit','class'=>'btm-search btn bg-olive')); ?>
                                                    <?php echo $this->Html->link('Cancel',['controller'=>'homePages','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;

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
                                <?php echo $this->Html->link('Add',['controller'=>'alerts','action'=>'add'],array('class'=>'btn btn-primary','escape' => false)); ?>
                    </span>
                </div>
            </div>

            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col"><?php echo $this->Paginator->sort('title', 'Title'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                            <th scope="col">Action</th>       
                        </tr>
                    </thead>
                    <tbody>
                 <?php  if($alerts->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                 <?php } else { 
                     foreach($alerts as $alert){
                        $id = $this->Encryption->encode($alert->id);
                     ?>
                        <tr scope="row">
                            <td>
                                 <?php echo $this->Html->link($alert->title,['controller'=>'alerts','action'=>'view',$id],array('title'=>'View','escape' => false)); ?> 
                            </td>
                            <td><?php echo $this->Custom->DateTime($alert->modified);?></td>
                            <td class="center">
                                <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'alerts','action'=>'edit',$id],array('title'=>'Edit','escape' => false)); ?> &nbsp;&nbsp;
                                 <?php echo $this->Html->link($this->Html->image("icons/view.png"),['controller'=>'alerts','action'=>'view',$id],array('title'=>'View','escape' => false)); ?> &nbsp;&nbsp;
                            </td>
                        </tr>
                <?php } } ?>
                    </tbody> 
                </table>
                  <?php echo $this->element('pagination'); ?>
            </div>
        </div>
    </div>
</div>
