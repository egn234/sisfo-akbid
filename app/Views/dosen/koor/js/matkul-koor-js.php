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
                "render": function(data, type, row) {
                    let html = `
                        <a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editParam" data-id="${row.id}">
                            <i class="fa fa-file-alt"></i>
                        </a>
                    `
                    return html;
                }
            }
        ],
        "responsive": true,
        "autoWidth": false,
        "scrollX": true,
    });

    $('#editParam').on('show.bs.modal', function(e) {
        var rowid = $(e.relatedTarget).data('id');
        $.ajax({
            type: 'POST',
            url: '<?= url_to('dosen/koordinator/edit-param')?>',
            data: {rowid: rowid},
            success: function(data) {
                $('#fetch-editParam').html(data); //menampilkan data ke dalam modal
            }
        });
    });
</script>