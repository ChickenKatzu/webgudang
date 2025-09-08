<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- row 1 -->
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header">
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </div>
        <!-- sub row 1 -->
        <div class="box-header">
          <h1>
            Adapundi
            <small>Cideng</small>
          </h1>
        </div>
        <div class="box-body">
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
        </div>
        <!-- sub row 2 -->
        <div class="box-header">
          <h1>
            Adapundi
            <small>Bungur</small>
          </h1>
        </div>
        <div class="box-body">
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
        </div>
        <!-- sub row 3 -->
        <div class="box-header">
          <h1>
            Adapundi
            <small>Capital Place</small>
          </h1>
        </div>
        <div class="box-body">
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

        </div>
      </div>
    </div>
  </div>

  <!-- row 2 -->
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h1 class="box-title">Filter Log History</h1>
        </div>
        <div class="box-body">
          <form method="get" action="<?php echo site_url('log_history/filter'); ?>">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Jenis Aksi</label>
                  <select name="action_type" class="form-control">
                    <option value="">-- Semua Aksi --</option>
                    <option value="insert">Tambah Data</option>
                    <option value="update">Update Data</option>
                    <option value="delete">Hapus Data</option>
                    <option value="login">Login</option>
                    <option value="logout">Logout</option>
                    <option value="pinjam">Peminjaman</option>
                    <option value="kembali">Pengembalian</option>
                    <option value="mutasi">Mutasi</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Kode Aset</label>
                  <input type="text" name="kode_aset" class="form-control" placeholder="Masukkan kode aset">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tanggal Mulai</label>
                  <input type="date" name="start_date" class="form-control">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tanggal Akhir</label>
                  <input type="date" name="end_date" class="form-control">
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
            <a href="<?php echo site_url('log_history/export'); ?>" class="btn btn-success"><i class="fa fa-download"></i> Export CSV</a>
          </form>
        </div>
      </div>

      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Daftar Log History</h3>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>User</th>
                  <th>Aksi</th>
                  <th>Tabel</th>
                  <th>Kode Aset</th>
                  <th>Deskripsi</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($logs)): ?>
                  <?php foreach ($logs as $log): ?>
                    <tr>
                      <td><?php echo date('d/m/Y H:i:s', strtotime($log->created_at)); ?></td>
                      <td><?php echo $log->username . ' (' . $log->nama_karyawan . ')'; ?></td>
                      <td>
                        <?php
                        $badge_color = 'default';
                        if ($log->action_type == 'insert') $badge_color = 'success';
                        if ($log->action_type == 'update') $badge_color = 'info';
                        if ($log->action_type == 'delete') $badge_color = 'danger';
                        if ($log->action_type == 'login') $badge_color = 'primary';
                        ?>
                        <span class="badge bg-<?php echo $badge_color; ?>">
                          <?php echo strtoupper($log->action_type); ?>
                        </span>
                      </td>
                      <td><?php echo $log->table_name; ?></td>
                      <td><?php echo $log->kode_aset; ?></td>
                      <td><?php echo $log->description; ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center">Tidak ada data log history</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
          <?php echo $pagination; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- content wraooer pages end -->