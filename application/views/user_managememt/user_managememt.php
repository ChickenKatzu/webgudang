<div class="content-wrapper">
    <section class="content-header">
        <h1>Master User Management</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User Management</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Daftar User</h3>
                        <div class="box-tools">
                            <?php if (has_access('user', 'create')): ?>
                                <a href="<?php echo site_url('user_management/create'); ?>" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Tambah User
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Nama Karyawan</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Last Login</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo $user->username; ?></td>
                                            <td><?php echo $user->nama_karyawan ?: 'N/A'; ?></td>
                                            <td><?php echo $user->email; ?></td>
                                            <td>
                                                <span class="label label-primary"><?php echo $user->role_name; ?></span>
                                            </td>
                                            <td><?php echo $user->last_login ? date('d/m/Y H:i', strtotime($user->last_login)) : 'Never'; ?></td>
                                            <td>
                                                <span class="label label-<?php echo $user->is_active ? 'success' : 'danger'; ?>">
                                                    <?php echo $user->is_active ? 'Aktif' : 'Nonaktif'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?php echo site_url('user_management/edit/' . $user->id); ?>" class="btn btn-sm btn-warning" <?php echo disable_if_no_access('user', 'update'); ?>>
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <?php if (has_access('user', 'delete') && $user->id != $this->session->userdata('id')): ?>
                                                        <button onclick="confirmDelete(<?php echo $user->id; ?>)" class="btn btn-sm btn-danger">
                                                            <i class="fa fa-trash"></i> Hapus
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function confirmDelete(userId) {
        if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
            window.location.href = '<?php echo site_url('user_management/delete/'); ?>' + userId;
        }
    }
</script>