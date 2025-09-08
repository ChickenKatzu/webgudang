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
              <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                <option value="">Pilih Karyawan</option>
                <?php foreach ($karyawan as $k): ?>
                  <option value="<?php echo $k->id_karyawan; ?>" data-jabatan="<?php echo $k->jabatan; ?>">
                    <?php echo $k->nama_karyawan; ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <input type="hidden" name="nama_penerima" id="nama_penerima">
            </div>
            <!-- mouse -->
            <!-- <div class="form-group">
              <label>Mouse</label>
              <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                <option value="">Pilih Mouse</option>
                <?php foreach ($mouse as $m): ?>
                  <option value="<?php echo $m->id; ?>" data-mouse="<?php echo $m->mouse; ?>">
                    <?php echo $m->mouse; ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <input type="hidden" name="nama_penerima" id="nama_penerima">
            </div> -->
            <!-- headset -->
            <!-- <div class="form-group">
              <label>Headset</label>
              <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                <option value="">Pilih Heaset</option>
                <?php foreach ($headset as $h): ?>
                  <option value="<?php echo $h->id; ?>" data-headset="<?php echo $h->headset; ?>">
                    <?php echo $h->headset; ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <input type="hidden" name="nama_penerima" id="nama_penerima">
            </div> -->
            <!-- charger -->
            <!-- <div class="form-group">
              <label>Charger</label>
              <select name="id_karyawan" id="id_karyawan" class="form-control" required>
                <option value="">Pilih Headset</option>
                <?php foreach ($charger as $c): ?>
                  <option value="<?php echo $c->id; ?>" data-charger="<?php echo $c->charger; ?>">
                    <?php echo $c->charger; ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <input type="hidden" name="nama_penerima" id="nama_penerima">
            </div> -->

            <!-- <div class="form-group">
              <label>Aksesoris (CHM)</label><br>
              <?php foreach ($aksesoris as $a): ?>
                <label>
                  <input type="checkbox" name="aksesoris[]" value="<?php echo $a->id; ?>">
                  <?php echo $a->jenis_aksesoris . ' - ' . $a->kode_aksesoris; ?>
                </label><br>
              <?php endforeach; ?>
            </div> -->

            <div class="form-group">
              <label>Catatan</label>
              <input type="text" class="form-control" id="catatan" name="catatan" required>
            </div>

            <div class="form-group">
              <label>Posisi Penerima</label>
              <input type="text" name="posisi_penerima" id="posisi_penerima" class="form-control" readonly required>
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