<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $this->include('dekan/partials/partial-head') ?>
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/datatables/datatables.min.css"/>
    </head>

    <body class="sb-nav-fixed">
        
        <?= $this->include('dekan/partials/partial-topbar') ?>

        <div id="layoutSidenav">
            <?= $this->include('dekan/partials/partial-sidebar') ?>

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
                                <i class="fas fa-table me-1"></i>
                                Daftar Pengajuan Surat & Dokumen
                                <div class="btn-group float-end">
                                    <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addPengajuan">
                                        Tambah Pengajuan
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <?= session()->getFlashdata('notif')?>
                                <table id="dataTable" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th width="5%">No.</th>
                                            <th>Dosen</th>
                                            <th>NIP</th>
                                            <th>Judul</th>
                                            <th>Kategori</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $c = 1 ?>
                                        <?php foreach ($list_surat as $a) {?>
                                            <tr>
                                                <td><?=$c?></td>
                                                <td><?=$a->nama_lengkap?></td>
                                                <td><?=$a->nip?></td>
                                                <td><?=$a->judul_surat?></td>
                                                <td><?=$a->nama_kategori?></td>
                                                <td>
                                                    <div class="btn-group d-flex align-items-center">
                                                        <a  href="<?= url_to('admin_detail_dokumen', $a->idsurat) ?>" class="btn btn-sm btn-primary">
                                                            <span class="fa fa-search"></span> Detail
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php $c++; ?>
                                        <?php }?>
                                    </tbody>
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

        <?= $this->include('dekan/partials/partial-footer') ?> 
        
        <script type="text/javascript" src="<?=base_url()?>/assets/datatables/datatables.min.js"></script>
        <script type="text/javascript">
            $('#dataTable').DataTable();
        </script>

    </body>
</html>

