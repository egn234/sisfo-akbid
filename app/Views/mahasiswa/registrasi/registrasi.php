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

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Matakuliah yang dipilih
                            <div class="btn-group float-end">
                                <button type="button" onclick="cekJadwal(this)" data-bs-toggle="modal" data-bs-target="#cekJadwal" class="btn btn-primary <?= ($cekRegis != 0) ? 'd-none' : '' ?>">
                                    Cek Jadwal
                                </button>
                            </div>
                        </div>

                        <?php if ($cekMasaRegis == 0) { ?>
                            <div class="card-body">
                                <div class="d-block w-100">
                                    ANDA BELUM BERADA DI MASA REGISTRASI
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="card-body <?= ($cekRegis != 0) ? 'd-none' : '' ?>">
                                <?= session()->getFlashdata('notif') ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table id="available-items" class="display table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Id</th>
                                                    <th>Kode</th>
                                                    <th>Mata Kuliah</th>
                                                    <th>Tingkat</th>
                                                    <th>Sks</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table id="selected-items" class="display table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Id</th>
                                                    <th>Kode</th>
                                                    <th>Mata Kuliah</th>
                                                    <th>Tingkat</th>
                                                    <th>Sks</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                Total SKS yang diambil: <span id="total-sks"></span><br><br>
                                <a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#reqRegis">Ajukan Persetujuan Registrasi</a>
                            </div>
                            <div class="card-body <?= ($cekRegis == 0) ? 'd-none' : '' ?>">
                                <div class="d-block w-100">
                                    SUDAH MENGAJUKAN REGISTRASI, SILAHKAN CEK STATUS PADA MENU CETAK KSM
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                
            </main>
            <?= $this->include('partials/footer') ?>
        </div>
    </div>


    <!-- CRUD Modal -->
    <div id="reqRegis" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Ajukan registrasi mata kuliah?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="add-selected" class="btn btn-primary">Ajukan</button>
                </div>
            </div>
        </div>
    </div>

    <div id="cekJadwal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cek Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="timetable"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="schedule-modal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Schedule List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="schedule-modal-table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Day</th>
                                <th>Time</th>
                                <th>Course Name</th>
                                <th>Classroom</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>

    </div>

    <?= $this->include('mahasiswa/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <?= $this->include('mahasiswa/registrasi/js/regis-js') ?>

</body>

</html>