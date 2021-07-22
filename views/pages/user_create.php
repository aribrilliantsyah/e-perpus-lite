<div class="row">
  <div class="col-xl-12 order-xl-1">
    <div class="card">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col-8">
            <h3 class="mb-0"><?= isset($data['subtitle']) ? $data['subtitle'] : '' ?></h3>
          </div>
          <div class="col-4 text-right">
            <a href="<?= base_url('controllers/User.php') ?>" class="btn btn-sm btn-primary"><i class="fas fa-chevron-left"></i> Back</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <?php
          if (isset($_SESSION['validasi']) && $_SESSION['validasi']) {
        ?>
          <div class="alert alert-danger">
            <strong>Info! </strong> <?= $_SESSION['validasi'] ?>
          </div>
        <?php
            unset($_SESSION['validasi']);
          }
        ?>
        <form action="<?= isset($data['action']) ? $data['action'] : '' ?>" method="POST" enctype="multipart/form-data">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Username <span class="text-red">*</span></label>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Email address  <span class="text-red">*</span></label>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Full Name  <span class="text-red">*</span></label>
                <input type="text" name="fullname" class="form-control" placeholder="Full Name" required>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Role  <span class="text-red">*</span></label>
                <select name="role_id" class="form-control select2" required>
                  <?php 
                    if(isset($data['list_role']) && count($data['list_role']) > 0){
                      foreach($data['list_role'] as $item){
                        echo '<option value="'.$item['id'].'">'.$item['role'].'</option>';
                      }
                    }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Password  <span class="text-red">*</span></label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Repeat Password  <span class="text-red">*</span></label>
                <input type="password" name="repeat_password" class="form-control" placeholder="Repeat Password" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Avatar</label>
                <input type="file" name="avatar" class="form-control" placeholder="Avatar" accept="image/*">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <span class="text-red">* Required</span>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <button type="reset" class="btn btn-secondary"><i class="fas fa-undo-alt"></i> Reset</button>
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>