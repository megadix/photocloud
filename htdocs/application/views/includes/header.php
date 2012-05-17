<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PhotoCloud</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PhotoCloud">
    <meta name="author" content="Dimitri De Franciscis per www.internetpost.it">
    <base href="<?php echo base_url();?>" />

    <!-- Le styles -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="assets/css/jquery.lightbox-0.5.css" rel="stylesheet" type="text/css" media="screen" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
  </head>

  <body>
  
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="#">Photocloud</a>
          <ul class="nav">
            <li ><?php echo anchor('/', 'Home'); ?></li>
            <li class="divider-vertical"></li>
            <li ><?php echo anchor('collection/index', 'Collezioni'); ?></li>
            <li class="divider-vertical"></li>
            <li ><?php echo anchor('/home/about', 'About'); ?></li>
          </ul>
          <div class="nav-collapse pull-right">
            <?php
            if (isset($this->session->userdata['logged_in'])) {
              echo anchor('login/logout', '<i class="icon-user"></i>Logout', 'class="btn"');
            }
            else {
              echo anchor('login/index', '<i class="icon-user"></i>Login', 'class="btn"');
            }
            ?>
          </div>
        </div><!-- class="container" -->
      </div><!-- class="navbar-inner" -->
    </div><!-- class="navbar" -->
    
    <div class="container">
      <?php
      if (isset($this->session->userdata['logged_in'])) {
        echo '<div class="pull-right">';
        echo 'Logged in as <em>' . $this->session->userdata['username'] . '</em>';
        echo '</div>';
      }
      ?>
    
      <?php
      if (isset($show_masthead)) {
        ?>
      <div class="hero-unit">
        <h1>Photocloud</h1>
        <p>Gallery fotografica basata su PHP e Cloud Storage.</p>
      </div>
        <?php
      }
      ?>
  
