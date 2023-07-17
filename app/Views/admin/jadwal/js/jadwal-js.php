<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // create
        $('#periode-list').select2({
            dropdownParent: $('#createData')
        })
        $('#matkul-list').select2({
            dropdownParent: $('#createData')
        })
        $('#dosen-list').select2({
            dropdownParent: $('#createData')
        })
        $('#ruangan-list').select2({
            dropdownParent: $('#createData')
        })
        $('#day').select2({
            dropdownParent: $('#createData')
        })

        // update
        $('#periode-listPut').select2({
            dropdownParent: $('#updateData')
        })
        $('#matkul-listPut').select2({
            dropdownParent: $('#updateData')
        })
        $('#dosen-listPut').select2({
            dropdownParent: $('#updateData')
        })
        $('#ruangan-listPut').select2({
            dropdownParent: $('#updateData')
        })
        $('#dayPut').select2({
            dropdownParent: $('#updateData')
        })

    })

    function switchFlag(x) {
        $('#id_data').val($(x).attr('data-id'))
        $('#nameUser').text($(x).attr('data-name'))
    }
    let ckEditor
    ClassicEditor
        .create(document.querySelector('.ckeditor2'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
            height: '500px'
        }).then(editor => {
            ckEditor = editor
        })
        .catch(error => {
            console.error(error);
        });

    function updateData(x) {
        $('#idPut').val($(x).attr('data-idPut'))

        $('#periode-listPut').val($(x).attr('data-periodePut')); // Select the option with a value of '1'
        $('#periode-listPut').trigger('change');
        $('#matkul-listPut').val($(x).attr('data-matkulPut')); // Select the option with a value of '1'
        $('#matkul-listPut').trigger('change');
        $('#dosen-listPut').val($(x).attr('data-dosenPut')); // Select the option with a value of '1'
        $('#dosen-listPut').trigger('change');
        $('#ruangan-listPut').val($(x).attr('data-ruanganPut')); // Select the option with a value of '1'
        $('#ruangan-listPut').trigger('change');
        $('#dayPut').val($(x).attr('data-dayPut')); // Select the option with a value of '1'
        $('#dayPut').trigger('change');

        $('.startTime').val($(x).attr('data-startTime'))
        $('.endTime').val($(x).attr('data-endTime'))
        $('#deskripsiPut').val($(x).attr('data-deskripsiPut'))
        ckEditor.setData($(x).attr('data-deskripsiPut'))

    }

    ClassicEditor
        .create(document.querySelector('.ckeditor1'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
            height: '500px'
        })
        .catch(error => {
            console.error(error);
        });

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
                $('#periode-listPut').append(
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
                        text: list[i].kodeMatkul + ' - ' + list[i].namaMatkul + ' - ' + list[i].tingkat + ' - ' + list[i].semester,
                    })
                );
                $('#matkul-listPut').append(
                    $('<option>', {
                        value: list[i].id,
                        text: list[i].kodeMatkul + ' - ' + list[i].namaMatkul + ' - ' + list[i].tingkat + ' - ' + list[i].semester,
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
                $('#dosen-listPut').append(
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
                $('#ruangan-listPut').append(
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
        "ajax": {
            "url": "<?= base_url() ?>/admin/jadwal/data-jadwal",
            "dataSrc": "list_jadwal"
        },
        columnDefs: [{
            searchable: true,
            orderable: false,
            targets: "_all",
            defaultContent: "-",
        }, ],
        data: [],
        columns: [{
                title: 'No',
                "render": function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                title: 'Tahun Ajaran',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let tahunAjaran = row['tahunPeriode'] + ' ' + row['semester']
                        return tahunAjaran
                    }
                    return data
                }
            },
            {
                title: 'Mata Kuliah',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let matkul = row['kodeMatkul'] + ' - ' + row['namaMatkul']
                        return matkul
                    }
                    return data
                }
            },
            {
                title: 'Tingkat',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let tingkat = 'TINGKAT ' + row['tingkat']
                        return tingkat
                    }
                    return data
                }
            },
            {
                title: 'Kode Dosen',
                data: 'kodeDosen'
            },
            {
                title: 'Hari',
                data: 'day'
            },
            {
                title: 'Jam',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let jam = row['startTime'] + ' - ' + row['endTime']
                        return jam
                    }
                    return data
                }
            },
            {
                title: 'Ruangan',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let ruangan = row['kodeRuangan'] + ' - ' + row['namaRuangan']
                        return ruangan
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
                        let alignment = '<div class="d-flex justify-content-center">'
                        let open_group = '<div class="btn-group">'
                        let base_url = "<?= base_url() ?>"
                        let button = 
                        // '<a class="btn btn-sm btn-primary" href="' + base_url + 'admin/dosen/detail/' + row['user_id'] + '"> Detail </a>' +
                            '<a class="btn btn-sm btn-info" onclick="updateData(this)" data-bs-toggle="modal" data-bs-target="#updateData" data-idPut="' + data + '" data-dayPut="' + row['day'] + '" data-deskripsiPut="' + row['deskripsi'] + '" data-ruanganPut="' + row['ruanganID'] + '" data-periodePut="' + row['periodeID'] + '" data-dosenPut="' + row['dosenID'] + '" data-matkulPut="' + row['matakuliahID'] + '" data-startTime="' + row['startTime'] + '" data-endTime="' + row['endTime'] + '" > Ubah </a>'
                        if (row['flag'] == 1) {
                            html = '<a class="btn btn-danger btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchJadwal" data-id="' + data + '" data-name="' + row['namaMatkul'] + '" >Nonaktifkan</a>'
                        } else {
                            html = '<a class="btn btn-success btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchJadwal" data-id="' + data + '" data-name="' + row['namaMatkul'] + '">Aktifkan</a>'
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

    // $.ajax({
    //     url: "<?= base_url() ?>/admin/jadwal/data-jadwal",
    //     type: "get"
    // }).done(function(result) {
    //     try {
    //         var data = jQuery.parseJSON(result);
    //         dataTable.clear().draw();
    //         dataTable.rows.add(data['list_jadwal']).draw();
    //     } catch (error) {
    //         console.log(error.message);
    //     }
    // }).fail(function(jqXHR, textStatus, errorThrown) {
    //     console.log(errorThrown);
    //     // needs to implement if it fails
    // });

    // // Numbering Row
    // dataTable.on('order.dt search.dt', function() {
    //     let i = 1;

    //     dataTable.cells(null, 0, {
    //         search: 'applied',
    //         order: 'applied'
    //     }).every(function(cell) {
    //         this.data(i++);
    //     });
    // }).draw();

    flatpickr("#time-input-from", {
        appendTo: document.body,
        className: "flatpickr",
        enableTime: true,
        noCalendar: true,
        static: true,
        dateFormat: "H:i", // Use 24-hour format
        time_24hr: true // Use 24-hour format
    });

    flatpickr("#time-input-to", {
        appendTo: document.body,
        className: "flatpickr",
        enableTime: true,
        noCalendar: true,
        static: true,
        dateFormat: "H:i", // Use 24-hour format
        time_24hr: true // Use 24-hour format
    });
</script>