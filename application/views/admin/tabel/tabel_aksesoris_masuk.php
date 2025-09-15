<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tabel Aksesoris Masuk
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li>Tables</li>
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
        <div class="col-md-6">
          <a href="<?php echo site_url('aksesoris/masuk_aksesoris'); ?>" class="btn btn-primary">Tambah Aksesoris Masuk</a>
          <a href="<?php echo site_url('aset'); ?>" class="btn btn-default">Kembali</a>
        </div>
        <div class="col-md-6">
          <form method="get" action="<?php echo site_url('aksesoris/list_aksesoris'); ?>" class="form-inline pull-right">
            <div class="form-group">
              <input type="text" name="search" class="form-control" placeholder="Cari..." value="<?php echo $search; ?>">
            </div>
            <button type="submit" class="btn btn-default">Cari</button>
          </form>
        </div>
      </div>
      <table class="table table-bordered table-striped mt-3">
        <thead>
          <tr>
            <th>No</th>
            <th>
              <a href="<?= site_url('aksesoris/list_aksesoris?' . http_build_query(array_merge($_GET, ['sort_by' => 'tanggal_masuk', 'sort_order' => ($sort_by == 'tanggal_masuk' && $sort_order == 'asc') ? 'desc' : 'asc']))); ?>">
                Tanggal Masuk
                <?php if ($sort_by == 'tanggal_masuk'): ?>
                  <i class="fa fa-sort-<?= $sort_order == 'asc' ? 'asc' : 'desc'; ?>"></i>
                <?php else: ?>
                  <i class="fa fa-sort"></i>
                <?php endif; ?>
              </a>
            </th>
            <th>
              <a href="<?= site_url('aksesoris/list_aksesoris?' . http_build_query(array_merge($_GET, ['sort_by' => 'kode', 'sort_order' => ($sort_by == 'kode' && $sort_order == 'asc') ? 'desc' : 'asc']))); ?>">
                Kode
                <?php if ($sort_by == 'kode'): ?>
                  <i class="fa fa-sort-<?= $sort_order == 'asc' ? 'asc' : 'desc'; ?>"></i>
                <?php else: ?>
                  <i class="fa fa-sort"></i>
                <?php endif; ?>
              </a>
            </th>
            <th>
              <a href="<?= site_url('aksesoris/list_aksesoris?' . http_build_query(array_merge($_GET, ['sort_by' => 'jenis', 'sort_order' => ($sort_by == 'jenis' && $sort_order == 'asc') ? 'desc' : 'asc']))); ?>">
                Jenis
                <?php if ($sort_by == 'jenis'): ?>
                  <i class="fa fa-sort-<?= $sort_order == 'asc' ? 'asc' : 'desc'; ?>"></i>
                <?php else: ?>
                  <i class="fa fa-sort"></i>
                <?php endif; ?>
              </a>
            </th>
            <th>
              <a href="<?= site_url('aksesoris/list_aksesoris?' . http_build_query(array_merge($_GET, ['sort_by' => 'merk', 'sort_order' => ($sort_by == 'merk' && $sort_order == 'asc') ? 'desc' : 'asc']))); ?>">
                Merk
                <?php if ($sort_by == 'merk'): ?>
                  <i class="fa fa-sort-<?= $sort_order == 'asc' ? 'asc' : 'desc'; ?>"></i>
                <?php else: ?>
                  <i class="fa fa-sort"></i>
                <?php endif; ?>
              </a>
            </th>
            <th>
              <a href="<?= site_url('aksesoris/list_aksesoris?' . http_build_query(array_merge($_GET, ['sort_by' => 'lokasi', 'sort_order' => ($sort_by == 'lokasi' && $sort_order == 'asc') ? 'desc' : 'asc']))); ?>">
                Lokasi
                <?php if ($sort_by == 'lokasi'): ?>
                  <i class="fa fa-sort-<?= $sort_order == 'asc' ? 'asc' : 'desc'; ?>"></i>
                <?php else: ?>
                  <i class="fa fa-sort"></i>
                <?php endif; ?>
              </a>
            </th>
            <th>
              <a href="<?= site_url('aksesoris/list_aksesoris?' . http_build_query(array_merge($_GET, ['sort_by' => 'kondisi', 'sort_order' => ($sort_by == 'kondisi' && $sort_order == 'asc') ? 'desc' : 'asc']))); ?>">
                Kondisi
                <?php if ($sort_by == 'kondisi'): ?>
                  <i class="fa fa-sort-<?= $sort_order == 'asc' ? 'asc' : 'desc'; ?>"></i>
                <?php else: ?>
                  <i class="fa fa-sort"></i>
                <?php endif; ?>
              </a>
            </th>
            </th>
            <th>
              <a href="<?= site_url('aksesoris/list_aksesoris?' . http_build_query(array_merge($_GET, ['sort_by' => 'status', 'sort_order' => ($sort_by == 'status' && $sort_order == 'asc') ? 'desc' : 'asc']))); ?>">
                Status
                <?php if ($sort_by == 'status'): ?>
                  <i class="fa fa-sort-<?= $sort_order == 'asc' ? 'asc' : 'desc'; ?>"></i>
                <?php else: ?>
                  <i class="fa fa-sort"></i>
                <?php endif; ?>
              </a>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($aksesoris)): ?>
            <?php foreach ($aksesoris as $index => $item): ?>
              <tr>
                <td><?php echo $page + $index + 1; ?></td>
                <td><?php echo date('d-m-Y', strtotime($item->tanggal_masuk)); ?></td>
                <td><?php echo $item->kode; ?></td>
                <td><?php echo $item->jenis; ?></td>
                <td><?php echo $item->merk; ?></td>
                <td><?php echo $item->lokasi; ?></td>
                <td><?php echo $item->kondisi; ?></td>
                <td><?php echo $item->status; ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center">Tidak ada data ditemukan</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
      <div class="row">
        <div class="col-md-6">
          <p>Total Aksesoris: <?php echo $this->M_aksesoris->count_all_aksesoris_masuk($search); ?></p>
        </div>
        <div class="col-md-6 text-right">
          <?php echo $pagination; ?>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Include FontAwesome for sort icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Handle sorting links
    $('th a').on('click', function(e) {
      e.preventDefault();
      window.location.href = $(this).attr('href');
    });
  });
</script>