<?php ?>
<div class="row">
    <h5><?= $this->Flash->render() ?></h5>
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border padding-top-10">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-12 bg-primary clearfix text-center">
                            <?php echo $this->Form->hidden('Permit.name', array('data-id'=>$permits->id,'value'=>htmlentities($permits->name),'class'=>'form-control inp-permit-name')) ?>
                            <h3>  <?php echo ucfirst(htmlentities($permits->name));?></h3>
                            <div style="text-align: left">
                                    <?php echo htmlentities($permits->description); ?>
                            </div>
                            <div>&nbsp;</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer button-form-sub text-right">
                    <?php echo $this->Html->link('Edit',['controller'=>'permits','action'=>'edit',$permitId],array('class'=>'btn btn-primary','escape' => false)); ?> &nbsp;&nbsp;
                    <?php echo $this->Html->link('Cancel',['controller'=>'permits','action'=>'index'],array('class'=>'btn btn-warning','escape' => false)); ?>
            </div>
              <?php echo $this->element('backend/permit/attributes_menus'); ?>
        </div>
    </div>
</div>
<?php echo $this->Html->script(['backend/permit']);?>






