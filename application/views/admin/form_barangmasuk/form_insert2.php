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
    <div class="row">
      <div class="col-sm-6">
        <div class="container">
          <!-- flashdata notification start -->
          <?php if ($this->session->flashdata('msg_berhasil')) { ?>
            <div class="alert alert-success alert-dismissible text-left">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong><br> <?php echo $this->session->flashdata('msg_berhasil'); ?>
            </div>
          <?php } ?>

          <?php if (validation_errors()) { ?>
            <div class="alert alert-warning alert-dismissible">
              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Warning!</strong><br> <?php echo validation_errors(); ?>
            </div>
          <?php } ?>
          <!-- flashdata notification end -->
          <div class="col-md-6 col-md-offset-3">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-archive" aria-hidden="true"></i> Tambah Data Barang Masuk</h3>
              </div>
              <!-- FORM INSERT START -->
              <div class="box-body" style="padding-left: 50px; padding-right: 50px; margin-top: 50px; margin-bottom: 50px;">
                <form id="contactForm">
                  <!-- Nama -->
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" id="nama" placeholder="Nama" required>
                  </div>

                  <!-- Nama Aset -->
                  <div class="form-group">
                    <label for="namaAset">Nama Aset</label>
                    <input type="text" class="form-control" id="namaAset" placeholder="Nama Aset" required>
                  </div>

                  <!-- Kode Aset -->
                  <div class="form-group">
                    <label for="kodeAset">Kode Aset</label>
                    <input type="text" class="form-control" id="kodeAset" placeholder="Kode Aset" required>
                  </div>

                  <!-- Lokasi Dropdown -->
                  <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                    <select class="form-control" id="lokasi">
                      <option value="-">-</option>
                      <option value="Cideng">Cideng</option>
                      <option value="Bungur">Bungur</option>
                      <option value="Capital Place">Capital Place</option>
                    </select>
                  </div>

                  <!-- Departemen Dropdown -->
                  <div class="form-group">
                    <label for="departement">Departement</label>
                    <select class="form-control" id="departement">
                      <option value="-">-</option>
                      <option value="Accounting">Accounting</option>
                      <option value="Collection">Collection</option>
                      <option value="Customer Service">Customer Service</option>
                      <option value="Finance">Finance</option>
                      <option value="HR">HR</option>
                      <option value="IT">IT</option>
                      <option value="Manager">Manager</option>
                    </select>
                  </div>

                  <!-- Condition -->
                  <div class="form-group">
                    <label for="condition">Condition</label>
                    <select class="form-control" id="condition">
                      <option value="-">-</option>
                      <option value="Return">Return</option>
                      <option value="Good">Good</option>
                    </select>
                  </div>

                  <!-- Merk -->
                  <div class="form-group">
                    <label for="merk">Merk</label>
                    <input type="text" class="form-control" id="merk" placeholder="Merk" required>
                  </div>

                  <!-- Type -->
                  <div class="form-group">
                    <label for="type">Type</label>
                    <select class="form-control" id="type">
                      <option value="-">-</option>
                      <option value="Laptop">Laptop</option>
                      <option value="Monitor">Monitor</option>
                      <option value="Charger">Charger</option>
                      <option value="Mouse">Mouse</option>
                      <option value="Headset">Headset</option>
                    </select>
                  </div>

                  <!-- RAM Dropdown -->
                  <div class="form-group">
                    <label for="ram">Ram</label>
                    <select class="form-control" id="ram">
                      <option value="-">-</option>
                      <option value="Ram 4">Ram 4</option>
                      <option value="Ram 8">Ram 8</option>
                      <option value="Ram 16">Ram 16</option>
                      <option value="Ram 32">Ram 32</option>
                      <option value="Ram 64">Ram 64</option>
                    </select>
                  </div>

                  <!-- Operating System -->
                  <div class="form-group">
                    <label for="operatingSystem">Operating System</label>
                    <input type="text" class="form-control" id="operatingSystem" placeholder="Operating System" required>
                  </div>

                  <!-- CHM Checkboxes -->
                  <div class="form-group">
                    <label>CHM</label>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="chm" id="mouse"> Mouse
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="chm" id="charger"> Charger
                      </label>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="chm" id="headset"> Headset
                      </label>
                    </div>
                  </div>

                  <!-- CHM Code -->
                  <div class="form-group">
                    <label for="chmCode">CHM Code</label>
                    <input type="text" class="form-control" id="chmCode" placeholder="CHM Code" required>
                  </div>

                  <!-- Serial Number -->
                  <div class="form-group">
                    <label for="sNSerialNumber">S/N : Serial Number</label>
                    <input type="text" class="form-control" id="sNSerialNumber" placeholder="S/N : Serial Number" required>
                  </div>

                  <!-- Condition Details -->
                  <div class="form-group">
                    <label for="conditionDetails">Condition Details</label>
                    <input type="text" class="form-control" id="conditionDetails" placeholder="Condition Details" required>
                  </div>

                  <!-- Submit Button -->
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
                  </div>
                </form>
              </div>
              <!-- FORM INSERT END -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- input form end -->

</div>