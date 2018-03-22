<?php ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <h5><?= $this->Flash->render() ?></h5>
            <div class="box-header">
                <div class="UserAdminIndexForm">
                    <div class="box-body">	
                        <div class="row">

                                 <?php  echo $this->Form->create('HowItWorks', array('url' => array('controller' => 'HowItWorks', 'action' => 'index'),'id'=>'HowItWorkIndexForm',' method'=>'get')); ?>
                            <div class='col-xs-3 col-md-3'>
                                        <?php echo $this->Form->input('title', array(
                                                  'placeholder'=>'Title',
                                                  'class'=>'form-control btm-search',
                                                  'label' => false,
                                                 ));  
                                              ?> 
                            </div>								
                            <div class='col-xs-12 col-md-3'>
                                <?php echo $this->Html->link('Cancel',['controller'=>'HowItWorks','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
                                 <?php echo $this->Form->button('Search', array('type'=>'submit','class'=>'btm-search btn bg-olive')); ?>
                            </div>	
                            <?php echo $this->Form->end();?>
                        </div>
                    </div>	
                </div>
                <div style="clear:both;"></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                          
                            <th scope="col"><?php echo $this->Paginator->sort('title', 'Title'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('description', 'Description'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                            <th scope="col">Modified By</th>       
                            <th scope="col">Action</th>       
                        </tr>
                    </thead>
                    <tbody>

                    <?php  if($howItWorks->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else { foreach($howItWorks as $howItWork){ 
                        
                           
                             $id = $this->Encryption->encode($howItWork->id);
                             ?>
                        <tr>
                           
                            <td>
                             <?php echo $this->Html->link($howItWork->title,['controller'=>'HowItWorks','action'=>'view',$id],array('title'=>'View','escape' => false)); ?>
                             
                            </td>
                            <td>
                             <?= substr($howItWork->description,0,100); ?> 
                            </td>

                            <td><?= $this->Custom->dateTime($howItWork->modified); ?></td>
                            <td><?= @$howItWork->user->first_name; ?></td>
                            <td class="center">
                                <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'HowItWorks','action'=>'edit',$id],array('title'=>'Edit','escape' => false));?> &nbsp;&nbsp;
                            </td>
                        </tr>
                          <?php  }?>

                    <?php } ?>
                    </tbody>
                </table>
                 <?php echo $this->element('layout/backend/default/pagination'); ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

