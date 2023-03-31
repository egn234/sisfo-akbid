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
                    <h1 class="mt-4">Pertanyaan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><a href="<?= url_to('mahasiswa/kuesioner') ?>"><?= $title ?></a></li>
                        <li class="breadcrumb-item active">Pertanyaan</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Pertanyaan
                        </div>
                        <div class="card-body">
                            <?php
                            //print_r($list_pertanyaan);
                            for ($i = 0; $i < count($list_pertanyaan); $i++) {
                            ?>
                                <div class="card" style="width: 100%;">
                                    <div class="card-header" style="background-color: white;">
                                        <h5 class="card-title"><?= $list_pertanyaan[$i]->pertanyaan ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if ($list_pertanyaan[$i]->jenis_pertanyaan == 'Essay') { ?>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                        <?php } else { ?>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Default checkbox
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card-footer">
                            <div class="btn-group">
                                <button class="btn btn-primary">
                                    Submit
                                </button>
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
    <?= $this->include('mahasiswa/kuesioner/js/kuesioner-js') ?>
</body>

</html>