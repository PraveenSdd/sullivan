<?php ?>

<div class="main-content clearfix">
    <h4 class="pull-left"> 
            <?php echo $this->element('frontend/breadcrumb'); ?>      
    </h4>
    <div class="clearfix"></div>
    <div class="form-default clearfix">
        <div class="row">
            <div class="col-sm-3 col-xs-6">
                <label>First Name</label>
            </div>
            <div class="col-sm-9 col-xs-6">
                            <?php echo $staff['first_name'];?>
            </div>
        </div>
        <div class="row">                  
            <div class="col-sm-3 col-xs-6">
                <label>Last Name</label>
            </div>
            <div class="col-sm-9 col-xs-6">
                         <?php echo $staff['last_name'];?>
            </div>
        </div>
        <div class="row">                  
            <div class="col-sm-3 col-xs-6">
                <label>Email</label>
            </div>
            <div class="col-sm-9 col-xs-6">
                         <?php echo $staff['email'];?>
            </div>
        </div>
        <div class="row">                  
            <div class="col-sm-3 col-xs-6">
                <label>Phone</label>
            </div>
            <div class="col-sm-9 col-xs-6">
                        <?php echo $staff['phone'];?>
            </div>
        </div>
        <div class="row">                  
            <div class="col-sm-3 col-xs-6">
                <label>Created</label>
            </div>
            <div class="col-sm-9 col-xs-6">
                          <?php echo $this->Custom->dateTime($staff['created']) ; ?>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12 clearfix">
            <?php echo $this->Html->link('Cancel',['/Staffs'],array('class'=>'btn btn-warning','escape' => false)); ?> &nbsp;&nbsp;
        </div>
    </div>

</div>
</div>

