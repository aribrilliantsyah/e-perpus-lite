<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
  <meta name="author" content="Creative Tim">
  <title></title>
  <!-- Favicon -->
  <link rel="icon" href="<?= asset('assets/img/brand/favicon.png') ?>" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="<?= asset('assets/vendor/nucleo/css/nucleo.css') ?>" type="text/css">
  <link rel="stylesheet" href="<?= asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') ?>" type="text/css">
  <!-- Page plugins -->
  <link rel="stylesheet" href="<?= asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/vendor/select2/dist/css/select2.min.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="<?= asset('assets/css/argon.css?v=1.2.0') ?>" type="text/css">
  <!-- Core -->
  <script src="<?= asset('assets/vendor/jquery/dist/jquery.min.js') ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>

<body>
  <!-- Sidenav -->
  <?php include_once('../views/components/sidenav.php') ?>

  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <?php include_once('../views/components/topnav.php') ?>
    <!-- Header -->
    <?php include_once('../views/components/header.php') ?>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <!-- Content -->
      <?php include_once( (isset($data['page']) ? $data['page'] : '../views/pages/404.php') ) ?>
      <!-- Footer -->
      <?php include_once('../views/components/footer.php') ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="<?= asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
  <script src="<?= asset('assets/vendor/js-cookie/js.cookie.js') ?>"></script>
  <script src="<?= asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') ?>"></script>
  <script src="<?= asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') ?>"></script>
  <!-- Optional JS -->
  <script src="<?= asset('assets/vendor/chart.js/dist/Chart.min.js') ?>"></script>
  <script src="<?= asset('assets/vendor/chart.js/dist/Chart.extension.js') ?>"></script>
  <!-- Argon JS -->
  <script src="<?= asset('assets/js/argon.js?v=1.2.0') ?>"></script>
  <!-- Page plugins -->
  <script src="<?= asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
  <script src="<?= asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
  <script src="<?= asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') ?>"></script>
  <script src="<?= asset('assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') ?>"></script>
  <script src="<?= asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') ?>"></script>
  <script src="<?= asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') ?>"></script>
  <script src="<?= asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js') ?>"></script>
  <script src="<?= asset('assets/vendor/datatables.net-select/js/dataTables.select.min.js') ?>"></script>
  <script src="<?= asset('assets/vendor/select2/dist/js/select2.min.js') ?>"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $(() => {
      $('.dt_table').DataTable();
      $('.select2').select2();
    })
    
    function initSelect2Member(){
      $('#member').select2({
        placeholder: "Search Member's Name",
        ajax: {
          url: "<?= base_url('controllers/Library.php?type=autocomplete') ?>",
          dataType: 'json',
          delay: 250,
          data: function (data) {
            return {
              searchTerm: data.term // search term
            };
          },
          processResults: function (response) {
            console.log(response)
            return {
              results: response
            };
          },
          cache: true
        },
        escapeMarkup: function(markup) {
          return markup;
        },
        templateResult: function(data) {
          return data.html;
        },
        templateSelection: function(data) {
          return data.text;
        },
        minimumInputLength: 1,
      })
    }
    
  </script>
</body>

</html>


