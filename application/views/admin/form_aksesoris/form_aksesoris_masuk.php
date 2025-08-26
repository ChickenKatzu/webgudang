    <!-- Content Wrapper. Contains page content -->
    <!-- File: application/views/admin/form_aksesoris/form_tambah_aksesoris.php -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                <?php echo $data['title']; ?>
                <small>Tambah Aksesoris Aset</small>
            </h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Form Tambah Aksesoris</h3>
                        </div>

                        <form method="post" action="<?php echo site_url('aset/aksesoris_masuk'); ?>">
                            <div class="form-group">
                                <label>Jenis Aksesoris</label>
                                <select name="jenis_aksesoris" class="form-control" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="Headset">Headset</option>
                                    <option value="Mouse">Mouse</option>
                                    <option value="Charger">Charger</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function generateKodeAksesoris() {
            var jenisAksesoris = document.getElementById('jenis_aksesoris').value;

            if (jenisAksesoris !== '') {
                // Kirim permintaan AJAX untuk generate kode
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '<?php echo site_url("aset/generate_kode_aksesoris_ajax"); ?>', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            document.getElementById('kode_aksesoris_display').value = response.kode_aksesoris;
                            document.getElementById('kode_aksesoris').value = response.kode_aksesoris;
                        } else {
                            alert('Gagal generate kode aksesoris: ' + response.message);
                        }
                    }
                };
                xhr.send('jenis_aksesoris=' + encodeURIComponent(jenisAksesoris));
            } else {
                document.getElementById('kode_aksesoris_display').value = '';
                document.getElementById('kode_aksesoris').value = '';
            }
        }
    </script>