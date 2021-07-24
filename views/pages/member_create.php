<div class="row">
  <div class="col-xl-12 order-xl-1">
    <div class="card">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col-8">
            <h3 class="mb-0"><?= isset($data['subtitle']) ? $data['subtitle'] : '' ?></h3>
          </div>
          <div class="col-4 text-right">
            <a href="<?= base_url('controllers/Member.php') ?>" class="btn btn-sm btn-primary"><i class="fas fa-chevron-left"></i> Back</a>
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
                <label class="form-control-label">Code Member <span class="text-red">*</span></label>
                <input type="text" name="code" class="form-control" placeholder="Code member" value="<?= $data['code_member'] ?>" required readonly> 
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Name Member  <span class="text-red">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="Name Member" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Address  <span class="text-red">*</span></label>
                <textarea class="form-control" name="address" rows="3"></textarea>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Gender  <span class="text-red">*</span></label>
                <select name="gender" class="form-control select2" required>
                  <?php 
                    if(isset($data['list_gender']) && count($data['list_gender']) > 0){
                      foreach($data['list_gender'] as $item){
                        echo '<option value="'.$item.'">'.$item.'</option>';
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
                <label class="form-control-label">Profession  <span class="text-red">*</span></label>
                <input type="text" name="profession" class="form-control" placeholder="Profession" required>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Photo</label>
                <input type="file" name="photo" class="form-control" placeholder="Photo" accept="image/*">
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