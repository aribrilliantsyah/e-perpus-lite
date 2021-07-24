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
        <div class="row">
          <div class="col-lg-3">
          <img class="avathar rounded-circle" style="width: 100%;height: auto;" onerror="this.src='<?= asset('/assets/img/theme/team-3.jpg') ?>'" src="<?= base_url('uploads/cover/'.$data['detail']['cover']) ?>">
          </div>
          <div class="col-lg-9">
            <table class="table table-bordered">
              <tr>
                <td width="30%">Code Book</td>
                <td><?= isset($data['detail']['code']) ? $data['detail']['code'] : '' ?></td>
              </tr>
              <tr>
                <td width="30%">Name</td>
                <td><?= isset($data['detail']['name']) ? $data['detail']['name'] : '' ?></td>
              </tr>
              <tr>
                <td width="30%">Summary</td>
                <td><?= isset($data['detail']['summary']) ? $data['detail']['summary'] : '' ?></td>
              </tr>
              <tr>
                <td width="30%">Author</td>
                <td><?= isset($data['detail']['author_name']) ? $data['detail']['author_name'] : '' ?></td>
              </tr>
              <tr>
                <td width="30%">Stock</td>
                <td><?= isset($data['detail']['stock']) ? $data['detail']['stock'] : '' ?></td>
              </tr>
              <tr>
                <td width="30%">Created at</td>
                <td><?= isset($data['detail']['created_at']) ? $data['detail']['created_at'] : '' ?></td>
              </tr>
              <tr>
                <td width="30%">Created by</td>
                <td><?= isset($data['detail']['created_name']) ? $data['detail']['created_name'] : '' ?></td>
              </tr>
              <tr>
                <td width="30%">Updated at</td>
                <td><?= isset($data['detail']['updated_at']) ? $data['detail']['updated_at'] : '' ?></td>
              </tr>
              <tr>
                <td width="30%">Updated by</td>
                <td><?= isset($data['detail']['updated_name']) ? $data['detail']['updated_name'] : '' ?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>