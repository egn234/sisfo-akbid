<script>
    function switchFlag(x) {
        $('#pertanyaan_id').val($(x).attr('data-id'))
        $('#nameUser').text($(x).attr('data-name'))
    }

    function deleteData(x) {
        $('#idDel').val($(x).attr('data-idDel'))
        $('#nameDel').text($(x).attr('data-nameDel'))
    }

    function updateData(x) {
        $('#idPut').val($(x).attr('data-idPut'))
        $('#pertanyaanPut').val($(x).attr('data-pertanyaanPut'))
        $('#jenisPut').val($(x).attr('data-jenisPut'))
    }
    
    let dataTable
    // Data Table
    dataTable = $("#dataTable").DataTable({
        "ajax": {
            "url": "<?= url_to('list-pertanyaan-1', $detail_kuesioner->id) ?>",
            "dataSrc": "list_pertanyaan"
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
                        let html, htmlFlag
                        let base_url = '<?= base_url() ?>'
                        let grouping = '<div class="btn-group">'
                        let alignment = '<div class="d-flex justify-content-center">'
                        let close_group = '</div>'
                        html = '<a class="btn btn-primary btn-sm" onclick="updateData(this)" data-bs-toggle="modal" data-bs-target="#updateData" data-idPut="' + data + '" data-pertanyaanPut="' + row['pertanyaan'] + '" data-jenisPut="' + row['jenis_pertanyaan'] + '" >Ubah</a>' +
                            '<a class="btn btn-danger btn-sm" onclick="deleteData(this)" data-bs-toggle="modal" data-bs-target="#delData" data-idDel="' + data + '" data-nameDel="' + row['pertanyaan'] + '" >Hapus</a>'
                        if (row['flag'] == 1) {
                            htmlFlag = '<a class="btn btn-danger btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchPertanyaan" data-id="' + row['id'] + '" data-name="'+row['pertanyaan']+'" >Nonaktifkan</a>'
                        } else {
                            htmlFlag = '<a class="btn btn-success btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchPertanyaan" data-id="' + row['id'] + '" data-name="'+row['pertanyaan']+'">Aktifkan</a>'
                        }
                        return alignment + grouping + html + htmlFlag + close_group + close_group
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
    //     url: "<?= url_to('list-pertanyaan-1', $detail_kuesioner->id) ?>",
    //     type: "get"
    // }).done(function(result) {
    //     try {
    //         var data = jQuery.parseJSON(result);
    //         dataTable.clear().draw();
    //         dataTable.rows.add(data['list_pertanyaan']).draw();
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

</script>