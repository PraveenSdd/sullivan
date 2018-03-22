<?php ?>
<style>
     .view-permit-outer .bg-primary:focus, .view-permit-outer .bg-primary:hover{color:#fff;}
</style>

<div class="row ">
    <h5 class="msg"><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border padding-top-10">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12 bg-primary clearfix text-center">
                            <h3>  <?php echo ucfirst(htmlentities($operation->name));?></h3>
                            <p><?php echo htmlentities($operation->description);?></p>
                             <?php echo $this->Form->hidden('name', array(
                                                  'class'=>'form-control inp-operation-name',
                                                  'label' => false,
                                                  'data-id'=>$operation->id,
                                                  'value'=>htmlentities($operation->name),
                                                   'maxlength'=>120, 
                                                 ));  
                                              ?>
                        </div>
                    </div>
                </div>
            </div>
       
   
               <?php echo $this->element('backend/operation/attributes_menus'); ?>

            </div>
            </div>

