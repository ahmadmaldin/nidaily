<ul class="nav">
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('/dashboard') ?>">
            <i class="mdi mdi-home menu-icon"></i>
            <span class="menu-title">Dashboard</span>
        </a>
    </li>

    
    <li class="nav-item">
        <a class="nav-link" href="<?= site_url('/tugas') ?>">
            <i class="mdi mdi-format-list-bulleted menu-icon"></i>
            <span class="menu-title">Task</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= site_url('/user') ?>">
            <i class="mdi mdi-account menu-icon"></i>
            <span class="menu-title">User</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= site_url('/attachment') ?>">
            <i class="mdi mdi-paperclip menu-icon"></i>
            <span class="menu-title">Attachment</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= site_url('/groups') ?>">
            <i class="mdi mdi-account-multiple menu-icon"></i>
            <span class="menu-title">Groups</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="<?= site_url('/backup') ?>">
            <i class="mdi mdi-database menu-icon"></i>
            <span class="menu-title">Backup DB</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-danger" href="<?= site_url('/logout') ?>">
            <i class="mdi mdi-logout menu-icon"></i>
            <span class="menu-title">Logout</span>
        </a>
    </li>
</ul>
