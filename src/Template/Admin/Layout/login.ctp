<?php ?>
<!DOCTYPE html>
<html>
   <head>
          <title>Admin <?php echo isset($pageTitle) ? ('| '.$pageTitle) : '';?></title>
  <?= $this->Html->css(['/vendor/plugin/bootstrap/dist/css/bootstrap.min','/vendor/plugin/font-awesome/css/font-awesome.min','/vendor/plugin/Ionicons/css/ionicons.min','/vendor/dist/css/AdminLTE.min','/vendor/dist/css/blue','/vendor/custom']); ?>
        
           <?= $this->Html->script(['/vendor/plugin/jquery/dist/jquery.min','/vendor/plugin/jquery-ui/jquery-ui.min','/vendor/plugin/bootstrap/dist/js/bootstrap.min','jquery.validate']);?>

  <link rel="shortcut icon" href="/img/favicon.ico">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
                <!-- Main content -->
                <section class="content">
                <?= $this->fetch('content') ?>

                </section>
         

   <?= $this->Html->script(['/vendor/plugin/jquery/dist/jquery.min','/vendor/plugin/jquery-ui/jquery-ui.min','/vendor/plugin/bootstrap/dist/js/bootstrap.min','/vendor/plugin/bootstrap/dist/js/icheck.min']);?>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
<style>
     .checkbox, .radio{
        margin-left: 10px;
    }
    .icheck > label{
         margin-left: 10px;
    }
    
</style>
</body>
</html>
