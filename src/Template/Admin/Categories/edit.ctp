<?php ?>
<style>
    .box-primary .with-border .box-header{
        position:inherit!important;
    }
</style>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
           <?php  echo $this->Form->create('Categories', array('url' => array('controller' => 'Categories', 'action' => 'edit'),'id'=>'categoryId',' method'=>'post','class'=>'form-horizontal')); ?>
                
                <div class="col-md-12">
                    <div class="text-right">
                        <?php echo $this->Html->link($this->Html->image("icons/delete.png"),'javascript:void(0);',array('data-url'=>'/admin/categories/index','escape' => false,'data-id'=>$category->id, 'data-modelname'=>'categories','data-title'=>$category->name, 'class'=>"myalert-delete  addicons ")); ?> 

                   </div>
               <div class="box-body">                    
                        <div class="row">
                        <div class="col-sm-6">
                            <label for="title" class=" control-label padding-top-20">Agency Name <span class="text-danger">*</span></label>
                         <?php echo $this->Form->input('name', array(
                                                  'placeholder'=>'Agency name',
                                                  'class'=>'form-control inp-agency-name padding-top-5',
                                                  'label' => false,
                                                  'data-id'=>$category->id,
                                                  'data-parentId'=>'',
                                                  'maxlength'=>120,
                                                  'value'=>$category->name,
                                                 ));  
                                              ?>
                            
                        </div>
                        </div>
                        <div class="row padding-top-5">
                            <div class="col-sm-6">
                                <label for="title" class=" control-label">Address <span class="text-danger">*</span></label>
                                <?php echo $this->Form->textarea('address1', array(
                                        'placeholder'=>'Address',
                                        'class'=>'form-control inp-agency-description',
                                        'label' => 'false',
                                        'rows'=>"2",
                                         'maxlength'=>80, 
                                         'label' => false,
                                         'value'=>($category['address']['address1'])? $category['address']['address1'] :'',

                                       ));  
                                    ?>
                            
                            </div>
                            <div class="col-sm-6">
                                <label for="title" class=" control-label">Address2 </label>
                                <?php echo $this->Form->textarea('address2', array(
                                        'placeholder'=>'Address',
                                        'class'=>'form-control inp-agency-description',
                                        'label' => 'false',
                                        'rows'=>"2",
                                        'maxlength'=>80, 
                                        'label' => false,
                                        'value'=>($category['address']['address2'])? $category['address']['address1'] :'',

                                       ));  
                                    ?>
                            
                            </div>
                        </div>
                        <div class="row padding-top-5">
                            <div class="col-sm-6">
                                <label for="" class=" control-label">City <span class="text-danger">*</span></label>
                                <?php echo $this->Form->input('city', array(
                                        'placeholder'=>'City',
                                        'class'=>'form-control ',
                                        'label' => 'false',
                                         'maxlength'=>40,
                                         'label' => false,
                                         'value'=>($category['address']['city'])? $category['address']['city'] :'',

                                       ));  
                                    ?>
                            
                            </div>
                            <div class="col-sm-6">
                                <label for="" class=" control-label">State </label>
                                <?php 
                                    echo $this->Form->input('state_id', array(
                                       'type' => 'select',
                                       'options' => $statesList,
                                        'empty'=>'Please select state',
                                        'label' => false,
                                        'class'=> 'form-control inp-add-state sel-add-state',
                                        'data-add-count'=>'1',
                                         'default'=>($category['address']['state_id'])? $category['address']['state_id'] :154,
                                        'label' => false,

                                        ));
                                ?>
                            
                            </div>
                        </div>
                        <div class="row padding-top-5">
                            <div class="col-sm-6">
                                <label for="" class=" control-label">Zip Code <span class="text-danger">*</span></label>
                                <?php echo $this->Form->input('zipcode', array(
                                        'placeholder'=>'Zip Code',
                                        'class'=>'form-control ',
                                        'label' => 'false',
                                         'maxlength'=>10, 
                                         'label' => false,
                                         'value'=>($category['address']['zipcode'])? $category['address']['zipcode'] :'',
                                       ));  
                                    ?>
                            
                            </div>
                            <div class="col-sm-6">
                                <div class="phone-block" >
                                     <label>Phone number </label>
                                     <?php echo $this->Form->input('phone', array(
                                                'placeholder'=>'Phone number ',
                                                'class'=>'form-control inp-phone inp-address_phone' ,
                                                'label' => false,
                                                'div'=>false,
                                                'legend' => false,
                                                'value'=>($category['address']['phone'])? $category['address']['phone'] :'',
                                                 ));  
                                    ?>
                                    </div>
                                    <div class="phone-extension-block">
                                         <label> Extension </label>
                                    <?php echo $this->Form->input('phone_extension', array(
                                                'class'=>'form-control phone-extension-address inp-add_address-country_code',
                                                'id'=>'phone_extension',
                                                 'placeholder'=>'Extension ',
                                                 'maxlength'=>4,
                                        'label' => false,
                                                'div'=>false,
                                                'legend' => false,
                                                'value'=>($category['address']['phone_extension'])? $category['address']['phone_extension'] :'',
                                                 ));  
                                              ?>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        
                    </div>
          
                
                <div class="box-header with-border ">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12 bg-primary clearfix text-center">
                            <h5 class="permitTitle">Contact Person & Permits</h5>
                            <p class="description"></p>
                        </div>
                    </div>
                    <div class="box-body view-permit-outer text-center">                    
<!-- Agency related conatct person Block - START -->
                        <div class="row ">
                            <div class="form-group">
                                <div class="col-sm-9">
                                    <a  class="collapsed control-label" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1" >Contact Person</a>
                                    <div id="collapse-1" class="collapse padding-top-20" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body permit-agency-block">
                                           <?php echo $this->element('backend/agency/contact_list'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <a href="javascript:void(0);" data-categoryId="<?=$category->id;?>"  data-title="<?php echo 'Contact';?>" class="addConatctPerson  addicons ">Add Contact</a>
                                </div>
                            </div>
                        </div>
            
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 bg-primary clearfix text-center">
                           
                        </div>
                    </div>
                    <div class="box-body view-permit-outer text-center">                    
<!-- Agency related permit Block - START -->
                        <div class="row ">
                            <div style=" text-align: left;"> <h4>Permit Details </h4></div>
                              <?php echo $this->element('backend/agency/permit_list'); ?>
                        </div>
            
                    </div>
                
                </div>
            </div>
                    <?php  if(!empty($category->id)){ echo $this->Form->hidden('id', array('value'=>$category->id));} ?>
                    <?php  if(!empty($category['address']['id'])){ echo $this->Form->hidden('address_id', array('value'=>$category['address']['id']));} ?>
                 <div class="box-footer button-form-sub">
                        <a href="/admin/categories" class="btn btn-warning">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-agency-submit">Update</button>

                    </div>

             <?php echo $this->Form->end();?>
                      </div>
        </div>
    </div>
</div>
<!-- modal add conatct person form -->
<?php echo $this->element('backend/agency/contact_person'); ?>

</div>
    <?php echo $this->Html->script(['category']);?>
