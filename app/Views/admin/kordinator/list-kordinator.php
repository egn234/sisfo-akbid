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
                    <h1 class="mt-4"><?= $title ?></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Koordinator Mata Kuliah
                            <div class="btn-group float-end">
                                <button data-bs-toggle="modal" data-bs-target="#createData" class="btn btn-sm btn-primary">
                                    Tambah Koordinator
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
                <form action="<?= base_url('admin/kordinator/input-process') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row ">
                            <div class="col-12">
                                <label class="form-label">MATA KULIAH</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <select class="form-control" name="matakuliahID" id="matkul-list" style="width: 100%;">
                                    <option value="" selected>-- Pilih Mata Kuliah --</option>
                                    <!-- Load From Ajax -->
                                </select>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-12">
                                <label class="form-label">DOSEN</label>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <select class="form-select" name="dosenID" id="dosen-list" style="width: 100%;">
                                    <option value="" selected>-- Pilih Dosen --</option>
                                    <!-- Load From Ajax -->
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
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
                <form action="<?= base_url('admin/ruangan/update-process') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">KODE RUANGAN</label>
                            <input type="text" class="form-control" name="idPut" id="idPut" style="display:none;">
                            <input type="text" class="form-control" name="kodeRuangan" id="kodePut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NAMA RUANGAN</label>
                            <input type="text" class="form-control" name="namaRuangan" id="namaRuanganPut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">DESKRIPSI</label>
                            <input type="text" class="form-control" name="deskripsi" id="deskripsiPut">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
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
                <form action="<?= base_url('admin/kordinator/delete-process') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="text" class="form-control" id="idDel" name="idDel" style="display: none;">
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

    <?= $this->include('admin/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <?= $this->include('admin/kordinator/js/kordinator-js') ?>
</body>

</html>