<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin <?php echo isset($pageTitle) ? ('| '.$pageTitle) : '';?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?= $this->Html->css(['/vendor/plugin/bootstrap/dist/css/bootstrap.min','/vendor/plugin/font-awesome/css/font-awesome.min','/vendor/plugin/Ionicons/css/ionicons.min','/vendor/dist/css/AdminLTE.min','/vendor/dist/css/skins/_all-skins.min','/vendor/plugin/morris.js/morris','/vendor/plugin/morris.js/morris','/vendor/plugin/jvectormap/jquery-jvectormap','bootstrap-datetimepicker','plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min','/vendor/plugin/select2/dist/css/select2.min','custom','datepicker/timepicker','datepicker/datepicker','p-notify']); ?>
        <link rel="shortcut icon" href="/img/favicon.ico">
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <?= $this->Html->script(['/vendor/plugin/jquery/dist/jquery.min','/vendor/plugin/jquery-ui/jquery-ui.min','/vendor/plugin/bootstrap/dist/js/bootstrap.min','jquery-validate/jquery.validate.min','jquery-validate/jquery-validation-custom','jquery-validate/additional-validation','jquery-validate/jquery.maskedinput','p-notify','custom','datepicker/timepicker','datepicker/bootstrap-datepicker']);?>
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
<!-- loader for all pages  -->
     <?php echo $this->element('loader/flickr'); ?> 
<!-- header contains  -->

  <?php echo $this->element('backend/header'); ?>
<!-- Left side column. contains the logo and sidebar -->
  <?php echo $this->element('backend/sidebar/left'); ?>	  
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo isset($pageHedding) ? $pageHedding : '&nbsp;';?>
        </h1>
<?php echo $this->element('backend/breadcrumb'); ?>      
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
            <?= $this->Flash->render()?>
            </div>
        </div>		
        <?= $this->fetch('content') ?>
    </section>
</div>
<!-- /.content-FOOTER -->
<?php echo $this->element('backend/footer'); ?>
<!-- Control right Side bar -->
<?php echo $this->element('backend/sidebar/right'); ?>
<div class="control-sidebar-bg"></div>
</div>
        <?= $this->Html->script(['/vendor/plugin/raphael/raphael.min','/vendor/plugin/morris.js/morris.min','/vendor/plugin/jquery-sparkline/dist/jquery.sparkline.min','plugins/jvectormap/jquery-jvectormap-1.2.2.min','plugins/jvectormap/jquery-jvectormap-world-mill-en','/vendor/plugin/jquery-knob/dist/jquery.knob.min','/vendor/plugin/moment/min/moment.min','plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min','/vendor/plugin/jquery-slimscroll/jquery.slimscroll.min','/vendor/plugin/fastclick/lib/fastclick','/vendor/dist/js/adminlte.min','/vendor/dist/js/pages/dashboard','/vendor/dist/js/demo','jquery.validate','/vendor/plugin/select2/dist/js/select2.full.min','jquery.validate','custom']);?>
 <!--js for datepiker and time piker-->
<script type="text/javascript">
    $('.time').timepicker();
    $(function () {
        $(".datepicker").datepicker({minDate: 0});
    });
</script>
    </body>
</html>
