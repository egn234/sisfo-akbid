<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('mahasiswa/partials/partial-head') ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/datatables/datatables.min.css" />
</head>

<body class="sb-nav-fixed">

    <?= $this->include('mahasiswa/partials/partial-topbar') ?>

    <div id="layoutSidenav">
        <?= $this->include('mahasiswa/partials/partial-sidebar') ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Detail Posting</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"> <a href="<?= url_to('mahasiswa/posting'); ?>"><?= $title ?></a></li>
                        <li class="breadcrumb-item active">Detail Posting</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Detail Posting
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <img src="<?php echo base_url('img/people.png') ?>" width="400" class="img-fluid img-thumbnail rounded mx-auto d-block" alt="Responsive image">
                                </div>
                                <div class="col-lg-8">
                                    <h4 class="text-center"><?= $list_posting[0]->judul ?></h4>
                                    <div class="form-group">
                                        <label >Deskripsi</label>
                                        <textarea class="form-control" id="deskripsi" rows="12" readonly><?= $list_posting[0]->deskripsi ?></textarea>
                                    </div>
                                </div>
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


    <?= $this->include('mahasiswa/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <?= $this->include('mahasiswa/posting/js/posting-js') ?>
</body>

</html>