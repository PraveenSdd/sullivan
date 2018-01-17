<?php ?>
<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>

    <div class="clearfix"></div>
    <div class="form-default clearfix">
        <h5><?= $this->Flash->render() ?></h5>
           <?php  echo $this->Form->create('Staffs', array('url' => array('controller' => 'staffs', 'action' => 'edit'),'id'=>'add_user',' method'=>'post')); ?>
        <div class="col-md-12">
            <div class="text-right">
                <?php echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>"/staffs/index", 'data-title'=>$staff['first_name'],'data-modelname'=>'Users','data-id'=> $staff['id'],'class'=>"myalert-delete")); ?> 

            </div>
        </div>
        <div class="row">

            <div class="col-sm-6 col-xs-6">
                <label>First Name<span class="text-danger">*</span></label>
                         <?php echo $this->Form->input(
                                'first_name', array(
                                'placeholder'=>'First Name',
                                'class'=>'form-control required',
                                'label' => false,
                                'value'=>@$staff['first_name'], 
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
                                'value'=>@$staff['last_name'],       
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
                                'class'=>'form-control required',
                                'label' => false,
                                'data-id'=>@$staff['id'],
                                'data-parentId'=>'',
                                 'value'=>@$staff['email'],   
                               ));  
                            ?>
            </div>
            <div class="col-sm-6 col-xs-6">
                <label>Phone<span class="text-danger">*</span></label>
                         <?php echo $this->Form->input(
                                'phone', array(
                                'placeholder'=>'Phone',
                                'class'=>'form-control inp-phone ',
                                'label' => false,
                                 'value'=>@$staff['phone'], 
                               ));  
                            ?>
            </div>
        </div>
        <div class="row">

            <?php echo $this->Form->hidden('id', array('value'=>@$staff->id));  ?>

            <div class="col-sm-12 col-xs-12 clearfix">
                  <?php echo $this->Html->link('Cancel',['/Staffs'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-default')); ?>
            </div>
        </div>
              <?php echo $this->Form->end();?>
    </div>
</div>

<?= $this->Html->script(['user']);?>



