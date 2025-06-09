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
    <div class="row">
      <div class="col-md-12">
        <div class="container">
          <!-- flashdata notification start -->
          <?php if ($this->session->flashdata('msg_berhasil')) { ?>
            <div class="alert alert-success alert-dismissible text-left">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong><br> <?php echo $this->session->flashdata('msg_berhasil'); ?>
            </div>
          <?php } ?>

          <?php if (validation_errors()) { ?>
            <div class="alert alert-warning alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Warning!</strong><br> <?php echo validation_errors(); ?>
            </div>
          <?php } ?>
          <!-- flashdata notification end -->
          <div class="col-md-6 col-md-offset-3">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-archive" aria-hidden="true"></i> Tambah Data Barang Masuk</h3>
              </div>
              <!-- FORM INSERT START -->
              <div class="box-body">
                <form action="<?= base_url('admin/proses_databarang_masuk_insert') ?>" role="form" method="post" class=" text-center form-horizontal">
                  <div class="form-group">
                    <label class="col-md-3 control-label text-right">ID Transaksi</label>
                    <div class="col-md-6 col-md-offset-0">
                      <input type="text" id="id_transaksi" name="id_transaksi" class="form-control" value="<?= $id_transaksi ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="kategori" class="col-md-3 control-label text-right">Kategori</label>
                    <div class="col-md-6 col-md-offset-0">
                      <select type="text" id="kategori" name="kategori" class="form-control" placeholder="Klik Disini">
                        <option value="">-Pilih-</option>
                        <option value="Laptop" data-alias="Lt">Laptop</option>
                        <option value="Charger" data-alias="Cg">Charger</option>
                        <option value="Headset" data-alias="Hs">Headset</option>
                        <option value="Mouse" data-alias="Ms">Mouse</option>
                        <option value="Pheriperal" data-alias="Ph">Pheriperal</option>
                      </select>
                    </div>
                  </div>
                  <!-- tidak jadi digunakan
              <div class="form-group">
                <label class="col-md-3 control-label text-right">Status</label>
                <div class="col-md-6 col-md-offset-0">
                  <select name="status" id="status" class="form-control">
                    <option value="">-Pilih-</option>
                    <option value="new">New</option>
                    <option value="resign">Resign</option>
                  </select>
                </div>
              </div>


              <div class="form-group">
                <label class="col-md-3 control-label text-right">User</label>
                <div class="col-md-6 col-md-offset-0">
                  <input type="text" name="user" id="user" class="form-control" value="<?= $this->session->userdata('username'); ?>" readonly placeholder="Resignation">
                </div>
              </div> -->

                  <div class="form-group">
                    <label for="merek" class="col-md-3 control-label text-right">Merek</label>
                    <div class="col-md-6 col-md-offset-0">
                      <input type="text" name="merek" id="merek" class="form-control" placeholder="Klik Disini">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="tanggal" class="col-md-3 control-label text-right">Tanggal</label>
                    <div class="col-md-6 col-md-offset-0">
                      <input type="text" name="tanggal" id="tanggal" class="form-control form_datetime" placeholder="Klik Disini">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="lokasi" class="col-md-3 control-label text-right">Lokasi</label>
                    <div class="col-md-6 col-md-offset-0">
                      <select class="form-control" id="lokasi" name="lokasi">
                        <option value="">-- Pilih --</option>
                        <option value="Cideng">Cideng</option>
                        <option value="Bungur">Bungur</option>
                        <option value="CP">CP</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="satuan" class="col-md-3 control-label text-right">Satuan</label>
                    <div class="col-md-6 col-md-offset-0">
                      <select class="form-control" id="satuan" name="satuan">
                        <option value="">-- Pilih --</option>
                        <option value="Pcs">Pcs</option>
                        <option value="Dus">Dus</option>
                        <option value="Roll">Roll</option>
                        <option value="Bungkus">Bungkus</option>
                        <option value="Meter">Meter</option>
                        <option value="Pack">Pack</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="jumlah" class="col-md-3 control-label text-right">Jumlah</label>
                    <div class="col-md-6 col-md-offset-0">
                      <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Klik Disini">
                    </div>
                  </div>
                  <hr>
                  <div class="form-group">
                    <a type="button" class="btn btn-default" onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
                    <a type="button" class="btn btn-info" href="<?= base_url('admin/tabel_barangmasuk') ?>" name="btn_listbarang"><i class="fa fa-table" aria-hidden="true"></i> Lihat List Barang</a>
                    <button type="reset" class="btn btn-basic" name="btn_reset"><i class="fa fa-eraser" aria-hidden="true"></i> Reset</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- input form ends -->
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->