<div class="row">
  <div class="col-xl-3">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">All Members</h5>
            <span class="h2 font-weight-bold mb-0"><?= isset($data['all_member']) ? $data['all_member'] : '0' ?></span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-orange text-white rounded-circle shadow">
              <i class="ni ni-spaceship"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-sm">
          <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
          <span class="text-nowrap"></span>
        </p>
      </div>
    </div>
  </div>
  <div class="col-xl-3">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">Books Borrowed</h5>
            <span class="h2 font-weight-bold mb-0"><?= isset($data['books_borrowed']) ? $data['books_borrowed'] : '0' ?></span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-blue text-white rounded-circle shadow">
              <i class="ni ni-books"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-sm">
          <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
          <span class="text-nowrap"></span>
        </p>
      </div>
    </div>
  </div>
  <div class="col-xl-3">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">TOTAL ADMIN</h5>
            <span class="h2 font-weight-bold mb-0"><?= isset($data['admin_total']) ? $data['admin_total'] : '0' ?></span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-green text-white rounded-circle shadow">
              <i class="ni ni-settings"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-sm">
          <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
          <span class="text-nowrap"></span>
        </p>
      </div>
    </div>
  </div>
  <div class="col-xl-3">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">BOOKS RETURNED</h5>
            <span class="h2 font-weight-bold mb-0"><?= isset($data['books_returned']) ? $data['books_returned'] : '0' ?></span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
              <i class="fas fa-undo"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-sm">
          <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
          <span class="text-nowrap"></span>
        </p>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-xl-6">
    <div class="card">
      <div class="card-header border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="mb-0">Borrowing history</h3>
          </div>
          <div class="col text-right">
            <a href="<?= base_url('controllers/Borrow_log.php') ?>" class="btn btn-sm btn-primary">See all</a>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <!-- Projects table -->
        <table class="table align-items-center table-flush">
          <thead class="thead-light">
            <tr>
              <th scope="col">Member</th>
              <th scope="col">Book</th>
              <th scope="col">Date Transaction</th>
              <th scope="col">Returned?</th>
            </tr>
          </thead>
          <tbody>
          <?php if(isset($data['result']) && count($data['result']) > 0){ ?>
          <?php foreach($data['result'] as $item) { ?>
            <tr>
              <th scope="row"><span class=""><?= $item['full_name'] ?></span></th>
              <td><span class="badge badge-info"><?= $item['name'] ?></span></td>
              <td><?= date('d/m/Y H:i:s', strtotime($item['created_at'])) ?></td>
              <td>
                <?php
                  if($item['is_returned']){
                    echo "<span class='badge badge-success'>YES</span>";
                  }else{
                    echo "<span class='badge badge-danger'>NO</span>";
                  }
                ?>
              </td>
            </tr>
          <?php } ?>
          <?php }else { ?>
            <tr>
              <td colspan="4">No data available in table</td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-xl-6">
    <div class="card">
      <div class="card-header border-0">
        <div class="row align-items-center">
          <div class="col">
            <h3 class="mb-0">Popular Books</h3>
          </div>
          <div class="col text-right">
            <a href="<?= base_url('controllers/Borrow_log.php') ?>" class="btn btn-sm btn-primary">See all</a>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <!-- Projects table -->
        <table class="table align-items-center table-flush">
          <thead class="thead-light">
            <tr>
              <th scope="col">Books</th>
              <th scope="col">Borrower</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php 
              if(isset($data['popular']) && count($data['popular']) > 0) { 
                $popular = $data['popular'];
            ?>
            <?php foreach($popular as $item) { ?>
            <tr>
              <th scope="row">
                <?= $item['name'] ?>
              </th>
              <td>  
                <?= $item['borrow_count'] ?>
              </td>
              <td>
                <?php
                  $percent = $item['borrow_count']/$data['count']*100;
                  $percent = round($percent);
                ?>
                <div class="d-flex align-items-center">
                  <span class="mr-2"><?= $percent ?>%</span>
                  <div>
                    <div class="progress">
                      <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="<?= $percent ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $percent ?>%;"></div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
              <tr>
                <td colspan="3">
                  No data available in table
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>