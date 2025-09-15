<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>Form Master User (Karyawan)</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?= base_url('karyawan'); ?>">Karyawan</a></li>
            <li class="active"><?= isset($karyawan) ? 'Edit' : 'Tambah'; ?> Data</li>
        </ol>
    </section>

    <section class="content">
        <div class="container">
            <h3><?= isset($karyawan) ? 'Edit Data Karyawan' : 'Tambah Data Karyawan'; ?></h3>

            <?php if (validation_errors()) : ?>
                <div class="alert alert-danger"><?= validation_errors(); ?></div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('karyawan/simpan'); ?>">
                <?php if (isset($karyawan)) : ?>
                    <input type="hidden" name="id_karyawan" value="<?= $karyawan->id_karyawan; ?>">
                <?php endif; ?>

                <!-- Nama -->
                <div class="form-group">
                    <label>Nama Karyawan</label>
                    <input type="text" name="nama_karyawan" class="form-control" value="<?= isset($karyawan) ? $karyawan->nama_karyawan : set_value('nama_karyawan'); ?>" required>
                </div>

                <!-- Jabatan -->
                <div class="form-group">
                    <label>Jabatan</label>
                    <select name="jabatan" id="jabatanSelect" class="form-control" required>
                        <option value="leader" <?= (isset($karyawan) && $karyawan->jabatan == 'leader') ? 'selected' : ''; ?>>Leader</option>
                        <option value="supervisor" <?= (isset($karyawan) && $karyawan->jabatan == 'supervisor') ? 'selected' : ''; ?>>Supervisor</option>
                        <option value="team_leader" <?= (isset($karyawan) && $karyawan->jabatan == 'team_leader') ? 'selected' : ''; ?>>Team Leader</option>
                        <option value="staff" <?= (isset($karyawan) && $karyawan->jabatan == 'staff') ? 'selected' : ''; ?>>Staff</option>
                    </select>
                </div>

                <!-- Atasan -->
                <div class="form-group">
                    <label>Atasan</label>
                    <select name="id_atasan" id="atasanSelect" class="form-control">
                        <option value="">-- Tidak Ada --</option>
                        <?php foreach ($list_atasan as $atasan) : ?>
                            <!-- Jangan tampilkan diri sendiri di dropdown atasan saat edit -->
                            <?php if (!(isset($karyawan) && $atasan->id_karyawan == $karyawan->id_karyawan)) : ?>
                                <option value="<?= $atasan->id_karyawan; ?>" <?= (isset($karyawan) && $karyawan->id_atasan == $atasan->id_karyawan) ? 'selected' : ''; ?>>
                                    <?= $atasan->nama_karyawan . ' (' . $atasan->jabatan . ')'; ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="aktif" <?= (isset($karyawan) && $karyawan->status == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                        <option value="resign" <?= (isset($karyawan) && $karyawan->status == 'resign') ? 'selected' : ''; ?>>Resign</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= site_url('karyawan'); ?>" class="btn btn-default">Kembali</a>
            </form>
        </div>
    </section>
</div>

<!-- Script untuk menangani enable/disable dropdown atasan -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jabatanSelect = document.getElementById('jabatanSelect');
        const atasanSelect = document.getElementById('atasanSelect');

        // Fungsi untuk toggle dropdown atasan
        function toggleAtasanField() {
            if (jabatanSelect.value === 'leader') {
                atasanSelect.disabled = true;
                atasanSelect.value = ''; // Kosongkan nilai karena leader tidak punya atasan
            } else {
                atasanSelect.disabled = false;
            }
        }

        // Jalankan fungsi saat halaman pertama kali load
        toggleAtasanField();

        // Jalankan fungsi setiap kali jabatan berubah
        jabatanSelect.addEventListener('change', toggleAtasanField);
    });
</script>