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
                <form action="<?= url_to('admin/mahasiswa/input-process') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">NAMA <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama" value="<?=session()->getFlashdata('nama')?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIM <span class="text-danger">*</span></label>
                            <input type="text" class="form-control numeric-input" name="nim" value="<?=session()->getFlashdata('nim')?>" id="nimNumber" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIK <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="nik" min="1000000000000000" max="9999999999999999" value="<?=session()->getFlashdata('nik')?>" name="nik" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">JENIS KELAMIN <span class="text-danger">*</span></label>
                            <select class="form-select" name="jenisKelamin" required>
                                <option value="L" <?=(session()->getFlashdata('JenisKelamin') == 'L')?'selected':''?>>Laki-Laki</option>
                                <option value="P" <?=(session()->getFlashdata('JenisKelamin') == 'P')?'selected':''?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">TEMPAT/TANGGAL LAHIR <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="text" class="form-control" name="tempatLahir" value="<?=session()->getFlashdata('tempatLahir')?>" required>
                                </div>
                                <div class="col-8">
                                    <input type="date" class="form-control" name="tanggalLahir" value="<?=session()->getFlashdata('tanggalLahir')?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ALAMAT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="alamat" value="<?=session()->getFlashdata('alamat')?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">EMAIL <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="<?=session()->getFlashdata('email')?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KONTAK <span class="text-danger">*</span></label>
                            <input type="text" class="form-control numeric-input" name="kontak" value="<?=session()->getFlashdata('kontak')?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NAMA IBU KANDUNG/ANGKAT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="namaIbu" value="<?=session()->getFlashdata('namaIbu')?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KONTAK IBU KANDUNG/ANGKAT</label>
                            <input type="text" class="form-control numeric-input" name="kontakIbu" value="<?=session()->getFlashdata('kontakIbu')?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NAMA AYAH KANDUNG/ANGKAT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="namaAyah" value="<?=session()->getFlashdata('namaAyah')?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KONTAK AYAH KANDUNG/ANGKAT</label>
                            <input type="text" class="form-control numeric-input" name="kontakAyah" value="<?=session()->getFlashdata('kontakAyah')?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NAMA WALI</label>
                            <input type="text" class="form-control" name="namaWali" value="<?=session()->getFlashdata('namaWali')?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KONTAK WALI</label>
                            <input type="text" class="form-control numeric-input" name="kontakWali" value="<?=session()->getFlashdata('kontakWali')?>">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">FOTO MAHASISWA</label>
                            <input class="form-control" type="file" name="fileUpload" id="formFile" accept="image/jpeg">
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">USERNAME <span class="text-danger">*</span></label>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
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
                <form action="<?= base_url('admin/mahasiswa/update-process') ?>" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">NAMA</label>
                            <input type="text" style="display: none;" name="idPut" id="idPut">
                            <input type="text" class="form-control" name="nama" id="namePut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="text" class="form-control" name="nim" id="nimPut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-control" name="nik" id="nikPut">
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
                            <label class="form-label">TEMPAT/TANGGAL LAHIR</label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="text" class="form-control" name="tempatLahir" id="tempatLahirPut">
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control flatpickr-basic" name="tanggalLahir" id="tanggalLahirPut">
                                </div>
                            </div>
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
                        <div class="mb-3">
                            <label class="form-label">NAMA IBU</label>
                            <input type="text" class="form-control" name="namaIbu" id="namaIbuPut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KONTAK IBU</label>
                            <input type="text" class="form-control" name="kontakIbu" id="kontakIbuPut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NAMA AYAH</label>
                            <input type="text" class="form-control" name="namaAyah" id="namaAyahPut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KONTAK AYAH</label>
                            <input type="text" class="form-control" name="kontakAyah" id="kontakAyahPut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NAMA WALI</label>
                            <input type="text" class="form-control" name="namaWali" id="namaWaliPut">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KONTAK WALI</label>
                            <input type="text" class="form-control" name="kontakWali" id="kontakWaliPut">
                        </div>
                        <!-- <div class="mb-3">
                            <label for="formFile" class="form-label">FOTO MAHASISWA</label>
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
                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
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