<?php ?>
       <?= $this->Html->css(['how_it_work']); ?>
<div class="main-content clearfix">
    <h2>HOW IT WORKS <span class="arrow-down"></span></h2>
    <ul class="hiw-wrap">
            <?php $no = 1; foreach($howItWorks as $howItWork){ ?>
        <li class="item-col-<?=$no;?> clearfix">
            <div class="hiw-item">
                <div class="hiw-index">
                    0<?=$no;?>
                </div>
                <div class="hiw-title">
                    <span><?=trim($howItWork->title);?></span>
                </div>
                <span class="<?=$howItWork->icons;?>"></span>
                <p><?=trim(substr($howItWork->description, 0, 50)."...");?> <a href="javascript:void(0);" class="hiw-half-text">more</a></p>
                <p style="display:none;"><?=trim($howItWork->description);?> <a href="javascript:void(0);" class="hiw-full-text">less</a></p>
            </div>
        </li>
            <?php $no++; }?>

</div>

<div id="hiw-preview" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Register</h4>
            </div>
            <div class="modal-body">
                <p>Register your company, yourself and the employees</p>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $(".hiw-half-text").click(function () {
            $(this).parent().hide();
            $(this).parent().next().show();
        });
        $(".hiw-full-text").click(function () {
            $(this).parent().hide();
             $(this).parent().prev().show();
        });
    });
</script>