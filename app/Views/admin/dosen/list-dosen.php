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
                            <div class="btn-group float-end">
                                <button data-bs-toggle="modal" data-bs-target="#createData" class="btn btn-sm btn-primary">
                                    Tambah Dosen
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
                <form action="<?= base_url('admin/dosen/input-process') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">NAMA</label>
                            <input type="text" class="form-control" name="nama">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" class="form-control" name="nip">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-control" name="nik">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KODE DOSEN</label>
                            <input type="text" class="form-control" name="kodeDosen">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">JENIS KELAMIN</label>
                            <select class="form-select" name="jenisKelamin" required>
                                <option value="" selected>--Pilih Jenis Kelamin--</option>
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ALAMAT</label>
                            <input type="text" class="form-control" name="alamat">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">EMAIL</label>
                            <input type="text" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KONTAK</label>
                            <input type="text" class="form-control" name="kontak">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">FOTO DOSEN</label>
                            <input class="form-control" type="file" name="fileUpload" id="formFile" accept=" image/jpeg, image/png">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">USERNAME</label>
                            <input type="text" class="form-control" name="username">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">PASSWORD</label>
                            <input type="text" class="form-control" name="password">
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
                <form action="<?= base_url('admin/dosen/update-process') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">NAMA</label>
                            <input type="text" style="display: none;" name="idPut" id="idPut">
                            <input type="text" class="form-control" name="nama" id="namePut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" class="form-control" name="nip" id="nipPut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-control" name="nik" id="nikPut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KODE DOSEN</label>
                            <input type="text" class="form-control" name="kodeDosen" id="kodeDosenPut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">JENIS KELAMIN</label>
                            <select class="form-select" name="jenisKelamin" id="jenisKelaminPut" required>
                                <option value="" selected>--Pilih Jenis Kelamin--</option>
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ALAMAT</label>
                            <input type="text" class="form-control" name="alamat" id="alamatPut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">EMAIL</label>
                            <input type="text" class="form-control" name="email" id="emailPut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KONTAK</label>
                            <input type="text" class="form-control" name="kontak" id="kontakPut">
                        </div>
                        <!-- <div class="mb-3">
                            <label for="formFile" class="form-label">FOTO DOSEN</label>
                            <input class="form-control" type="file" name="fileUpload" id="formFile" accept=" image/jpeg, image/png">
                        </div> -->
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

    <?= $this->include('admin/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <?= $this->include('admin/dosen/js/dosen-js') ?>
</body>

</html>