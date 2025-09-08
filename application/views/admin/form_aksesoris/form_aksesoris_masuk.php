<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <nav class="breadrumb">
            <h1>
                Input Data Aksesoris Masuk
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Forms</a></li>
                <li class="active">Data Aksesoris Masuk</li>
            </ol>
        </nav>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container">
            <h2><?php echo $title; ?></h2>

            <?php if (validation_errors()): ?>
                <div class="alert alert-danger">
                    <?php echo validation_errors(); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <form method="post" action="<?php echo site_url('aksesoris/simpan'); ?>" id="formAksesoris">
                <div class="form-group">
                    <label>Pilih Jenis Aksesoris:</label><br>
                    <label class="checkbox-inline">
                        <input type="checkbox" id="checkC" name="jenis[]" value="C"> Charger (C)
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" id="checkH" name="jenis[]" value="H"> Headset (H)
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" id="checkM" name="jenis[]" value="M"> Mouse (M)
                    </label>
                </div>

                <div id="inputFields">
                    <!-- Input fields akan muncul di sini berdasarkan checkbox yang dipilih -->
                </div>

                <div class="form-group">
                    <label>Merk</label>
                    <input type="text" name="merk" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Lokasi</label>
                    <select name="lokasi" class="form-control" required>
                        <option value="">Pilih Lokasi</option>
                        <option value="cideng">Cideng</option>
                        <option value="bungur">Bungur</option>
                        <option value="cp">CP</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Kondisi</label>
                    <select name="kondisi" class="form-control" required>
                        <option value="">Pilih Kondisi</option>
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo site_url('aset'); ?>" class="btn btn-default">Kembali</a>
            </form>
        </div>
    </section>
    <!-- input form end -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Event ketika checkbox diubah
            $('input[name="jenis[]"]').change(function() {
                updateInputFields();
            });

            // Fungsi untuk mengupdate field input berdasarkan checkbox yang dipilih
            function updateInputFields() {
                $('#inputFields').empty();
                var selectedTypes = [];

                // Cek checkbox mana yang dipilih
                if ($('#checkC').is(':checked')) {
                    selectedTypes.push('C');
                }
                if ($('#checkH').is(':checked')) {
                    selectedTypes.push('H');
                }
                if ($('#checkM').is(':checked')) {
                    selectedTypes.push('M');
                }

                // Jika ada yang dipilih, ambil nomor urut dari server
                if (selectedTypes.length > 0) {
                    $.ajax({
                        url: '<?php echo site_url("aksesoris/get_next_numbers"); ?>',
                        type: 'POST',
                        data: {
                            types: selectedTypes
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 'success') {
                                // Buat input field untuk setiap jenis yang dipilih
                                $.each(response.data, function(type, nextNumber) {
                                    var fieldId = 'input' + type;
                                    var fieldName = 'kode_' + type.toLowerCase();
                                    var fieldValue = type + nextNumber.toString().padStart(4, '0');

                                    var inputField = `
                                <div class="form-group">
                                    <label>Kode ${type == 'C' ? 'Charger' : type == 'H' ? 'Headset' : 'Mouse'}</label>
                                    <input type="text" id="${fieldId}" name="${fieldName}" 
                                        value="${fieldValue}" class="form-control" readonly>
                                    <input type="hidden" name="jenis_${type.toLowerCase()}" value="${type}">
                                </div>
                            `;

                                    $('#inputFields').append(inputField);
                                });
                            } else {
                                alert('Error: ' + response.message);
                            }
                        },
                        error: function() {
                            alert('Error mengambil data dari server.');
                        }
                    });
                }
            }
        });
    </script>
</div>