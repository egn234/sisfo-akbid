<script>
    function switchFlag(x) {
        $('#user_id').val($(x).attr('data-id'))
        $('#nameUser').text($(x).attr('data-name'))
    }

    function detailPage(x) {
        window.location.href = "<?= base_url() ?>/admin/kelas/detail/" + $(x).attr('data-idKelas');
    }

    function deleteData(x) {
        $('#idDel').val($(x).attr('data-idDel'))
        $('#nameDel').text($(x).attr('data-nameDel'))
    }

    let ckEditor
    ClassicEditor
        .create(document.querySelector('.ckeditor2'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
            height: '500px'
        }).then(editor => {
            ckEditor = editor
        })
        .catch(error => {
            console.error(error);
        });

    function updateData(x) {
        $('#idPut').val($(x).attr('data-idPut'))
        $('#kodePut').val($(x).attr('data-kodePut'))
        $('#angkatanPut').val($(x).attr('data-angkatanPut'))
        $('#tahunPut').val($(x).attr('data-tahunPut'))
        $('#deskripsiPut').val($(x).attr('data-deskripsiPut'))
        $('#flagPut').val($(x).attr('data-flagPut'))
        ckEditor.setData($(x).attr('data-deskripsiPut'))

    }

    let ckeditor
    ClassicEditor
        .create(document.querySelector('.ckeditor1'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
            height: '500px'
        })
        .catch(error => {
            console.error(error);
        });

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
                title: 'Kode Kelas',
                data: "kodeKelas"
            },
            {
                title: 'Angkatan',
                data: "angkatan"
            },
            {
                title: 'Tahun Angkatan',
                data: 'tahunAngkatan'
            },
            {
                title: 'Deskripsi',
                data: 'deskripsi'
            },
            {
                title: 'Status',
                data: 'flag',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let html
                        if (data == 1) {
                            html = '<span class="badge rounded-pill bg-success">Aktif</span>'
                        } else {
                            html = '<span class="badge rounded-pill bg-danger">Non-Aktif</span>'
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

                        let grouping = '<div class="btn-group">'
                        let alignment = '<div class="d-flex justify-content-center">'
                        let close_group = '</div>'
                        if (row['flag'] == 1) {
                            htmlFlag = '<a class="btn btn-danger btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchFlag" data-id="' + data + '" data-name="' + row['kodeKelas'] + '" >Nonaktifkan</a>'
                        } else {
                            htmlFlag = '<a class="btn btn-success btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchFlag" data-id="' + data + '" data-name="' + row['kodeKelas'] + '">Aktifkan</a>'
                        }
                        html = '<a onclick="detailPage(this)" data-idKelas="' + data + '" class="btn btn-info btn-sm" >Detail</a>' +
                            '<a class="btn btn-primary btn-sm" onclick="updateData(this)" data-bs-toggle="modal" data-bs-target="#updateData" data-idPut="' + data + '" data-kodePut="' + row['kodeKelas'] + '" data-angkatanPut="' + row['angkatan'] + '" data-tahunPut="' + row['tahunAngkatan'] + '" data-flagPut="' + row['flag'] + '" data-deskripsiPut="' + row['deskripsi'] + '" >Ubah</a>' +
                            '<a class="btn btn-danger btn-sm" onclick="deleteData(this)" data-bs-toggle="modal" data-bs-target="#delData" data-idDel="' + data + '" data-nameDel="' + row['kodeKelas'] + '" >Hapus</a>'
                        return alignment + grouping + html + htmlFlag + close_group + close_group
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
        url: "<?= base_url() ?>/admin/kelas/data_kelas",
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