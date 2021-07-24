<div class="row">
  <div class="col-xl-12 order-xl-1">
    <div class="card">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col-8">
            <h3 class="mb-0"><i class="fas fa-search"></i> Search Members</h3>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <div class="input-group mb-3">
            <select class="form-control" id="member" name="member_id" readonly></select>
          </div>
        </div>
      </div>
    </div>
  </div>
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
        <?php if(isset($data['member_id'])) { ?>
        <div class="alert alert-info"><strong>Please</strong> wait until member information showed!</div>
        <?php } else { ?>
        <div class="alert alert-info"><strong>Please</strong> select one of any members!</div>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="col-xl-12 order-xl-1">
    <div class="card">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col-8">
            <h3 class="mb-0"><i class="fas fa-book"></i> Detail Books</h3>
          </div>
          <div class="col-4 text-right">
            <a href="" class="btn btn-sm btn-primary" id="borrow_button" style="display: none;"><i class="ni ni-fat-add"></i> Borrow</a>
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
          <table class="table dt_table table-flush table-vertical-align" id="borrowed_books">
            <thead class="thead-light">
              <tr>
                <th>Cover</th>
                <th>Book</th>
                <th>Borrowed At</th>
                <th>Returned?</th>
                <th>Return Estimate</th>
                <th>Late Back?</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            
            </tbody>
            <tfoot>
              <tr>
                <th>Cover</th>
                <th>Book</th>
                <th>Borrowed At</th>
                <th>Returned?</th>
                <th>Return Estimate</th>
                <th>Late Back?</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var t = '';
  var base_url = '<?= base_url() ?>';
  var g_member_id = '';
  $(() => {
    setTimeout(() => {
      $('#member').attr('readonly', false);
      setTimeout(() => {
        initSelect2Member()
        $('#member').on('change', () => {
          on_member_change()
        })
      }, 500);

      $('#borrowed_books').DataTable().destroy();
      t = $('#borrowed_books').DataTable({
        "columns": [
          { 
            "data": "cover", 
            "render": function(data, meta, row) {
              return `<img onerror="this.src='${base_url}/assets/img/theme/team-3.jpg'" src="${base_url}/uploads/${data}" class="avatar avatar-xs cover-image">`;
            }
          },
          { 
            "data": "name", 
            "render": function(data, meta, row) {
              return data;
            }
          },
          { 
            "data": "created_at", 
            "render": function(data, meta, row) {
              return moment(data, "YYYY-MM-DD H:mm:ss").format('DD/MM/YYYY HH:mm:ss');
            }
          },
          { 
            "data": "updated_at", 
            "render": function(data, meta, row) {
              if(row.is_returned == '1'){
                return moment(data, "YYYY-MM-DD H:mm:ss").format('DD/MM/YYYY HH:mm:ss');
              }

              return '<span class="badge badge-danger">not yet</span>';
            }
          },
          { 
            "data": "return_estimate", 
            "render": function(data, meta, row) {
              return moment(data, "YYYY-MM-DD H:mm:ss").format('DD/MM/YYYY');
            }
          },
          { 
            "data": "return_estimate", 
            "render": function(data, meta, row) {
              if(row.is_returned == '0'){
                return '';
              }else{
                let date1 = moment(row.updated_at, 'YYYY-MM-DD HH:mm:ss');
                let date2 = moment(data, 'YYYY-MM-DD HH:mm:ss');
                
                return date1.isAfter(date2) ? '<span class="badge badge-danger"> YES </span>' : '<span class="badge badge-success"> NO </span>';
              }
            }
          },
          { 
            "data": "id", 
            "render": function(data, meta, row) {
              if(row.is_returned == '0'){
                return `<a href="${base_url}controllers/Library.php?type=on_return&id=${row.id}&book_id=${row.book_id}&member_id=${g_member_id}" class="btn btn-sm btn-primary"><i class="fas fa-undo"></i> Return</a>`;
              }else{
                return '';
              }
            }
          },
        ]
      }); 

      <?php
        if(isset($data['member_id'])){
      ?>
        let t_member_id = '<?= $data['member_id'] ?>';
        get_info_member(t_member_id);
        get_borrowed_books(t_member_id);
      <?php
        }
      ?>
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
        g_member_id = member_id;
        $('#profile-information').html(html)
      }
    }).fail((xhr) => {
      console.log(res)
      alert('Terjadi Kesalahan Server')
    })
  }

  function get_borrowed_books(member_id){
    let url = "<?= base_url('controllers/Library.php?type=get_borrowed_books&member_id=') ?>"+member_id;
    $.getJSON(url).done((res) => {
      console.log(res)
      // t.clear().draw();
      $('#borrow_button').hide();
      if(res.status != undefined && res.status){
        $('#borrow_button').show();
        $('#borrow_button').attr('href', `${base_url}controllers/Library.php?type=borrow&member_id=${member_id}`);
        if(res.data != '' || res.data.length > 0){
          for(let i = 0; i < res.data.length; i++){
            t.row.add(res.data[i])
          }
          t.draw();
        }
      }
    }).fail((xhr) => {
      console.log(res)
      alert('Terjadi Kesalahan Server')
    })
  }

  function on_member_change(){
    let member_id = $('#member').val();
    console.log(member_id)
    get_info_member(member_id)
    get_borrowed_books(member_id)
  }
</script>