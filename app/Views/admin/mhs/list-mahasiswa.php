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
                            <li class="breadcrumb-item active"><?=$title?></li>
                        </ol>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Daftar Mahasiswa
                                <div class="btn-group float-end">
                                    <a href="<?= url_to('admin/mahasiswa/add') ?>" class="btn btn-sm btn-primary">
                                        Tambah Mahasiswa
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <?= session()->getFlashdata('notif')?>
                                <table id="dataTable" class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th width="5%">No.</th>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>JK</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $c = 1 ?>
                                        <?php foreach ($list_mhs as $a) {?>
                                            <tr>
                                                <td><?=$c?></td>
                                                <td><?=$a->nim?></td>
                                                <td><?=$a->nama?></td>
                                                <td><?=$a->jenisKelamin?></td>
                                                <td>
                                                    <div class="btn-group d-flex align-items-center">
                                                        <?php if($a->flag == 1){?>
                                                            <a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#switchMahasiswa" data-id="<?=$a->user_id?>">
                                                                Nonaktifkan
                                                            </a>
                                                        <?php }else{?>
                                                            <a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#switchMahasiswa" data-id="<?=$a->user_id?>">
                                                                Aktifkan
                                                            </a>
                                                        <?php }?>
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
        
        <div id="updateKategori" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <span class="fetched-data"></span>
                </div>
            </div>
        </div><!-- /.modal -->

        <div id="switchMahasiswa" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <span class="fetched-data"></span>
                </div>
            </div>
        </div><!-- /.modal -->

        <?= $this->include('admin/partials/partial-footer') ?> 
        
        <script type="text/javascript" src="<?=base_url()?>/assets/datatables/datatables.min.js"></script>
        <script type="text/javascript">
            $('#dataTable').DataTable();
            $('#switchMahasiswa').on('show.bs.modal', function(e) {
                var rowid = $(e.relatedTarget).data('id');
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>/admin/mahasiswa/switch-mhs',
                    data: 'rowid=' + rowid,
                    success: function(data) {
                        $('.fetched-data').html(data);
                    }
                });
            });
        </script>

    </body>
</html>

