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
                                 <?php  echo $this->Form->create('Forms', array('url' => array('controller' => 'forms', 'action' => 'index'),'id'=>'CategoryIndexForm',' method'=>'get')); ?>
                                <div class='col-xs-3 col-md-2'>
                                <?php echo $this->Form->input('title', array(
                                    'placeholder'=>'Tile',
                                    'class'=>'form-control btm-search',
                                    'label' => false,
                                   ));  
                                ?>

                                </div>								

                              <div class='col-xs-12 col-md-3'>
                                <?php echo $this->Html->link('Cancel',['controller'=>'forms','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
                                 <?php echo $this->Form->button('Search', array('type'=>'submit','class'=>'btm-search btn bg-olive')); ?>
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
                        <?php echo $this->Html->link('Add Permit',['controller'=>'forms','action'=>'permit'],array('class'=>'btn btn-primary','escape' => false)); ?> &nbsp;&nbsp;
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

                    <?php  if($forms->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else { foreach($forms as $formdata){ 
                           
                             $id = $this->Encryption->encode($formdata->id);
                             ?>
                        <tr>
                            <td>
                                <?php echo $this->Html->link($formdata->title,['controller'=>'forms','action'=>'view',$id],array('title'=>'View','escape' => false)); ?> 

                            </td>


                            <td><?= date("d-m-Y", strtotime($formdata->modified)); ?></td>

                            <td class="center">

        <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'forms','action'=>'edit',$id],array('title'=>'Edit','escape' => false)); ?> 
                            </td>
                        </tr>    
                    <?php } }?>
                    </tbody>
                </table>
                 <?php echo $this->element('pagination'); ?>
            </div>
        </div>
    </div>
</div>

