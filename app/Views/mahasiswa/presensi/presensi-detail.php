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
                            Presensi Mahasiswa
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


    <?= $this->include('mahasiswa/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                ajax: {
                    url: "<?= base_url() ?>mahasiswa/presensi/data-presensi/<?= $duser->id ?>",
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
                        title: "Jumlah Kehadiran",
                        data: "jum_kehadiran"
                    },
                    {
                        title: "Jumlah Perkuliahan",
                        data: "jum_perkuliahan"
                    },
                    {
                        title: "Persentase Kehadiran",
                        render: function(data, type, row) {
                            var hasil = 0;
                            if (row.jum_perkuliahan != 0){
                                hasil = (row.jum_kehadiran / row.jum_perkuliahan) * 100;
                            }
                            return hasil + "%";
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