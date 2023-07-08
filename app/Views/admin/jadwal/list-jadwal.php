<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('admin/partials/partial-head') ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/datatables/datatables.min.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

    <style>
        .flatpickr {
            z-index: 9999;
        }

        ;
    </style>
</head>

<body class="sb-nav-fixed">

    <?= $this->include('admin/partials/partial-topbar') ?>

    <div id="layoutSidenav">
        <?= $this->include('admin/partials/partial-sidebar') ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4"><?= $title ?></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                    <div class="card mb-3">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Timetable
                            <div class="btn-group float-end">
                                <button data-bs-toggle="modal" data-bs-target="#createData" class="btn btn-sm btn-primary">
                                    Tambah Jadwal
                                </button>
                            </div>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Jadwal
                        </div>
                        <div class="card-body">
                            <?= session()->getFlashdata('notif') ?>
                            <?= session()->getFlashdata('notif_day') ?>
                            <?= session()->getFlashdata('notif_time') ?>
                            <?= session()->getFlashdata('notif_ruangan') ?>
                            <?= session()->getFlashdata('notif_matkul') ?>
                            <?= session()->getFlashdata('notif_dosen') ?>

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

    <!-- CRUD Modal -->
    <div class="modal fade" id="createData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/jadwal/input-process') ?>" class="w-100" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">TAHUN AJARAN</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <select class="form-select" name="periodeID" id="periode-list" style="width: 100%;" required>
                                        <option value="" selected hidden>-- Pilih Tahun Ajaran --</option>
                                        <!-- Load From Ajax -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">MATA KULIAH</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <select class="form-select" name="matakuliahID" id="matkul-list" style="width: 100%;" required>
                                        <option value="" selected hidden>-- Pilih Mata Kuliah --</option>
                                        <!-- Load From Ajax -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">DOSEN</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <select class="form-select" name="dosenID" id="dosen-list" style="width: 100%;" required>
                                        <option value="" selected hidden>-- Pilih Dosen --</option>
                                        <!-- Load From Ajax -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">RUANGAN</label>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <select class="form-select" name="ruanganID" id="ruangan-list" style="width: 100%;" required>
                                        <option value="" selected hidden>-- Pilih Ruangan --</option>
                                        <!-- Load From Ajax -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">HARI</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <select class="form-select" name="day" id="day" style="width: 100%;" required>
                                        <option value="" selected hidden>-- Pilih Hari--</option>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                        <option value="Sabtu">Sabtu</option>
                                        <option value="Minggu">Minggu</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Jam Awal <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="startTime" id="time-input-from" placeholder="dari" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Jam Akhir<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="endTime" id="time-input-to" placeholder="sampai" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">DESKRIPSI</label>
                            <textarea class="form-control ckeditor1" style="height:400px" name="deskripsi"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Jadwal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/jadwal/edit-process') ?>" class="w-100" method="POST" enctype="multipart/form-data">
                    <input type="text" id="idPut" name="idPut" style="display: none;">
                    <div class="modal-body">
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">TAHUN AJARAN</label>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <select class="form-select" name="periodeID" id="periode-listPut" style="width: 100%;" required>
                                        <option value="" selected hidden>-- Pilih Tahun Ajaran --</option>
                                        <!-- Load From Ajax -->
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">MATA KULIAH</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <select class="form-select" name="matakuliahID" id="matkul-listPut" style="width: 100%;" required>
                                        <option value="" selected hidden>-- Pilih Mata Kuliah --</option>
                                        <!-- Load From Ajax -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">DOSEN</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <select class="form-select" name="dosenID" id="dosen-listPut" style="width: 100%;" required>
                                        <option value="" selected hidden>-- Pilih Dosen --</option>
                                        <!-- Load From Ajax -->
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">RUANGAN</label>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <select class="form-select" name="ruanganID" id="ruangan-listPut" style="width: 100%;" required>
                                        <option value="" selected hidden>-- Pilih Ruangan --</option>
                                        <!-- Load From Ajax -->
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">HARI</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <select class="form-select" name="day" id="dayPut" style="width: 100%;" required>
                                        <option value="" selected hidden>-- Pilih Hari--</option>
                                        <option value="Senin">Senin</option>
                                        <option value="Selasa">Selasa</option>
                                        <option value="Rabu">Rabu</option>
                                        <option value="Kamis">Kamis</option>
                                        <option value="Jumat">Jumat</option>
                                        <option value="Sabtu">Sabtu</option>
                                        <option value="Minggu">Minggu</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Jam Awal <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control startTime" name="startTime" id="time-input-from" placeholder="dari" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Jam Akhir<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control endTime" name="endTime" id="time-input-to" placeholder="sampai" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">DESKRIPSI</label>
                            <textarea class="form-control ckeditor2" style="height:400px" name="deskripsi" id="deskripsiPut"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Ubah Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="switchJadwal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/jadwal/switch-jadwal') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="text" id="id_data" name="id_data" style="display: none;">
                        <p>Ubah Status Jadwal ini? <b id="nameUser"></b></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?= $this->include('admin/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <?= $this->include('admin/jadwal/js/jadwal-js') ?>
</body>

</html>