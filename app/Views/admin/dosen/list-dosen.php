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
                            Daftar Dosen
                            <div class="float-end">
                                <button data-bs-toggle="modal" data-bs-target="#createData" class="btn btn-sm btn-primary">
                                    Tambah dosen
                                </button>
                                <div class="btn-group">
                                    <button data-bs-toggle="modal" data-bs-target="#importDosen" class="btn btn-sm btn-success">
                                        Import data dosen
                                    </button>
                                    <a href="<?= base_url() ?>assets/template/dosen.xlsx" class="btn btn-sm btn-outline-success">Unduh Template Excel</a>
                                </div>
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
                <form action="<?= base_url('admin/dosen/input-process') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">NAMA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" value="<?= session()->getFlashdata('nama') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control numeric-input" name="nip" value="<?= session()->getFlashdata('nip') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nik" min="1000000000000000" max="9999999999999999" name="nik" value="<?= session()->getFlashdata('nik') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="prodi">PROGRAM STUDI <span class="text-danger">*</span></label>
                            <select id="prodi" class="form-select" name="prodi" required></select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KODE DOSEN <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" maxlength="3" name="kodeDosen" value="<?= session()->getFlashdata('kodeDosen') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">JENIS KELAMIN <span class="text-danger">*</span></label>
                            <select class="form-select" name="jenisKelamin" required>
                                <option value="" selected>--Pilih Jenis Kelamin--</option>
                                <option value="L" <?= (session()->getFlashdata('jenisKelamin') == 'L') ? 'selected' : '' ?>>Laki-Laki</option>
                                <option value="P" <?= (session()->getFlashdata('jenisKelamin') == 'P') ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ALAMAT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="alamat" value="<?= session()->getFlashdata('alamat') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">EMAIL <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="<?= session()->getFlashdata('email') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KONTAK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control numeric-input" name="kontak" value="<?= session()->getFlashdata('kontak') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">FOTO DOSEN (.jpg)</label>
                            <input class="form-control" type="file" name="fileUpload" id="formFile" accept=" image/jpeg">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">USERNAME <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">PASSWORD <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">RE-TYPE PASSWORD <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password2" required>
                        </div>
                        <span class="text-xs text-danger">
                            <i>*Tidak boleh dikosongkan</i>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="switchDosen" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/dosen/switch-dosen') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="text" id="user_id" name="user_id" style="display: none;">
                        <p>Ubah Status User ini? <b id="nameUser"></b></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="importDosen" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload file</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/dosen/import-dosen') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="file" class="form-control" id="file_import" name="file_import" accept=".xlsx, .xls, .csv" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Unggah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?= $this->include('admin/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <?= $this->include('admin/dosen/js/dosen-js') ?>
</body>

</html>