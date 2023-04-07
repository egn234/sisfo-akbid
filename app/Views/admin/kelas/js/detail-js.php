<script type="text/javascript" src="<?= base_url() ?>/assets/datatables/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $('.search').select2({
        dropdownParent: $('#pilih-Dosen')
    });
    $('.search2').select2({
        dropdownParent: $('#createDataMhs')
    });
    $("#form-remove").submit(function(e) {
        var $inputs = $('#form-remove input[type=checkbox]:checked');
        if ($inputs.length == 0) {
            e.preventDefault();

        }
    });

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

    function removeMhs(x) {
        $('#idDelMhs').val($(x).attr('data-idDel'))
        $('#nameDelMhs').text($(x).attr('data-nameDel'))
    }

    function removeMhsProcess(x) {
        $.ajax({
            url: "<?= base_url() ?>/admin/kelas/remove_mhs",
            type: "post",
            data: {
                idDel: $('#idDelMhs').val()
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

    function plotMhs(x) {
        $.ajax({
            url: "<?= base_url() ?>/admin/kelas/ploting_Kelas_Mhs",
            type: "post",
            data: {
                kelasID: $('#id-kelas-mhs').val(),
                mahasiswaID: $(x).attr('data-idMhs')
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
    let dataDosen, dataTable, dataMhs

    function removeDosen(x) {
        $('#idDel').val($(x).attr('data-idDos'))
        $('#nameDel').text($('#namaDosen').val())
    }

    dataMhs = $("#dataTableMhs").DataTable({
        columnDefs: [{
            searchable: true,
            orderable: false,
            targets: "_all",
            defaultContent: "-",
        }, ],
        data: [],
        columns: [{},
            {
                data: "nim"
            },
            {
                data: "nama"
            },
            {
                data: "id",
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let html
                        if (row['idRelasiKls'] == null) {
                            html = '<a type="button" onclick="plotMhs(this)" data-idMhs="' + data + '" class="btn btn-sm btn-primary">PILIH</a>'
                        } else {
                            html = 'Sudah Terdaftar'
                        }
                        return html
                    }
                    return data
                }
            }
        ]
    });

    // Numbering Row
    dataMhs.on('order.dt search.dt', function() {
        let i = 1;

        dataMhs.cells(null, 0, {
            search: 'applied',
            order: 'applied'
        }).every(function(cell) {
            this.data(i++);
        });
    }).draw();

    function listDosen(x) {
        $('#id-kelas').val(<?= $idKelas ?>)
        $.ajax({
            url: "<?= base_url() ?>admin/kordinator/data_dosen_flag",
            type: "get"
        }).done(function(result) {
            try {
                var data = jQuery.parseJSON(result);
                let row = data['list_dosen']
                for (var x = 0; x < data['list_dosen'].length; x++) {
                    $('.search').append(
                        $('<option>', {
                            value: row[x].id,
                            text: row[x].nip + ' - ' + row[x].nama,
                        })
                    );
                }
            } catch (error) {
                console.log(error.message);
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            // needs to implement if it fails
        });
    }

    function listMhs(x) {
        $('#id-kelas-mhs').val(<?= $idKelas ?>)
        $.ajax({
            url: "<?= base_url() ?>/admin/kelas/data_mhs_flag",
            type: "get"
        }).done(function(result) {
            try {
                var data = jQuery.parseJSON(result);
                let row = data['list_mhs']
                for (var x = 0; x < data['list_mhs'].length; x++) {
                    $('.search2').append(
                        $('<option>', {
                            value: row[x].id,
                            text: row[x].nim + ' - ' + row[x].nama,
                        })
                    );
                }
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
                    title: 'No'
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
                    width: '5%',
                    title: "Aksi",
                    data: "id",
                    render: function(data, type, row, full) {
                        if (type === 'display') {
                            // let html = '<a class="btn btn-danger btn-sm" onclick="removeMhs(this)" data-bs-toggle="modal" data-bs-target="#remove-Mhs" data-idDel="' + data + '" data-nameDel="' + row['nim'] + ' - ' + row['nama'] + '" >Hapus</a>'
                            let checkbox = '<input class="form-check-input" type="checkbox" value="' + data + '" name="idDel[]">'
                            return checkbox
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