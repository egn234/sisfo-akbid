<script type="text/javascript">
    let dataTable
    // Data Table
    dataTable = $("#dataTable").DataTable({
        "ajax": {
            "url": "<?= base_url() ?>/dosen/koordinator/koor_data",
            "dataSrc": "list_matkul"
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
                title: 'Kehadiran',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let kehadiran = row['paramKehadiran'] + "%"
                        return kehadiran
                    }
                    return data
                }
            },
            {
                title: 'Tugas',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let tugas = row['paramTugas'] + "%"
                        return tugas
                    }
                    return data
                }
            },
            {
                title: 'UTS',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let uts = row['paramUTS'] + "%"
                        return uts
                    }
                    return data
                }
            },
            {
                title: 'UAS',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let uas = row['paramUAS'] + "%"
                        return uas
                    }
                    return data
                }
            },
            {
                title: 'Praktek',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let Praktek = row['paramPraktek'] + "%"
                        return Praktek
                    }
                    return data
                }
            },
            {
                title: "Aksi",
                data: "idKor",
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let html
                        html = 'a'
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
    //     url: "<?= base_url() ?>/dosen/koordinator/koor_data",
    //     type: "get"
    // }).done(function(result) {
    //     try {
    //         var data = jQuery.parseJSON(result);
    //         console.log(data['list_matkul']);
    //         dataTable.clear().draw();
    //         dataTable.rows.add(data['list_matkul']).draw();
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