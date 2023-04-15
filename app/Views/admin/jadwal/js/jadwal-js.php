<script>
    function switchFlag(x) {
        $('#user_id').val($(x).attr('data-id'))
        $('#nameUser').text($(x).attr('data-name'))
    }

    function updateData(x) {
        $('#idPut').val($(x).attr('data-idPut'))
        $('#namePut').val($(x).attr('data-namePut'))
        $('#nipPut').val($(x).attr('data-nipPut'))
        $('#nikPut').val($(x).attr('data-nikPut'))
        $('#kodeDosenPut').val($(x).attr('data-kodeDosenPut'))
        $('#jenisKelaminPut').val($(x).attr('data-jenisKelaminPut'))
        $('#alamatPut').val($(x).attr('data-alamatPut'))
        $('#emailPut').val($(x).attr('data-emailPut'))
        $('#kontakPut').val($(x).attr('data-kontakPut'))

    }
    $(document).ready(function() {
        $('.numeric-input').keydown(function(e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    })

    // periode
    $.ajax({
        url: "<?= base_url() ?>/admin/tahun-ajaran/data_tahunajaran",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);
            let list = data['list_tahunajaran']
            for (let i = 0; i < list.length; i++) {
                $('#periode-list').append(
                    $('<option>', {
                        value: list[i].id,
                        text: list[i].tahunPeriode + ' - ' + list[i].semester,
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

    // matkul
    $.ajax({
        url: "<?= base_url() ?>/admin/matkul/data_matkul",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);
            let list = data['list_matkul']
            for (let i = 0; i < list.length; i++) {
                $('#matkul-list').append(
                    $('<option>', {
                        value: list[i].id,
                        text: list[i].kodeMatkul + ' - ' + list[i].namaMatkul + ' - ' + list[i].semester,
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

    // dosen
    $.ajax({
        url: "<?= base_url() ?>/admin/dosen/data_dosen",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);
            let list = data['list_dosen']
            for (let i = 0; i < list.length; i++) {
                $('#dosen-list').append(
                    $('<option>', {
                        value: list[i].id,
                        text: list[i].kodeDosen + ' - ' + list[i].nama,
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

    // ruangan
    $.ajax({
        url: "<?= base_url() ?>/admin/ruangan/data_ruangan",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);
            let list = data['list_ruangan']
            for (let i = 0; i < list.length; i++) {
                $('#ruangan-list').append(
                    $('<option>', {
                        value: list[i].id,
                        text: list[i].kodeRuangan + ' - ' + list[i].namaRuangan,
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

    let dataTable
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
                title: 'Username',
                data: 'username'
            },
            {
                title: 'NIP',
                data: "nip"
            },
            {
                title: 'Nama',
                data: "nama"
            },
            {
                title: 'Kode Dosen',
                data: 'kodeDosen'
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
                        console.log(row);
                        let html
                        let alignment = '<div class="d-flex justify-content-center">'
                        let open_group = '<div class="btn-group">'
                        let base_url = "<?= base_url() ?>"
                        let button = '<a class="btn btn-sm btn-primary" href="' + base_url + '/admin/dosen/detail/' + row['user_id'] + '"> Detail </a>'
                        if (row['flag'] == 1) {
                            html = '<a class="btn btn-danger btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchDosen" data-id="' + row['user_id'] + '" data-name="' + row['nama'] + '" >Nonaktifkan</a>'
                        } else {
                            html = '<a class="btn btn-success btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchDosen" data-id="' + row['user_id'] + '" data-name="' + row['nama'] + '">Aktifkan</a>'
                        }
                        let close_group = '</div></div>'
                        return alignment + open_group + html + button + close_group
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
        url: "<?= base_url() ?>/admin/jadwal/data-jadwal",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);
            console.log(data);
            dataTable.clear().draw();
            dataTable.rows.add(data['list_jadwal']).draw();
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
    // $('#switchMahasiswa').on('show.bs.modal', function(e) {
    //     var rowid = $(e.relatedTarget).data('id');
    //     $.ajax({
    //         type: 'POST',
    //         url: '<?= base_url() ?>/admin/mahasiswa/switch-mhs',
    //         data: 'rowid=' + rowid,
    //         success: function(data) {
    //             $('.fetched-data').html(data);
    //         }
    //     });
    // });
</script>