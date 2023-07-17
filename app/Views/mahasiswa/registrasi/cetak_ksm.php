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
                            Daftar Matakuliah yang dipilih
                        </div>

                        <?php if ($cekMasaRegis == 0) {?>
                            <div class="card-body">
                                <div class="d-block w-100">
                                    ANDA BELUM BERADA DI MASA REGISTRASI
                                </div>
                            </div>
                        <?php }else{?>    
                            <div class="card-body ">
                                <?= session()->getFlashdata('notif') ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="available-items" class="display table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Mata Kuliah</th>
                                                    <th>Kode Dosen</th>
                                                    <th>Hari</th>
                                                    <th>Jam</th>
                                                    <th>Ruangan</th>
                                                    <th>Sks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                foreach ($list_matkul as $a) {?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $a->kodeMatkul .' - '. $a->namaMatkul ?></td>
                                                        <td><?= $a->kodeDosen?></td>
                                                        <td><?= $a->day?></td>
                                                        <td><?= $a->startTime .'-'. $a->endTime?></td>
                                                        <td><?= $a->kodeRuangan?></td>
                                                        <td><?= $a->sks?></td>
                                                    </tr>
                                                <?php $i++;}?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row">
                                    <?php if($list_matkul){?>
                                    <div class="col-md-12">
                                        Status: 
                                        <?php if ($list_matkul[0]->status_perwalian == 'waiting') {?>
                                            <div class="badge bg-warning">Menunggu Konfirmasi</div>
                                        <?php }else{?>
                                            <div class="badge bg-success">Telah Disetujui</div>
                                        <?php }?>
                                        <div class="btn-group float-end">
                                            <a href="<?=base_url()?>mahasiswa/registrasi/print-ksm" target="_blank" class="btn btn-primary <?=($list_matkul[array_key_last($list_matkul)]->status_perwalian == 'approved')?'':'disabled'?>" >
                                                Cetak KSM
                                            </a>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </main>
            <?= $this->include('partials/footer') ?>
        </div>
    </div>
 

    <?= $this->include('mahasiswa/partials/partial-footer') ?>

    <script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>

</body>

</html>