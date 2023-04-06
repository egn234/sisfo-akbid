<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('admin/partials/partial-head') ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/datatables/datatables.min.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
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

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Mata Kuliah
                            <div class="btn-group float-end">
                                <button data-bs-toggle="modal" data-bs-target="#createData" class="btn btn-sm btn-primary">
                                    Tambah Mata Kuliah
                                </button>
                            </div>
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

    <!-- CRUD Modal -->
    <div class="modal fade" id="createData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/matkul/input-process') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">KODE MATA KULIAH</label>
                            <input type="text" class="form-control" name="kodeMatkul" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NAMA MATA KULIAH</label>
                            <input type="text" class="form-control" name="namaMatkul" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">TINGKAT</label>
                            <select name="tingkat" class="form-select" required>
                                <option value="" hidden>--Pilih Tingkat--</option>
                                <option value="1">Tingkat 1</option>
                                <option value="2">Tingkat 2</option>
                                <option value="3">Tingkat 3</option>
                                <option value="4">Tingkat 4</option>
                                <option value="5">Tingkat 5</option>
                                <option value="6">Tingkat 6</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SKS</label>
                            <input type="number" min="1" max="12" class="form-control" name="sks" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SEMESTER</label>
                            <select class="form-select" name="semester" required>
                                <option value="" hidden>--Pilih Semester--</option>
                                <option value="ganjil">Ganjil</option>
                                <option value="genap">Genap</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">DESKRIPSI</label>
                            <textarea class="form-control ckeditor1" style="height:400px" name="deskripsi"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Matakuliah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/matkul/update-process') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">KODE MATA KULIAH</label>
                            <input type="text" class="form-control" name="idPut" id="idPut" style="display:none;">
                            <input type="text" class="form-control" name="kodeMatkul" id="kodePut" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NAMA MATA KULIAH</label>
                            <input type="text" class="form-control" name="namaMatkul" id="namaMatkulPut" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">TINGKAT</label>
                            <select name="tingkat" class="form-select" id="tingkatPut" required>
                                <option value="" hidden>--Pilih Tingkat--</option>
                                <option value="1">Tingkat 1</option>
                                <option value="2">Tingkat 2</option>
                                <option value="3">Tingkat 3</option>
                                <option value="4">Tingkat 4</option>
                                <option value="5">Tingkat 5</option>
                                <option value="6">Tingkat 6</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SKS</label>
                            <input type="number" min="1" max="12" class="form-control" name="sks" id="sksPut" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">SEMESTER</label>
                            <select class="form-select" name="semester" id="semesterPut" required>
                                <option value="" hidden>--Pilih Semester--</option>
                                <option value="ganjil">Ganjil</option>
                                <option value="genap">Genap</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">DESKRIPSI</label>
                            <textarea class="form-control ckeditor2" style="height:400px" name="deskripsi" id="deskripsiPut"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah Matakuliah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="delData" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/matkul/delete-process') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="text" class="form-control" id="idDel" name="idDel" placeholder="KODE MATA KULIAH" style="display: none;">
                        <p>Anda yakin ingin menghapus data? (<b id="nameDel"></b>)</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="switchFlag" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/matkul/switch-matkul') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="text" id="user_id" name="id_data" style="display: none;">
                        <p>Ubah Status Data ini? <b id="nameUser"></b></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?= $this->include('admin/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <?= $this->include('admin/matkul/js/matkul-js') ?>
</body>

</html>