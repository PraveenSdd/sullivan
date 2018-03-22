<?php ?>
<div class="modal fade modal-default" id="viewConatcPerson" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title modelTitle"></h4>
            </div>
            <?php  echo $this->Form->create('Forms', array('url' =>'javascript:void(0);' ,'id'=>'',' method'=>'post')); ?>
            <div class="contactPerson"></div>
          <?php echo $this->Form->end();?>
    </div>
</div>
