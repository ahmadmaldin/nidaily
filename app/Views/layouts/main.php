

<!-- app/Views/layouts/main.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= $title ?? 'Dashboard' ?></title>

    
    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.png'); ?>" />
</head>

<body>
    <div class="container-scroller">
        <!-- Sidebar -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <?= view('layouts/menu') ?>
        </nav>

        <!-- Wrapper -->
        <div class="container-fluid page-body-wrapper">

            <!-- Navbar -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch justify-content-end">
                    <ul class="navbar-nav navbar-nav-right">
                        <li class="nav-item nav-profile">
                            <span class="nav-link">💖 Hai nidia 😘</span>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Konten Utama -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <?= $this->renderSection('content'); ?>
                </div>

                <!-- Footer -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                            © 2025, made with 💖 by nidia
                        </span>
                    </div>
                </footer>
            </div>

        </div>
    </div>

    
</body>

</html>
