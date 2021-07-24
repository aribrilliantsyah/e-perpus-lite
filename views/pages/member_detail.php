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
        <div class="row">
          <div class="col-lg-3">
          <img class="avathar rounded-circle" style="width: 100%;height: auto;" onerror="this.src='<?= asset('/assets/img/theme/team-3.jpg') ?>'" src="<?= base_url('uploads/cover/'.$data['detail']['cover']) ?>">
          </div>
          <div class="col-lg-9">
            <table class="table table-bordered">
              <tr>
                <td width="30%">Code Member</td>
                <td><?= isset($data['detail']['code']) ? $data['detail']['code'] : '' ?></td>
              </tr>
              <tr>
                <td width="30%">Full Name</td>
                <td><?= isset($data['detail']['full_name']) ? $data['detail']['full_name'] : '' ?></td>
              </tr>
              <tr>
                <td width="30%">Address</td>
                <td><?= isset($data['detail']['address']) ? $data['detail']['address'] : '' ?></td>
              </tr>
              <tr>
                <td width="30%">Gender</td>
                <td><?= isset($data['detail']['gender']) ? $data['detail']['gender'] : '' ?></td>
              </tr>
              <tr>
                <td width="30%">Profession</td>
                <td><?= isset($data['detail']['profession']) ? $data['detail']['profession'] : '' ?></td>
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