<script>
    let dataTable
    // Data Table
    dataTable = $("#dataTable").DataTable({
        columnDefs: [{
            searchable: true,
            orderable: false,
            targets: "_all",
            defaultContent: "-",
        }, ],
        order: [
            [1, 'asc']
        ],
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
            },
            {
                title: "Aksi",
                data: "flag",
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let html
                        if (data == 1) {
                            html = '<a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#switchMahasiswa" data-id="' + data + '">Nonaktifkan</a>'
                        } else {
                            html = '<a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#switchMahasiswa" data-id="' + data + '">Aktifkan</a>'
                        }
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
        url: "<?= base_url() ?>admin/mahasiswa/data_mhs",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);
            // console.log(data['list_mhs']);
            dataTable.clear().draw();
            dataTable.rows.add(data['list_mhs']).draw();
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
    $('#switchMahasiswa').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
            type: 'POST',
            url: '<?= base_url() ?>/admin/mahasiswa/switch-mhs',
            data: 'rowid=' + rowid,
            success: function(data) {
                $('.fetched-data').html(data);
            }
        });
    });
</script>