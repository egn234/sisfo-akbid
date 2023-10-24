<!DOCTYPE html>
<html>
<head>
	<?php 
		date_default_timezone_set("Asia/Jakarta");
		setlocale(LC_TIME, 'id_ID');
	?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="<?= base_url() ?>/assets/css/styles.css" rel="stylesheet" />

	<title>KSM</title>
	<style type="text/css">
		.header{
			border-bottom: 4px double black;
		}

		.keterangan{
			border: 1px solid black;
		}
        .cell-content {
            display: flex;
            align-items: flex-start; /* Align content to the top */
            justify-content: flex-start; /* Align content to the left */
            height: 100%; /* Ensure the cell takes up full height */
        }

        @media print {
            hr {
                display: block;
                border: none;
                border-top: 1px solid #000;
                margin: 1em 0;
                height: 0;
            }
        }
	</style>
	<script type="text/javascript">
		window.print();
	</script>
</head>
    <body style="font-family: Times New Roman; margin: 20px;">
        <table width="100%">
            <tr>
                <td align="center">
                    <img src="<?= base_url() ?>/img/ikbis_logo_t.png" class="img-fluid" style="width:100px">
                </td>
                <td class="cell-content">
                    <i>
                        <b>Institut Kesehatan Dan Bisnis Annisa</b></br>
                        Karanggan No. 30, Puspasari, Citeureup</br>
                        Bogor
                        Indonesia
                    </i>
                </td>
            </tr>
        </table>
        <hr>
        <table width="100%" style="font-size: 14px;">
            <tr>
                <td colspan="3" style="font-size:20px !important">
                    <b>Kartu Studi Mahasiswa</b>
                </td>
            </tr>
            <tr>
                <td width="35%" >NIM (Nomor Induk Mahasiswa)</td>
                <td width="1%">:</td>
                <td><?= $detail_mhs->nim?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?= $detail_mhs->nama?></td>
            </tr>
            <tr>
                <td>Program Studi</td>
                <td>:</td>
                <td>D3 Kebidanan</td>
            </tr>
        </table>
        <br>
        <table border="1" width="100%" class="table table-bordered table-sm" style="font-size:14px">
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
        <i style="font-size: 11px;">Pencetakan KSM pada tanggal <b><?=date('d F Y')?></b> pukul <?=date('H:i:s')?> oleh <?=$detail_mhs->nama?></i>
    </body>
</html>