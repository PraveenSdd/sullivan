<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <br>
<!-- general form elements -->

            <?php  echo $this->Form->create('HomePages', array('url' => array('controller' => 'homePages', 'action' => 'EditSubscriptionPlans'),'id'=>'edit_subcription',' method'=>'post','class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
                <div class="col-md-8">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Name<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                  <?php echo $this->Form->input('name', array(
                                                  'placeholder'=>'Name',
                                                  'class'=>'form-control ',
                                                  'label' => false,
                                                  'value'=>$SubscriptionPlan['name'],
                                                  'data-id'=>$SubscriptionPlan['id'],
                                                  'data-parentId'=>'',
                                                 ));  
                                              ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Description<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                  <?php echo $this->Form->textarea('description', array(
                                                  'placeholder'=>'Description',
                                                  'class'=>'form-control ',
                                                  'label' => 'false',
                                                    'rows'=>"5",
                                                    'value'=>$SubscriptionPlan['description'],    
                                                 ));  
                                              ?>
                            </div>
                        </div>

                    </div>
                     <?php echo $this->Form->hidden('id', array('value'=>$SubscriptionPlan['id']));  ?>
                    
        <div class="box-body">
              <div class="header"><h4><u>Attributes</u></h4></div>
     <?php if(empty($SubscriptionPlan['attributes'])) ?>
      <div class="input_fields_container">  </div>
                        <?php foreach($SubscriptionPlan['attributes'] as $attributes){ ?>
                        <div class="input_fields_container">
                          <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label"></label>
                            <div class="col-sm-8">
                                <?php echo $this->Form->input('attribute.', array(
                                    'placeholder'=>'Attribute',
                                    'class'=>'form-control required',
                                    'label' => false,
                                    'data-id'=>'',
                                    'data-parentId'=>@$attributes['subscription_plan_id'],
                                    'value'=>@$attributes['attribute']
                                   ));  
                                ?>
                            </div>
                             <div class="col-sm-1">
                                 <?php echo $this->Html->link('<i class="fa fa-minus"></i>','javascript:void(0);',array('escape' => false, 'data-id'=>$attributes['id'], 'class'=>"label label-danger remove_field remove_id" )); ?> 

                             </div>
                        </div>
                     
                        </div>
                           <?php echo $this->Form->hidden('remove_attribute_id', array('value'=>$attributes['id']));  ?>

                        <?php } ?>
                            <?php echo $this->Form->hidden('remove_attribute_id', array('id'=>'remove_attribute_id'));  ?>

                   </div>
                   
                        <div class="row">
                                <label for="" class="control-label">Add Attribute</label>
                                <a  id="addScnt" class="label label-success add_more_button"><i class="fa fa-plus"></i></a>
                            </div>
                    
                    <div class="box-footer button-form-sub">
                         <?php echo $this->Html->link('Cancel',['controller'=>'homePages','action'=>'SubscriptionPlans'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
                         <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-primary')); ?>
                    </div>
                </div>


             <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script(['home']);?>



