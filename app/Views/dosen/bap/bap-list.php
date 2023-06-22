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
                            Daftar Berita Acara Perkuliahan (BAP)
                            <div class="btn-group float-end">
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createBap">
                                    Buat BAP baru
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?= session()->getFlashdata('notif') ?>
                            <table id="dataTable" class="table table-sm table-bordered w-100">
                                <!-- Load From ajax -->
                            </table>
                        </div>
                    </div>
                </div>
            </main>
            <?= $this->include('partials/footer') ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createBap" tabindex="-1" aria-labelledby="createBapLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBapLabel">Buat BAP Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form method="post" class="form" id="buatBap" action="<?= url_to('dosen/bap/create-bap') ?>">
                    <div class="mb-3">
                        <label for="pertemuan" class="form-label">Pertemuan</label>
                        <select class="form-select" name="pertemuan" id="pertemuan">
                            <option value=""> -- Pilih Minggu --</option>
                            <?php
                                for ($i = 1; $i <= 20; $i++) {
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                            ?>
                        </select>
                        <p id="warningMsg" style="display: none; color: red;">Pilih terlebih dahulu untuk minggu pertemuan nya.</p>
                    </div>
                    <div class="mb-3">
                        <label for="materi" class="form-label">Materi yang dibahas</label>
                        <input type="text" class="form-control" id="materi" name="materi">
                    </div>
                    <input type="text" class="form-control" name="jadwal_id" value="<?= service('request')->uri->getSegment(4) ?>" hidden>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" form="buatBap" id="submitBtn" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('dosen/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                "ajax": {
                    "url": "<?= base_url() ?>dosen/bap/data-bap/<?=$jadwal_id?>",
                    "dataSrc": "data"
                },
                "columnDefs": [
                    {
                        "searchable": true,
                        "orderable": false,
                        "targets": "_all",
                        "defaultContent": "-",
                    }
                ],
                "columns": [
                    { 
                        "title": "No",
                        "render": function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        "title": "Minggu ke-",
                        "data": "mingguPertemuan"
                    },
                    {
                        "title": "Materi Perkuliahan",
                        "data": "materiPertemuan"
                    },
                    {
                        "title": "Tanggal Submit",
                        "data": "created_at"
                    },
                    {
                        "title": "Status",
                        render: function(data, type, row) {
                            let html
                            
                            if (row.data_hadir == "0") {
                                html = "<span class='badge bg-success'>Open</span>"
                            } else {
                                html = "<span class='badge bg-danger'>Closed</span>"
                            }

                            return '<div class="text-center">' + html + '</div>'
                        }
                    },
                    {
                        "title": "Daftar Hadir",
                        render: function(data, type, row) {
                            let html = "<a href='<?= base_url()?>dosen/bap/detail-bap/"+row.id+"' class='btn btn-primary btn-sm'><i class='fa fa-search'></i></a>"
                            return '<div class="text-center">' + html + '</div>'
                        }
                    },
                    
                ],
                "scrollX": true
            });

            $('#buatBap').submit(function(event) {
                var selectedValue = $('#pertemuan').val();
                if (selectedValue === "") {
                    event.preventDefault(); // Prevent form submission
                    $('#warningMsg').show(); // Show the warning message
                }
            });
            
            table.draw();
        });
    </script>
</body>

</html>