<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tabel Aksesoris Masuk
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
        <div class="alert alert-success alert-dismissible" id="success-alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <?php echo $this->session->flashdata('success'); ?>
        </div>
      <?php endif; ?>

      <div class="row">
        <div class="col-md-6">
          <a href="<?php echo site_url('aset/masuk'); ?>" class="btn btn-primary">Tambah Aset Masuk</a>
          <a href="<?php echo site_url('aset'); ?>" class="btn btn-default">Kembali</a>
        </div>
        <div class="col-md-6">
          <form method="get" action="<?php echo site_url('aset/list_masuk'); ?>" class="form-inline pull-right">
            <div class="form-group">
              <input type="text" name="search" class="form-control" placeholder="Cari..." value="<?php echo $search; ?>">
            </div>
            <button type="submit" class="btn btn-default">Cari</button>
          </form>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-md-12">
          <form method="get" action="<?php echo site_url('aset/list_masuk'); ?>" class="form-inline">
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

      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Aset Utama</th>
            <th>Nama Aset</th>
            <th>Jenis Aksesoris</th>
            <th>Kode Aksesoris</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($aksesoris) > 0): ?>
            <?php $no = 1; ?>
            <?php foreach ($aksesoris as $item): ?>
              <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $item->kode_aset_utama; ?></td>
                <td><?php echo $item->nama_aset; ?></td>
                <td><?php echo $item->jenis_aksesoris; ?></td>
                <td><?php echo $item->kode_aksesoris; ?></td>
                <td>
                  <a href="<?php echo site_url('aset/edit_aksesoris/' . $item->id); ?>" class="btn btn-warning btn-sm">Edit</a>
                  <a href="<?php echo site_url('aset/hapus_aksesoris/' . $item->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
              </tr>
              <?php $no++; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center">Tidak ada data aksesoris</td>
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
  </script>
  <!-- /.content -->
</div>