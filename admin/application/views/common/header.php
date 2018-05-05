<!DOCTYPE html>
<html dir="<?php echo $direction ?>" lang="<?php echo $lang ?>" ng-app="myApp">
<head>
<meta charset="UTF-8" />
<title><?php echo $title ?></title>
<base href="<?php echo $base ?>" />
<?php if($description) { ?>
<meta name="description" content="<?php echo $description ?>" />
<?php } ?>
<?php if($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords ?>" />
<?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
<script type="text/javascript" src="public/javascript/jquery/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="public/javascript/angular/angular.min.js"></script>
<script type="text/javascript" src="public/javascript/angular/app.js"></script>
<script type="text/javascript" src="public/javascript/bootstrap/js/bootstrap.min.js"></script>
<link href="public/stylesheet/bootstrap.css" type="text/css" rel="stylesheet" />
<link href="public/javascript/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
<script src="public/javascript/jquery/datetimepicker/moment/moment.min.js" type="text/javascript"></script>
<script src="public/javascript/jquery/datetimepicker/moment/moment-with-locales.min.js" type="text/javascript"></script>
<script src="public/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<link href="public/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
<link type="text/css" href="public/stylesheet/stylesheet.css" rel="stylesheet" media="screen" />
<?php  foreach( $styles as $style) { ?>
<link type="text/css" href="<?php echo $style['href']; ?>" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<?php  foreach( $links as $link)  { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<script src="public/javascript/common.js" type="text/javascript"></script>
<?php  foreach( $scripts as $script)  { ?>
<script type="text/javascript" src="<?php echo $script ?>"></script>
<?php } ?>
<script type="text/javascript">
//<![CDATA[
  var ci_var = {
    base_url : '<?php echo base_url(); ?>',
    user_token : '<?php echo $user_token; ?>',
  };
//]]>
</script>
</head>
<body>
<div id="container">
<header id="header" class="navbar navbar-static-top">
  <div class="container-fluid">

  
    <div id="header-logo" class="navbar-header"><a href="<?php echo $home ?>" class="navbar-brand"><img src="public/image/logo.png" alt="<?php echo $heading_title ?>" title="<?php echo $heading_title ?>" /></a></div>
    <a href="#" id="button-menu" class="hidden-md hidden-lg"><span class="fa fa-bars"></span></a>
    <?php  if ($logged) { ?>

    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo $image ?>" alt="<?php echo $firstname ?> <?php echo $lastname ?>" title="<?php echo $username ?>" id="user-profile" class="img-circle" /><?php echo $firstname ?> <?php echo $lastname ?> <i class="fa fa-caret-down fa-fw"></i></a>
        <ul class="dropdown-menu dropdown-menu-right">
          <li><a href="<?php echo $profile ?>"><i class="fa fa-user-circle-o fa-fw"></i> <?php echo $text_profile ?></a></li>
          <li role="separator" class="divider"></li>
          <li class="dropdown-header"><?php echo $text_store ?></li>
          <?php  foreach( $stores as $store) { ?>
          <li><a href="<?php echo $store['href']; ?>" target="_blank"><?php echo $store['name'] ?></a></li>
          <?php } ?>
          <li role="separator" class="divider"></li>
          <li><a href="http://www.hitechfocus.com" target="_blank"><i class="fa fa-bandcamp"></i> <?php echo $text_homepage ?></a></li>
          <li><a href="http://docs.hitechfocus.com" target="_blank"><i class="fa fa-file-text-o fa-fw"></i> <?php echo $text_documentation ?></a></li>
          <li><a href="http://foreach(um.hitechfocus.com" target="_blank"><i class="fa fa-comments-o fa-fw"></i> <?php echo $text_support ?></a></li>
        </ul>
      </li>
      <li><a href="<?php echo $logout ?>"><i class="fa fa-sign-out"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $text_logout ?></span></a></li>
    </ul>
    <?php } ?> </div>
</header>
