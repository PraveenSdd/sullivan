<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border padding-top-10">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12 bg-primary clearfix text-center">
                            <?php echo $this->Form->hidden('name', array('data-id'=>$category->id,'value'=>$category->name)) ?>
                            <h3>  <?php echo ucfirst($category->name);?></h3>
                            <p><?php if(!empty($category->short_description))echo $category->short_description;?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-header with-border ">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12 bg-primary clearfix text-center">
                            <h5 class="permitTitle">Contact Person Details</h5>
                            <p class="description"></p>
                        </div>
                    </div>
                    <div class="box-body view-permit-outer text-center">                    
<!-- Agency related contact person Block - START -->
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
                                    <a href="javascript:void(0);" data-categoryId="<?=$category->id;?>"  data-title="<?php echo 'Conatct';?>" class="viewConatctPerson  addicons ">Add Conatct</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Agency related permit Block - START -->
                    <div class="row">
                        <div class="col-sm-12 bg-primary clearfix text-center">
                        </div>
                    </div>
                    <div class="box-body view-permit-outer text-center">                    
                        <div class="row ">
                            <div style=" text-align: left;"> <h4>Permit Details </h4></div>
                              <?php echo $this->element('backend/agency/permit_list'); ?>
                        </div>
                    </div>

                </div>
            </div>
                    <?php  if(!empty($category->id)){ echo $this->Form->hidden('id', array('value'=>$category->id));} ?>
            <div class="box-footer button-form-sub">
                             <?php echo $this->Html->link('Cancel',['controller'=>'categories','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
            </div>
             <?php echo $this->Form->end();?>
        </div>
    </div>
<!-- modal add contact person form --> 
   <?php echo $this->element('backend/agency/contact_person'); ?>
</div>

 <?php echo $this->Html->script(['category']);?>




