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
                            Daftar Mahasiswa
                            <div class="btn-group float-end">
                                <button data-bs-toggle="modal" data-bs-target="#createData" class="btn btn-sm btn-primary">
                                    Tambah Mahasiswa
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
    <div class="modal fade" id="createData" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/mahasiswa/input-process') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">NAMA</label>
                            <input type="text" class="form-control" name="nama">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" class="form-control" name="nim">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-control" name="nik">
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
                            <label class="form-label">TEMPAT/TANGGAL LAHIR</label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="text" class="form-control" name="tempatLahir">
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control flatpickr-basic" name="tanggalLahir">
                                </div>
                            </div>
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
                            <label class="form-label">NAMA IBU</label>
                            <input type="text" class="form-control" name="namaIbu">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KONTAK IBU</label>
                            <input type="text" class="form-control" name="kontakIbu">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NAMA AYAH</label>
                            <input type="text" class="form-control" name="namaAyah">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KONTAK AYAH</label>
                            <input type="text" class="form-control" name="kontakAyah">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NAMA WALI</label>
                            <input type="text" class="form-control" name="namaWali">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KONTAK WALI</label>
                            <input type="text" class="form-control" name="kontakWali">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">FOTO MAHASISWA</label>
                            <input class="form-control" type="file" name="fileUpload" id="formFile" accept=" image/jpeg, image/png">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">USERNAME</label>
                            <input type="text" class="form-control" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">PASSWORD</label>
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

    <div id="switchMahasiswa" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('admin/mahasiswa/switch-mhs') ?>" method="POST" enctype="multipart/form-data">
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
    <?= $this->include('admin/mhs/js/mahasiswa-js') ?>
</body>

</html>