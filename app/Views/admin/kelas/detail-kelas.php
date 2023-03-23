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
                    <h1 class="mt-4"><?= $titleDetail ?></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><?= $titleDetail ?></li>
                    </ol>

                    <div class="card mb-4" id="base-url" data-baseUrl="<?= url_to('admin/kelas') ?>">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Detail Kelas
                            <!-- <div class="btn-group float-end">
                                <button data-bs-toggle="modal" data-bs-target="#createData" class="btn btn-sm btn-primary">
                                    Tambah Kelas
                                </button>
                            </div> -->
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <h4 class="text-center">Kelas</h4>
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Kode Kelas</label>
                                        <input type="text" class="form-control" id="kodeKelas" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Angkatan</label>
                                        <input type="text" class="form-control" id="angkatan" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Tahun Angkatan</label>
                                        <input type="text" class="form-control" id="tahunAngkatan" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h4 class="text-center">Wali Dosen</h4>
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Kode Dosen</label>
                                        <input type="text" class="form-control" id="kodeDosen" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">Nama Dosen</label>
                                        <input type="text" class="form-control" id="namaDosen" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlFile1">NIP</label>
                                        <input type="text" class="form-control" id="nip" readonly>
                                    </div>
                                    <button type="button" id="pilihDosen" onclick="listDosen(this)" data-bs-toggle="modal" data-bs-target="#pilih-Dosen" class="btn btn-sm btn-primary mt-1">Pilih Dosen</button>
                                    <button type="button" id="removeDosen" onclick="removeDosen(this)" data-bs-toggle="modal" data-bs-target="#remove-Dosen" class="btn btn-sm btn-danger mt-1">Remove</button>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <i class="fas fa-table me-1"></i>
                                            List mahasiswa
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="btn-group float-end mb-3">
                                                <button data-bs-toggle="modal" onclick="listMhs(this)" data-bs-target="#createDataMhs" class="btn btn-sm btn-primary">
                                                    Plotting Mahasiswa
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?= session()->getFlashdata('notif') ?>
                                            <table id="dataTable" class="table table-bordered table-sm">
                                                <!-- Load From ajax -->
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">

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
    <div class="modal fade" id="pilih-Dosen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Daftar Dosen</h5>
                    <input type="text" id="id-kelas" style="display: none;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- <form action="<?= base_url('admin/kelas/input-process') ?>" method="POST" enctype="multipart/form-data"> -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <table id="dataTableDosen" class="table table-bordered table-responsive" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
                </div>
                <!-- </form> -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="createDataMhs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Plotting Kelas Mahasiswa</h5>
                    <input type="text" id="id-kelas-mhs" style="display: none;">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- <form action="<?= base_url('admin/kelas/input-process') ?>" method="POST" enctype="multipart/form-data"> -->
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="dataTableMhs" class="table table-bordered table-responsive" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
                    </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
    <div id="remove-Dosen" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- <form action="<?= base_url('admin/kelas/delete-process') ?>" method="POST" enctype="multipart/form-data"> -->
                <div class="modal-body">
                    <input type="text" class="form-control" id="idDel" name="idDel" style="display: none;">
                    <p>Anda yakin ingin menghapus data wali dosen? (<b id="nameDel"></b>)</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button onclick="removeProcess(this)" class="btn btn-danger">Remove</button>
                </div>
                <!-- </form> -->
            </div>
        </div>
    </div>
    <div id="remove-Mhs" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- <form action="<?= base_url('admin/kelas/delete-process') ?>" method="POST" enctype="multipart/form-data"> -->
                <div class="modal-body">
                    <input type="text" class="form-control" id="idDelMhs" name="idDel" style="display: none;">
                    <p>Anda yakin ingin menghapus data wali dosen? (<b id="nameDelMhs"></b>)</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button onclick="removeMhsProcess(this)" class="btn btn-danger">Remove</button>
                </div>
                <!-- </form> -->
            </div>
        </div>
    </div>

    <?= $this->include('admin/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <?= $this->include('admin/kelas/js/detail-js') ?>
</body>

</html>