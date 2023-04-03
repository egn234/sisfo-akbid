<script>
    function deleteData(x) {
        $('#idDel').val($(x).attr('data-idDel'))
        $('#nameDel').text($(x).attr('data-nameDel'))
    }

    function updateData(x) {
        $('#idPut').val($(x).attr('data-idPut'))
        $('#pertanyaanPut').val($(x).attr('data-pertanyaanPut'))
        $('#jenisPut').val($(x).attr('data-jenisPut'))
        $('#flagPut').val($(x).attr('data-flagPut'))

    }

    function deleteDataPertanyaan(x) {
        $('#idPertanyaanDel').val($(x).attr('data-idDel'))
        $('#namePertanyaanDel').text($(x).attr('data-nameDel'))
    }

    function updateDataPertanyaan(x) {
        $('#idPertanyaanPut').val($(x).attr('data-idPut'))
        $('#pertanyaanPut').val($(x).attr('data-pertanyaanPut'))
        $('#jenisPut').val($(x).attr('data-jenisPut'))
        $('#flagPertanyaanPut').val($(x).attr('data-flagPut'))

    }

    function changeFlag(x) {
        let id = $(x).attr('data-idFlag')
        let flag = $(x).attr('data-flag')

        $.ajax({
            url: "<?= base_url() ?>/admin/kuesioner/switch-kuesioner",
            type: "post",
            data: {
                idPut: id,
                flag : flag
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
    $(document).ready(function() {
        document.getElementsByClassName("flatpickr-basic").flatpickr({
            dateFormat: "Y-m-d"
        })
    })

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
                width: '5%',
                title: 'NO'
            },
            {
                title: 'Judul Kuesioner',
                data: "judul_kuesioner",
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        return '<a onclick="listPertanyaan(this)" data-id="' + row['id'] + '" data-name="'+data+'" style="color:blue;cursor:pointer;">' + data + '</a>'
                    }
                    return data
                }
            },
            {
                title: 'Status',
                data: 'flag',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let html
                        if (data == 1) {
                            html = '<span class="badge rounded-pill bg-success">Aktif</span>'
                        } else {
                            html = '<span class="badge rounded-pill bg-danger">Non-Aktif</span>'
                        }
                        return html
                    }
                    return data
                }
            },
            {
                width: '20%',
                title: "Aksi",
                data: "id",
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let html, htmlFlag
                        html = '<a class="btn btn-primary btn-sm" style="margin-right:2%;" onclick="updateData(this)" data-bs-toggle="modal" data-bs-target="#updateData" data-idPut="' + data + '" data-pertanyaanPut="' + row['pertanyaan'] + '" data-jenisPut="' + row['jenis_pertanyaan'] + '" data-flagPut="' + row['flag'] + '" >Ubah</a>' +
                            '<a class="btn btn-danger btn-sm" style="margin-right:2%;" onclick="deleteData(this)" data-bs-toggle="modal" data-bs-target="#delData" data-idDel="' + data + '" data-nameDel="' + row['judul_kuesioner'] + '" >Hapus</a>'
                        if (row['flag'] == 1) {
                            htmlFlag = '<a class="btn btn-danger btn-sm" onclick="changeFlag(this)" data-idFlag="' + data + '" data-flag="0">Non-Aktifkan</a>'
                        } else {
                            htmlFlag = '<a class="btn btn-success btn-sm" onclick="changeFlag(this)" data-idFlag="' + data + '" data-flag="1">Aktifkan</a>'
                        }
                        return html + htmlFlag
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
        url: "<?= base_url() ?>/admin/kuesioner/data_kuesioner",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);
            dataTable.clear().draw();
            dataTable.rows.add(data['list_kuesioner']).draw();
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

    let dataTablePertanyaan
    // Data Table
    dataTablePertanyaan = $("#dataTablePertanyaan").DataTable({
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
                title: 'Pertanyaan',
                data: "pertanyaan"
            },
            {
                title: 'Jenis Pertanyaan',
                data: "jenis_pertanyaan"
            },
            {
                title: 'Status',
                data: 'flag',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let html
                        if (data == 1) {
                            html = '<span class="badge rounded-pill bg-success">Aktif</span>'
                        } else {
                            html = '<span class="badge rounded-pill bg-danger">Non-Aktif</span>'
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
                        html = '<a class="btn btn-primary btn-sm" style="margin-right:2%;" onclick="updateDataPertanyaan(this)" data-bs-toggle="modal" data-bs-target="#updateDataPertanyaan" data-idPut="' + data + '" data-pertanyaanPut="' + row['pertanyaan'] + '" data-jenisPut="' + row['jenis_pertanyaan'] + '" data-flagPut="' + row['flag'] + '" >Ubah</a>' +
                            '<a class="btn btn-danger btn-sm" onclick="deleteDataPertanyaan(this)" data-bs-toggle="modal" data-bs-target="#delDataPertanyaan" data-idDel="' + data + '" data-nameDel="' + row['pertanyaan'] + '" >Hapus</a>'
                        return html
                    }
                    return data
                }
            }
        ],
        "responsive": true,
        "autoWidth": false,
        "scrollX": true,
    });
    // Numbering Row
    dataTablePertanyaan.on('order.dt search.dt', function() {
        let i = 1;

        dataTablePertanyaan.cells(null, 0, {
            search: 'applied',
            order: 'applied'
        }).every(function(cell) {
            this.data(i++);
        });
    }).draw();

    function listPertanyaan(x) {
        $('#card-pertanyaan').show()
        $('#nama-kuesioner').text($(x).attr('data-name'))
        $('#kuesionerID').val($(x).attr('data-id'))
        $.ajax({
            url: "<?= base_url() ?>/admin/kuesioner/data_pertanyaan",
            type: "post",
            data: {
                id: $(x).attr('data-id')
            }
        }).done(function(result) {
            try {
                var data = jQuery.parseJSON(result);
                dataTablePertanyaan.clear().draw();
                dataTablePertanyaan.rows.add(data['list_pertanyaan']).draw();
            } catch (error) {
                console.log(error.message);
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            // needs to implement if it fails
        });
    }
</script>