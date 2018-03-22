<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>PermitAdmin <?php echo isset($pageTitle) ? ('| '.$pageTitle) : '';?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?= $this->Html->css(['/vendor/plugin/bootstrap/dist/css/bootstrap.min','datepicker/bootstrap-datetimepicker.min','/frontend/home/css/main','p-notify','forntend-custom']); ?>
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <?= $this->Html->script(['/frontend/js/jquery.min','/vendor/plugin/bootstrap/dist/js/bootstrap.min','/vendor/plugin/moment/min/moment.min','datepicker/bootstrap-datetimepicker.min','/frontend/home/js/bootstrap-multiselect','/frontend/js/jquery.mCustomScrollbar.concat.min','jquery-validate/jquery.validate.min','jquery-validate/jquery-validation-custom','jquery-validate/additional-validation','jquery-validate/jquery.maskedinput','p-notify','custom']);?>
    </head>
    <body class="body-main chk-disable-select2" data-flag ="1" >
<?php echo $this->element('layout/frontend/default/header'); ?>
<?php echo $this->element('loader/flickr'); ?>
<?php echo $this->element('layout/frontend/default/sidebar/left'); ?>	  
<?php echo $this->element('layout/frontend/default/sidebar/right'); ?>	  
        <span class="logged-role-permission hide" data-role-id="<?php echo $LoggedRoleId; ?>" data-permission-id="<?php echo $LoggedPermissionId; ?>" data-user-id="<?php echo $LoggedUserId; ?>" data-company-id="<?php echo $LoggedCompanyId; ?>"></span>

                    <?= $this->fetch('content') ?>

<?php echo $this->element('layout/frontend/default/footer'); ?>

        <script>
            //js for date piker and time piker            
            $(document).ready(function () {

                $(window).on("load", function () {

                    $(".alert-box").mCustomScrollbar({
                        setHeight: 150,
                        theme: "minimal-dark"
                    });

                    $(".notification-box").mCustomScrollbar({
                        setHeight: 340,
                        theme: "minimal-dark"
                    });
                });

                $(document).on('click', '.lft-sidebar-control', function () {
                    $('.left-sidebar').toggleClass('active');
                });

                $(document).on('click', '.rgt-sidebar-control', function () {
                    $('.right-sidebar').toggleClass('active');
                });

                $(document).on('click', '.action-txt', function () {
                    $('.advance-search-panel').removeClass('hide');
                });

                $(document).on('click', '.advance-search-panel .asp-control', function () {
                    $('.advance-search-panel').addClass('hide');
                });

                $('.inp-time-picker, .time').each(function () {
                    $(this).datetimepicker({
                        format: 'LT'
                    });
                });

                $('.inp-date-picker, .datepicker').each(function () {
                    $(this).datetimepicker({
                        format: 'MM-DD-YYYY',
                        minDate: new Date()
                    });
                });
            });
        </script>
    </body>
</html>




