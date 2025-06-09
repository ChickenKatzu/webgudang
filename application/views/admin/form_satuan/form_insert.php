<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <nav class="breadrumb">
      <h1>
        Input Satuan Barang
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Satuan Barang</li>
      </ol>
    </nav>
  </section>

  <!-- Main content -->
  <div class="row">
    <!-- left column -->
    <div class="col-md-12">
      <div class="container">
        <!-- general form elements -->
        <div class="box box-primary" style="width:94%;">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-archive" aria-hidden="true"></i> Tambah Satuan Barang</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <div class="container">
            <form action="<?= base_url('admin/proses_satuan_insert') ?>" role="form" method="post">

              <?php if ($this->session->flashdata('msg_berhasil')) { ?>
                <div class="alert alert-success alert-dismissible" style="width:91%">
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

              <div class="box-body">
                <div class="form-group" style="display:inline-block;">
                  <label for="kode_satuan" style="width:87%;margin-left: 12px;">Kode Satuan</label>
                  <input type="text" name="kode_satuan" style="width: 90%;margin-right: 67px;margin-left: 11px;" class="form-control" id="kode_satuan" placeholder="Kode Satuan">
                </div>
                <div class="form-group" style="display:inline-block;">
                  <label for="nama_satuan" style="width:73%;">Nama Satuan</label>
                  <input type="text" name="nama_satuan" style="width:90%;margin-right: 67px;" class="form-control" id="nama_satuan" placeholder="Nama Satuan">
                </div>
                <div class="form-group" style="display:inline-block;">
                  <button type="reset" class="btn btn-basic" name="btn_reset" style="width:95px;margin-left:20px;"><i class="fa fa-eraser" aria-hidden="true"></i> Reset</button>
                </div>

                <!-- /.box-body -->

                <div class="box-footer" style="width:93%;">
                  <a type="button" class="btn btn-default" style="width:10%;margin-right:26%" onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
                  <a type="button" class="btn btn-info" style="width:13%;margin-right:29%" href="<?= base_url('admin/tabel_satuan') ?>" name="btn_listsatuan"><i class="fa fa-table" aria-hidden="true"></i> Lihat Satuan</a>
                  <button type="submit" style="width:20%" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/.col (right) -->
</div>