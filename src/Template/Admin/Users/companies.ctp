<?php ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <h5><?= $this->Flash->render() ?></h5>
            <div class="box-header">
                <div class="UserAdminIndexForm">
                    <div class="box-body">	
                        <div class="row">
                             <?php  echo $this->Form->create('Users', array('url' => array('controller' => 'users', 'action' => 'companies'),'id'=>'CategoryIndexForm',' method'=>'get')); ?>
                            <div class='col-xs-3 col-md-2'>
                                        <?php echo $this->Form->input('name', array(
                                                  'placeholder'=>'Name',
                                                  'class'=>'form-control btm-search',
                                                  'label' => false,
                                                 ));  
                                              ?>                                </div>								
                            <div class='col-xs-12 col-md-3'>
                                <?php echo $this->Html->link('Cancel',['controller'=>'users','action'=>'companies'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
                                 <?php echo $this->Form->button('Search', array('type'=>'submit','class'=>'btm-search btn bg-olive')); ?>
                            </div>	
                            <?php echo $this->Form->end();?>
                        </div>
                    </div>	
                </div>

                <div style="clear:both;"></div>
            </div>
            <div class=" padding_btm_20" style="padding-top:10px">
                <div class="col-xs-12 margin-top-20"><span class="pull-right"><a href="/admin/users/addCompany" class="btn btn-primary">Add</a></span></div>
            </div>

            <div class="box-body table-responsive">
                <table class="table table-striped">

                    <thead>
                        <tr>
                            <th scope="col"><?php echo $this->Paginator->sort('company', 'Company'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('email', 'Email'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('phone', 'Phone'); ?></th>
                            <th scope="col"><?php echo $this->Paginator->sort('created', 'Created'); ?></th>
                            <th scope="col">Action</th>       
                        </tr>
                    </thead>
                    <tbody>

                    <?php  if($companies->count() <= 0 ){  ?>
                        <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else { foreach($companies as $company){ 
                           
                             $id = $this->Encryption->encode($company->id);
                             ?>
                        <tr>
                            <td>
                             <?= $company->company; ?> 
                            </td>
                            <td>
                             <?= @$company->email; ?> 
                            </td>
                            <td>
                             <?= @$company->phone; ?> 
                            </td>

                            <td><?= date("d-m-Y", strtotime($company->created)); ?></td>
                            <td class="center">
                               <?php echo $this->Html->link($this->Html->image("icons/edit.png"),['controller'=>'users','action'=>'editCompany',$id],array('title'=>'Edit','escape' => false)); ?> &nbsp;&nbsp;
                                 <?php echo $this->Html->link($this->Html->image("icons/view.png"),['controller'=>'users','action'=>'viewCompany',$id],array('title'=>'View','escape' => false)); ?> &nbsp;&nbsp; 
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

