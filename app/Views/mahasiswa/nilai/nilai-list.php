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


    <?= $this->include('mahasiswa/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                ajax: {
                    url: "<?= base_url() ?>mahasiswa/nilai/data-nilai",
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
                ],
                scrollX: true
            });

            table.draw();
        });
    </script>

</body>

</html>