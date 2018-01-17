<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sullivan <?php echo isset($pageTitle) ? ('| '.$pageTitle) : '';?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?= $this->Html->css(['/frontend/home/css/main','forntend-custom','datepicker/timepicker','datepicker/datepicker','p-notify']); ?>
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <?= $this->Html->script(['/frontend/js/jquery.min','/frontend/js/bootstrap.min','jquery-validate/jquery.validate.min','jquery-validate/jquery-validation-custom','jquery-validate/additional-validation','jquery-validate/jquery.maskedinput','signup','/frontend/home/js/bootstrap-multiselect','p-notify','forntend_custom','datepicker/timepicker','datepicker/bootstrap-datepicker']);?>
    </head>
    <body class="body-main">
<?php echo $this->element('frontend/dashboard/header'); ?>
<?php echo $this->element('frontend/dashboard/sidebar/left'); ?>	  
<?php echo $this->element('frontend/dashboard/sidebar/right'); ?>	  

                    <?= $this->fetch('content') ?>

<?php echo $this->element('frontend/dashboard/footer'); ?>

        <script>
        //js for date piker and time piker            
            $('.time').timepicker();
            $('.datepicker').datepicker();
        //js for loder    
            (function ($) {
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
            })(jQuery);
        //js for left bar     

            $(document).ready(function () {
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
            });
        </script>
    </body>
</html>




