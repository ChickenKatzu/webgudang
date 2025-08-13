    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Tambah Barang Keluar
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="<?= base_url('admin/tabel_barangmasuk') ?>">Tables</a></li>
          <li class="active">Tambah Barang Keluar</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container">
          <h2><?php echo $title; ?></h2>

          <?php if (validation_errors()): ?>
            <div class="alert alert-danger">
              <?php echo validation_errors(); ?>
            </div>
          <?php endif; ?>

          <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php endif; ?>

          <form method="post" action="<?php echo site_url('aset/keluar'); ?>">
            <?php if (isset($asset)): ?>
              <input type="hidden" name="kode_aset" value="<?php echo $asset->kode_aset; ?>">

              <div class="form-group">
                <label>Kode Aset</label>
                <input type="text" class="form-control" value="<?php echo $asset->kode_aset; ?>" readonly>
              </div>

              <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" class="form-control" value="<?php echo $asset->nama_barang; ?>" readonly>
              </div>

              <div class="form-group">
                <label>Merk</label>
                <input type="text" class="form-control" value="<?php echo $asset->merk; ?>" readonly>
              </div>

              <div class="form-group">
                <label>Tipe</label>
                <input type="text" class="form-control" value="<?php echo $asset->tipe; ?>" readonly>
              </div>

              <div class="form-group">
                <label>Serial Number</label>
                <input type="text" class="form-control" value="<?php echo $asset->serial_number; ?>" readonly>
              </div>

              <div class="form-group">
                <label>Lokasi</label>
                <input type="text" class="form-control" value="<?php echo $asset->lokasi; ?>" readonly>
              </div>

              <div class="form-group">
                <label>Kondisi</label>
                <input type="text" class="form-control" value="<?php echo $asset->kondisi; ?>" readonly>
              </div>

              <div class="form-group">
                <label>Tanggal Masuk</label>
                <input type="text" class="form-control" value="<?php echo $asset->tanggal_masuk; ?>" readonly>
              </div>
            <?php else: ?>
              <div class="form-group">
                <label>Kode Aset</label>
                <input type="text" name="kode_aset" class="form-control" required>
              </div>
            <?php endif; ?>

            <div class="form-group">
              <label>Nama Penerima</label>
              <input type="text" name="nama_penerima" class="form-control" required>
            </div>

            <div class="form-group">
              <label>Posisi Penerima</label>
              <select name="posisi_penerima" class="form-control" required>
                <option value="">Pilih Posisi</option>
                <option value="collection">Collection</option>
                <option value="staff">Staff</option>
                <option value="back office">Back Office</option>
              </select>
            </div>

            <div class="form-group">
              <label>Tanggal Keluar</label>
              <input type="date" name="tanggal_keluar" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="<?php echo site_url('aset'); ?>" class="btn btn-default">Kembali</a>
          </form>
        </div>
      </section>
    </div>