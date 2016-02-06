<!DOCTYPE html>
<html class="" lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <link rel="shortcut icon" href="/assets/images/favicon.png" type="image/png">
    <title>Page Peeper</title>
    <link href="https://fonts.googleapis.com/css?family=Nothing+You+Could+Do" rel="stylesheet" type="text/css">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/theme.css" rel="stylesheet">
    <link href="/assets/css/ui.css" rel="stylesheet">
    <link href="/assets/plugins/datatables/dataTables.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/theme.css" rel="stylesheet">
    <link href="/assets/css/ui.css" rel="stylesheet">
    <link href="/assets/plugins/dropzone/dropzone.min.css" rel="stylesheet">
    <link href="/assets/plugins/input-text/style.min.css" rel="stylesheet">
    <link href="/assets/plugins/metrojs/metrojs.min.css" rel="stylesheet">
    <link href="/assets/plugins/maps-amcharts/ammap/ammap.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/assets/plugins/modernizr/modernizr-2.6.2-respond-1.1.0.min.js"></script>
    <![endif]-->
</head>
<body class="fixed-topbar color-default bg-darker theme-sdtd">
<section>
    <div class="sidebar">
        <div class="logopanel">
            <h1><a href="/">&nbsp;</a></h1>
        </div>
        <div class="sidebar-inner">
            <div class="sidebar-top small-img clearfix">
                <a href="/account/">
                    <div class="user-image">
                        <img src="https://s.gravatar.com/avatar/<?php echo md5($this->session->userdata('email')); ?>?s=70&d=mm" class="img-responsive img-circle">
                    </div>

                    <div class="user-details">
                        <h4 style="margin-top: 25px;"><?php echo htmlentities($this->session->userdata('name')); ?></h4>
                    </div>
                </a>
            </div>
            <div class="menu-title">
                <span>Navigation</span>
            </div>
            <ul class="nav nav-sidebar">
                <li class="tm<?php if ($this->uri->total_segments()==0) { echo " nav-active active"; } ?>"><a href="/"><i class="icon-home"></i><span>Dashboard</span></a></li>
                <li class="tm nav-parent<?php if ($this->uri->segment(1)=="sites") { echo " nav-active active"; } ?>">
                    <a href="#"><i class="icon-globe"></i><span>Sites</span> <span class="fa arrow"></span></a>
                    <ul class="children collapse">
                        <li<?php if ($this->uri->segment(1)=="sites" && $this->uri->segment(2)=="add") { echo ' class="active"'; } ?>><a href="/sites/add/">Add a Site</a></li>
                        <li<?php if ($this->uri->segment(1)=="sites" && $this->uri->total_segments()==1) { echo ' class="active"'; } ?>><a href="/sites/">Manage Sites</a></li>
                    </ul>
                </li>
                <li class="tm<?php if ($this->uri->segment(1)=="account") { echo " nav-active active"; } ?>"><a href="/account/"><i class="icon-user"></i><span>Account</span></a></li>
                <li class="tm<?php if ($this->uri->segment(1)=="support") { echo " nav-active active"; } ?>"><a href="/support/"><i class="icon-question"></i><span>Support</span></a></li>
                <li class="tm"><a href="/logout/"><i class="icon-key"></i><span>Logout</span></a></li>
            </ul>
        </div>
    </div>
    <div class="main-content">
        <div class="topbar">
            <div class="header-left">       <div class="topnav">
                    <a class="menutoggle" href="#" data-toggle="sidebar-collapsed"><span class="menu__handle"><span>Menu</span></span></a>
                    <ul class="nav nav-icons">
                        <a href="/sites/add/"><li><span class="octicon octicon-plus"></span></li></a>
                    </ul>
                </div>
            </div>
        </div>
<?php
if (isset($bar_message) && $bar_message) {
?>
<script>
    window.onload = function() {
        setTimeout(function() {
            var n = $('.page-content').noty({
                text: '<div class="alert alert-<?php echo $bar_message['type']; ?>"><p><?php echo $bar_message['message']; ?></p></div>',
                layout: 'top', //or left, right, bottom-right...
                theme: 'made',
                maxVisible: 10,
                animation: {
                    open: 'animated fadeInDown',
                    close: 'animated fadeOutUp'
                },
                timeout: 4000
            });
        }, 800);
    }
</script>
<?php
}
?>