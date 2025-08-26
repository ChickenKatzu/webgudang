</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 2.4.0
  </div>
  <strong>Adapundi Reserved &copy; <?= date('Y') ?></strong>
</footer>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url() ?>assets/web_admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url() ?>assets/web_admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url() ?>assets/web_admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url() ?>assets/web_admin/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>assets/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?php echo base_url() ?>assets/web_admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url() ?>assets/web_admin/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>assets/web_admin/dist/js/demo.js"></script>

<!-- JS addon -->
<!-- jquery version -->
<!-- <script>
    $(document).ready(function() {
      $('#kategori').change(function() {
        let kategori = $(this).val();
        let alias = $('#kategori option:selected').data('alias');
        let bulan = ("0" + (new Date().getMonth() + 1)).slice(-2); // 01-12
        let nomorUrut = Math.floor(Math.random() * 9000) + 1000; // Contoh random 4 digit

        if (kategori) {
          let idTransaksi = `${kategori}/${alias}-${bulan}-${nomorUrut}`;
          $('#id_transaksi').val(idTransaksi);
        } else {
          $('#id_transaksi').val('');
        }
      });
    });
  </script> -->
<!-- ajax version -->
<!-- <script>
    $(document).ready(function() {
      $('#kategori').change(function() {
        var kategori = $(this).val();

        if (kategori !== '') {
          $.ajax({
            url: "<?= base_url('admin/generate_id_ajax'); ?>", // GANTI ke method baru!
            type: "POST",
            dataType: "json",
            data: {
              kategori: kategori
            },
            success: function(response) {
              if (response.status === 'success') {
                $('#id_transaksi').val(response.id_transaksi);
              } else {
                alert('Gagal: ' + response.message);
              }
            },
            error: function() {
              alert('Gagal generate ID Transaksi. Coba lagi.');
            }
          });
        } else {
          $('#id_transaksi').val('');
        }
      });
    });
  </script> -->

<!-- <script>
    $(document).ready(function() {
      $('select[name="kategori"]').on('change', function() {
        var kategori = $(this).val();
        if (kategori != '') {
          $.ajax({
            url: "<?= base_url('admin/get_id_transaksi') ?>",
            method: "POST",
            data: {
              kategori: kategori
            },
            success: function(data) {
              $('input[name="id_transaksi"]').val(data);
            }
          });
        }
      });
    });
  </script> -->

<!-- <script>
    $(document).ready(function() {
      $('#kategori, #lokasi').on('change', function() {
        let lokasi = $('#lokasi').val();
        let kategori = $('#kategori').val();

        if (lokasi && kategori) {
          $.ajax({
            url: "<?= base_url('admin/get_id_transaksi') ?>",
            method: "POST",
            data: {
              lokasi: lokasi,
              kategori: kategori
            },
            dataType: "json",
            success: function(data) {
              $('#id_transaksi').val(data.id_transaksi);
            }
          });
        }
      });
    });
  </script> -->


<!-- on click close -->
<script>
  $(document).ready(function() {
    // Cek localStorage, jika sudah di-close sebelumnya, jangan tampilkan
    if (localStorage.getItem('alert-success-dismissed')) {
      $('#success-alert').remove(); // Hapus alert jika sudah pernah di-close
    }

    // Saat tombol close diklik, simpan status di localStorage
    $('[data-dismiss="alert"]').on('click', function() {
      localStorage.setItem('alert-success-dismissed', 'true');
    });

    // Optional: Reset status localStorage saat berpindah halaman
    $(window).on('beforeunload', function() {
      localStorage.removeItem('alert-success-dismissed');
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#kategori, #lokasi').change(function() {
      var kategori = $('#kategori').val();
      var lokasi = $('#lokasi').val();

      if (kategori !== "" && lokasi !== "") {
        $.ajax({
          url: "<?= base_url('admin/get_id_transaksi') ?>",
          type: "POST",
          data: {
            kategori: kategori,
            lokasi: lokasi
          },
          dataType: "json",
          success: function(response) {
            $('#id_transaksi').val(response.id_transaksi);
          }
        });
      }
    });
  });
</script>


<script>
  $(document).ready(function() {
    $('#kategori, #lokasi').change(function() {
      var kategori = $('#kategori').val();
      var lokasi = $('#lokasi').val();

      if (kategori !== "" && lokasi !== "") {
        $.ajax({
          url: "<?= base_url('admin/get_id_transaksi') ?>",
          type: "POST",
          data: {
            kategori: kategori,
            lokasi: lokasi
          },
          dataType: "json",
          success: function(response) {
            $('#id_transaksi').val(response.id_transaksi);
          }
        });
      }
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#status').on('change', function() {
      var status = $(this).val();

      if (status === 'new') {
        $('#user').prop('readonly', true).css('background-color', '#e9ecef'); // Bootstrap style readonly
      } else if (status === 'resign') {
        $('#user').prop('readonly', false).css('background-color', '#ffffff');
      } else {
        $('#user').prop('readonly', true).css('background-color', '#e9ecef'); // default: readonly
      }
    });

    // Trigger on page load (kalau status sudah terisi)
    $('#status').trigger('change');
  });
</script>

<script>
  jQuery(document).ready(function($) {
    $('.btn-delete').on('click', function() {
      var getLink = $(this).attr('href');
      swal({
        title: 'Delete Data',
        text: 'Yakin Ingin Menghapus Data ?',
        html: true,
        confirmButtonColor: '#d9534f',
        showCancelButton: true,
      }, function() {
        window.location.href = getLink
      });
      return false;
    });
  });

  $(function() {
    $('#example1').DataTable();
    $('#example2').DataTable({
      'paging': true,
      'lengthChange': false,
      'searching': false,
      'ordering': true,
      'info': true,
      'autoWidth': false
    })
  });
</script>
<!-- datepicker -->
<script type="text/javascript">
  $(".form_datetime").datetimepicker({
    format: 'dd/mm/yyyy',
    autoclose: true,
    todayBtn: true,
    pickTime: false,
    minView: 2,
    maxView: 4,
  });
</script>

<!-- script for sort -->
<script>
  $(document).ready(function() {
    // Handler untuk perubahan jumlah item per halaman
    $('#per_page').change(function() {
      var perPage = $(this).val();
      var url = new URL(window.location.href);
      url.searchParams.set('per_page', perPage);
      url.searchParams.set('page', 1); // Reset ke halaman 1
      window.location.href = url.toString();
    });
  });
</script>
<!-- gudang -->

<!-- form aset keluar -->
<script>
  document.getElementById('id_karyawan').addEventListener('change', function() {
    var selected = this.options[this.selectedIndex];
    var jabatan = selected.getAttribute('data-jabatan');
    var nama = selected.text;

    document.getElementById('posisi_penerima').value = jabatan;
    document.getElementById('nama_penerima').value = nama;
  });
</script>

<!-- <script>
  function generateKodeGudang() {
    var nama = document.getElementById('nama_gudang').value;
    var lokasi = document.getElementById('lokasi_gudang').value;

    if (nama && lokasi) {
      // Kirim permintaan AJAX untuk generate kode
      $.ajax({
        url: '<?php echo site_url("aset/generate_kode_ajax"); ?>',
        type: 'POST',
        data: {
          nama_gudang: nama,
          lokasi_gudang: lokasi
        },
        success: function(response) {
          var result = JSON.parse(response);
          if (result.success) {
            document.getElementById('kode_gudang_display').value = result.kode;
            document.getElementById('kode_gudang').value = result.kode;
          }
        }
      });
    }
  }
</script> -->
<script>
  function generateKodeGudang() {
    var lokasi = document.getElementById('lokasi_gudang').value;

    if (lokasi) {
      // Kirim permintaan AJAX untuk generate kode
      $.ajax({
        url: '<?php echo site_url("aset/generate_kode_ajax"); ?>',
        type: 'POST',
        data: {
          lokasi_gudang: lokasi
        },
        success: function(response) {
          var result = JSON.parse(response);
          if (result.success) {
            document.getElementById('kode_gudang_display').value = result.kode;
            document.getElementById('kode_gudang').value = result.kode;
          }
        }
      });
    }
  }
</script>
</body>

</html>