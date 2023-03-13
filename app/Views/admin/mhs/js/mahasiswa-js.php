<script>
    function switchFlag(x) {
        $('#user_id').val($(x).attr('data-id'))
        $('#nameUser').text($(x).attr('data-name'))
    }
    function updateData(x) {
        $('#idPut').val($(x).attr('data-idPut'))
        $('#kodePut').val($(x).attr('data-kodePut'))
        $('#namaMatkulPut').val($(x).attr('data-namePut'))
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
                render : function(data, type, row, full) {
                    if (type === 'display') {
                        let html

                        if (data == 'L') {
                            html = "Laki-Laki"
                        } else {
                            html = "Perempuan" 
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
                        let html
                        let htmlPut = '<a class="btn btn-primary btn-sm" style="margin-right:2%;" onclick="updateData(this)" data-bs-toggle="modal" data-bs-target="#updateData" data-idPut="' + data + '" data-namePut="' + row['namaMatkul'] + '" data-kodePut="' + row['kodeMatkul'] + '" data-deskripsiPut="' + row['deskripsi'] + '" >Ubah</a>' 

                        if (row['flag'] == 1) {
                            html = '<a class="btn btn-danger btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchMahasiswa" data-id="' + row['user_id'] + '" data-name="'+row['nama']+'" >Nonaktifkan</a>'
                        } else {
                            html = '<a class="btn btn-success btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchMahasiswa" data-id="' + row['user_id'] + '" data-name="'+row['nama']+'">Aktifkan</a>'
                        }
                        return htmlPut + html
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
        url: "<?= base_url() ?>/admin/mahasiswa/data_mhs",
        type: "get"
    }).done(function(result) {
        try {
            var data = jQuery.parseJSON(result);
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
    // $('#switchMahasiswa').on('show.bs.modal', function(e) {
    //     var rowid = $(e.relatedTarget).data('id');
    //     $.ajax({
    //         type: 'POST',
    //         url: '<?= base_url() ?>/admin/mahasiswa/switch-mhs',
    //         data: 'rowid=' + rowid,
    //         success: function(data) {
    //             $('.fetched-data').html(data);
    //         }
    //     });
    // });
</script>