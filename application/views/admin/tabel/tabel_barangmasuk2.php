<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tabel Barang Masuk
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li>Tables</li>
      <li class="active"><a href="<?= base_url('admin/tabel_barangmasuk2') ?>">Tabel Barang Masuk</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Daftar Barang</h3>
            <div class="box-tools">
              <a href="<?= base_url('barang/form') ?>" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> Tambah Baru
              </a>
            </div>
          </div>
          <div class="box-body">
            <!-- Filter and Pagination Controls -->
            <div class="row">
              <div class="col-sm-6">
                <form method="get" action="<?= base_url('barang') ?>">
                  <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="<?= $search ?>">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-primary">Cari</button>
                    </span>
                  </div>
                </form>
              </div>
              <div class="col-sm-6 text-right">
                <div class="form-inline">
                  <label>Show:</label>
                  <select class="form-control input-sm" onchange="window.location.href='<?= base_url('barang') ?>?per_page='+this.value+'<?= $search ? '&search=' . $search : '' ?>'">
                    <option value="5" <?= ($per_page == 5) ? 'selected' : '' ?>>5</option>
                    <option value="10" <?= ($per_page == 10) ? 'selected' : '' ?>>10</option>
                    <option value="15" <?= ($per_page == 15) ? 'selected' : '' ?>>15</option>
                    <option value="20" <?= ($per_page == 20) ? 'selected' : '' ?>>20</option>
                  </select>
                  <label>entries</label>
                </div>
              </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Aset</th>
                    <th>Nama Aset</th>
                    <th>Lokasi</th>
                    <th>Departemen</th>
                    <th>Kondisi</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1;
                  foreach ($barang as $b): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= $b->kode_aset ?></td>
                      <td><?= $b->nama_aset ?></td>
                      <td><?= $b->lokasi ?></td>
                      <td><?= $b->departemen ?></td>
                      <td>
                        <span class="label label-<?=
                                                  ($b->kondisi == 'Baik') ? 'success' : (($b->kondisi == 'Rusak Ringan') ? 'warning' : 'danger')
                                                  ?>">
                          <?= $b->kondisi ?>
                        </span>
                      </td>
                      <td>
                        <a href="<?= base_url('barang/edit/' . $b->id) ?>" class="btn btn-xs btn-warning">
                          <i class="fa fa-edit"></i>
                        </a>
                        <button onclick="confirmDelete('<?= $b->id ?>')" class="btn btn-xs btn-danger">
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="row">
              <div class="col-sm-6">
                <div class="dataTables_info">
                  Showing <?= ($page + 1) ?> to <?= min($page + $per_page, $config['total_rows']) ?> of <?= $config['total_rows'] ?> entries
                </div>
              </div>
              <div class="col-sm-6 text-right">
                <?= $pagination ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
    function confirmDelete(id) {
      if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        window.location.href = '<?= base_url("barang/delete/") ?>' + id;
      }
    }
  </script>
  <!-- /.content -->
</div>