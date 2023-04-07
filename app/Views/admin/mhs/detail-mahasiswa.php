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
                                    Profil Mahasiswa
                                </div>
                                <div class="card-body">
                                    <div class="col-12 d-flex justify-content-center align-items-center">
                                        <img class="img-fluid" style="height:200px" src="<?=base_url()?>uploads/user/<?=$detail_mhs->username?>/profil_pic/<?=$detail_mhs->foto?>">
                                    </div>
                                    <div class="col-12 mt-2">
                                        <table style="text-align:center" class="table">
                                            <tr>
                                                <td><?=$detail_mhs->nama?></td>
                                            </tr>
                                            <tr>
                                                <td>NIM: <?=$detail_mhs->nim?></td>
                                            </tr>
                                            <tr>
                                                <td>No. Telp: <?=$detail_mhs->kontak?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$detail_mhs->jenisKelamin == "L"? 'Laki-laki': 'Perempuan'?></td>
                                            </tr>
                                            <tr>
                                                <td><?=$detail_mhs->userType?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Status: 
                                                    <?php if ($detail_mhs->statusAkademik == 'aktif') { ?><div class="badge bg-success">
                                                    <?php }elseif ($detail_mhs->statusAkademik == 'cuti'){?><div class="badge bg-secondary">
                                                    <?php }elseif ($detail_mhs->statusAkademik == 'keluar'){?><div class="badge bg-warning">
                                                    <?php }elseif ($detail_mhs->statusAkademik == 'lulus'){?><div class="badge bg-secondary">
                                                    <?php }elseif ($detail_mhs->statusAkademik == 'mangkir'){?><div class="badge bg-danger">
                                                    <?php }elseif ($detail_mhs->statusAkademik == 'meninggal'){?><div class="badge bg-secondary">
                                                    <?php }elseif ($detail_mhs->statusAkademik == 'dropout'){?><div class="badge bg-danger">
                                                    <?php }?>
                                                        <?=$detail_mhs->statusAkademik?></div>
                                                </td>
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
                                                                <?=$detail_mhs->nama?>
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
                                                                <?=$detail_mhs->nik?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="py-1">
                                                    <div class="row">
                                                        <div class="col-xl-2">
                                                            <div>
                                                                Tempat, Tanggal Lahir :
                                                            </div>
                                                        </div>
                                                        <div class="col-xl">
                                                            <div class="text-muted">
                                                                <?= $detail_mhs->tempatLahir ?>, <?= $detail_mhs->tanggalLahir ?>
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
                                                                <?=$detail_mhs->email?>
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
                                                                <?=$detail_mhs->alamat?>
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
                                                                <?=$detail_mhs->kontak?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="py-1">
                                                    <div class="row">
                                                        <div class="col-xl-2">
                                                            <div>
                                                                Nama Ibu :
                                                            </div>
                                                        </div>
                                                        <div class="col-xl">
                                                            <div class="text-muted">
                                                                <?=$detail_mhs->namaIbu?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="py-1">
                                                    <div class="row">
                                                        <div class="col-xl-2">
                                                            <div>
                                                                Kontak Ibu :
                                                            </div>
                                                        </div>
                                                        <div class="col-xl">
                                                            <div class="text-muted">
                                                                <?=$detail_mhs->kontakIbu?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="py-1">
                                                    <div class="row">
                                                        <div class="col-xl-2">
                                                            <div>
                                                                Nama Ayah :
                                                            </div>
                                                        </div>
                                                        <div class="col-xl">
                                                            <div class="text-muted">
                                                                <?=$detail_mhs->namaAyah?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="py-1">
                                                    <div class="row">
                                                        <div class="col-xl-2">
                                                            <div>
                                                                Kontak Ayah :
                                                            </div>
                                                        </div>
                                                        <div class="col-xl">
                                                            <div class="text-muted">
                                                                <?=$detail_mhs->kontakAyah ? $detail_mhs->kontakAyah : '-' ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="py-1">
                                                    <div class="row">
                                                        <div class="col-xl-2">
                                                            <div>
                                                                Nama Wali :
                                                            </div>
                                                        </div>
                                                        <div class="col-xl">
                                                            <div class="text-muted">
                                                                <?=$detail_mhs->namaWali ? $detail_mhs->namaWali : '-' ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="py-1">
                                                    <div class="row">
                                                        <div class="col-xl-2">
                                                            <div>
                                                                Kontak Wali :
                                                            </div>
                                                        </div>
                                                        <div class="col-xl">
                                                            <div class="text-muted">
                                                                <?=$detail_mhs->kontakWali ? $detail_mhs->kontakWali: '-' ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                                            <div class="m-3">
                                                <form action="<?= url_to('update-mahasiswa-1', $detail_mhs->user_id) ?>" method="POST" id="ubahProfil" enctype="multipart/form-data">
                                                    <div class="mb-3">
                                                        <label class="form-label">NAMA <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="nama" value="<?=$detail_mhs->nama?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">NIM <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control numeric-input" name="nim" value="<?=$detail_mhs->nim?>" id="nimNumber" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">NIK <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="nik" min="1000000000000000" max="9999999999999999" value="<?=$detail_mhs->nik?>" name="nik" disabled>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">JENIS KELAMIN <span class="text-danger">*</span></label>
                                                        <select class="form-select" name="jenisKelamin" required>
                                                            <option value="L" <?=($detail_mhs->jenisKelamin == 'L')?'selected':''?>>Laki-Laki</option>
                                                            <option value="P" <?=($detail_mhs->jenisKelamin == 'P')?'selected':''?>>Perempuan</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">TEMPAT/TANGGAL LAHIR <span class="text-danger">*</span></label>
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <input type="text" class="form-control" name="tempatLahir" value="<?=$detail_mhs->tempatLahir?>" required>
                                                            </div>
                                                            <div class="col-8">
                                                                <input type="date" class="form-control" name="tanggalLahir" value="<?=$detail_mhs->tanggalLahir?>" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">ALAMAT <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="alamat" value="<?=$detail_mhs->alamat?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">EMAIL <span class="text-danger">*</span></label>
                                                        <input type="email" class="form-control" name="email" value="<?=$detail_mhs->email?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">KONTAK <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control numeric-input" name="kontak" value="<?=$detail_mhs->kontak?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">NAMA IBU KANDUNG/ANGKAT <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="namaIbu" value="<?=$detail_mhs->namaIbu?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">KONTAK IBU KANDUNG/ANGKAT</label>
                                                        <input type="text" class="form-control numeric-input" name="kontakIbu" value="<?=$detail_mhs->kontakIbu?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">NAMA AYAH KANDUNG/ANGKAT <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="namaAyah" value="<?=$detail_mhs->namaAyah?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">KONTAK AYAH KANDUNG/ANGKAT</label>
                                                        <input type="text" class="form-control numeric-input" name="kontakAyah" value="<?=$detail_mhs->kontakAyah?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">NAMA WALI</label>
                                                        <input type="text" class="form-control" name="namaWali" value="<?=$detail_mhs->namaWali?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">KONTAK WALI</label>
                                                        <input type="text" class="form-control numeric-input" name="kontakWali" value="<?=$detail_mhs->kontakWali?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label">FOTO MAHASISWA</label>
                                                        <input class="form-control" type="file" name="fileUpload" id="formFile" accept="image/jpeg">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">STATUS AKADEMIK <span class="text-danger">*</span></label>
                                                        <select class="form-select" name="statusAkademik" required>
                                                            <option value="aktif" <?=($detail_mhs->statusAkademik == 'aktif')?'selected':''?>>Aktif</option>
                                                            <option value="cuti" <?=($detail_mhs->statusAkademik == 'cuti')?'selected':''?>>Cuti</option>
                                                            <option value="keluar" <?=($detail_mhs->statusAkademik == 'keluar')?'selected':''?>>Keluar</option>
                                                            <option value="mangkir" <?=($detail_mhs->statusAkademik == 'mangkir')?'selected':''?>>Mangkir</option>
                                                            <option value="lulus" <?=($detail_mhs->statusAkademik == 'lulus')?'selected':''?>>Lulus</option>
                                                            <option value="meninggal" <?=($detail_mhs->statusAkademik == 'meninggal')?'selected':''?>>Meninggal</option>
                                                            <option value="dropout" <?=($detail_mhs->statusAkademik == 'dropout')?'selected':''?>>Dropout</option>
                                                        </select>
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
                                                <form action="<?= url_to('update-pass-mahasiswa-1', $detail_mhs->user_id) ?>" id="ubahPassword" method="POST">
                                                    <div class="mb-3">
                                                        <label for="formFile" class="form-label">USERNAME <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="username" value="<?=$detail_mhs->username?>" autocomplete="off" disabled>
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
                    konfirmasi untuk mengubah password ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="ubahPassword" class="btn btn-primary">Ubah</button>
                </div>
            </div>
        </div>
    </div>    

    <?= $this->include('admin/partials/partial-footer') ?>
    
</body>

</html>