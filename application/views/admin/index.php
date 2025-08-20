<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Adapundi
      <small>Cideng</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <?php if (!empty($stokBarangMasukCideng)) { ?>
              <h3><?= $stokBarangMasukCideng ?></h3>
            <?php } else { ?>
              <h3>0</h3>
            <?php } ?>
            <p>Stok Barang Gudang</p>
          </div>
          <div class="icon">
            <i class="fa fa-laptop"></i>
          </div>
          <a href="<?= base_url('admin/list_masuk') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <?php if (!empty($stokBarangKeluarCideng)) { ?>
              <h3><?= $stokBarangKeluarCideng ?></h3>
            <?php } else { ?>
              <h3>0</h3>
            <?php } ?>
            <p>Stok Barang Keluar</p>
          </div>
          <div class="icon">
            <i class="fa fa-share"></i>
          </div>
          <a href="<?= base_url('admin/list_keluar') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- user and invoice dashboard start -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <?php if (!empty($dataUser)) { ?>
              <h3><?= $dataUser ?></h3>
            <?php } else { ?>
              <h3>0</h3>
            <?php } ?>
            <p>Users</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="<?= base_url('admin/users') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>Invoice</h3>

            <p>Cetak Invoice</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="<?= base_url('admin/list_keluar') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- user and invoice dashboard end -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <!-- /.row (main row) -->

    <!-- /.content -->
  </section>
  <section class="content-header">
    <h1>
      Adapundi
      <small>Bungur</small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <?php if (!empty($stokBarangMasukBungur)) { ?>
              <h3><?= $stokBarangMasukBungur ?></h3>
            <?php } else { ?>
              <h3>0</h3>
            <?php } ?>
            <p>Stok Barang Gudang</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="<?= base_url('admin/list_masuk') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <?php if (!empty($stockBarangKeluarBungur)) { ?>
              <h3><?= $stockBarangKeluarBungur ?></h3>
            <?php } else { ?>
              <h3>0</h3>
            <?php } ?>
            <p>Stok Barang Keluar</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="<?= base_url('admin/list_keluar') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- user and invoice dashboard start -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <?php if (!empty($dataUser)) { ?>
              <h3><?= $dataUser ?></h3>
            <?php } else { ?>
              <h3>0</h3>
            <?php } ?>
            <p>Users</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="<?= base_url('admin/users') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>Invoice</h3>

            <p>Cetak Invoice</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="<?= base_url('admin/list_keluar') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- user and invoice dashboard end -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <!-- /.row (main row) -->
  </section>
  <section class="content-header">
    <h1>
      Adapundi
      <small>Capital Place</small>
    </h1>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <?php if (!empty($stockBarangMasukCapitalPlace)) { ?>
              <h3><?= $stockBarangMasukCapitalPlace ?></h3>
            <?php } else { ?>
              <h3>0</h3>
            <?php } ?>
            <p>Stok Barang Gudang</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="<?= base_url('admin/list_masuk') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <?php if (!empty($stockBarangKeluarCapitalPlace)) { ?>
              <h3><?= $stockBarangKeluarCapitalPlace ?></h3>
            <?php } else { ?>
              <h3>0</h3>
            <?php } ?>
            <p>Stok Barang Keluar</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="<?= base_url('admin/list_keluar') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- user and invoice dashboard start -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <?php if (!empty($dataUser)) { ?>
              <h3><?= $dataUser ?></h3>
            <?php } else { ?>
              <h3>0</h3>
            <?php } ?>
            <p>Users</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="<?= base_url('admin/users') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>Invoice</h3>

            <p>Cetak Invoice</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="<?= base_url('admin/list_keluar') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- user and invoice dashboard end -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <!-- /.row (main row) -->

  </section>
</div>
<!-- content wraooer pages end -->