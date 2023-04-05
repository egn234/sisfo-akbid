<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate PDF CodeIgniter 4 - qadrLabs</title>

</head>

<body>
    <h2>Data Test </h2>
    <table border=1 width=80% cellpadding=2 cellspacing=0 style="margin-top: 5px; text-align:center">
        <thead>
            <tr bgcolor=silver align=center>
                <td width="5%">No</td>
                <td width="25%">Kode Mata Kuliah</td>
                <td width="50%">Nama Mata Kuliah</td>
                <td width="20%">Deskripsi</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($list_matkul as $row) {
                # code...
            ?>
                <tr>
                    <td><?= $no ?></td>
                    <td><?= $row->kodeMatkul ?></td>
                    <td><?= $row->namaMatkul ?></td>
                    <td><?= $row->deskripsi ?></td>
                </tr>
            <?php $no++;
        } ?>

        </tbody>
    </table>
</body>

</html>