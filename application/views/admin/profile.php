<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      User Profile
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= base_url('admin/profile') ?>" class="active">Profile</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
          <div class="box-body box-profile">
            <?php foreach ($avatar as $a) { ?>
              <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url() ?>assets/upload/user/img/<?= $a->nama_file ?>" alt="User profile picture">
            <?php } ?>
            <h3 class="profile-username text-center"><?= $this->session->userdata('name') ?></h3>

            <p class="text-muted text-center">Software Engineer</p><br>

            <?php if ($this->session->flashdata('msg_berhasil_gambar')) { ?>
              <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success</strong><br> <?php echo $this->session->flashdata('msg_berhasil_gambar'); ?>
              </div>
            <?php } ?>

            <?php if ($this->session->flashdata('msg_error_gambar')) { ?>
              <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Warning !</strong><br> <?php echo $this->session->flashdata('msg_error_gambar'); ?>
              </div>
            <?php } ?>

            <?php if (isset($pesan_error)) { ?>
              <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Warning!</strong><br> <?php echo $pesan; ?>
              </div>
            <?php } ?>

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->

        <!-- /.box -->
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#settings" data-toggle="tab">Change Password</a></li>
            <li><a href="#picture" data-toggle="tab">Change Picture</a></li>
          </ul>
          <div class="tab-content">

            <!-- /.tab-pane -->

            <!-- /.tab-pane -->

            <div class="tab-pane" id="picture">
              <form class="form-horizontal" action="<?= base_url('admin/proses_gambar_upload') ?>" method="post" enctype="multipart/form-data">

                <div class="form-group">
                  <label for="username" class="col-sm-2 control-label">Open Picture</label>

                  <div class="col-sm-10">
                    <input type="file" name="userpicture" class="form-control" id="username">
                  </div>
                </div>
                <?php if (isset($token_generate)) { ?>
                  <input type="hidden" name="token" class="form-control" value="<?= $token_generate ?>">
                <?php } else {
                  redirect(base_url('admin/profile'));
                } ?>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success"><i class="fa fa-send" aria-hidden="true"></i>&nbsp;Submit</button>
                  </div>
                </div>
              </form>
            </div>

            <div class="tab-pane active" id="settings">
              <form class="form-horizontal" action="<?= base_url('admin/proses_new_password') ?>" method="post">

                <?php if ($this->session->flashdata('msg_berhasil')) { ?>
                  <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success</strong><br> <?php echo $this->session->flashdata('msg_berhasil'); ?>
                  </div>
                <?php } ?>

                <?php if (validation_errors()) { ?>
                  <div class="alert alert-warning alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Warning!</strong><br> <?php echo validation_errors(); ?>
                  </div>
                <?php } ?>

                <div class="form-group">
                  <label for="username" class="col-sm-2 control-label">Username</label>

                  <div class="col-sm-10">
                    <input type="text" name="username" class="form-control" id="username" disabled="" value="<?= $this->session->userdata('name') ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="email" class="col-sm-2 control-label">Email</label>

                  <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" id="email" value="<?= $this->session->userdata('email') ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="new_password" class="col-sm-2 control-label">New Password</label>

                  <div class="col-sm-10">
                    <input type="password" name="new_password" class="form-control" id="new_password" placeholder="New Password">
                  </div>
                </div>
                <div class="form-group">
                  <label for="confirm_new_password" class="col-sm-2 control-label">Confirm New Password</label>

                  <div class="col-sm-10">
                    <input type="password" name="confirm_new_password" class="form-control" id="confirm_new_password" placeholder="Confirm New Password">
                  </div>
                </div>
                <?php if (isset($token_generate)) { ?>
                  <input type="hidden" name="token" class="form-control" value="<?= $token_generate ?>">
                <?php } else {
                  redirect(base_url('admin/profile'));
                } ?>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success"><i class="fa fa-send" aria-hidden="true"></i>&nbsp;Submit</button>
                  </div>
                </div>
              </form>
            </div>
            <!-- /.tab-pane -->
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- /.nav-tabs-custom -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->