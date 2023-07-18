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
                            <?= session()->getFlashdata('notif') ?>
                            <table id="infoBap" class="w-100">
                                <tr>
                                    <td>Dosen Pengajar</td>
                                    <td>:</td>
                                    <td><?= $detail_bap->nama ?> / <?= $detail_bap->kodeDosen ?></td>
                                </tr>
                                <tr>
                                    <td>NIP</td>
                                    <td>:</td>
                                    <td><?= $detail_bap->nip ?></td>
                                </tr>
                                <tr>
                                    <td>Semester / Tahun Ajaran</td>
                                    <td>:</td>
                                    <td><?= $detail_bap->semester ?> <?= $detail_bap->tahunPeriode ?></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Input</td>
                                    <td>:</td>
                                    <td><?= $detail_bap->created_at ?></td>
                                </tr>
                                <tr>
                                    <td>Pertemuan</td>
                                    <td>:</td>
                                    <td><?= $detail_bap->mingguPertemuan ?></td>
                                </tr>
                                <tr>
                                    <td>Materi</td>
                                    <td>:</td>
                                    <td><?= $detail_bap->materiPertemuan ?></td>
                                </tr>
                            </table>
                            <div class="mt-5 mb-2">
                                Daftar Kehadiran
                            </div>
                            <form method="post" action="<?= url_to('dosen/bap/simpan-absensi') ?>" id="kehadiran">
                                <input name="bap_id" value="<?= $detail_bap->id ?>" hidden />
                                <?= session()->getFlashdata('notif') ?>
                                <table id="dataTable" class="table table-sm table-bordered table-striped w-100">
                                    <!-- Load From ajax -->
                                </table>
                                <div class="btn-group float-end">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#konfirAbsensi">
                                        Simpan Kehadiran BAP
                                    </button>
                                </div>
                            </form>
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

    <?= $this->include('dosen/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
    <!-- Datatable with ajax load -->
    <script>
        $(document).ready(function() {
            var data_hadir = "<?= $detail_bap->data_hadir ?>";
            var bap_id = "<?= $detail_bap->id ?>";
            var table = $('#dataTable').DataTable({
                "ajax": {
                    "url": "<?= base_url() ?>dosen/bap/data-mhs/<?= $detail_bap->id ?>",
                    "dataSrc": "data"
                },
                "searching": false,
                "paging": false,
                "columns": [{
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
                        "title": "kehadiran",
                        render: function(data, type, row) {
                            let statusHadir
                            $.ajax({
                                url: "<?= base_url() ?>dosen/bap/status-hadir",
                                type: "get",
                                async: false,
                                data: {
                                    bap_id: bap_id,
                                    studentId: row['id']
                                }
                            }).done(function(result) {
                                try {
                                    var data = jQuery.parseJSON(result);
                                    statusHadir = data.status
                                } catch (error) {
                                    console.log(error.message);
                                }
                            }).fail(function(jqXHR, textStatus, errorThrown) {
                                console.log(errorThrown);
                                // needs to implement if it fails
                            });

                            // Generate radio buttons with unique names and values
                            var radioHtml = '';
                            var statuses = ['hadir', 'izin', 'sakit', 'alfa'];
                            var i = 0;
                            statuses.forEach(function(status) {
                                var checked
                                if (statusHadir == "Kosong") {
                                    checked = (status === 'alfa') ? 'checked' : '';
                                } else {
                                    checked = (status === statusHadir) ? 'checked' : '';
                                }
                                radioHtml += `
                                    <input type="radio" class="btn-check" id="opt_${i}${row.id}" name="status_${row.id}" value="${status}" ${checked}/>
                                    <label class="btn btn-sm btn-outline-secondary" for="opt_${i}${row.id}">
                                    ${status}
                                    </label>
                                `;
                                i++;
                            });

                            return radioHtml;
                        }
                    },

                ],
                "scrollX": true
            });

            table.draw();
        });
    </script>
</body>

</html>