<!DOCTYPE html>
<html lang="en">

<head>
    <?= $this->include('dosen/partials/partial-head') ?>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/datatables/datatables.min.css" />
</head>

<body class="sb-nav-fixed">

    <?= $this->include('dosen/partials/partial-topbar') ?>

    <div id="layoutSidenav">
        <?= $this->include('dosen/partials/partial-sidebar') ?>

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
                            Daftar mata kuliah yang diampu semester ini
                        </div>
                        <div class="card-body">
                            <?= session()->getFlashdata('notif') ?>
                            <table id="dataTable" class="table table-bordered w-100">
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

    <?= $this->include('dosen/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                ajax: {
                    url: "<?= base_url() ?>dosen/bap/data-matkul",
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
                        title: "Hari",
                        data: "day"
                    },
                    {
                        title: "Jam",
                        render: function(data, type, row) {
                            return row.startTime + " - " + row.endTime;
                        }
                    },
                    {
                        title: "Ruangan",
                        data: "kodeRuangan"
                    },
                    {
                        title: "Kelola Nilai",
                        render: function(data, type, row) {
                            let button
                            let link = "<?= base_url() ?>dosen/nilai/list-mhs/" + row.id
                            button = "<a href='" + link + "' class='btn btn-sm btn-primary'><i class='fa fa-search'></i></a>"
                            return button
                        }
                    }
                ],
                scrollX: true
            });

            table.draw();
        });
    </script>
</body>

</html>