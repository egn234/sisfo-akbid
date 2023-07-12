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
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Indeks Prestasi Kumulatif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <table class="table w-100">
                                        <tr>
                                            <td>IPK Keseluruhan</td>
                                            <td>:</td>
                                            <td><?=number_format($total_ipk['ipk'], 2, '.', '')?></td>
                                        </tr>
                                        <tr>
                                            <td>SKS yang diambil</td>
                                            <td>:</td>
                                            <td><?=$total_ipk['sks']?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-6">
                                    <table class="table w-100">
                                        <tr>
                                            <td>Total IPK saat ini</td>
                                            <td>:</td>
                                            <td><?=number_format($ipk_now['ipk'], 2, '.', '')?></td>
                                        </tr>
                                        <tr>
                                            <td>SKS yang diambil saat ini</td>
                                            <td>:</td>
                                            <td><?=$ipk_now['sks']?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Matakuliah
                        </div>
                        <div class="card-body">
                            <?= session()->getFlashdata('notif') ?>
                            <table id="dataTable" class="table table-bordered table-striped w-100">
                                <!-- Load From ajax -->
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?= $this->include('partials/footer') ?>
        </div>
    </div>

    <!-- CRUD Modal -->
    <div id="editNilai" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <span id="fetch-editNilai"></span>
            </div>
        </div>
    </div><!-- /.modal -->

    <?= $this->include('admin/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                ajax: {
                    url: "<?= base_url() ?>admin/nilai/data-nilai/<?=$mhs_id?>",
                    dataSrc: "data"
                },
                columnDefs: [{
                    searchable: true,
                    orderable: false,
                    targets: "_all",
                    defaultContent: "-",
                }],
                columns: [
                    { 
                        title: "No",
                        "render": function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        title: "Mata Kuliah",
                        render: function(data, type, row) {
                            return row.kodeMatkul + " - " + row.namaMatkul;
                        }
                    },
                    {
                        title: "SKS",
                        data: "sks"
                    },
                    {
                        title: "Tingkat",
                        data: "tingkat"
                    },
                    {
                        title: "Semester",
                        data: "semester"
                    },
                    {
                        title: "Tugas",
                        data: "nilaiTugas"
                    },
                    {
                        title: "Praktek",
                        data: "nilaiPraktek"
                    },
                    {
                        title: "UTS",
                        data: "nilaiUTS"
                    },
                    {
                        title: "UAS",
                        data: "nilaiUAS"
                    },
                    {
                        title: "Nilai Akhir",
                        data: "nilaiAkhir"
                    },
                    {
                        title: "Indeks",
                        data: "indeksNilai"
                    },
                    {
                        "title": "Aksi",
                        "render": function(data, type, row) {
                            let html = `
                                <a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editNilai" data-id="${row.id}" data-id2="${row.matakuliahID}">
                                    <i class="fa fa-file-alt"></i>
                                </a>
                            `
                            return html;
                        }
                    },
                ],
                scrollX: true
            });

            $('#editNilai').on('show.bs.modal', function(e) {
                var rowid = $(e.relatedTarget).data('id');
                var matkulId = $(e.relatedTarget).data('id2')
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url() ?>/admin/nilai/edit-nilai',
                    data: {rowid: rowid, matkulId: matkulId},
                    success: function(data) {
                        $('#fetch-editNilai').html(data); //menampilkan data ke dalam modal
                    }
                });
            });

            table.draw();
        });
    </script>

</body>

</html>