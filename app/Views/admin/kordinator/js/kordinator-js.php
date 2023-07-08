<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    function deleteData(x) {
        $('#idDel').val($(x).attr('data-idDel'))
        $('#nameDel').text($(x).attr('data-nameDel'))
    }

    function updateData(x) {
        $('#idPut').val($(x).attr('data-idPut'))
        $('#kodePut').val($(x).attr('data-kodePut'))
        $('#namaRuanganPut').val($(x).attr('data-namePut'))
        $('#deskripsiPut').val($(x).attr('data-deskripsiPut'))
    }
    $(document).ready(function() {
        document.getElementsByClassName("flatpickr-basic").flatpickr({
            dateFormat: "Y-m-d"
        })
        $('#matkul-list').select2({
            dropdownParent: $('#createData')
        })
        $('#dosen-list').select2({
            dropdownParent: $('#createData')

        })
    })

    let dataTable
    // Data Table
    dataTable = $("#dataTable").DataTable({
        "ajax": {
            "url": "<?= base_url() ?>/admin/kordinator/data_kordinator",
            "dataSrc": "list_rel_dos_matkul_koor"
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
                title: 'Kode Matkul',
                data: "kodeMatkul"
            },
            {
                title: 'Nama Matkul',
                data: "namaMatkul"
            },
            {
                title: 'Kode Dosen',
                data: 'kodeDosen'
            },
            {
                title: 'Nama Dosen',
                data: 'namaDosen'
            },
            {
                title: "Aksi",
                data: "idKor",
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let html
                        html = '<a class="btn btn-danger btn-sm" onclick="deleteData(this)" data-bs-toggle="modal" data-bs-target="#delData" data-idDel="' + data + '" data-nameDel="' + row['namaMatkul'] + ' - ' + row['namaDosen'] + '" >Hapus</a>'
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

    // $.ajax({
    //     url: "<?= base_url() ?>/admin/kordinator/data_kordinator",
    //     type: "get"
    // }).done(function(result) {
    //     try {
    //         var data = jQuery.parseJSON(result);
    //         dataTable.clear().draw();
    //         dataTable.rows.add(data['list_rel_dos_matkul_koor']).draw();
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

    $.ajax({
        url: "<?= base_url() ?>/admin/kordinator/data_matkul_flag",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);

            for (let i = 0; i < data['list_matkul'].length; i++) {
                $('#matkul-list').append(
                    $('<option>', {
                        value: data['list_matkul'][i]['id'],
                        text: data['list_matkul'][i]['kodeMatkul'] + ' - ' + data['list_matkul'][i]['namaMatkul'] + ' - ' + data['list_matkul'][i]['tingkat'] + ' - ' + data['list_matkul'][i]['semester'],
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

    $.ajax({
        url: "<?= base_url() ?>/admin/kordinator/data_dosen_flag",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);
            for (let i = 0; i < data['list_dosen'].length; i++) {
                $('#dosen-list').append(
                    $('<option>', {
                        value: data['list_dosen'][i]['id'],
                        text: data['list_dosen'][i]['kodeDosen'] + ' - ' + data['list_dosen'][i]['nama'],
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
</script>