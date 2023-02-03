<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $this->include('admin/partials/partial-head') ?>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/datatables/datatables.min.css"/>
    </head>

    <body class="sb-nav-fixed">
        
        <?= $this->include('admin/partials/partial-topbar') ?>

        <div id="layoutSidenav">
            <?= $this->include('admin/partials/partial-sidebar') ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"><?=$title?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Berkas & Dokumen</li>
                            <li class="breadcrumb-item active">Dokumen Surat</li>
                            <li class="breadcrumb-item active"><?=$title?></li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-book-open me-1"></i>
                                Detail Dokumen / Surat
                            </div>
                            <div class="card-body">
                                <?= session()->getFlashdata('notif')?>
                                <table class="table">
                                    <tr>
                                        <td>Pemohon</td>
                                        <td>:</td>
                                        <td><b><?=$detail_surat->nama_lengkap?></b></td>
                                    </tr>
                                    <tr>
                                        <td>NIP</td>
                                        <td>:</td>
                                        <td><b><?=$detail_surat->nip?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Judul</td>
                                        <td>:</td>
                                        <td><b><?=$detail_surat->judul_surat?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Upload</td>
                                        <td>:</td>
                                        <td><b><?=$detail_surat->tanggal_upload?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Dokumen / Surat</td>
                                        <td>:</td>
                                        <td><b><?=$detail_surat->nama_kategori?></b></td>
                                    </tr>
                                    <tr>
                                        <td>File</td>
                                        <td>:</td>
                                        <td>
                                            <a href="<?= base_url() ?>/uploads/user/<?=$detail_surat->username?>/doc/<?=$detail_surat->file_dosen?>" download="<?=$detail_surat->file_dosen?>">
                                                <b><?=$detail_surat->file_dosen?></b>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php if($detail_surat->file_sekpem){?>
                                        <tr>
                                            <td>File TTD</td>
                                            <td>:</td>
                                            <td>
                                                <a href="<?= base_url() ?>/uploads/user/<?=$detail_surat->username?>/doc/<?=$detail_surat->file_sekpem?>" download="<?=$detail_surat->file_sekpem?>">
                                                    <b><?=$detail_surat->file_sekpem?></b>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </table>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <a class="btn btn-success m-1 <?=($detail_surat->flag != 2)?'disabled':''?>" data-bs-toggle="modal" data-bs-target="#ttdDokumen">
                                        Upload TTD dokumen
                                    </a>
                                </div>
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

        <div id="ttdDokumen" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPengajuanLabel">Konfirmasi Revisi Dokumen</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= url_to('admin_ttd_dokumen', $detail_surat->idsurat) ?>" id="formTTD" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="doc_upload">Dokumen yang telah di TTD (.pdf)</label>
                                <input type="file" class="form-control" id="doc_upload" name="file_sekpem" accept=".pdf" required>
                                <input type="text" class="form-control" name="judul_surat" value="<?= $detail_surat->judul_surat ?>" hidden>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn btn-primary" form="formTTD">Upload</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal -->

        <?= $this->include('admin/partials/partial-footer') ?> 

    </body>
</html>

