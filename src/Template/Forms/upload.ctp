  <?php ?>
<!-- main content start here -->
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
    <div class="form-default clearfix">
        <h5><?= $this->Flash->render() ?></h5>
           <?php  echo $this->Form->create('Forms', array('url' => array('controller' => 'forms', 'action' => 'upload'),'id'=>'upload_user_forms',' method'=>'post','enctype'=>'multipart/form-data')); ?> 
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Project</label>
                          <?php 
                            echo $this->Form->input('porject_id', array(
                               'type' => 'select',
                               'options' => @$projectslist,
                                 'empty'=>'-- Select Project --',
                                'label' => false,
                                'class'=> 'form-control select2',
                                ));
                             ?>
            </div>
            <div class="col-sm-16 col-xs-6">
                <label>Category<span class="text-danger">*</span></label>
                           <?php 
                                    echo $this->Form->input('category_id', array(
                                       'type' => 'select',
                                       'options' => @$categotylist,
                                         'empty'=>'-- Select Category --',
                                        'label' => false,
                                        'class'=> 'form-control select2 category formlist',
                                        ));
                                     ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Sub Category</label>
                          <?php 
                                    echo $this->Form->input('sub_category_id', array(
                                       'type' => 'select',
                                        'label' => false,
                                         'empty'=>'-- Select Sub Category --',
                                        'class'=> 'form-control select2',
                                         'id'=>'ProductCategoryId',
                                        ));
                                     ?>
            </div>
            <div class="col-sm-16 col-xs-6">
                <label>Forms<span class="text-danger">*</span></label>
                           <?php 
                                    echo $this->Form->input('form_id', array(
                                        'type' => 'select',
                                        'label' => false,
                                         'empty'=>'-- Select Form --',
                                        'class'=> 'form-control select2',
                                         'id'=>'formList',
                                        ));
                                     ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Location</label>
                         <?php 
                                    echo $this->Form->input('location_id', array(
                                       'type' => 'select',
                                       'options' => $locationlist,
                                         'empty'=>'-- Select Location --',
                                        'label' => false,
                                        'class'=> 'form-control select2',
                                        ));
                                     ?>
            </div>
            <div class="col-sm-16 col-xs-6">
                <label>Status</label>
                        <?php 
                            echo $this->Form->input('is_private', array(
                               'type' => 'select',
                               'options' => array('Public'=>'Public','Private'=>'Private'),
                                 'empty'=>'-- Select Location --',
                                'label' => false,
                                'class'=> 'form-control select2',
                                ));
                        ?>

            </div>

        </div>
        <div class="row">
            <div class="col-sm-6 col-xs-6">
                <label>Upload Forms <span class="text-danger">*</span></label>

                               <?php echo $this->Form->input('file', array(
                                                    'type'=>'file',
                                                    'label' => false,
                                                    'class'=>''
                                                 ));  
                                              ?>
            </div>
            <div class="col-sm-16 col-xs-6">
                <label>Description</label>
                           <?php echo $this->Form->textarea('description', array(
                                                  'placeholder'=>'Description',
                                                  'class'=>'form-control',
                                                  'label' => 'false',
                                                    'rows'=>"5",
                                                    
                                                   
                                                 ));  
                                              ?>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12 clearfix">
 <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-primary')); ?>
        </div>
    </div>
              <?php echo $this->Form->end();?>
</div>
</div>

<?= $this->Html->script(['forms']);?>
