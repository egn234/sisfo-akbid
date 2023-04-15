<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('dosen/partials/partial-head') ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/datatables/datatables.min.css" />

</head>

<body class="sb-nav-fixed">
    <?= $this->include('dosen/partials/partial-topbar') ?>

    <div id="layoutSidenav">
        <?= $this->include('dosen/partials/partial-sidebar') ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><?= $title ?></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Matakuliah yang di koordinasi
                        </div>
                        <div class="card-body">
                            <?= session()->getFlashdata('notif') ?>
                            <table id="dataTable" class="table table-bordered table-sm">
                                <!-- Load From ajax -->
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?= $this->include('partials/footer') ?>

        </div>
    </div>

    <?= $this->include('dosen/partials/partial-footer') ?>
    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    
    <?= $this->include('dosen/koor/js/matkul-koor-js') ?>

</body>

</html>