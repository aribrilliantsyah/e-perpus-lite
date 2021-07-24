<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
  <div class="scrollbar-inner">
    <!-- Brand -->
    <div class="sidenav-header  align-items-center">
      <a class="navbar-brand" href="javascript:void(0)">
        <img src="<?= asset('assets/img/brand/logo.png') ?>" class="navbar-brand-img" alt="..." style="max-height: 3rem !important;">
      </a>
    </div>
    <div class="navbar-inner">
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Nav items -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?= get_last_uri() == 'Dashboard.php' ? 'active' : '' ?>" href="<?= base_url('controllers/Dashboard.php') ?>">
              <i class="ni ni-tv-2"></i>
              <span class="nav-link-text">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="examples/dashboard.html">
              <i class="ni ni-spaceship"></i>
              <span class="nav-link-text">Member</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= get_last_uri() == 'Library.php' ? 'active' : '' ?>" href="<?= base_url('controllers/Library.php') ?>">
              <i class="ni ni-books"></i>
              <span class="nav-link-text">Library</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="examples/dashboard.html">
              <i class="ni ni-planet"></i>
              <span class="nav-link-text">Borrowing History</span>
            </a>
          </li>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Nav items -->
        <h6 class="navbar-heading p-0 text-muted">
          <span class="docs-normal">Master Data</span>
        </h6>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link <?= get_last_uri() == 'Author.php' ? 'active' : '' ?>" href="<?= base_url('controllers/Author.php') ?>">
              <i class="ni ni-single-02"></i>
              <span class="nav-link-text">Author Book</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= get_last_uri() == 'Book.php' ? 'active' : '' ?>" href="<?= base_url('controllers/Book.php') ?>">
              <i class="ni ni-ruler-pencil"></i>
              <span class="nav-link-text">Book</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= get_last_uri() == 'User.php' ? 'active' : '' ?>" href="<?= base_url('controllers/User.php') ?>">
              <i class="ni ni-settings"></i>
              <span class="nav-link-text">User Management</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>