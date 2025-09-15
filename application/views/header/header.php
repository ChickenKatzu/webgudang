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
    <!-- Bootstarp 5.3.7 -->
    <!-- <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css"> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/web_admin/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Font Awesome 5 -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/fontawesome2/css/fonetawesome.min.css">
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

    <!-- css for sorting list_masuk -->
    <style>
        .fa-sort,
        .fa-sort-asc,
        .fa-sort-desc {
            margin-left: 5px;
            font-size: 12px;
        }

        th a {
            color: #333;
            text-decoration: none;
            display: block;
        }

        th a:hover {
            color: #333;
            text-decoration: none;
        }
    </style>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-yellow sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo base_url('admin') ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>A</b>DP</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Ada</b>Pundi</span>
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
                    </li>
                    <?php
                    $segment = $this->uri->segment(2); // 'form_barangmasuk', 'form_resignation', etc
                    ?>
                    <li class="treeview <?= in_array($segment, ['list_masuk', 'list_keluar']) ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-book"></i> <span>Laporan</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= ($segment == 'list_masuk') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/list_masuk') ?>">
                                    <i class="fa fa-circle-o"></i> Laporan aset masuk
                                </a>
                            </li>
                            <li class="<?= ($segment == 'list_keluar') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/list_keluar') ?>">
                                    <i class="fa fa-circle-o"></i> Laporan aset keluar
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Sub Laporan Aset Masuk -->
                    <?php
                    $segment = $this->uri->segment(2);
                    ?>
                    <li class="treeview <?= in_array($segment, ['masuk_laptop', 'masuk_firewall', 'masuk_monitor', 'masuk_server', 'masuk_pc']) ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-book"></i> <span>Sub Laporan Aset Masuk</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= ($segment == 'masuk_laptop') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/masuk_laptop') ?>">
                                    <i class="fa fa-circle-o"></i> Laptop
                                </a>
                            </li>
                            <li class="<?= ($segment == 'masuk_monitor') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/masuk_monitor') ?>">
                                    <i class="fa fa-circle-o"></i> Monitor
                                </a>
                            </li>
                            <li class="<?= ($segment == 'masuk_firewall') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/masuk_firewall') ?>">
                                    <i class="fa fa-circle-o"></i> Firewall
                                </a>
                            </li>
                            <li class="<?= ($segment == 'masuk_server') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/masuk_server') ?>">
                                    <i class="fa fa-circle-o"></i> Server
                                </a>
                            </li>
                            <li class="<?= ($segment == 'masuk_pc') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/masuk_pc') ?>">
                                    <i class="fa fa-circle-o"></i> PC
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Sub Laporan Aset Keluar -->
                    <?php
                    $segment = $this->uri->segment(2);
                    ?>
                    <li class="treeview <?= in_array($segment, ['keluar_monitor', 'keluar_firewall', 'keluar_laptop', 'keluar_server', 'keluar_pc']) ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-book"></i> <span>Sub Laporan Aset Keluar</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= ($segment == 'keluar_laptop') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/keluar_laptop') ?>">
                                    <i class="fa fa-circle-o"></i> Laptop
                                </a>
                            </li>
                            <li class="<?= ($segment == 'keluar_monitor') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/keluar_monitor') ?>">
                                    <i class="fa fa-circle-o"></i> Monitor
                                </a>
                            </li>
                            <li class="<?= ($segment == 'keluar_firewall') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/keluar_firewall') ?>">
                                    <i class="fa fa-circle-o"></i> Firewall
                                </a>
                            </li>
                            <li class="<?= ($segment == 'keluar_server') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/keluar_server') ?>">
                                    <i class="fa fa-circle-o"></i> Server
                                </a>
                            </li>
                            <li class="<?= ($segment == 'keluar_pc') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/keluar_pc') ?>">
                                    <i class="fa fa-circle-o"></i> PC
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Gudang -->
                    <?php
                    $segment = $this->uri->segment(2);
                    ?>
                    <li class="treeview <?= in_array($segment, ['tambah_gudang', 'list_gudang']) ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-book"></i> <span>Master Gudang/Site</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= ($segment == 'tambah_gudang') ? 'active' : '' ?>">
                                <a href="<?= base_url('gudang/tambah_gudang') ?>">
                                    <i class="fa fa-circle-o"></i> Form Tambah Gudang
                                </a>
                            </li>
                            <li class="<?= ($segment == 'list_gudang') ? 'active' : '' ?>">
                                <a href="<?= base_url('gudang/list_gudang') ?>">
                                    <i class="fa fa-circle-o"></i> List Gudang
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Mutasi -->
                    <?php
                    $segment = $this->uri->segment(2);
                    ?>
                    <!-- <li class="treeview <?= in_array($segment, ['mutasi', 'riwayat']) ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-book"></i> <span>Translokasi Aset</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= ($segment == 'mutasi') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/mutasi') ?>">
                                    <i class="fa fa-circle-o"></i> Laporan Mutasi Aset
                                </a>
                            </li>
                            <li class="<?= ($segment == 'riwayat') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/riwayat') ?>">
                                    <i class="fa fa-circle-o"></i> Laporan Riwayat Aset
                                </a>
                            </li>
                        </ul>
                    </li> -->

                    <!-- Master Karyawan -->
                    <?php $segment = $this->uri->segment(2); ?>
                    <li class="treeview <?= in_array($segment, ['tambah', null]) ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-book"></i> <span>Master Karyawan</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= ($segment == 'tambah') ? 'active' : '' ?>">
                                <a href="<?= base_url('karyawan/tambah') ?>">
                                    <i class="fa fa-circle-o"></i> Form Karyawan
                                </a>
                            </li>
                            <li class="<?= ($segment == null) ? 'active' : '' ?>">
                                <a href="<?= base_url('karyawan') ?>">
                                    <i class="fa fa-circle-o"></i> Data Karyawan
                                </a>
                            </li>
                        </ul>
                    </li>


                    <!-- master aksesoris -->
                    <?php $segment = $this->uri->segment(2); ?>
                    <li class="treeview <?= in_array($segment, ['list_aksesoris', 'masuk_aksesoris']) ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-book"></i> <span>Master Aksesoris</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= ($segment == 'list_aksesoris') ? 'active' : '' ?>">
                                <a href="<?= base_url('aksesoris/list_aksesoris') ?>">
                                    <i class="fa fa-circle-o"></i> List Aksesoris
                                </a>
                            </li>
                            <li class="<?= ($segment == 'masuk_aksesoris') ? 'active' : '' ?>">
                                <a href="<?= base_url('aksesoris/masuk_aksesoris') ?>">
                                    <i class="fa fa-circle-o"></i> Form Aksesoris
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- master barang -->
                    <?php $segment = $this->uri->segment(2);  ?>
                    <li class="treeview <?= in_array($segment, ['list_masuk', 'masuk']) ? 'active' : '' ?>">
                        <a href="#">
                            <i class="fa fa-book"></i> <span>Master Barang</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="<?= ($segment == 'list_masuk') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/list_masuk') ?>">
                                    <i class="fa fa-circle-o"></i> List Barang
                                </a>
                            </li>
                            <li class="<?= ($segment == 'masuk') ? 'active' : '' ?>">
                                <a href="<?= base_url('aset/masuk') ?>">
                                    <i class="fa fa-circle-o"></i> Form Barang
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Labels -->
                    <li class="header">LABELS</li>
                    <li>
                        <a href="<?php echo base_url('admin/profile') ?>">
                            <i class="fa fa-cogs" aria-hidden="true"></i> <span>Profile</span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('admin/users') ?>">
                            <i class="fa fa-fw fa-users" aria-hidden="true"></i> <span>Users</span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('user_management') ?>">
                            <i class="fa fa-fw fa-users" aria-hidden="true"></i> <span>Users Management</span></a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->