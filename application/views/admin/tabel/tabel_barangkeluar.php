<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tabel Barang Keluar
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li>Tables</li>
      <li class="active"><a href="<?= base_url('admin/tabel_barangkeluar') ?>">Tabel Barang Keluar</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <!-- /.box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-table" aria-hidden="true"></i> Stok Barang Masuk</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">

            <?php if ($this->session->flashdata('msg_berhasil')) { ?>
              <div class="alert alert-success alert-dismissible" style="width:100%">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong><br> <?php echo $this->session->flashdata('msg_berhasil'); ?>
              </div>
            <?php } ?>

            <a href="<?= base_url('admin/tabel_barangmasuk') ?>" style="margin-bottom:10px;" type="button" class="btn btn-primary" name="tambah_data"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data Keluar</a>
            <a href="<?= base_url('report/barangKeluarManual') ?>" style="margin-bottom:10px;" type="button" class="btn btn-danger" name="laporan_data"><i class="fa fa-file-text" aria-hidden="true"></i> Invoice Manual</a>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>ID Transaksi</th>
                  <th>Tanggal Masuk</th>
                  <th>Tanggal Keluar</th>
                  <th>Lokasi</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Jumlah</th>
                  <th>Details</th>
                  <th>Resignation</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php if (is_array($list_data)) { ?>
                    <?php $no = 1; ?>
                    <?php foreach ($list_data as $dd): ?>
                      <td><?= $no ?></td>
                      <td><?= $dd->id_transaksi ?></td>
                      <td><?= $dd->tanggal_masuk ?></td>
                      <td><?= $dd->tanggal_keluar ?></td>
                      <td><?= $dd->lokasi ?></td>
                      <td><?= $dd->kode_barang ?></td>
                      <td><?= $dd->nama_barang ?></td>
                      <td><?= $dd->satuan ?></td>
                      <td><?= $dd->jumlah ?></td>
                      <td><a type="button" class="btn btn-danger btn-report" href="<?= base_url('report/barangKeluar/' . $dd->id_transaksi . '/' . $dd->tanggal_keluar) ?>" name="btn_report" style="margin:auto;"><i class="fa fa-file-text" aria-hidden="true"></i></a></td>
                      <td><a type="button" class="btn btn-warning btn-report" href="<?= base_url('admin/form_resignation/' . $dd->id_transaksi . '/' . $dd->tanggal_keluar) ?>" name="btn_report" style="margin:auto;"><i class="fa fa-edit" aria-hidden="true"></i></a></td>
                </tr>
                <?php $no++; ?>
              <?php endforeach; ?>
            <?php } else { ?>
              <td colspan="7" align="center"><strong>Data Kosong</strong></td>
            <?php } ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>ID Transaksi</th>
                  <th>Tanggal Masuk</th>
                  <th>Tanggal Keluar</th>
                  <th>Lokasi</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Satuan</th>
                  <th>Jumlah</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
        </div>


        <!-- /.col -->
      </div>
      <!-- /.row -->
  </section>
  <!-- /.content -->
</div>