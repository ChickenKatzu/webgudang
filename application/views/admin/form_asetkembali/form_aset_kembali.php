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

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Konfirmasi Pengembalian Aset</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Kode Aset</th>
                            <td><?php echo $aset->kode_aset; ?></td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td><?php echo $aset->nama_barang; ?></td>
                        </tr>
                        <tr>
                            <th>Merk</th>
                            <td><?php echo $aset->merk; ?></td>
                        </tr>
                        <tr>
                            <th>Tipe</th>
                            <td><?php echo $aset->tipe; ?></td>
                        </tr>
                    </table>

                    <p class="lead">Apakah Anda yakin ingin mengembalikan aset ini?</p>
                    <p>Aset akan kembali tersedia untuk dipinjam oleh orang lain.</p>

                    <form method="post" action="<?php echo site_url('aset/kembalikan/' . $aset->kode_aset); ?>">
                        <button type="submit" class="btn btn-success">
                            <i class="glyphicon glyphicon-ok"></i> Ya, Kembalikan
                        </button>
                        <a href="<?php echo site_url('aset/list_keluar'); ?>" class="btn btn-danger">
                            <i class="glyphicon glyphicon-remove"></i> Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- input form end -->

</div>