<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Tabel Users
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?= base_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?= base_url('admin/users') ?>" class="active">Users</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <!-- /.box -->
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-fw fa-users" aria-hidden="true"></i> Users</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">

            <?php if ($this->session->flashdata('msg_berhasil')) { ?>
              <div class="alert alert-success alert-dismissible" style="width:100%">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong><br> <?php echo $this->session->flashdata('msg_berhasil'); ?>
              </div>
            <?php } ?>

            <a href="<?= base_url('admin/form_user') ?>" style="margin-bottom:10px;" type="button" class="btn btn-primary" name="tambah_data"><i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data</a>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Last Login</th>
                  <th>Update</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <?php if (is_array($list_users)) { ?>
                    <?php foreach ($list_users as $dd): ?>
                      <td><?= $dd->username ?></td>
                      <td><?= $dd->email ?></td>
                      <?php if ($dd->role == 1) { ?>
                        <td>User Admin</td>
                      <?php } else { ?>
                        <td>User Biasa</td>
                      <?php } ?>
                      <td><?= $dd->last_login ?></td>
                      <td><a type="button" class="btn btn-info" href="<?= base_url('admin/update_user/' . $dd->id) ?>" name="btn_update" style="margin:auto;"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                      <td><a type="button" class="btn btn-danger btn-delete" href="<?= base_url('admin/proses_delete_user/' . $dd->id) ?>" name="btn_delete" style="margin:auto;"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>
              <?php endforeach; ?>
            <?php } else { ?>
              <td colspan="7" align="center"><strong>Data Kosong</strong></td>
            <?php } ?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>


        <!-- /.col -->
      </div>
      <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->