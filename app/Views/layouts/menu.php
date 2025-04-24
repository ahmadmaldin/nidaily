<ul class="nav">
    <li class="nav-item menu-items">
        <a class="nav-link" href="<?= base_url('/dashboard') ?>">
            <span class="menu-icon">
                <i class="mdi mdi-home"></i>
            </span>
            <span class="menu-title">Dashboard</span>
        </a>
    </li>

    <li class="nav-item menu-items">
        <a class="nav-link" href="<?= site_url('/tugas') ?>">
            <span class="menu-icon">
                <i class="mdi mdi-format-list-bulleted"></i>
            </span>
            <span class="menu-title">Task</span>
        </a>
    </li>

    <li class="nav-item menu-items">
        <a class="nav-link" href="<?= site_url('/groups') ?>">
            <span class="menu-icon">
                <i class="mdi mdi-account-multiple"></i>
            </span>
            <span class="menu-title">Groups</span>
        </a>
    </li>
    <li class="nav-item menu-items">
        <a class="nav-link" href="<?= site_url('/frienship') ?>">
            <span class="menu-icon">
                <i class="mdi mdi-account-multiple"></i>
            </span>
            <span class="menu-title">Friendship</span>
        </a>
    </li>
    <li class="nav-item menu-items">
        <a class="nav-link" href="<?= site_url('/sharedtome') ?>">
            <span class="menu-icon">
                <i class="mdi mdi-account-multiple"></i>
            </span>
            <span class="menu-title">Shared To Me</span>
        </a>
    </li>
    <li class="nav-item nav-profile dropdown">
  <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
    <img src="<?= base_url('public/uploads/user/') ?>" alt="profile" />
  </a>
  <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
    <a class="dropdown-item" href="<?= base_url('user/edit') ?>">
      <i class="mdi mdi-settings text-primary"></i>
      Settings
    </a>
    <a class="dropdown-item" href="<?= base_url('logout') ?>">
      <i class="mdi mdi-logout text-primary"></i>
      Logout
    </a>
  </div>
</li>

    <li class="nav-item menu-items">
        <a class="nav-link" href="<?= site_url('/backup') ?>">
            <span class="menu-icon">
                <i class="mdi mdi-database"></i>
            </span>
            <span class="menu-title">Backup DB</span>
        </a>
    </li>

    <li class="nav-item menu-items">
        <a class="nav-link text-danger" href="<?= site_url('/logout') ?>">
            <span class="menu-icon">
                <i class="mdi mdi-logout"></i>
            </span>
            <span class="menu-title">Logout</span>
        </a>
    </li>
</ul>
