<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('mahasiswa/partials/partial-head') ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/datatables/datatables.min.css" />
</head>

<body class="sb-nav-fixed">

    <?= $this->include('mahasiswa/partials/partial-topbar') ?>

    <div id="layoutSidenav">
        <?= $this->include('mahasiswa/partials/partial-sidebar') ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><?= $title ?></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                    <div class="card mb-3">
                        <div class="card-header">
                            Filter
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <label for="exampleInputEmail1" class="form-label">Periode</label>
                                <select class="form-select" id="periode-list">
                                    <option value="">--Pilih Periode--</option>

                                </select>
                            </div>
                            <div class="row">
                                <button class="btn btn-sm btn-primary">
                                    Filter
                                </button>
                            </div>


                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Nilai
                            <!-- <div class="btn-group float-end">
                                <button class="btn btn-sm btn-primary">
                                    CETAK KSM
                                </button>
                            </div> -->
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
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2022</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- CRUD Modal -->


    <?= $this->include('mahasiswa/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <?= $this->include('mahasiswa/nilai/js/nilai-js') ?>
</body>

</html>