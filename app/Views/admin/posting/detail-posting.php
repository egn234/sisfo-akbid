<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('admin/partials/partial-head') ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/datatables/datatables.min.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

</head>

<body class="sb-nav-fixed">

    <?= $this->include('admin/partials/partial-topbar') ?>

    <div id="layoutSidenav">
        <?= $this->include('admin/partials/partial-sidebar') ?>

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
                                    <?php //print_r($list_posting[0]->attachment)?>
                                    <img src="<?php echo base_url('uploads/posts').'/'.$list_posting[0]->attachment ?>" width="400" class="img-fluid img-thumbnail rounded mx-auto d-block" alt="Responsive image">
                                </div>
                                <div class="col-lg-8">
                                    <h4 class="text-center"><?= $list_posting[0]->judul ?></h4>
                                    <div class="form-group">
                                        <label >Deskripsi</label>
                                        <textarea class="form-control ckeditor1" id="deskripsi" rows="12" readonly><?= $list_posting[0]->deskripsi ?></textarea>
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


    <?= $this->include('admin/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <?= $this->include('admin/posting/js/posting-js') ?>
</body>

</html>