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
                title: 'NO'
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
                        html = '<a class="btn btn-danger btn-sm" onclick="deleteData(this)" data-bs-toggle="modal" data-bs-target="#delData" data-idDel="' + data + '" data-nameDel="' + row['namaMatkul'] + ' - ' + row['namaDosen'] +'" >Hapus</a>'
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

    $.ajax({
        url: "<?= base_url() ?>/admin/kordinator/data_kordinator",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);
            console.log(data['list_rel_dos_matkul_koor']);
            dataTable.clear().draw();
            dataTable.rows.add(data['list_rel_dos_matkul_koor']).draw();
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

    $.ajax({
        url: "<?= base_url() ?>/admin/matkul/data_matkul",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);
            for (let i = 0; i < data['list_matkul'].length; i++) {
                $('#matkul-list').append(
                    $('<option>', {
                        value: data['list_matkul'][i]['id'],
                        text: data['list_matkul'][i]['kodeMatkul'] + ' - ' + data['list_matkul'][i]['namaMatkul'],
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
        url: "<?= base_url() ?>/admin/dosen/data_dosen_flag",
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