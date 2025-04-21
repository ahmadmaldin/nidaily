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
        <a class="nav-link" href="<?= site_url('/user') ?>">
            <span class="menu-icon">
                <i class="mdi mdi-account"></i>
            </span>
            <span class="menu-title">User</span>
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
