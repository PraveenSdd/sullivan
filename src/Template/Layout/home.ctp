<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>PermitAdmin <?php echo isset($pageTitle) ? ('| ' . $pageTitle) : ''; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="author" content="urrzaa" />
        <meta name="Resource-type" content="Document" />
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
        <?= $this->Html->css(['/frontend/home/css/bootstrap.min', '/frontend/home/css/main', 'forntend-custom', 'custom']); ?>
        <?= $this->Html->script(['/frontend/js/jquery.min', '/frontend/js/bootstrap.min', 'jquery.validate']); ?>


    </head>
    <body class="body-index">
        <?php echo $this->element('layout/frontend/home/header'); ?> 

        <?= $this->fetch('content') ?>

        <?php echo $this->element('layout/frontend/footer'); ?>

    </body>
</html>
