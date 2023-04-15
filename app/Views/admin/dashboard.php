<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('admin/partials/partial-head') ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/datatables/datatables.min.css" />

</head>

<body class="sb-nav-fixed">
    <?= $this->include('admin/partials/partial-topbar') ?>

    <div id="layoutSidenav">
        <?= $this->include('admin/partials/partial-sidebar') ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-header">Total mahasiswa</div>
                                <div class="card-body text-center">
                                    <h4><?= $total_mhs ?></h4>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="<?= url_to('admin/mahasiswa') ?>">Lihat Semua</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-header">Total Dosen</div>
                                <div class="card-body text-center">
                                    <h4><?= $total_dosen ?></h4>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="<?= url_to('admin/dosen') ?>">Lihat Semua</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-header">Total Kelas</div>
                                <div class="card-body text-center">
                                    <h4><?= $total_kelas ?></h4>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="<?= url_to('admin/kelas') ?>">Lihat Semua</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">Posting</div>
                                <div class="card-body">
                                    <?php
                                    $allData = $posting_limit;
                                    // print_r($allData);
                                    ?>
                                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators">
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                            </div>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="<?php echo base_url('uploads/posts') ?>/<?= $allData[0]->attachment ?>" style="width:75%; max-height:420px;" class="d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="<?php echo base_url('uploads/posts') ?>/<?= $allData[1]->attachment ?>" style="width:75%; max-height:420px;" class="d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="<?php echo base_url('uploads/posts') ?>/<?= $allData[2]->attachment ?>" style="width:75%; max-height:420px;" class="d-block w-100" alt="...">
                                                </div>
                                            </div>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        </div>

                                        
                                    <?php  ?>
                                </div>
                                <!-- <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small stretched-link" href="<?= url_to('admin/posting') ?>">Lihat Semua</a>
                                    <div class="small "><i class="fas fa-angle-right"></i></div>
                                </div> -->
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
                                <div class="card-header">Jadwal Perkuliahan Hari Ini</div>
                                <div class="card-body">
                                    <table id="dataTablePerkuliahan" class="table table-bordered table-sm">
                                        <thead>
                                            <th>No</th>
                                            <th>Jadwal</th>
                                            <th>Kelas</th>
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
                    </div>
                </div>
            </main>
            <?= $this->include('partials/footer') ?>
        </div>
    </div>

    <?= $this->include('admin/partials/partial-footer') ?>
    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <script type="text/javascript">
        $('#dataTable').DataTable();
        $('#dataTablePerkuliahan').DataTable();
    </script>
</body>

</html>