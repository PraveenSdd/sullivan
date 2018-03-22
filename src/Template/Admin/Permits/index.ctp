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
                                 <?php  echo $this->Form->create('Permit', array('url' => array('controller' => 'permits', 'action' => 'index'),'id'=>'srchFromAgency','type'=>'get')); ?>
                                <div class='col-xs-3 col-md-3'>
                                <?php echo $this->Form->input('name', array(
                                    'placeholder'=>'Name',
                                    'class'=>'form-control btm-search',
                                    'label' => false,
                                   ));  
                                ?>

                                </div>								

                              <div class='col-xs-12 col-md-3'>
                                   <?php echo $this->Form->button('Search', array('type'=>'submit','class'=>'btm-search btn bg-olive')); ?>
                                <?php echo $this->Html->link('Cancel',['controller'=>'permits','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
                            </div>	
                            <?php echo $this->Form->end();?>
                        </div>
                    </div>	
                </div>

                <div style="clear:both;"></div>
            </div>
           
                <div class="col-xs-12">
                    <span class="pull-right">
                        
                        <?php echo $this->Html->link('Add Permit',['controller'=>'permits','action'=>'add'],array('class'=>'btn btn-primary','escape' => false)); ?> 
                    </span>
                </div>
            
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

                    <?php  if($permits->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else { foreach($permits as $permit){ 
                           
                             $permitId = $this->Encryption->encode($permit->id);
                             ?>
                        <tr>
                            <td>
                                <?php echo $this->Html->link(htmlentities($permit->name),['controller'=>'permits','action'=>'view',$permitId],array('title'=>'View','escape' => false)); ?> 

                            </td>


                            <td><?= $this->Custom->DateTime($permit->modified); ?></td>
                            <td><?= @$permit->user->first_name; ?></td>

                            <td class="center">

        <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'permits','action'=>'edit',$permitId],array('title'=>'Edit','escape' => false)); ?> 
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

