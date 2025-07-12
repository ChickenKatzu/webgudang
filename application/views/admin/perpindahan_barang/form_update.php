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
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <div class="container">
              <!-- general form elements -->
              <div class="box box-primary" style="width:94%;">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-archive" aria-hidden="true"></i> Tambah Barang Keluar</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <div class="container">
                  <form action="<?= base_url('admin/proses_data_keluar') ?>" role="form" method="post">

                    <?php if (validation_errors()) { ?>
                      <div class="alert alert-warning alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Warning!</strong><br> <?php echo validation_errors(); ?>
                      </div>
                    <?php } ?>

                    <div class="box-body">
                      <div class="form-group">
                        <?php foreach ($list_data as $d) { ?>
                          <label for="id_transaksi" style="margin-left:220px;display:inline;">ID Transaksi</label>
                          <input type="text" name="id_transaksi" style="margin-left:84px;width:20%;display:inline;" class="form-control" readonly="readonly" value="<?= $d->id_transaksi ?>">
                      </div>
                      <div class="form-group">
                        <label for="tanggal" style="margin-left:220px;display:inline;">Tanggal Masuk</label>
                        <input type="text" name="tanggal" style="margin-left:66px;width:20%;display:inline;" class="form-control" readonly="readonly" value="<?= $d->tanggal ?>">
                      </div>
                      <div class="form-group">
                        <label for="user" style="margin-left:220px;display:inline;">User</label>
                        <input type="text" name="user" style="margin-left:130px;width:20%;display:inline;" class="form-control" placeholder="Klik Disini">
                      </div>
                      <div class="form-group">
                        <label for="tanggal_keluar" style="margin-left:220px;display:inline;">Tanggal Keluar</label>
                        <input type="text" name="tanggal_keluar" style="margin-left:66px;width:20%;display:inline;" class="form-control form_datetime" placeholder="Klik Disini">
                      </div>
                      <!-- <div class="form-group">
                        <label for="posisi" style="margin-left:220px;display:inline;">Posisi</label>
                        <input type="text" name="posisi" style="margin-left:122px;width:20%;display:inline;" class="form-control form_datetime" placeholder="Klik Disini">
                      </div> -->
                      <div class="form-group" style="margin-bottom:40px;">
                        <label for="lokasi" style="margin-left:220px;display:inline;">Lokasi</label>
                        <input type="text" name="lokasi" style="margin-left:117px;width:20%;display:inline;" class="form-control" readonly="readonly" value="<?= $d->lokasi ?>">
                      </div>

                      <!-- checkbox dialog -->
                      <div class="container">
                        <div class="col-sm-10">
                          <div class="form-group row text-center">
                            <label for="charger" class="text-left">Charger</label>
                            <input class="form-check-input" type="checkbox" id="blankCheckbox" value="charger" aria-label="...">
                          </div>
                          <div class="form-group row text-center">
                            <label for="headset" class="text-center">Headset</label>
                            <input class="form-check-input" type="checkbox" id="blankCheckbox" value="headset" aria-label="...">
                          </div>
                          <div class="form-group row text-center">
                            <label for="mouse" class="text-center">Mouse</label>
                            <input class="form-check-input" type="checkbox" id="blankCheckbox" value="mouse" aria-label="...">
                          </div>
                        </div>
                      </div>
                      <!-- end dialog -->

                      <div class="form-group" style="display:inline-block;">
                        <label for="kode_barang" style="width:87%;margin-left: 12px;">Nama Barang</label>
                        <input type="text" name="kode_barang" style="width: 90%;margin-right: 67px;margin-left: 11px;" class="form-control" id="kode_barang" readonly value="<?= $d->kode_barang ?>">
                      </div>
                      <div class="form-group" style="display:inline-block;">
                        <label for="kategori" style="width:73%;">Kategori</label>
                        <input type="text" name="kategori" readonly="readonly" style="width:90%;margin-right: 67px;" class="form-control" id="kategori" readonly value="<?= $d->nama_barang ?>">
                      </div>
                      <div class="form-group" style="display:inline-block;">
                        <label for="satuan" style="width:73%;">Satuan</label>
                        <select class="form-control" name="satuan" style="width:110%;margin-right: 18px;" readonly>
                          <?php foreach ($list_satuan as $s) { ?>
                            <?php if ($d->satuan == $s->nama_satuan) { ?>
                              <option value="<?= $d->satuan ?>" selected=""><?= $d->satuan ?></option>
                            <?php } else { ?>
                              <option value="<?= $s->kode_satuan ?>"><?= $s->nama_satuan ?></option>
                            <?php } ?>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group" style="display:inline-block;">
                        <label for="jumlah" style="width:73%;margin-left:33px;">Jumlah</label>
                        <input type="number" name="jumlah" style="width:41%;margin-left:34px;margin-right:18px;" class="form-control" id="jumlah" max="<?= $d->jumlah ?>" value="<?= $d->jumlah ?>">
                      </div>
                    <?php } ?>
                    <!-- /.box-body -->

                    <div class="box-footer" style="width:93%;">
                      <a type="button" class="btn btn-default" style="width:10%" onclick="history.back(-1)" name="btn_kembali"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</a>
                      <button type="submit" style="width:20%;margin-left:689px;" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>&nbsp;&nbsp;&nbsp;
                    </div>
                  </form>
                </div>
              </div>
              <!-- /.box -->

              <!-- Form Element sizes -->

              <!-- /.box -->


              <!-- /.box -->

              <!-- Input addon -->

              <!-- /.box -->

            </div>
          </div>

        </div>
    </div>