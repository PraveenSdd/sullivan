<?php ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <h5><?= $this->Flash->render() ?></h5>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                          
                            <th scope="col" width='33%'><?php echo $this->Paginator->sort('name', 'Label Name'); ?></th>
                            <th scope="col" width='33%'><?php echo $this->Paginator->sort('value', 'Label Value'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('modified', 'Modified Date'); ?></th>
                            <th scope="col">Modified By</th>       
                            <th scope="col">Action</th>       
                        </tr>
                    </thead>
                    <tbody>

                    <?php  if($pageLabelList->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else { foreach($pageLabelList as $pageLabel){ 
                        
                           
                             $id = $this->Encryption->encode($pageLabel->id);
                             ?>
                        <tr>
                           
                            <td>
                             <?php echo $this->Html->link($pageLabel->name,['controller'=>'pageLabels','action'=>'edit',$id],array('title'=>'Edit','escape' => false)); ?>
                             
                            </td>
                            <td>
                             <?php echo $pageLabel->value; ?> 
                            </td>

                            <td><?= $this->Custom->dateTime($pageLabel->modified); ?></td>
                            <td><?= @$pageLabel->user->first_name; ?></td>
                            <td class="center">
                                <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'pageLabels','action'=>'edit',$id],array('title'=>'Edit','escape' => false));?> &nbsp;&nbsp;
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

