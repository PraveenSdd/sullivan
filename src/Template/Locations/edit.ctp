<?php ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
        <?php echo $this->element('layout/frontend/default/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
    <div class="form-default clearfix">
        <h5><?= $this->Flash->render() ?></h5>
        
         <?php if($locationData['is_company'] ==1 && $LoggedPermissionId !=6){ ?>
        <div class="col-md-12">
            <div class="text-right">
                <?php echo $this->Form->postLink($this->Html->image('icons/delete.png'), ['controller' => 'customs', 'action' => 'delete', $this->Encryption->encode($locationData['id'])],['data'=>['model_name'=>'UserLocations','module_name'=>'Location Front','table_name'=>'user_locations','title'=>'Location','redirect_url'=>'/locations/index','foreignId'=>'','subModel'=>''], 'escape'=>false, 'class'=>'deleteConfirm']);
                ?> 

            </div>
        </div>
         <?php } ?>
        <?php echo $this->Form->create('Location', array('url' => array('controller' => 'locations', 'action' => 'edit',$locationId), 'id' => 'user_locations', ' method' => 'post')); ?>
        <div class="row">                 
            <div class="col-sm-6 col-xs-6">
                <label>Address Label<span class="text-danger">*</span></label>
                <?php
                echo $this->Form->input('title', array(
                    'placeholder' => 'Address label',
                    'class' => 'form-control',
                    'label' => false,
                    'data-id' => '',
                    'data-parentId' => '',
                ));
                ?>
            </div>
        </div>
        <div class="row">

            <div class="col-sm-6 col-xs-6">
                <label>Address 1<span class="text-danger">*</span></label>
                <?php
                echo $this->Form->textarea('address1', array(
                    'placeholder' => 'Address 1',
                    'class' => 'form-control',
                    'label' => false,
                    'rows' => "5",
                ));
                ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label>Address 2</label>
                <?php
                echo $this->Form->textarea('address2', array(
                    'placeholder' => 'Address 2',
                    'class' => 'form-control',
                    'label' => false,
                    'rows' => "5",
                ));
                ?>
            </div>  
        </div>
        <div class="row">

            <div class="col-sm-6 col-xs-6">
                <label>Email<span class="text-danger">*</span></label>
                <?php
                echo $this->Form->input('email', array(
                    'placeholder' => 'Email',
                    'class' => 'form-control',
                    'label' => false,
                    'rows' => "5",
                ));
                ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label>Phone</label>
                <?php
                echo $this->Form->input('phone', array(
                    'placeholder' => 'Phone',
                    'class' => 'form-control inp-phone',
                    'label' => false,
                ));
                ?>
            </div>  
        </div>        
        <div class="row">
            <?php if($locationData['is_company'] == 1) : ?>
            <div class="col-sm-6 col-xs-6 work-operation-chkbx">
                <label>Would You Like To Use Company Address As Work-Operation?</label>
                <div class="checkbox-wrap1">
                <?php
                $checked = '';
                if($locationData['is_operation'] == 1){
                    $checked = "checked='checked'";
                }
                echo $this->Form->input('is_operation', array(
                    'type' => 'checkbox',                    
                    'label' => false,                    
                    'class' => 'form-control-chk checkbox chk-company-operation',
                    'hiddenField'=>false,
                    //'id'=> 'is-operation-chk',
                    'div'=>false,
                    $checked
                ));
                ?>
                    <!--                <label for="is-operation-chk"></label>    -->
                </div>

            </div>


            <?php endif; ?>
            <div class="col-sm-6 col-xs-6 col-sel-company-operation custm-multidrop">
                <label>Operation<span class="text-danger">*</span></label>
                <?php
                echo $this->Form->input('operation_id', array(
                    'type' => 'select',
                    'options' => $operationList,
                    'label' => false,
                    'multiple' => true,
                    'class' => 'form-control category formlist sel-location-operation',
                    'id' => 'mult-drop1',
                    'default' => $locationOperationIds,
                ));
                ?>
                <label id="mult-drop1-error" class="authError" for="mult-drop1" style="display:none"></label>
            </div>  
        </div>

        <div class="col-sm-12 col-xs-12 clearfix">
            <?php echo $this->Html->link('Cancel', ['controller' => 'locations', 'action' => 'index'], array('class' => 'btn btn-warning', 'escape' => false)); ?> &nbsp;&nbsp;
            <?php echo $this->Form->button('Update', array('type' => 'submit', 'class' => 'btn btn-primary')); ?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>
<?= $this->Html->script(['location']); ?>
