<div class="row">
  <div class="col-xl-12 order-xl-1">
    <div class="card">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col-8">
            <h3 class="mb-0">List Book </h3>
          </div>
          <div class="col-4 text-right">
            <a href="<?= base_url('controllers/Book.php?type=create') ?>" class="btn btn-sm btn-primary"><i class="ni ni-fat-add"></i> Add</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <?php
          if (isset($_SESSION['success']) && $_SESSION['success']) {
        ?>
          <div class="alert alert-success">
            <strong>Info! </strong> <?= $_SESSION['success'] ?>
          </div>
        <?php
            unset($_SESSION['success']);
          }
        ?>

        <?php
          if (isset($_SESSION['error']) && $_SESSION['error']) {
        ?>
          <div class="alert alert-danger">
            <strong>Info! </strong> <?= $_SESSION['error'] ?>
          </div>
        <?php
            unset($_SESSION['error']);
          }
        ?>

        <div class="table-responsive py-4">
          <table class="table dt_table table-flush table-vertical-align" id="datatable-buttons">
            <thead class="thead-light">
              <tr>
                <th>Action</th>
                <th>Cover</th>
                <th>Code Book</th>
                <th>Name</th>
                <th>Summary</th>
                <th>Author Name</th>
              </tr>
            </thead>
            <tbody>
            <?php
              if(isset($data['result']) && count($data['result']) > 0){
                foreach($data['result'] as $item) {
            ?>
              <tr>
                <td>
                  <a href="<?= base_url('controllers/Book.php?type=detail&id='.$item['id']) ?>" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> detail</a>  
                  <a href="<?= base_url('controllers/Book.php?type=update&id='.$item['id']) ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> edit</a>
                  <a href="<?= base_url('controllers/Book.php?type=delete_action&id='.$item['id']) ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> delete</a>
                </td>
                <td><img onerror="this.src='<?= asset('/assets/img/theme/team-3.jpg') ?>'" src="<?= base_url('/uploads/'.$item['cover']) ?>" class="avatar avatar-xs" ></td>
                <td><?= $item['code'] ?></td>
                <td><?= $item['name'] ?></td>
                <td><?= strlen($item['summary']) > 100 ? substr($item['summary'], 0, 100).'...' : $item['summary'] ?></td>
                <td><?= $item['author_name'] ?></td>
              </tr>
            <?php
                }
              }
            ?>
            </tbody>
            <tfoot>
              <tr>
                <th>Action</th>
                <th>Cover</th>
                <th>Code Book</th>
                <th>Name</th>
                <th>Summary</th>
                <th>Author Name</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>