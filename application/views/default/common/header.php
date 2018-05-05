<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<script src="<?php echo base_url('public/javascript/jquery/jquery-2.1.1.min.js'); ?>" type="text/javascript"></script>
<link href="<?php echo base_url('public/javascript/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" media="screen" />
<script src="<?php echo base_url('public/javascript/bootstrap/js/bootstrap.min.js'); ?>" type="text/javascript"></script>
<link href="<?php echo base_url('public/javascript/font-awesome/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('public/default/stylesheet/stylesheet.css'); ?>" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/default/stylesheet/settings.css'); ?>" media="screen" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('public/default/stylesheet/dropdown.css'); ?>" />

  <link rel="stylesheet" href="<?php echo base_url('public/default/stylesheet/global.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('public/default/stylesheet/style.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('public/default/stylesheet/homepage-5.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('public/default/stylesheet/responsive.css'); ?>" />
  <link href="<?php echo base_url('public/default/stylesheet/skin.less'); ?>" rel="stylesheet/less">

<?php foreach($styles as $style) { ?>
<link href="<?php echo $style['hre']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>}" />
<?php } ?>
<?php foreach($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<script src="<?php echo base_url('public/javascript/common.js'); ?>" type="text/javascript"></script>
<?php foreach($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>
</head>
<body>
<div id="wrapper" class="homepage homepage-5">

            <header id="header" class="header header-style-4 header-style-5">
              <div class="primary-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-8 col-md-6">
                                <ul class="link-wrap clearfix">
                                    <li class="mail">
                                        <span><a class="email-us" href=""><?php echo $comment; ?></a></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-6">
                                <div class="social-wrap clearfix">

                                    <ul class="social">
                                        
                                        <li>
                                            <a href="#"> <i class="fa fa-facebook"></i> </a>
                                        </li>
                                        <li>
                                            <a href="#"> <i class="fa fa-twitter"></i> </a>
                                        </li>
                                        <li>
                                            <a href="#"> <i class="fa fa-google-plus"></i> </a>
                                        </li>
                                    </ul>
                                    <ul class="link-wrap hotline">
                                   
                                    <li>
                                        <a href="tel:5917890123"> <i class="fa fa-phone-square"> </i> <?php echo $telephone; ?> </a>
                                    </li>
                                    <li>
                                        <a href="#"> <i class="fa fa-clock-o"> </i> <?php echo $email; ?> </a>
                                    </li>
                                </ul>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
                <div class="main-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12 col-sm-3">
                              <?php if($logo) { ?>
                              <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>
                              <?php } else { ?>
                              <h1><a href="<?php echo $home; ?>"><?php echo $name; ?></a></h1>
                             <?php } ?>
                            </div>
                            <div class="col-xs-12 col-sm-9 custom-nav">
                               <?php echo $menu_header; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
