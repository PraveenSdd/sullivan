<?php ?>

<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
    <div class="main-action-btn pull-right clearfix">
        <a href="javascript:void(0);" class="action-txt">Search Here</a>

    </div>
    <div class="clearfix"></div>
    <div class="advance-search-panel hide clearfix">
        <a href="javascript:void(0);" class="asp-control"><i class="fa fa-close"></i></a>
           <?php  echo $this->Form->create('Alerts', 'javascript:void(0);','id'=>'',' method'=>'get')); ?>
        <div class="row">
            <div class="col-sm-3 col-xs-6">
                <label>Title Here</label>
                     <?php 
                        echo $this->Form->input('name', array(
                            'label' => false,
                            'placeholder'=>'Name'
                            'class'=> 'form-control',

                            ));
                         ?>
            </div>
            <div class="col-sm-3 col-xs-6">
                <label>Title Here</label>
                     <?php 
                        echo $this->Form->input('name', array(
                            'label' => false,
                            'placeholder'=>'Name'
                            'class'=> 'form-control',

                            ));
                         ?>
            </div>
            <div class="col-sm-3 col-xs-6">
                <label>Title Here</label>
                     <?php 
                        echo $this->Form->input('select', array(
                           'type' => 'select',
                           'options' => '',
                            'empty'=>'Please select',
                            'label' => false,
                            'class'=> 'form-control select2',

                            ));
                         ?>
            </div>
            <div class="col-sm-3 col-xs-6">
                <label>Title Here</label>
                        <?php 
                        echo $this->Form->input('name', array(
                            'label' => false,
                            'placeholder'=>'Name'
                            'class'=> 'form-control',

                            ));
                         ?>     
            </div>
            <div class="col-sm-3 col-xs-6">
                <label>Title Here</label>
                <div class="input-group">
                    <div class="radio-wrap">
                            <?php 
                            echo $this->Form->radio('name', array(
                            'label' => false,
                            'placeholder'=>'Name'
                            'class'=> 'form-control',

                            ));
                         ?>      
                        <label for="agent-yes">Yes</label>
                    </div>
                    <div class="radio-wrap">
                            <?php 
                            echo $this->Form->radio('name', array(
                            'label' => false,
                            'class'=> 'form-control',
                                'id'=>'agent-no',

                            ));
                         ?>      
                        <label for="agent-no">No</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-xs-6">
                <label>Title Here</label>
                <div class="input-group">
                    <div class="checkbox-wrap">
                             <?php 
                            echo $this->Form->checkbox('name', array(
                            'label' => false,
                            'class'=> 'form-control',
                                'id'=>'agent-yes-chk',

                            ));
                         ?>  
                        <label for="agent-yes-chk">Yes</label>
                    </div>
                    <div class="checkbox-wrap">
                            <?php 
                            echo $this->Form->checkbox('name', array(
                            'label' => false,
                            'class'=> 'form-control',
                                'id'=>'agent-no-chk',

                            ));
                         ?>  
                        <label for="agent-no-chk">No</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xs-12 clearfix text-center">
                    <?php echo $this->Html->link('Cancel',['controller'=>'alerts','action'=>'index'],array('class'=>'btn btn-default','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Submit', array('type'=>'submit','class'=>'btn btn-default')); ?>
            </div>
        </div>
    <?php echo $this->Form->end();?>

    </div>
    <div class="table-responsive clearfix">
     <?= $this->Flash->render() ?>
        <table class="table-striped">
            <thead>
                <tr>
                    <th scope="col">
                        <?php echo $this->Paginator->sort('title', 'Name'); ?>
                    </th>
                    <th scope="col"> Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php  if($agencies->count() <= 0 ){  ?>
                <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else {  foreach($agencies as $agency){
                        $id = $this->Encryption->encode($agency->id);
                     ?>
                <tr>
                    <td>
                    <?php echo $this->Html->link($agency->name,['controller'=>'agencies','action'=>'details',$id],array('title'=>'Details','escape' => false)); ?>
                    </td>
                    <td>
                             <?php $operations = $this->Custom->getAgencyIndustryList($agency->id);
                             
                                    if($operations != 0){
                                       foreach($operations as $operation){
                                           $arrOperation[] = $operation['industry']['name'];
                                       }
                                        echo implode(' ,  ', $arrOperation);
                                    }
                             ?> 
                    </td>
                </tr>    
              <?php } }?>
            </tbody>
        </table>
    </div>