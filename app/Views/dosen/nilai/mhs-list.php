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
                            Detail Berita Acara Perkuliahan
                        </div>
                        <div class="card-body">
                            <table id="infoBap" class="w-100">
                                <tr>
                                    <td>Dosen Pengajar</td>
                                    <td>:</td>
                                    <td><?=$detail_matkul->nama?> / <?=$detail_matkul->kodeDosen?></td>
                                </tr>
                                <tr>
                                    <td>Semester / Tahun Ajaran</td>
                                    <td>:</td>
                                    <td><?=$detail_matkul->semester.' '.$detail_matkul->tahunPeriode?></td>
                                </tr>
                                <tr>
                                    <td>SKS</td>
                                    <td>:</td>
                                    <td><?=$detail_matkul->sks?></td>
                                </tr>
                                <tr>
                                    <td>Jadwal</td>
                                    <td>:</td>
                                    <td><?=$detail_matkul->day.', '.$detail_matkul->startTime.' - '.$detail_matkul->endTime?></td>
                                </tr>
                                <tr>
                                    <td>Ruangan</td>
                                    <td>:</td>
                                    <td><?=$detail_matkul->namaRuangan.' - '.$detail_matkul->kodeRuangan?></td>
                                </tr>
                            </table>
                            <div class="mt-5 mb-2">
                                Daftar Mahasiswa
                            </div>
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

    <!-- Modal -->
    <div class="modal fade" id="konfirAbsensi" tabindex="-1" aria-labelledby="createBapLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBapLabel">Buat BAP Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Submit data kehadiran untuk BAP ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" form="kehadiran" id="submitBtn" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div id="editNilai" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <span id="fetch-editNilai"></span>
            </div>
        </div>
    </div><!-- /.modal -->

    <?= $this->include('dosen/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <script>
        $(document).ready(function() {
            var table = $('#dataTable').DataTable({
                "ajax": {
                    "url": "<?= base_url() ?>dosen/nilai/data-mhs/<?=$detail_matkul->id?>",
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
                        "title": "Kelas",
                        "data": "kodeKelas"
                    },
                    {
                        "title": "Tugas",
                        "data": "nilaiTugas"
                    },
                    {
                        "title": "Praktek",
                        "data": "nilaiPraktek"
                    },
                    {
                        "title": "UTS",
                        "data": "nilaiUTS"
                    },
                    {
                        "title": "UAS",
                        "data": "nilaiUAS"
                    },
                    {
                        "title": "Nilai Akhir",
                        "data": "nilaiAkhir"
                    },
                    {
                        "title": "Indeks",
                        "data": "indeksNilai"
                    },
                    {
                        "title": "Aksi",
                        "render": function(data, type, row) {
                            let html = `
                                <a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editNilai" data-id="${row.id}" data-id2="${row.matakuliahID}">
                                    <i class="fa fa-file-alt"></i> Setujui
                                </a>
                            `
                            return html;
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
                    url: '<?= base_url() ?>/dosen/nilai/edit-nilai',
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