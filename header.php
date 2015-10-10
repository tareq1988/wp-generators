<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WP Generator</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top navbar-inverse">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">WP Generator</a>
            </div>

            <?php $file_name = basename( $_SERVER['SCRIPT_NAME'] ); ?>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li<?php echo $file_name == 'admin-menu-page.php' ? ' class="active"' : ''; ?>><a href="admin-menu-page.php">Menu Page</a></li>
                    <li<?php echo $file_name == 'list-table.php' ? ' class="active"' : ''; ?>><a href="list-table.php">WP List Table</a></li>
                    <li<?php echo $file_name == 'form.php' ? ' class="active"' : ''; ?>><a href="form.php">Form Table</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <div style="margin-bottom: 100px;"></div>