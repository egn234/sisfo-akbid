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
                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <div class="card mb-4">
                                <div class="card-header">
                                    Profil Dosen
                                </div>
                                <div class="card-body">
                                    <div class="col-12 d-flex justify-content-center align-items-center">
                                        <img class="img-fluid" style="height:200px" src="<?= base_url() ?>uploads/user/<?= $detail_dosen->username ?>/profil_pic/<?= $detail_dosen->foto ?>">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <table style="text-align:center" class="table">
                                            <tr>
                                                <td><?= $detail_dosen->nama ?></td>
                                            </tr>
                                            <tr>
                                                <td>NIP: <?= $detail_dosen->nip ?></td>
                                            </tr>
                                            <tr>
                                                <td>Kode Dosen: <?= $detail_dosen->kodeDosen ?></td>
                                            </tr>
                                            <tr>
                                                <td>No. Telpon: <?= $detail_dosen->kontak ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= $detail_dosen->jenisKelamin == "L" ? 'Laki-laki' : 'Perempuan' ?></td>
                                            </tr>
                                            <tr>
                                                <td><?= $detail_dosen->userType ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-9">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-table me-1"></i>

                                </div>
                                <div class="card-body">
                                    <?= session()->getFlashdata('notif') ?>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Biodata</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button" role="tab" aria-controls="edit" aria-selected="false">Ubah Profil</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="edit-tab" data-bs-toggle="tab" data-bs-target="#pass_edit" type="button" role="tab" aria-controls="pass_edit" aria-selected="false">Ubah Password</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="edit-tab" data-bs-toggle="tab" data-bs-target="#detail" type="button" role="tab" aria-controls="detail" aria-selected="false">Detail</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">

                                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                            <div class="col-12 m-3">
                                                <div class="pb-1">
                                                    <div class="row">
                                                        <div class="col-xl-2">
                                                            <div>
                                                                Nama Lengkap:
                                                            </div>
                                                        </div>
                                                        <div class="col-xl">
                                                            <div class="text-muted">
                                                                <?= $detail_dosen->nama ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pb-1">
                                                    <div class="row">
                                                        <div class="col-xl-2">
                                                            <div>
                                                                Program Studi:
                                                            </div>
                                                        </div>
                                                        <div class="col-xl">
                                                            <div class="text-muted">
                                                                <?= $detail_dosen->strata.' '.$detail_dosen->nama_prodi ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="py-1">
                                                    <div class="row">
                                                        <div class="col-xl-2">
                                                            <div>
                                                                NIK :
                                                            </div>
                                                        </div>
                                                        <div class="col-xl">
                                                            <div class="text-muted">
                                                                <?= $detail_dosen->nik ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="py-1">
                                                    <div class="row">
                                                        <div class="col-xl-2">
                                                            <div>
                                                                Email :
                                                            </div>
                                                        </div>
                                                        <div class="col-xl">
                                                            <div class="text-muted">
                                                                <?= $detail_dosen->email ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="py-1">
                                                    <div class="row">
                                                        <div class="col-xl-2">
                                                            <div>
                                                                Alamat :
                                                            </div>
                                                        </div>
                                                        <div class="col-xl">
                                                            <div class="text-muted">
                                                                <?= $detail_dosen->alamat ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="py-1">
                                                    <div class="row">
                                                        <div class="col-xl-2">
                                                            <div>
                                                                Kontak :
                                                            </div>
                                                        </div>
                                                        <div class="col-xl">
                                                            <div class="text-muted">
                                                                <?= $detail_dosen->kontak ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                                            <div class="m-3">
                                                <form action="<?= url_to('update-dosen-1', $detail_dosen->user_id) ?>" method="POST" id="ubahProfil" enctype="multipart/form-data">
                                                    <div class="mb-3">
                                                        <label class="form-label">NAMA <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="nama" value="<?= $detail_dosen->nama ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">NIP <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control numeric-input" name="nip" value="<?= $detail_dosen->nip ?>" id="nimNumber" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="nik" min="1000000000000000" max="9999999999999999" value="<?= $detail_dosen->nik ?>" name="nik" readonly>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">KODE DOSEN <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="kode_dosen" value="<?= $detail_dosen->kodeDosen ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="prodi">PROGRAM STUDI <span class="text-danger">*</span></label>
                                                        <select id="prodi" class="form-select" name="prodi" required></select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">JENIS KELAMIN <span class="text-danger">*</span></label>
                                                        <select class="form-select" name="jenisKelamin" required>
                                                            <option value="L" <?= ($detail_dosen->jenisKelamin == 'L') ? 'selected' : '' ?>>Laki-Laki</option>
                                                            <option value="P" <?= ($detail_dosen->jenisKelamin == 'P') ? 'selected' : '' ?>>Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">ALAMAT <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="alamat" value="<?= $detail_dosen->alamat ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">EMAIL <span class="text-danger">*</span></label>
                                                        <input type="email" class="form-control" name="email" value="<?= $detail_dosen->email ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">KONTAK <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control numeric-input" name="kontak" value="<?= $detail_dosen->kontak ?>" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label">FOTO DOSEN</label>
                                                        <input class="form-control" type="file" name="fileUpload" id="formFile" accept="image/jpeg">
                                                    </div>
                                                    <span class="text-xs text-danger">
                                                        <i>*Tidak boleh dikosongkan</i>
                                                    </span>
                                                    <div class="d-flex float-end btn-group">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="pass_edit" role="tabpanel" aria-labelledby="pass-tab">
                                            <div class="m-3">
                                                <form action="<?= url_to('update-pass-dosen-1', $detail_dosen->user_id) ?>" id="ubahPassword" method="POST">
                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label">USERNAME <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="username" value="<?= $detail_dosen->username ?>" autocomplete="off" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label">PASSWORD BARU<span class="text-danger">*</span></label>
                                                        <input type="password" class="form-control" name="password" autocomplete="off" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label">RE-TYPE PASSWORD <span class="text-danger">*</span></label>
                                                        <input type="password" class="form-control" name="password2" autocomplete="off" required>
                                                    </div>
                                                </form>
                                                <div class="d-flex float-end btn-group">
                                                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updatePass">
                                                        Submit
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="detail" role="tabpanel" aria-labelledby="pass-tab">
                                            <div class="m-3">
                                                <table id="dataTable" class="table table-bordered table-striped w-100">
                                                    <!-- Load From ajax -->
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?= $this->include('partials/footer') ?>
        </div>
    </div>

    <div class="modal fade" id="updatePass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Konfirmasi untuk ubah password ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="ubahPassword" class="btn btn-primary">Ubah</button>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('admin/partials/partial-footer') ?>
    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>

    <script>
        var table = $('#dataTable').DataTable({
            ajax: {
                url: "<?= base_url() ?>admin/dosen/data_history/<?= $detail_dosen->id ?>",
                dataSrc: "data",
            },
            columnDefs: [{
                searchable: true,
                orderable: false,
                targets: "_all",
                defaultContent: "-",
            }],
            columns: [{
                    title: "No",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    title: "Kode Kelas",
                    data:"kodeKelas"
                },
                {
                    title: "Angkatan",
                    data: "angkatan"
                },
                {
                    title: "Tahun Angkatan",
                    data: "tahunAngkatan"
                }
            ],
            responsive: true,
        });
                
        // Function to fetch lecturers via AJAX
        function fetchProdi() {
            $.ajax({
                url: '<?= base_url()?>/admin/dosen/data_prodi', // Replace with your CI4 route
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Populate the <select> element with the received data
                    var select = $('#prodi');
                    select.empty(); // Clear existing options

                    $.each(data, function (index, list_prodi) {
                        select.append($('<option>', {
                            value: list_prodi.id,
                            text: list_prodi.strata +' '+  list_prodi.nama_prodi
                        }));
                    });
                    // Set the selected option based on the student's lecturer_id
                    select.val(<?= $detail_dosen->prodiID ?>);
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        fetchProdi();
        table.draw();
    </script>

</body>

</html>