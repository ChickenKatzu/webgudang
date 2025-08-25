<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tabel Barang Keluar Monitor
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li>Tables</li>
      <!-- <li class="active"><a href="<?= base_url('admin/tabel_barangmasuk2') ?>">Tabel Barang Masuk</li> -->
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container">
      <h2><?php echo $title; ?></h2>

      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
          <?php echo $this->session->flashdata('success'); ?>
        </div>
      <?php endif; ?>

      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
          <?php echo $this->session->flashdata('error'); ?>
        </div>
      <?php endif; ?>

      <div class="row">
        <div class="col-md-6">
          <a href="<?php echo site_url('aset/list_masuk'); ?>" class="btn btn-warning">Tambah Aset Keluar</a>
          <a href="<?php echo site_url('aset'); ?>" class="btn btn-default">Kembali</a>
        </div>
        <div class="col-md-6">
          <form method="get" action="<?php echo site_url('aset/keluar_monitor'); ?>" class="form-inline pull-right">
            <div class="form-group">
              <input type="text" name="search" class="form-control" placeholder="Cari..." value="<?php echo $search; ?>">
            </div>
            <button type="submit" class="btn btn-default">Cari</button>
          </form>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-md-12">
          <form method="get" action="<?php echo site_url('aset/keluar_monitor'); ?>" class="form-inline">
            <input type="hidden" name="search" value="<?php echo $search; ?>">
            <div class="form-group">
              <label>Tampilkan: </label>
              <select name="per_page" class="form-control" onchange="this.form.submit()">
                <option value="5" <?php echo $per_page == 5 ? 'selected' : ''; ?>>5</option>
                <option value="10" <?php echo $per_page == 10 ? 'selected' : ''; ?>>10</option>
                <option value="15" <?php echo $per_page == 15 ? 'selected' : ''; ?>>15</option>
                <option value="20" <?php echo $per_page == 20 ? 'selected' : ''; ?>>20</option>
                <option value="25" <?php echo $per_page == 25 ? 'selected' : ''; ?>>25</option>
              </select>
            </div>
          </form>
        </div>
      </div>

      <table class="table table-bordered table-striped mt-3">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Aset</th>
            <th>Nama Barang</th>
            <th>Tipe</th>
            <th>Nama Penerima</th>
            <th>Posisi Penerima</th>
            <th>Status</th>
            <th>Tanggal Keluar</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          <?php if (count($assets) > 0): ?>
            <?php $no = 1; ?>
            <?php foreach ($assets as $asset): ?>
              <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $asset->kode_aset; ?></td>
                <td><?php echo $asset->nama_barang; ?></td>
                <td><?php echo $asset->tipe; ?></td>
                <td><?php echo $asset->nama_penerima; ?></td>
                <td><?php echo $asset->status; ?></td>
                <td><?php echo ucfirst($asset->posisi_penerima); ?></td>
                <td><?php echo date('d/m/Y', strtotime($asset->tanggal_keluar)); ?></td>
                <td>
                  <button onclick="confirmKembalikan('<?php echo $asset->kode_aset; ?>')"
                    class="btn btn-info btn-sm">
                    Kembalikan
                  </button>
                </td>
              </tr>
              <?php $no++; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="9" class="text-center">Tidak ada data aset keluar</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

      <!-- pagination -->
      <div class="container">
        <nav class="text-center">
          <ul class="pagination">
            <?php echo $pagination; ?>
          </ul>
        </nav>
      </div>
      <!-- end of pagination -->
    </div>
  </section>

  <script>
    function confirmDelete(id) {
      if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        window.location.href = '<?= base_url("barang/delete/") ?>' + id;
      }
    }

    function confirmKembalikan(kode_aset) {
      if (confirm('Apakah Anda yakin ingin mengembalikan aset ini?')) {
        window.location.href = '<?php echo site_url("aset/kembalikan/"); ?>' + kode_aset;
      }
    }
  </script>
  <!-- /.content -->
</div>