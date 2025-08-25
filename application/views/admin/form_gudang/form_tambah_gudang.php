<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <nav class="breadrumb">
            <h1>
                Input Form Gudang
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home </a></li>
                <li><a href="#">Forms</a></li>
                <li class="active">Data Gudang Baru</li>
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

            <form method="post" action="<?php echo site_url('aset/tambah_gudang'); ?>" id="gudangForm">

                <div class="form-group">
                    <label>Kode Gudang</label>
                    <input type="text" name="kode_gudang_display" id="kode_gudang_display" class="form-control" readonly>
                    <input type="hidden" name="kode_gudang" id="kode_gudang">
                    <small class="text-muted">Kode akan tergenerate otomatis setelah mengisi nama dan lokasi</small>
                </div>

                <div class="form-group">
                    <label>Nama Gudang</label>
                    <!-- <input type="text" name="nama_gudang" id="nama_gudang" class="form-control" required onblur="generateKodeGudang()"> -->
                    <select name="nama_gudang" id="" value="" class="form-control" required>
                        <option name="" id="" value="">- Pilih Gudang -</option>
                        <option name="credinex" id="credinex" value="credinex" credinex>Credinex</option>
                        <option name="adapundi" id="adapundi" value="adapundi">Adapundi</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Lokasi Gudang</label>
                    <input type="text" name="lokasi_gudang" id="lokasi_gudang" class="form-control" required onblur="generateKodeGudang()">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="">-</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Non-Aktif">Non-Aktif</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo site_url('aset/list_gudang'); ?>" class="btn btn-default">Kembali</a>
            </form>
        </div>
    </section>
    <!-- input form end -->

</div>