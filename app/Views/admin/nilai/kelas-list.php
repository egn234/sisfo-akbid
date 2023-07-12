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
                    <h1 class="mt-4"><?= $title ?></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Kelas
                            <div class="btn-group float-end">
                                <button data-bs-toggle="modal" data-bs-target="#createData" class="btn btn-sm btn-primary">
                                    Tambah Kelas
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= session()->getFlashdata('notif') ?>
                            <table id="dataTable" class="table table-bordered table-sm">
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
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                ajax: {
                    url: "<?= base_url() ?>admin/nilai/data-kelas",
                    dataSrc: "list_kelas"
                },
                columnDefs: [{
                    searchable: true,
                    orderable: false,
                    targets: "_all",
                    defaultContent: "-",
                }, ],
                data: [],
                columns: [{
                        title: 'No',
                        "render": function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        title: 'Kode Kelas',
                        data: "kodeKelas"
                    },
                    {
                        title: 'Status',
                        data: 'flag',
                        render: function(data, type, row, full) {
                            if (type === 'display') {
                                let html
                                if (data == 1) {
                                    html = '<span class="badge rounded-pill bg-success">Aktif</span>'
                                } else {
                                    html = '<span class="badge rounded-pill bg-danger">Non-Aktif</span>'
                                }
                                return html
                            }
                            return data
                        }
                    },
                    {
                        title: "Kelola Nilai",
                        render: function(data, type, row) {
                            let button
                            let link = "<?= base_url() ?>admin/nilai/list-mhs/" + row.id
                            button = "<a href='" + link + "' class='btn btn-sm btn-primary'><i class='fa fa-search'></i></a>"
                            return button
                        }
                    }
                ],
                "responsive": true,
                "autoWidth": false,
                "scrollX": true,
            });

            table.draw();
        });
    </script>
</body>

</html>