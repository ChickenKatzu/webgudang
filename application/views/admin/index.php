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
          <h3 class="box-title">Log History - Aktivitas Sistem</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
          <!-- Filter Form -->
          <form method="get" action="<?php echo site_url('admin'); ?>">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label>Jenis Aksi</label>
                  <select name="action_type" class="form-control">
                    <option value="">-- Semua Aksi --</option>
                    <option value="insert" <?= ($this->input->get('action_type') == 'insert') ? 'selected' : ''; ?>>Tambah Data</option>
                    <option value="update" <?= ($this->input->get('action_type') == 'update') ? 'selected' : ''; ?>>Update Data</option>
                    <option value="delete" <?= ($this->input->get('action_type') == 'delete') ? 'selected' : ''; ?>>Hapus Data</option>
                    <option value="login" <?= ($this->input->get('action_type') == 'login') ? 'selected' : ''; ?>>Login</option>
                    <option value="logout" <?= ($this->input->get('action_type') == 'logout') ? 'selected' : ''; ?>>Logout</option>
                    <option value="pinjam" <?= ($this->input->get('action_type') == 'pinjam') ? 'selected' : ''; ?>>Peminjaman</option>
                    <option value="kembali" <?= ($this->input->get('action_type') == 'kembali') ? 'selected' : ''; ?>>Pengembalian</option>
                    <option value="mutasi" <?= ($this->input->get('action_type') == 'mutasi') ? 'selected' : ''; ?>>Mutasi</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Kode Aset</label>
                  <input type="text" name="kode_aset" class="form-control" placeholder="Masukkan kode aset" value="<?= $this->input->get('kode_aset'); ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tanggal Mulai</label>
                  <input type="date" name="start_date" class="form-control" value="<?= $this->input->get('start_date'); ?>">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tanggal Akhir</label>
                  <input type="date" name="end_date" class="form-control" value="<?= $this->input->get('end_date'); ?>">
                </div>
              </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
            <a href="<?php echo site_url('admin/export_logs') . '?' . http_build_query($this->input->get()); ?>" class="btn btn-success">
              <i class="fa fa-download"></i> Export CSV
            </a>
          </form>
          <hr>

          <!-- Log Table -->
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th width="15%">Waktu</th>
                  <th width="10%">User</th>
                  <th width="10%">Aksi</th>
                  <th width="10%">Tabel</th>
                  <th width="30%">Deskripsi</th>
                  <th width="10%">Kode Aset</th>
                  <th width="15%">Detail</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($logs)): ?>
                  <?php $no = 1 + (($this->input->get('page') ? $this->input->get('page') - 1 : 0) * $per_page); ?>
                  <?php foreach ($logs as $log): ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?= date('d M Y H:i:s', strtotime($log->created_at)); ?></td>
                      <td>
                        <?= $log->username ? $log->username : 'System'; ?>
                        <?php if ($log->id_karyawan && $log->nama_karyawan): ?>
                          <br><small>(<?= $log->nama_karyawan; ?>)</small>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php
                        $badge_class = 'default';
                        if ($log->action_type == 'insert') $badge_class = 'success';
                        elseif ($log->action_type == 'update') $badge_class = 'warning';
                        elseif ($log->action_type == 'delete') $badge_class = 'danger';
                        elseif ($log->action_type == 'login') $badge_class = 'info';
                        elseif ($log->action_type == 'logout') $badge_class = 'primary';
                        elseif ($log->action_type == 'pinjam') $badge_class = 'primary';
                        elseif ($log->action_type == 'kembali') $badge_class = 'success';
                        elseif ($log->action_type == 'mutasi') $badge_class = 'info';
                        ?>
                        <span class="label label-<?= $badge_class; ?>"><?= $log->action_type; ?></span>
                      </td>
                      <td><?= $log->table_name; ?></td>
                      <td><?= $log->description; ?></td>
                      <td><?= $log->kode_aset; ?></td>
                      <td>
                        <?php if (!empty($log->old_data) || !empty($log->new_data)): ?>
                          <button type="button" class="btn btn-xs btn-info" data-toggle="modal" data-target="#modalDetail-<?= $log->id_log; ?>">
                            Lihat Detail
                          </button>

                          <!-- Modal -->
                          <div class="modal fade" id="modalDetail-<?= $log->id_log; ?>" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">Detail Log #<?= $log->id_log; ?></h4>
                                </div>
                                <div class="modal-body">
                                  <?php if (!empty($log->old_data)): ?>
                                    <h5>Data Lama:</h5>
                                    <pre class="pre-scrollable" style="max-height: 200px;"><?= json_encode(json_decode($log->old_data), JSON_PRETTY_PRINT); ?></pre>
                                  <?php endif; ?>

                                  <?php if (!empty($log->new_data)): ?>
                                    <h5>Data Baru:</h5>
                                    <pre class="pre-scrollable" style="max-height: 200px;"><?= json_encode(json_decode($log->new_data), JSON_PRETTY_PRINT); ?></pre>
                                  <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php else: ?>
                          <span class="text-muted">Tidak ada data detail</span>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php $no++; ?>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="8" class="text-center">Tidak ada data log history</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div class="text-center">
            <?= $pagination; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- content wraooer pages end -->