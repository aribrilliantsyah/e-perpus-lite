<div class="row">
  <div class="col-xl-12 order-xl-1">
    <div class="card">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col-8">
            <h3 class="mb-0"><?= isset($data['subtitle']) ? $data['subtitle'] : '' ?></h3>
          </div>
          <div class="col-4 text-right">
            <a href="<?= base_url('controllers/Book.php') ?>" class="btn btn-sm btn-primary"><i class="fas fa-chevron-left"></i> Back</a>
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
          <input type="hidden" name="id" value="<?= isset($data['detail']['id']) ? $data['detail']['id'] : '' ?>">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Code Book <span class="text-red">*</span></label>
                <input type="text" name="code" value="<?= isset($data['detail']['code']) ? $data['detail']['code'] : '' ?>" class="form-control" placeholder="Bookname" required readonly>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Name Book  <span class="text-red">*</span></label>
                <input type="text" name="name" value="<?= isset($data['detail']['name']) ? $data['detail']['name'] : '' ?>" class="form-control" placeholder="Name" required>
              </div>
            </div>
          </div>
          <div class="row">
           <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Summary  <span class="text-red">*</span></label>
                <textarea class="form-control" name="summary" rows="3"><?= isset($data['detail']['summary']) ? $data['detail']['summary'] : '' ?></textarea>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="form-group">
                <label class="form-control-label">Author  <span class="text-red">*</span></label>
                <select name="author_id" class="form-control select2" required>
                  <?php 
                    if(isset($data['list_author']) && count($data['list_author']) > 0){
                      foreach($data['list_author'] as $item){
                        if(isset($data['detail']['author_id']) && $item['id'] == $data['detail']['author_id']){
                          echo '<option value="'.$item['id'].'" selected>'.$item['author_name'].'</option>';
                        }else{
                          echo '<option value="'.$item['id'].'">'.$item['author_name'].'</option>';
                        }
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
                <label class="form-control-label">Cover</label>
                <input type="file" name="cover" class="form-control" placeholder="Cover" accept="image/*"  >
                <br>
                <img class="avatar rounded-circle" onerror="this.src='<?= asset('/assets/img/theme/team-3.jpg') ?>'" src="<?= base_url('uploads/cover/'.$data['detail']['cover']) ?>">
                <input type="hidden" name="current_cover" value="<?= isset($data['detail']['cover']) ? $data['detail']['cover'] : '' ?>">
              </div>
            </div>
          </div>
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