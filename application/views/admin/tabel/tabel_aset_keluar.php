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
    <div class="container">
      <h2><?php echo $title; ?></h2>

      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
          <?php echo $this->session->flashdata('success'); ?>
        </div>
      <?php endif; ?>

      <div class="row">
        <div class="col-md-12">
          <a href="<?php echo site_url('aset/keluar'); ?>" class="btn btn-warning">Tambah Aset Keluar</a>
          <a href="<?php echo site_url('aset'); ?>" class="btn btn-default">Kembali</a>
        </div>
      </div>

      <table class="table table-bordered table-striped mt-3">
        <thead>
          <tr>
            <th>Kode Aset</th>
            <th>Nama Barang</th>
            <th>Tipe</th>
            <th>Nama Penerima</th>
            <th>Posisi Penerima</th>
            <th>Tanggal Masuk</th>
            <th>Tanggal Keluar</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($assets as $asset): ?>
            <tr>
              <td><?php echo $asset->kode_aset; ?></td>
              <td><?php echo $asset->nama_barang; ?></td>
              <td><?php echo $asset->tipe; ?></td>
              <td><?php echo $asset->nama_penerima; ?></td>
              <td><?php echo $asset->posisi_penerima; ?></td>
              <td><?php echo $asset->tanggal_masuk; ?></td>
              <td><?php echo $asset->tanggal_keluar; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
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