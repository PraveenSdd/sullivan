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
                                <?php  echo $this->Form->create('Operations', array('url' => array('controller' => 'operations', 'action' => 'index'),'id'=>'CategoryIndexForm',' method'=>'get')); ?>
                            
                            <form action="/admin/operations" novalidate="novalidate" id="CategoryIndexForm" method="get" accept-charset="utf-8">
                                <div class='col-xs-3 col-md-3'>
                                    <?php echo $this->Form->input('name', array(
                                                  'placeholder'=>'Operation Type',
                                                  'class'=>'form-control btm-search',
                                                  'label' => false,
                                                    'maxlength'=>120,
                                                 ));  
                                              ?>
                                </div>								
                                <div class='col-xs-12 col-md-3'>
                                    <?php echo $this->Form->button('Search', array('type'=>'submit','class'=>'btm-search btn bg-olive')); ?>
                                    <?php echo $this->Html->link('Cancel',['controller'=>'operations','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
                                 
                                </div>	

                           <?php echo $this->Form->end();?>
                        </div>
                    </div>	

                </div>

                <div style="clear:both;"></div>
            </div>
            <div class=" padding_btm_20">
                <div class="col-xs-12 margin-top-20">
                    <span class="pull-right">
                             <?php echo $this->Html->link('Add Operation',['controller'=>'operations','action'=>'add'],array('class'=>'btn btn-primary','escape' => false));?>
                    </span>
                </div>
            </div>

            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col"><?php echo $this->Paginator->sort('name', 'Operation Type'); ?></th>
                            <th scope="col">#of Permits</th>
                            <th scope="col">#of Alert</th>
                            <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modificaton'); ?></th>
                            <th scope="col">Modified By</th>       
                            <th scope="col">Action</th>       
                        </tr>
                    </thead>
                    <tbody>
                 <?php  if($operations->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                 <?php } else { 
                     foreach($operations as $operation){
                        $id = $this->Encryption->encode($operation->id);
                     ?>
                        <tr scope="row">
                            <td >   <?php echo $this->Html->link(htmlentities($operation->name),['controller'=>'operations','action'=>'view',$id],array('title'=>'View','escape' => false)); ?></td>
                            <td>
                                <?php if($permits = $this->Custom->getPermitListReletedOperation($operation->id)){
                                       
                                    echo $permits;
                                 }else{ echo '0';} ?>
                            </td>
                            <td>
                                <?php if($alerts = $this->Custom->getAlertListReletedOperation($operation->id)){
                                    echo $alerts;
                                    }else{ echo '0';} ?>
                            </td>


                            <td><?php echo $this->Custom->DateTime($operation->modified);?></td>
                            <td><?= @$operation->user->first_name; ?></td>

                            <td class="center">

                                <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'operations','action'=>'edit',$id],array('title'=>'Edit','escape' => false));?> &nbsp;&nbsp;

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
