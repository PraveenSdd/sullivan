<?php ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
    <div class="form-default clearfix">
        <h5><?= $this->Flash->render() ?></h5>
          <?php  echo $this->Form->create('Location', array('url' => array('controller' => 'locations', 'action' => 'edit'),'id'=>'user_locations',' method'=>'post')); ?>
            <div class="col-md-12">
                        <div class="text-right">
                             <?php echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>"/userLocations/index", 'data-title'=>'Location','data-modelname'=>'UserLocations','data-id'=> $location['id'],'class'=>"myalert-delete")); ?> 

                        </div>
             </div>
            <div class="row">
                <div class="col-sm-6 col-xs-6">
                  <label>Operation<span class="text-danger">*</span></label>

                            <?php foreach($location['location_industries'] as $industry){
                                $industries [] = $industry['industry_id']; 
                            }
                                    echo $this->Form->input('industry_id', array(
                                    'type' => 'select',
                                    'options' => $industryList,
                                    'label' => false,
                                    'multiple' => true,
                                    'class'=> 'form-control select2 category formlist custm-multidrop',
                                    'id'=>'mult-drop1',
                                      'default'=>@$industries,  
                                    ));
                                 ?>

                            <label id="mult-drop1-error" class="authError" for="mult-drop1" style="display:none"></label>

                </div>  
                <div class="col-sm-6 col-xs-6">
                    <label>Address Label<span class="text-danger">*</span></label>
                            <?php echo $this->Form->input('title', array(
                                         'placeholder'=>'Address label',
                                         'class'=>'form-control',
                                         'label' => false,
                                         'data-id'=>'',
                                         'data-parentId'=>'',
                                         'value'=>$location['title'],
                                        ));  
                                     ?>
                </div>


            </div>
             <div class="row">

                <div class="col-sm-6 col-xs-6">
                    <label>Email<span class="text-danger">*</span></label>
                             <?php echo $this->Form->input('email', array(
                                          'placeholder'=>'Email',
                                          'class'=>'form-control',
                                          'label' => false,
                                            'rows'=>"5",
                                    'value'=>@$location['email'],
                                         ));  
                                      ?>
                </div>
                  <div class="col-sm-6 col-xs-6">
                    <label>Phone</label>
                                <?php echo $this->Form->input('phone', array(
                                          'placeholder'=>'Phone',
                                          'class'=>'form-control inp-phone',
                                          'label' => false,
                                    'value'=>@$location['phone'],
                                         ));  
                                      ?>
                </div>  
             </div>
             <div class="row">
            
            <div class="col-sm-6 col-xs-6">
                <label>Address 1<span class="text-danger">*</span></label>
                         <?php echo $this->Form->textarea('address1', array(
                                      'placeholder'=>'Address 1',
                                      'class'=>'form-control',
                                      'label' => false,
                                        'rows'=>"5",
                             'value'=>$location['address1'],
                                     ));  
                                  ?>
            </div>
              <div class="col-sm-6 col-xs-6">
                <label>Address 2</label>
                            <?php echo $this->Form->textarea('address2', array(
                                      'placeholder'=>'Address 2',
                                      'class'=>'form-control',
                                      'label' => false,
                                        'rows'=>"5",
                                'value'=>$location['address2'],
                                     ));  
                                  ?>
            </div>  
         </div>
           <?php echo $this->Form->hidden('user_location_id', array(
                                'value'=>$location['id'],
                                     ));  
                                  ?>

            <div class="col-sm-12 col-xs-12 clearfix">
                <?php echo $this->Html->link('Cancel',['controller'=>'locations','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-primary')); ?>
            </div>
         <?php echo $this->Form->end();?>
        </div>
    </div>
<?= $this->Html->script(['location']);?>

