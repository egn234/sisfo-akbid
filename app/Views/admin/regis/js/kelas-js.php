<script>
    let dataTable
    // Data Table
    dataTable = $("#dataTable").DataTable({
        columnDefs: [
            {
                searchable: true,
                orderable: false,
                targets: "_all",
                defaultContent: "-",
            },
            {
                targets: 5,
                createdCell: function(cell, cellData, rowData, rowIndex, colIndex) {
                    // Apply text-center class to data cells only
                    if (colIndex !== 0) {
                        $(cell).addClass('text-center');
                    }
                }
            }
        ],
        data: [],
        columns: [{
                title: 'No'
            },
            {
                title: 'Kode Kelas',
                data: "kodeKelas"
            },
            {
                title: 'Angkatan Ke-',
                data: "angkatan"
            },
            {
                title: 'Tahun Angkatan',
                data: 'tahunAngkatan'
            },
            {
                title: 'Mahasiswa',
                data: 'jum_mhs'
            },
            {
                title: 'Status',
                data: 'flag',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let html
                        if (data == 1) {
                            html = '<span class="badge bg-success">Aktif</span>'
                        } else {
                            html = '<span class="badge bg-danger">Non-Aktif</span>'
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
                        let html, link
                        link = '<?= base_url()?>admin/registrasi/detail/' + data
                        html = '<div class="d-grid gap-2"><a href="'+link+'" class="btn btn-primary btn-sm">Pilih</a></div>'
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
        url: "<?= base_url() ?>/admin/registrasi/data_kelas",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);
            dataTable.clear().draw();
            dataTable.rows.add(data['list_kelas']).draw();
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