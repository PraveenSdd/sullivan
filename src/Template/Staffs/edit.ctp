<?php ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
    <div class="form-default clearfix">
        <h5><?= $this->Flash->render() ?></h5>
            <div class="col-md-12">
                <div class="text-right">
                <?php 
                if($LoggedPermissionId==4){
                echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($this->request->data['id'])],['data'=>['model_name'=>'Users','module_name'=>'Staff Front','table_name'=>'users','title'=>htmlentities($this->request->data['first_name']),'redirect_url'=>'/staffs/index','foreignId'=>'','subModel'=>''], 'escape'=>false, 'class'=>'deleteConfirm']);
                }
                ?> 

                </div>
            </div>
            
           <?php  echo $this->Form->create('Staffs', array('url' => array('controller' => 'staffs', 'action' => 'edit'),'id'=>'frmStaff',' method'=>'post')); ?>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>First Name<span class="text-danger">*</span></label>
                              <?php echo $this->Form->input(
                                    'first_name', array(
                                    'placeholder'=>'First Name',
                                    'class'=>'form-control',
                                    'label' => false,
                                   ));  
                                ?>
            </div>

            <div class="col-sm-6 col-xs-6">
                <label>Last Name</label>
                              <?php echo $this->Form->input(
                                    'last_name', array(
                                    'placeholder'=>'Last Name',
                                    'class'=>'form-control',
                                    'label' => false,
                                   ));  
                                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Email<span class="text-danger">*</span></label>
                             <?php echo $this->Form->input(
                                    'email', array(
                                    'placeholder'=>'Email',
                                    'class'=>'form-control',
                                    'label' => false,
                                   'data-id'=>$this->request->data['id'],
                                    'data-parentId'=>'',
                                   ));  
                                ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label>Phone<span class="text-danger">*</span></label>
                             <?php echo $this->Form->input(
                                    'phone', array(
                                    'placeholder'=>'Phone',
                                    'class'=>'form-control inp-phone',
                                    'label' => false,
                                   ));  
                                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label for="title" class=" control-label">Position <span class="text-danger">*</span></label>
                                 <?php echo $this->Form->input(
                                'position', array(
                                'placeholder'=>'Position',
                                'class'=>'form-control required',
                                'label' => false,
                                'maxlength'=>40,
                               ));  
                            ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label for="title" class=" control-label">Level<span class="text-danger">*</span> </label>
                                <?php 
                                    echo $this->Form->input('permission_id', array(
                                       'type' => 'select',
                                       'options' => $permissionsList,
                                        'empty'=>'Please select level',
                                        'label' => false,
                                        'class'=> 'form-control inp-add-state sel-add-state',
                                        
                                        'label' => false,

                                        ));
                                ?>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label for="title" class=" control-label">Address <span class="text-danger">*</span></label>
                                <?php echo $this->Form->textarea('Address.address1', array(
                                        'placeholder'=>'Address',
                                        'class'=>'form-control inp-agency-description',
                                        'label' => 'false',
                                        'rows'=>"2",
                                         'maxlength'=>80, 
                                         'label' => false,
                                           'value'=>$this->request->data['address']['address1'],
                                       ));  
                                    ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label for="title" class=" control-label">Address2 </label>
                                <?php echo $this->Form->textarea('Address.address2', array(
                                        'placeholder'=>'Address',
                                        'class'=>'form-control inp-agency-description',
                                        'label' => 'false',
                                        'rows'=>"2",
                                         'maxlength'=>80, 
                                         'label' => false,
                                           'value'=>$this->request->data['address']['address2'],
                                       ));  
                                    ?>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label for="" class=" control-label">City <span class="text-danger">*</span></label>
                                <?php echo $this->Form->input('Address.city', array(
                                        'placeholder'=>'City',
                                        'class'=>'form-control ',
                                        'label' => 'false',
                                         'maxlength'=>40,
                                         'label' => false,
                                           'value'=>$this->request->data['address']['city'],
                                       ));  
                                    ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label for="" class=" control-label">State </label>
                                <?php 
                                    echo $this->Form->input('Address.state_id', array(
                                       'type' => 'select',
                                       'options' => $statesList,
                                        'empty'=>'Please select state',
                                        'label' => false,
                                        'class'=> 'form-control inp-add-state sel-add-state',
                                        'data-add-count'=>'1',
                                        'label' => false,
                                          'default'=>$this->request->data['address']['state_id'],
                                        ));
                                ?>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label for="" class=" control-label">Zip Code <span class="text-danger">*</span></label>
                                <?php echo $this->Form->input('Address.zipcode', array(
                                        'placeholder'=>'Zip Code',
                                        'class'=>'form-control ',
                                        'label' => 'false',
                                         'maxlength'=>10, 
                                         'label' => false,
                                           'value'=>$this->request->data['address']['zipcode'],
                                       ));  
                                    ?>
            </div>


        </div>
        <div class="row">

 <?php echo $this->Form->hidden('Address.id', array('value'=>$this->request->data['address']['id'], ));  ?>
<?php echo $this->Form->hidden('id', array());  ?>

            <div class="col-sm-12 col-xs-12 clearfix">
                  <?php echo $this->Html->link('Cancel',['controller'=>'staffs','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-default subStaff')); ?>
            </div>
        </div>
              <?php echo $this->Form->end();?>
    </div>
</div>

<?= $this->Html->script(['user']);?>



