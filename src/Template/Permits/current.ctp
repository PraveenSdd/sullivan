<?php ?>
<style>
    .th-half-width, .td-half-width{width:48%; display: inline-block;}
    .th-half-width.th-half-left, .td-half-width.td-half-left{text-align: left;}
    .th-half-width.th-half-right, .td-half-width.td-half-right{text-align: right;}
    t
</style>
<div class="main-content clearfix">
    <h2 class="pull-left">Ongoing Projects (<?=count($data);?>)</h2>
    <div class="clearfix"></div>
     <div class="alert alert-success" id="success" style="display: none;"></div>
     <div class="alert alert-error" id="error" style="display: none;"></div>
     <div class="table-responsive clearfix">
     <?php echo $this->element('frontend/permit/records'); ?>
     <?php echo $this->element('layout/frontend/default/pagination'); ?>

    </div>
</div>
<?= $this->Html->script(['frontend/permit']);?>
 