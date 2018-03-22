<?php ?>
<footer class="main-footer">
    
    <strong>Copyright 2018 <a href="<?php echo $this->Html->webroot;?>">PermitAdmin</a>.</strong> All rights
    reserved.
</footer>

<!--Code for popup of status and delete confirmation-->

<?php echo $this->element('modal/confirm_alert_modal'); ?> <?php echo $this->element('modal/permission_alert_modal'); ?>
