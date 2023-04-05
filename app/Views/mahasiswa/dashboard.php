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
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-12 col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">Posting</div>
                                <div class="card-body">
                                    <?php
                                    $allData = $posting_limit;
                                    foreach ($allData as $data) {
                                    ?>
                                        <div class="row mt-3" style="padding-left: 40px; padding-right: auto;">
                                            <div style="width: 96%; border: 2px solid gray; border-radius: 25px; height: 125px;">
                                                <div class="row ">
                                                    <div class="col-lg-2" style="padding-top: 5px; padding-left: 15px;">
                                                        <img src="<?php echo base_url('uploads/post') . '/' . $data->attachment ?>" data-url="<?= $data->attachment ?>" width="100" height="100" alt="pic">
                                                    </div>
                                                    <div class="col-lg-8" style="padding-top: 30px;">
                                                        <h5 class="text-justify"><?= $data->judul ?></h5>
                                                        <p class="text-justify"><?= $data->deskripsi ?></p>
                                                    </div>
                                                    <div class="col-lg-2" style=" padding-top: 38px; padding-right: 80px;">
                                                        <div class="btn-group float-end">
                                                            <a href="<?= base_url('mahasiswa/posting/detail') . '/' . $data->id ?>" class="btn btn-lg btn-primary">
                                                                Detail
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small stretched-link" href="<?= url_to('mahasiswa/posting') ?>">Lihat Semua</a>
                                    <div class="small "><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">Jadwal Periode Ini</div>
                                <div class="card-body">
                                    <table id="dataTable" class="table table-bordered table-sm">
                                        <thead>
                                            <th>No</th>
                                            <th>Jadwal</th>
                                            <th>Tanggal</th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div> -->
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">MataKuliah Yang Diampuh</div>
                                <div class="card-body">
                                    <table id="dataTableMatkul" class="table table-bordered table-sm">
                                        <thead>
                                            <th>No</th>
                                            <th>MataKuliah</th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <!-- <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="#">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?= $this->include('partials/footer') ?>
        </div>
    </div>

    <?= $this->include('mahasiswa/partials/partial-footer') ?>
    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <script type="text/javascript">
        $('#dataTable').DataTable();
        $('#dataTableMatkul').DataTable();

    </script>
</body>

</html>