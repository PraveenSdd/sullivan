<?php ?>

<div class="main-content clearfix">
    <h2 class="pull-left">Upload Forms</h2>

    <div class="clearfix"></div>
    <div class="main-action-btn pull-right clearfix">
        <a href="javascript:void(0);" class="action-txt">Search Here</a>
             <?php echo $this->Html->link('Add',['controller'=>'forms','action'=>'upload'],array('class'=>'btn btn-default','escape' => false)); ?>
    </div>
    <div class="clearfix"></div>

    <div class="table-responsive clearfix">
     <?= $this->Flash->render() ?>
        <table class="table-striped">
            <thead>
                <tr>
                    <th scope="col"><?php echo $this->Paginator->sort('project.name', 'Project'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('form.title', 'Forms'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('Categories.name', 'Category'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('created', 'Created'); ?></th>
                    <th scope="col"><?php echo $this->Paginator->sort('is_active', 'Status'); ?></th>
                    <th scope="col">Action</th>       
                </tr>
            </thead>
            <tbody>
               <?php  if($forms->count() <= 0 ){  ?>
                <tr><td colspan="4" class="text-center">Record Not Found! </td></tr>
                    <?php } else { 
                            foreach($forms as $formdata){ 
                                $id = $this->Encryption->encode($formdata->id);?>
                <tr>
                    <td>
                             <?= $formdata->project->name; ?> 
                    </td>
                    <td>
                             <?= $formdata->form->title; ?> 
                    </td>
                    <td>
                             <?= @$formdata->category->name; ?> 
                    </td>

                    <td><?= date("d-m-Y", strtotime($formdata->created)); ?></td>


                    <td><?php if($formdata->is_active==1) { ?> 
                         <?php echo $this->Html->link($this->Html->image("icons/active.png"),'javasript:void();',array('title'=>'Active','escape' => false,'class'=>'myalert-active','data-title'=>'Form','data-status'=>'1','data-newstatus'=>'0','data-id'=>$formdata->id,'data-modelname'=>'ProjectDocuments')); ?>
                        <?php }if($formdata->is_active==0){?> 
                         <?php echo $this->Html->link($this->Html->image("icons/inactive.png"),'javasript:void();',array('title'=>'Active','escape' => false,'class'=>'myalert-active','data-title'=>'Form','data-status'=>'1','data-newstatus'=>'0','data-id'=>$formdata->id,'data-modelname'=>'ProjectDocuments')); ?>

                            <?php } ?>
                    </td>
                    <td class="center">
                                 <?php echo $this->Html->link($this->Html->image("icons/view.png"),['controller'=>'forms','action'=>'uploadFormView',$id],array('title'=>'View','escape' => false)); ?> &nbsp;&nbsp; 
                            <?php echo $this->Html->link($this->Html->image('icons/download.png'),['controller'=>'forms','action'=>'downloadPermitForm','ProjectDocuments',$id],array('escape' => false,'style'=>'color:#fff;')); ?>

                            <?php echo $this->Html->link($this->Html->image("icons/inactive.png"),'javasript:void();',array('title'=>'Delete','escape' => false,'class'=>'yalert-delete','data-title'=>'Form',,'data-id'=>$formdata->id,'data-modelname'=>'ProjectDocuments')); ?>
                    </td>
                </tr>    
                    <?php } 
                    
                        }?>
            </tbody>
        </table>
    </div>

