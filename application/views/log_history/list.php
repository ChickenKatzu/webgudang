<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= $title; ?>
            <small>Audit Trail Sistem</small>
        </h1>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Filter Log</h3>
                    </div>
                    <form method="get" action="<?= site_url('log_history/filter'); ?>">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Tipe Aksi</label>
                                        <select name="action_type" class="form-control">
                                            <option value="">- Semua -</option>
                                            <option value="insert" <?= (isset($filters['action_type']) && $filters['action_type'] == 'insert') ? 'selected' : ''; ?>>Insert</option>
                                            <option value="update" <?= (isset($filters['action_type']) && $filters['action_type'] == 'update') ? 'selected' : ''; ?>>Update</option>
                                            <option value="delete" <?= (isset($filters['action_type']) && $filters['action_type'] == 'delete') ? 'selected' : ''; ?>>Delete</option>
                                            <option value="login" <?= (isset($filters['action_type']) && $filters['action_type'] == 'login') ? 'selected' : ''; ?>>Login</option>
                                            <option value="logout" <?= (isset($filters['action_type']) && $filters['action_type'] == 'logout') ? 'selected' : ''; ?>>Logout</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Tabel</label>
                                        <select name="table_name" class="form-control">
                                            <option value="">- Semua -</option>
                                            <option value="karyawan" <?= (isset($filters['table_name']) && $filters['table_name'] == 'karyawan') ? 'selected' : ''; ?>>Karyawan</option>
                                            <option value="tb_aset_masuk" <?= (isset($filters['table_name']) && $filters['table_name'] == 'tb_aset_masuk') ? 'selected' : ''; ?>>Aset Masuk</option>
                                            <option value="tb_aset_keluar" <?= (isset($filters['table_name']) && $filters['table_name'] == 'tb_aset_keluar') ? 'selected' : ''; ?>>Aset Keluar</option>
                                            <option value="mutasi_aset" <?= (isset($filters['table_name']) && $filters['table_name'] == 'mutasi_aset') ? 'selected' : ''; ?>>Mutasi Aset</option>
                                            <option value="user" <?= (isset($filters['table_name']) && $filters['table_name'] == 'user') ? 'selected' : ''; ?>>User</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Kode Aset</label>
                                        <input type="text" name="kode_aset" class="form-control" value="<?= isset($filters['kode_aset']) ? $filters['kode_aset'] : ''; ?>" placeholder="Masukkan kode aset">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tanggal Mulai</label>
                                        <input type="date" name="start_date" class="form-control" value="<?= isset($filters['start_date']) ? $filters['start_date'] : ''; ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tanggal Akhir</label>
                                        <input type="date" name="end_date" class="form-control" value="<?= isset($filters['end_date']) ? $filters['end_date'] : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
                            <a href="<?= site_url('log_history'); ?>" class="btn btn-default">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="box box-solid">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Waktu</th>
                                        <th width="10%">User</th>
                                        <th width="10%">Aksi</th>
                                        <th width="15%">Tabel</th>
                                        <th width="20%">Deskripsi</th>
                                        <th width="10%">Kode Aset</th>
                                        <th width="15%">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($logs)) : ?>
                                        <?php $no = $this->uri->segment(3) + 1; ?>
                                        <?php foreach ($logs as $log) : ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= date('d M Y H:i:s', strtotime($log->created_at)); ?></td>
                                                <td><?= $log->username ? $log->username : 'User#' . $log->id_user; ?></td>
                                                <td>
                                                    <?php
                                                    $badge_color = 'secondary';
                                                    if ($log->action_type == 'insert') $badge_color = 'success';
                                                    if ($log->action_type == 'update') $badge_color = 'warning';
                                                    if ($log->action_type == 'delete') $badge_color = 'danger';
                                                    if ($log->action_type == 'login') $badge_color = 'info';
                                                    if ($log->action_type == 'logout') $badge_color = 'primary';
                                                    ?>
                                                    <span class="badge bg-<?= $badge_color; ?>"><?= strtoupper($log->action_type); ?></span>
                                                </td>
                                                <td><?= $log->table_name; ?></td>
                                                <td><?= $log->description; ?></td>
                                                <td><?= $log->kode_aset; ?></td>
                                                <td>
                                                    <?php if (!empty($log->old_data) || !empty($log->new_data)) : ?>
                                                        <button type="button" class="btn btn-xs btn-info btn-detail" data-logid="<?= $log->id_log; ?>" data-old='<?= $log->old_data; ?>' data-new='<?= $log->new_data; ?>'>
                                                            <i class="fa fa-eye"></i> Detail
                                                        </button>
                                                    <?php else : ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data log history</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?= $pagination; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal untuk detail -->
<div class="modal fade" id="detailModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Detail Perubahan Data</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>Data Lama</h4>
                        <pre id="old-data" class="json-display"></pre>
                    </div>
                    <div class="col-md-6">
                        <h4>Data Baru</h4>
                        <pre id="new-data" class="json-display"></pre>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle tombol detail
        $('.btn-detail').click(function() {
            var oldData = $(this).data('old');
            var newData = $(this).data('new');

            // Format JSON dengan pretty print
            $('#old-data').html(oldData ? JSON.stringify(JSON.parse(oldData), null, 2) : 'Tidak ada data');
            $('#new-data').html(newData ? JSON.stringify(JSON.parse(newData), null, 2) : 'Tidak ada data');

            $('#detailModal').modal('show');
        });
    });
</script>

<style>
    .json-display {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 4px;
        max-height: 400px;
        overflow-y: auto;
    }
</style>