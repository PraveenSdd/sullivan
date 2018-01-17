<?php ?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <h5><?= $this->Flash->render() ?></h5>
            <div class="box-header">
                <div class="UserAdminIndexForm">
                    <div class="box-body">	
                        <div class="row">

                                 <?php  echo $this->Form->create('HomePages', array('url' => array('controller' => 'HomePages', 'action' => 'index'),'id'=>'CategoryIndexForm',' method'=>'get')); ?>
                            <div class='col-xs-3 col-md-2'>
                                        <?php echo $this->Form->input('title', array(
                                                  'placeholder'=>'Title',
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
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col">Section</th>
                            <th scope="col"><?php echo $this->Paginator->sort('title', 'Title'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('modified', 'Last Modification'); ?></th>
                            <th scope="col">Action</th>       
                        </tr>
                    </thead>
                    <tbody>

                    <?php  if($homes->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else { foreach($homes as $homedata){ 
                        
                           
                             $id = $this->Encryption->encode($homedata->id);
                             ?>
                        <tr>
                            <td>
                             <?= 'Section '.$homedata->id; ?> 
                            </td>
                            <td>
                             <?= $homedata->title; ?> 
                            </td>

                            <td><?= $this->Custom->dateTime($homedata->modified); ?></td>



                            <td class="center">

                                <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'homePages','action'=>'edit',$id],array('title'=>'Edit','escape' => false)); ?> &nbsp;&nbsp;

                                 <?php echo $this->Html->link($this->Html->image("icons/view.png"),['controller'=>'homePages','action'=>'view',$id],array('title'=>'View','escape' => false)); ?> &nbsp;&nbsp; 

                            </td>
                        </tr>
                        <?php if($homedata->sub_home_page){
                            $countHomeSection = 1;
                            foreach($homedata->sub_home_page as $homeSection){
                                 $id = $this->Encryption->encode($homeSection->id);
                             ?>
                        <tr>
                            <td>
                             <?= 'Section '.$homedata->id.'.'.$countHomeSection; ?> 
                            </td>
                            <td>
                             <?= $homeSection->title; ?> 
                            </td>

                            <td><?= $this->Custom->dateTime($homeSection->created); ?></td>



                            <td class="center">

                                <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'homePages','action'=>'edit',$id],array('title'=>'Edit','escape' => false)); ?> &nbsp;&nbsp;

                                 <?php echo $this->Html->link($this->Html->image("icons/view.png"),['controller'=>'homePages','action'=>'view',$id],array('title'=>'View','escape' => false)); ?> &nbsp;&nbsp; 


                            </td>
                        </tr>
                          <?php  
                            $countHomeSection++;
                            }
                            
                        }?>

                    <?php } }?>
                    </tbody>
                </table>
                 <?php echo $this->element('pagination'); ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

