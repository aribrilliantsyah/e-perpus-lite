<div class="row">
  <div class="col-xl-12 order-xl-1">
    <div class="card">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col-8">
            <h3 class="mb-0"><i class="fas fa-user"></i> Member Information</h3>
          </div>
        </div>
      </div>
      <div class="card-body" id="profile-information">
        <div class="alert alert-info"><strong>Please</strong> wait until member information showed!</div>
      </div>
    </div>
  </div>
  <div class="col-xl-12 order-xl-1">
    <div class="card">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col-8">
            <h3 class="mb-0">Borrow Books </h3>
          </div>
          <div class="col-4 text-right">
            <a href="<?= base_url('controllers/Library.php?member_id='.@$data['member_id']) ?>" class="btn btn-sm btn-primary"><i class="fas fa-chevron-left"></i> Back</a>
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
                <th>Code</th>
                <th>Book</th>
                <th>Summary</th>
                <th>Author</th>
                <th>Stock</th>
              </tr>
            </thead>
            <tbody>
            <?php
              if(isset($data['result']) && count($data['result']) > 0){
                foreach($data['result'] as $item) {
            ?>
              <tr>
                <td>
                  <a href="<?= base_url('controllers/Library.php?type=on_borrow&id='.$item['id'].'&member_id='.$data['member_id']) ?>" class="btn btn-sm btn-success"><i class="fas fa-plus"></i> Borrow</a>
                </td>
                <td><img onerror="this.src='<?= asset('/assets/img/theme/team-3.jpg') ?>'" src="<?= base_url('/uploads/'.$item['cover']) ?>" class="avatar avatar-xs" ></td>
                <td><?= $item['code'] ?></td>
                <td><?= $item['name'] ?></td>
                <td><?= strlen($item['summary']) > 100 ? substr($item['summary'], 0, 100).'...' : $item['summary'] ?></td>
                <td><?= $item['author_name'] ?></td>
                <td><span class="badge badge-primary"><?= $item['stock'] ?></span></td>
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
                <th>Code</th>
                <th>Book</th>
                <th>Summary</th>
                <th>Author</th>
                <th>Stock</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(() => {
    setTimeout(() => {
      get_info_member(<?= @$data['member_id'] ?>);
    }, 3000);
  })

  function get_info_member(member_id){
    let url = "<?= base_url('controllers/Library.php?type=get_info_member&member_id=') ?>"+member_id;
    $.getJSON(url).done((res) => {
      console.log(res)
      if(res.status != undefined && res.status){
        let html = '<div class="alert alert-info"><strong>Please</strong> select one of any members!</div>'
        if(res.data != '' || res.data.length > 0){
          html = `<table class="table table-bordered">
            <tr>
              <td>Code</td>
              <th>${res.data.code}</th>
            </tr>
            <tr>
              <td>Full Name</td>
              <th>${res.data.full_name}</th>
            </tr>
            <tr>
              <td>Address</td>
              <th>${res.data.address}</th>
            </tr>
            <tr>
              <td>Gender</td>
              <th>${res.data.gender}</th>
            </tr>
            <tr>
              <td>Photo</td>
              <th><img onerror="this.src='<?= asset('/assets/img/theme/team-3.jpg') ?>'" src="<?= base_url('uploads') ?>/${res.data.photo}" class="avatar rounded-circle"></th>
            </tr>
            <tr>
              <td>Profession</td>
              <th>${res.data.profession}</th>
            </tr>
          </table>`;
        }

        $('#profile-information').html(html)
      }
    }).fail((xhr) => {
      console.log(res)
      alert('Terjadi Kesalahan Server')
    })
  }

</script>