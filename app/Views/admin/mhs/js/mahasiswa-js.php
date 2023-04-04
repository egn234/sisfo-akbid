<script>
    function switchFlag(x) {
        $('#user_id').val($(x).attr('data-id'))
        $('#nameUser').text($(x).attr('data-name'))
    }
    $(document).ready(function() {
        $('.numeric-input').keydown(function(e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
            }
            // Ensure that it is a number and stop the keypress
            if (e.shiftKey || (e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
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
                title: 'NO',
                width: '5%'
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
                width:"15%",
                data: "id",
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        console.log(row);
                        let html
                        let alignment = '<div class="d-flex justify-content-center">'
                        let open_group = '<div class="btn-group">' 
                        let base_url = "<?= base_url() ?>"
                        let button = '<a class="btn btn-sm btn-primary" href="' + base_url + '/admin/mahasiswa/detail/' + row['user_id'] + '"> Detail </a>'
                        if (row['flag'] == 1) {
                            html = '<a class="btn btn-danger btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchMahasiswa" data-id="' + row['user_id'] + '" data-name="'+row['nama']+'" >Nonaktifkan</a>'
                        } else {
                            html = '<a class="btn btn-success btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchMahasiswa" data-id="' + row['user_id'] + '" data-name="'+row['nama']+'">Aktifkan</a>'
                        }
                        let close_group = '</div></div>'
                        return alignment + open_group + html + button + close_group
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
</script>