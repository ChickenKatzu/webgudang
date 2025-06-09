<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Web Gudang | Data Barang Masuk</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/web_admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/web_admin/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/web_admin/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/web_admin/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/web_admin/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/datetimepicker/css/bootstrap-datetimepicker.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo base_url('admin') ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>A</b>LT</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Admin</b>LTE</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php foreach ($avatar as $a) { ?>
                                    <img src="<?php echo base_url('assets/upload/user/img/' . $a->nama_file) ?>" class="user-image" alt="User Image">
                                <?php } ?>
                                <span class="hidden-xs"><?= $this->session->userdata('name') ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <?php foreach ($avatar as $a) { ?>
                                        <img src="<?php echo base_url('assets/upload/user/img/' . $a->nama_file) ?>" class="img-circle" alt="User Image">
                                    <?php } ?>

                                    <p>
                                        <?= $this->session->userdata('name') ?> - Web Developer
                                        <small>Last Login: <?= $this->session->userdata('last_login') ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->

                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?= base_url('admin/profile') ?>" class="btn btn-default btn-flat"><i class="fa fa-cogs" aria-hidden="true"></i> Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?= base_url('admin/sigout') ?>" class="btn btn-default btn-flat"><i class="fa fa-sign-out" aria-hidden="true"></i> Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->

        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <?php foreach ($avatar as $a) { ?>
                            <img src="<?php echo base_url('assets/upload/user/img/' . $a->nama_file) ?>" class="img-circle" alt="User Image">
                        <?php } ?>
                    </div>
                    <div class="pull-left info">
                        <p><?= $this->session->userdata('name') ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <!-- search form -->

                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MAIN NAVIGATION</li>
                    <li>
                        <a href="<?= base_url('admin') ?>">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            <span class="pull-right-container">
                                <!-- <i class="fa fa-angle-left pull-right"></i> -->
                            </span>
                        </a>
                        <!-- <ul class="treeview-menu">
            <li><a href="<?php echo base_url() ?>assets/web_admin/index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="<?php echo base_url() ?>assets/web_admin/index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul> -->
                    </li>

                    <?php
                    $segment = $this->uri->segment(2); // 'form_barangmasuk', 'form_resignation', etc
                    ?>

                    <li class="treeview <?= in_array($segment, ['form_barangmasuk', 'form_resignation', 'form_satuan']) ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-edit"></i> <span>Forms</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= ($segment == 'form_barangmasuk') ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/form_barangmasuk') ?>"><i class="fa fa-circle-o"></i> Tambah Data Barang Masuk</a>
                            </li>
                            <li class="<?= ($segment == 'form_resignation') ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/form_resignation') ?>"><i class="fa fa-circle-o"></i> Tambah Data Resignation</a>
                            </li>
                            <li class="<?= ($segment == 'form_satuan') ? 'active' : '' ?>">
                                <a href="<?= base_url('admin/form_satuan') ?>"><i class="fa fa-circle-o"></i> Tambah Satuan Barang</a>
                            </li>
                        </ul>
                    </li>

                    <li class="treeview <?= in_array($segment, ['tabel_barangmasuk', 'tabel_barangkeluar', 'tabel_satuan']) ? 'active' : '' ?>">
                        <a href="treeview-menu">
                            <i class="fa fa-book"></i> <span>Laporan</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= ($segment == 'tabel_barangmasuk') ? 'active' : '' ?>"><a href="<?= base_url('admin/tabel_barangmasuk') ?>"><i class="fa fa-circle-o"></i> Laporan Barang Masuk</a></li>
                            <li class="<?= ($segment == 'tabel_barangkeluar') ? 'active' : '' ?>"><a href="<?= base_url('admin/tabel_barangkeluar') ?>"><i class="fa fa-circle-o"></i> Laporan Barang Keluar</a></li>
                            <li class="<?= ($segment == 'tabel_satuan') ? 'active' : '' ?>"><a href="<?= base_url('admin/tabel_satuan') ?>"><i class="fa fa-circle-o"></i> Laporan Satuan</a></li>
                        </ul>
                    </li>
                    <li>
                    <li class="header">LABELS</li>
                    <li>
                        <a href="<?php echo base_url('admin/profile') ?>">
                            <i class="fa fa-cogs" aria-hidden="true"></i> <span>Profile</span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('admin/users') ?>">
                            <i class="fa fa-fw fa-users" aria-hidden="true"></i> <span>Users</span></a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->