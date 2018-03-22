<?php ?>
<style>
    .box-primary .box-header{
        position:inherit!important;
    }
</style>

<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
                <div class="col-md-12">
                    <div class="text-right">
                        <?php 
                        if($LoggedPermissionId !=3){
                        echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($agency->id)],['data'=>['model_name'=>'Agencies','module_name'=>'Agency','table_name'=>'agencies','title'=>$agency->name,'redirect_url'=>"/admin/agencies/index",'foreignId'=>'','subModel'=>''], 'escape'=>false, 'class'=>'deleteConfirm']);
                        }?>
                    </div>
                    <?php  echo $this->Form->create('Agencies', array('url' => array('controller' => 'Agencies', 'action' => 'edit',$agencyId),'id'=>'frmAgency',' method'=>'post','class'=>'form-horizontal')); ?>
                    <div class="box-body">                    
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="title" class=" control-label padding-top-20">Agency Name <span class="text-danger">*</span></label>
                         <?php echo $this->Form->input('Agency.name', array(
                                                  'placeholder'=>'Agency name',
                                                  'class'=>'form-control inp-agency-name padding-top-5',
                                                  'label' => false,
                                                  'data-id'=>$agency->id,
                                                  'data-parentId'=>'',
                                                  'maxlength'=>120,
                                                  'value'=>$agency->name,
                                                 ));  
                                              ?>

                            </div>
                            <div class="col-sm-6">
                                <label for="title" class=" control-label">Address 1<span class="text-danger">*</span></label>
                                <?php echo $this->Form->textarea('Address.address1', array(
                                        'placeholder'=>'Address',
                                        'class'=>'form-control inp-agency-description',
                                        'label' => 'false',
                                        'rows'=>"2",
                                         'maxlength'=>80, 
                                         'label' => false,
                                         'value'=>($agency['address']['address1'])? $agency['address']['address1'] :'',

                                       ));  
                                    ?>

                            </div>
                        </div>
                        <div class="row padding-top-5">

                            <div class="col-sm-6">
                                <label for="title" class=" control-label">Address 2 </label>
                                <?php echo $this->Form->textarea('Address.address2', array(
                                        'placeholder'=>'Address',
                                        'class'=>'form-control inp-agency-description',
                                        'label' => 'false',
                                        'rows'=>"2",
                                        'maxlength'=>80, 
                                        'label' => false,
                                        'value'=>($agency['address']['address2'])? $agency['address']['address2'] :'',

                                       ));  
                                    ?>

                            </div>
                            <div class="col-sm-6">
                                <label for="" class=" control-label">City <span class="text-danger">*</span></label>
                                <?php echo $this->Form->input('Address.city', array(
                                        'placeholder'=>'City',
                                        'class'=>'form-control ',
                                        'label' => 'false',
                                         'maxlength'=>40,
                                         'label' => false,
                                         'value'=>($agency['address']['city'])? $agency['address']['city'] :'',

                                       ));  
                                    ?>

                            </div>
                        </div>
                        <div class="row padding-top-5">

                            <div class="col-sm-6">
                                <label for="" class=" control-label">State </label>
                                <?php 
                                    echo $this->Form->input('Address.state_id', array(
                                       'type' => 'select',
                                       'options' => $statesList,
                                        'empty'=>'Please select state',
                                        'label' => false,
                                        'class'=> 'form-control inp-add-state sel-add-state',
                                        'data-add-count'=>'1',
                                         'default'=>($agency['address']['state_id'])? $agency['address']['state_id'] :154,
                                        'label' => false,

                                        ));
                                ?>

                            </div>
                            <div class="col-sm-6">
                                <label for="" class=" control-label">Zip Code <span class="text-danger">*</span></label>
                                <?php echo $this->Form->input('Address.zipcode', array(
                                        'placeholder'=>'Zip Code',
                                        'class'=>'form-control ',
                                        'label' => 'false',
                                         'maxlength'=>10, 
                                         'label' => false,
                                         'value'=>($agency['address']['zipcode'])? $agency['address']['zipcode'] :'',
                                       ));  
                                    ?>

                            </div>
                        </div>
                        <div class="row margin-top-15">
                            <div class="col-sm-6">
                                <label for="title" class=" control-label padding-top-20">Description <span class="text-danger">*</span></label>
                                <?php
                                echo $this->Form->textarea('Agency.description', array(
                                    'placeholder' => 'Description',
                                    'class' => 'form-control inp-agency-description',
                                    'label' => 'false',
                                    'rows' => "3",
                                    'maxlength' => 160,
                                    'label' => false,
                                    'value'=>$agency->description,
                                    ));
                                ?>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer button-form-sub text-right">
                                     <?php echo $this->Html->link('Cancel',['controller'=>'agencies','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-primary')); ?>

                    </div>
                    <?php echo $this->Form->end();?>
                </div>

             <?php echo $this->element('backend/agency/attributes_menus'); ?>
            </div>

        </div>
    </div>
</div>
<?php echo $this->Html->script(['backend/agency']);?>

