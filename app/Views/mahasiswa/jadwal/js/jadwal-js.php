<script>
    $(document).ready(function() {
        // document.getElementsByClassName("flatpickr-basic").flatpickr({
        //     dateFormat: "Y-m-d"
        // })
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
                title: 'Judul',
                data: "judul"
            },
            {
                title: 'Deskripsi',
                data: "deskripsi"
            },
            {
                title: 'File',
                data: "attachment"
            }
            // {
            //     title: "Aksi",
            //     data: "id",
            //     render: function(data, type, row, full) {
            //         if (type === 'display') {
            //             let html
            //             html = '<a class="btn btn-primary btn-sm" style="margin-right:2%;" onclick="updateData(this)" data-bs-toggle="modal" data-bs-target="#updateData" data-idPut="' + data + '" data-judulPut="' + row['judul'] + '" data-deskripsiPut="' + row['deskripsi'] + '" data-attachmentPut="' + row['attachment'] + '" >Ubah</a>' +
            //                 '<a class="btn btn-danger btn-sm" onclick="deleteData(this)" data-bs-toggle="modal" data-bs-target="#delData" data-idDel="' + data + '" data-nameDel="' + row['judul'] + '" >Hapus</a>'
            //             return html
            //         }
            //         return data
            //     }
            // }
        ],
        "responsive": true,
        "autoWidth": false,
        "scrollX": true,
    });

    $.ajax({
        url: "<?= base_url() ?>/admin/jadwal/data_jadwal",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);
            // dataTable.clear().draw();
            // dataTable.rows.add(data['jadwal']).draw();
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