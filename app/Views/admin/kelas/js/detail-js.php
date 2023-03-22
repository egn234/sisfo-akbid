<script>
    function removeProcess(x) {
        $.ajax({
            url: "<?= base_url() ?>/admin/kelas/remove_dosen_wali",
            type: "post",
            data: {
                idDel: $('#idDel').val()
            }
        }).done(function(result) {
            try {
                var data = jQuery.parseJSON(result);
                if (data[0]['status'] == 'success') {
                    alert(data[0]['notif_text']) ? "" : location.reload();
                } else {
                    alert('Gagal') ? "" : location.reload();
                }
            } catch (error) {
                console.log(error.message);
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            // needs to implement if it fails
        });
    }

    function pilihDosen(x) {
        $.ajax({
            url: "<?= base_url() ?>/admin/kelas/add_dosen_wali",
            type: "post",
            data: {
                kelasID: $('#id-kelas').val(),
                dosenID: $(x).attr('data-idDos')
            }
        }).done(function(result) {
            try {
                var data = jQuery.parseJSON(result);
                if (data[0]['status'] == 'success') {
                    alert(data[0]['notif_text']) ? "" : location.reload();
                } else {
                    alert('Gagal') ? "" : location.reload();
                }
            } catch (error) {
                console.log(error.message);
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            // needs to implement if it fails
        });
    }
    let dataDosen, dataTable

    function removeDosen(x) {
        $('#idDel').val($(x).attr('data-idDos'))
        $('#nameDel').text($('#namaDosen').val())
    }

    dataDosen = $("#dataTableDosen").DataTable({
        columnDefs: [{
            searchable: true,
            orderable: false,
            targets: "_all",
            defaultContent: "-",
        }, ],
        data: [],
        columns: [{},
            {
                data: "nip"
            },
            {
                data: "nama"
            },
            {
                data: "id",
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let html = '<a type="button" onclick="pilihDosen(this)" data-idDos="' + data + '" class="btn btn-sm btn-primary">PILIH</a>'
                        return html
                    }
                    return data
                }
            }
        ]
    });

    // Numbering Row
    dataDosen.on('order.dt search.dt', function() {
        let i = 1;

        dataDosen.cells(null, 0, {
            search: 'applied',
            order: 'applied'
        }).every(function(cell) {
            this.data(i++);
        });
    }).draw();

    function listDosen(x) {
        $('#id-kelas').val(<?= $idKelas ?>)
        $.ajax({
            url: "<?= base_url() ?>/admin/dosen/data_dosen_flag",
            type: "get"
        }).done(function(result) {
            try {
                var data = jQuery.parseJSON(result);
                dataDosen.clear().draw();
                dataDosen.rows.add(data['list_dosen']).draw();
            } catch (error) {
                console.log(error.message);
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            // needs to implement if it fails
        });
    }


    $(document).ready(function() {
        // Data Table
        dataTable = $("#dataTable").DataTable({
            columnDefs: [{
                searchable: true,
                orderable: false,
                targets: "_all",
                defaultContent: "-",
            }, ],
            data: [],
            columns: [{
                    title: 'NO'
                },
                {
                    title: 'NIM',
                    data: "nim"
                },
                {
                    title: 'Nama',
                    data: "nama"
                },
                {
                    title: 'JK',
                    data: 'jenisKelamin',
                    render: function(data, type, row, full) {
                        if (type === 'display') {
                            let html

                            if (data == 'L') {
                                html = "Laki-Laki"
                            } else {
                                html = "Perempuan"
                            }
                            return html
                        }
                        return data
                    }
                },
                {
                    title: "Aksi",
                    data: "id",
                    render: function(data, type, row, full) {
                        if (type === 'display') {
                            let html
                            let htmlPut = '<a class="btn btn-primary btn-sm" style="margin-right:2%;" onclick="updateData(this)" data-bs-toggle="modal" data-bs-target="#updateData" ' +
                                ' data-idPut="' + data + '" data-namePut="' + row['nama'] + '" data-emailPut="' + row['email'] + '" data-jenisKelaminPut="' + row['jenisKelamin'] + '"  data-nimPut="' + row['nim'] + '"  data-nikPut="' + row['nik'] + '"' +
                                ' data-kontakAyahPut="' + row['kontakAyah'] + '" data-kontakIbuPut="' + row['kontakIbu'] + '" data-kontakWaliPut="' + row['kontakWali'] + '"' +
                                ' data-namaAyahPut="' + row['namaAyah'] + '" data-namaIbuPut="' + row['namaIbu'] + '" data-namaWaliPut="' + row['namaWali'] + '"' +
                                ' data-tanggalLahirPut="' + row['tanggalLahir'] + '" data-tempatLahirPut="' + row['tempatLahir'] + '"  data-alamatPut="' + row['alamat'] + '"  data-kontakPut="' + row['kontak'] + '" >Ubah</a>'

                            if (row['flag'] == 1) {
                                html = '<a class="btn btn-danger btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchMahasiswa" data-id="' + row['user_id'] + '" data-name="' + row['nama'] + '" >Nonaktifkan</a>'
                            } else {
                                html = '<a class="btn btn-success btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchMahasiswa" data-id="' + row['user_id'] + '" data-name="' + row['nama'] + '">Aktifkan</a>'
                            }
                            return htmlPut + html
                        }
                        return data
                    }
                }
            ],
            "responsive": true,
            "autoWidth": false,
            "scrollX": true,
        });

        $.ajax({
            url: "<?= base_url() ?>/admin/kelas/data-detail-kelas",
            type: "post",
            data: {
                id: <?= $idKelas ?>
            }
        }).done(function(result) {
            try {
                var data = jQuery.parseJSON(result);
                $('#kodeKelas').val(data['list_kelas'][0]['kodeKelas'])
                $('#angkatan').val(data['list_kelas'][0]['angkatan'])
                $('#tahunAngkatan').val(data['list_kelas'][0]['tahunAngkatan'])

                if (data['list_kelas'][0]['kodeDosen'] != null) {
                    $('#kodeDosen').val(data['list_kelas'][0]['kodeDosen'])
                    $('#namaDosen').val(data['list_kelas'][0]['namaDosen'])
                    $('#nip').val(data['list_kelas'][0]['nipDosen'])
                    $('#removeDosen').attr('data-idDos', data['list_kelas'][0]['idDosen'])
                    $('#pilihDosen').hide()
                    $('#removeDosen').show()

                } else {
                    $('#pilihDosen').show()
                    $('#removeDosen').hide()
                }

                if (data['list_kelas'][0]['nama'] != null) {
                    dataTable.clear().draw();
                    dataTable.rows.add(data['list_kelas']).draw();
                }
                console.log(data);
            } catch (error) {
                console.log(error.message);
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            // needs to implement if it fails
        });

        // Numbering Row
        dataTable.on('order.dt search.dt', function() {
            let i = 1;

            dataTable.cells(null, 0, {
                search: 'applied',
                order: 'applied'
            }).every(function(cell) {
                this.data(i++);
            });
        }).draw();
    })
</script>