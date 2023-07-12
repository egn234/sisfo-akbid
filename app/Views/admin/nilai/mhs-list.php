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
                            Daftar Mahasiswa
                        </div>
                        <div class="card-body">
                            <?= session()->getFlashdata('notif') ?>
                            <table id="dataTable" class="table table-sm table-bordered table-striped w-100">
                                <!-- Load From ajax -->
                            </table>
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
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                "ajax": {
                    "url": "<?= base_url() ?>admin/nilai/data-mhs/<?=$id_kls?>",
                    "dataSrc": "data"
                },
                "searching": false,
                "paging": false,
                "columns": [
                    { 
                        "title": "No",
                        "render": function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        "title": "NIM",
                        "data": "nim"
                    },
                    {
                        "title": "Nama",
                        "data": "nama"
                    },
                    {
                        "title": "Pilih",
                        "render": function(data, type, row) {
                            let button
                            let link = "<?= base_url() ?>admin/nilai/detail-nilai/" + row.id
                            button = "<a href='" + link + "' class='btn btn-sm btn-primary'><i class='fa fa-search'></i></a>"
                            return button
                        }
                    },
                ],
                "scrollX": true
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