<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="col-md-12">
                    <div class="text-right">
   <?php echo $this->Html->link($this->Html->image('icons/delete.png'),'javascript:void(0);',array('escape' => false,'title'=>'Delete','data-url'=>"/admin/users/companies", 'data-title'=>'Company','data-modelname'=>'Users','data-id'=> $cmpny->id,'class'=>"myalert-delete")); ?> 
                    </div>
                </div>

                     <?php  echo $this->Form->create('Users', array('url' => array('controller' => 'users', 'action' => 'editCompany'),'id'=>'add_company',' method'=>'post','class'=>'form-horizontal')); ?>

                <div class="col-md-8">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Company Name<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                        <?php echo $this->Form->input(
                                'company', array(
                                'placeholder'=>'Name',
                                'class'=>'form-control required',
                                'label' => false,
                               ));  
                            ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">First Name<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                        <?php echo $this->Form->input(
                                'first_name', array(
                                'placeholder'=>'First Name',
                                'class'=>'form-control required',
                                'label' => false,
                               ));  
                            ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Last Name</label>
                            <div class="col-sm-9">
                        <?php echo $this->Form->input(
                                'last_name', array(
                                'placeholder'=>'Last Name',
                                'class'=>'form-control',
                                'label' => false,
                               ));  
                            ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Email<span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                        <?php echo $this->Form->input(
                                'email', array(
                                'placeholder'=>'Email',
                                'class'=>'form-control required',
                                'label' => false,
                                'data-id'=>$this->request->data['id'],
                                'data-parentId'=>'',
                               ));  
                            ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="CategoryName" class="col-sm-3 control-label">Phone</label>
                            <div class="col-sm-9">
                        <?php echo $this->Form->input(
                                'phone', array(
                                'placeholder'=>'Phone',
                                'class'=>'form-control inp-phone ',
                                'label' => false,
                               ));  
                            ?>
                            </div>
                        </div>

                    </div>
            <?php echo $this->Form->hidden('id', array('value'=>$this->request->data['id']));?>  

                    <div class="box-footer button-form-sub">
                 <?php echo $this->Html->link('Cancel',['controller'=>'users','action'=>'companies'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
 <?php echo $this->Form->button('Update', array('type'=>'submit','class'=>'btn btn-primary')); ?>
                    </div>
                </div>
             <?php echo $this->Form->end();?>
            </div>
        </div>
    </div>
</div>
<?= $this->Html->script(['user']);?>



