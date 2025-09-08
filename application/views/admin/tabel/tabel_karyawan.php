<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <h1>
            Tabel Karyawan
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= base_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Karyawan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container">
            <h2><?php echo $title; ?></h2>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible" id="success-alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6">
                    <a href="<?php echo site_url('master_user/tambah'); ?>" class="btn btn-primary">Tambah Karyawan</a>
                    <a href="<?php echo site_url('admin'); ?>" class="btn btn-default">Kembali</a>
                </div>
                <div class="col-md-6">
                    <form method="get" action="<?php echo site_url('karyawan/list'); ?>" class="form-inline pull-right">
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
                            <a href="<?= site_url('karyawan/list?' . http_build_query(array_merge($_GET, ['sort_by' => 'nama_karyawan', 'sort_order' => ($sort_by == 'nama_karyawan' && $sort_order == 'asc') ? 'desc' : 'asc']))); ?>">
                                Nama Karyawan
                                <?php if ($sort_by == 'nama_karyawan'): ?>
                                    <i class="fa fa-sort-<?= $sort_order == 'asc' ? 'asc' : 'desc'; ?>"></i>
                                <?php else: ?>
                                    <i class="fa fa-sort"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>Jabatan</th>
                        <th>Atasan</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($karyawan) > 0): ?>
                        <?php $no = $page + 1; ?>
                        <?php foreach ($karyawan as $row): ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $row->nama_karyawan; ?></td>
                                <td><?= ucfirst($row->jabatan); ?></td>
                                <td><?= $row->nama_atasan ?? '-'; ?></td>
                                <td>
                                    <span class="label label-<?= $row->status == 'aktif' ? 'success' : 'danger'; ?>">
                                        <?= ucfirst($row->status); ?>
                                    </span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($row->created_at)); ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($row->updated_at)); ?></td>
                                <td>
                                    <a href="<?= site_url('karyawan/edit/' . $row->id_karyawan); ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= site_url('karyawan/delete/' . $row->id_karyawan); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php $no++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data ditemukan</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="container">
                <nav class="text-center">
                    <ul class="pagination">
                        <?= $pagination; ?>
                    </ul>
                </nav>
            </div>

        </div>
    </section>
</div>