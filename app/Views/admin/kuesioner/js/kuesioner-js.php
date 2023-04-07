<script>
    function switchFlag(x) {
        $('#kuesioner_id').val($(x).attr('data-id'))
        $('#nameUser').text($(x).attr('data-name'))
    }
    
    function deleteData(x) {
        $('#idDel').val($(x).attr('data-idDel'))
        $('#nameDel').text($(x).attr('data-nameDel'))
    }

    function updateData(x) {
        $('#idPut').val($(x).attr('data-idPut'))
        $('#judulPut').val($(x).attr('data-judulPut'))
    }

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
                title: 'No'
            },
            {
                title: 'Judul Kuesioner',
                data: "judul_kuesioner"
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
                width: '26%',
                title: "Aksi",
                data: "id",
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let html, htmlFlag, button_detail
                        let base_url = '<?= base_url() ?>'
                        let grouping = '<div class="btn-group">'
                        let alignment = '<div class="d-flex justify-content-center">'
                        let close_group = '</div>'
                        button_detail = '<a class="btn btn-info btn-sm me-2" href="' + base_url + 'admin/kuesioner/detail/' + row['id'] + '">Daftar Pertanyaan</a>'
                        html = '<a class="btn btn-primary btn-sm" onclick="updateData(this)" data-bs-toggle="modal" data-bs-target="#updateData" data-idPut="' + data + '" data-judulPut="' + row['judul_kuesioner'] + '">Ubah</a>' +
                            '<a class="btn btn-danger btn-sm" onclick="deleteData(this)" data-bs-toggle="modal" data-bs-target="#delData" data-idDel="' + data + '" data-nameDel="' + row['judul_kuesioner'] + '" >Hapus</a>'
                        if (row['flag'] == 1) {
                            htmlFlag = '<a class="btn btn-danger btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchKuesioner" data-id="' + row['id'] + '" data-name="'+row['judul_kuesioner']+'" >Nonaktifkan</a>'
                        } else {
                            htmlFlag = '<a class="btn btn-success btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchKuesioner" data-id="' + row['id'] + '" data-name="'+row['judul_kuesioner']+'">Aktifkan</a>'
                        }
                        return alignment + button_detail + grouping + html + htmlFlag + close_group + close_group
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
</script>