<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <nav class="breadrumb">
      <h1>
        Input Data Barang Masuk
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Data Barang Masuk</li>
      </ol>
    </nav>
  </section>

  <!-- Main content -->


  <!-- input form start -->
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

      <form method="post" action="<?php echo site_url('aset/masuk'); ?>">
        <div class="form-group">
          <label>Nama Barang</label>
          <!-- <input type="text" name="nama_barang" class="form-control" required> -->
          <select name="nama_barang" class="form-control" required>
            <option value="">Pilih Tipe</option>
            <option value="T480">T480 </option>
            <option value="IP320">IP320 </option>
            <option value="T490">T490 </option>
            <option value="T470">T470 </option>
          </select>
        </div>

        <div class="form-group">
          <label>Merk</label>
          <!-- <input type="text" name="merk" class="form-control" required> -->
          <select name="merk" class="form-control" required>
            <option value="">Pilih Tipe</option>
            <option value="Lenovo">Lenovo </option>
            <option value="Asus">Asus </option>
            <option value="Dell">Dell </option>
            <option value="MacBook">MacBook </option>
          </select>
        </div>

        <div class="form-group">
          <label>Tipe</label>
          <select name="tipe" class="form-control" required>
            <option value="">Pilih Tipe</option>
            <option value="Laptop">Laptop (01)</option>
            <option value="Monitor">Monitor (02)</option>
            <option value="Router">Router (03)</option>
            <option value="Firewall">Firewall (04)</option>
          </select>
        </div>

        <div class="form-group">
          <label>Serial Number</label>
          <input type="text" name="serial_number" class="form-control" required>
        </div>

        <div class="form-group">
          <label>Lokasi</label>
          <select name="lokasi" class="form-control" required>
            <option value="">Pilih Lokasi</option>
            <option value="cideng">Cideng</option>
            <option value="bungur">Bungur</option>
            <option value="cp">CP</option>
          </select>
        </div>

        <div class="form-group">
          <label>Kondisi</label>
          <select name="kondisi" class="form-control" required>
            <option value="">Pilih Kondisi</option>
            <option value="Baik">Baik</option>
            <option value="Rusak Ringan">Rusak Ringan</option>
            <option value="Rusak Berat">Rusak Berat</option>
          </select>
        </div>

        <div class="form-group">
          <label>Tanggal Masuk</label>
          <input type="date" name="tanggal_masuk" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?php echo site_url('aset'); ?>" class="btn btn-default">Kembali</a>
      </form>
    </div>
  </section>
  <!-- input form end -->

</div>