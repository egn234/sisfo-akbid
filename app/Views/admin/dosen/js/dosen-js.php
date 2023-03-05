<script>
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
        order: [
            [1, 'asc']
        ],
        data: [],
        columns: [{
                title: 'NO'
            },
            {
                title: 'NIP',
                data: "nip"
            },
            {
                title: 'Nama',
                data: "nama"
            },
            {
                title:'Kode Dosen',
                data:'kodeDosen'
            },
            {
                title: 'JK',
                data: 'jenisKelamin',
            },
            {
                title: "Aksi",
                data: "id",
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        
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
        url: "<?= base_url() ?>admin/dosen/data_dosen",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);
            console.log(data);
            dataTable.clear().draw();
            dataTable.rows.add(data['list_dosen']).draw();
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