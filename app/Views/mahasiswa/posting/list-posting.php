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
                    <h1 class="mt-4"><?= $title ?></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Posting
                        </div>
                        <div class="card-body">
                            <?php
                            $allData = $posting_limit;
                            $previous = $halaman - 1;
                            $next = $halaman + 1;
                            foreach ($allData as $data) {
                            ?>
                                <div class="row mt-3" style="padding-left: 40px; padding-right: auto;">
                                    <div style="width: 96%; border: 2px solid gray; border-radius: 25px; height: 125px;">
                                        <div class="row ">
                                            <div class="col-lg-2" style="padding-top: 5px; padding-left: 15px;">
                                                <img src="<?php echo base_url('uploads/post').'/'.$data->attachment ?>" data-url="<?= $data->attachment ?>" width="100" height="100" alt="pic">
                                            </div>
                                            <div class="col-lg-8" style="padding-top: 30px;">
                                                <h5 class="text-justify"><?= $data->judul ?></h5>
                                                <p class="text-justify"><?= $data->deskripsi ?></p>
                                            </div>
                                            <div class="col-lg-2" style=" padding-top: 38px; padding-right: 80px;">
                                                <div class="btn-group float-end">
                                                    <a href="<?= base_url('mahasiswa/posting/detail').'/'.$data->id ?>" class="btn btn-lg btn-primary">
                                                        Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="row mt-3 float-end">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination">
                                        <li class="page-item">
                                            <a class="page-link" <?php echo ($halaman > 1) ? "href='?halaman=$previous'" : ''; ?> aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                        </li>
                                        <?php
                                        $jumlah = 1;
                                        if ($total_halaman % 10 == 0) {
                                            $jumlah = $jumlah + $total_halaman;
                                        }
                                        for ($x = $jumlah; $x <= $total_halaman; $x++) {
                                        ?>
                                            <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?= $x; ?></a></li>
                                        <?php } ?>
                                        <li class="page-item">
                                            <a class="page-link" <?php echo ($halaman < $total_halaman) ? "href='?halaman=$next'" : ''; ?> aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?= $this->include('partials/footer') ?>
        </div>
    </div>


    <?= $this->include('mahasiswa/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <?= $this->include('mahasiswa/posting/js/posting-js') ?>
</body>

</html>