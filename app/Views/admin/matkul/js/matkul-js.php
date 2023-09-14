<script>
    function switchFlag(x) {
        $('#user_id').val($(x).attr('data-id'))
        $('#nameUser').text($(x).attr('data-name'))
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
        $('#namaMatkulPut').val($(x).attr('data-namePut'))
        $('#deskripsiPut').val($(x).attr('data-deskripsiPut'))
        $('#sksPut').val($(x).attr('data-sks'))
        $('#tingkatPut').val($(x).attr('data-tingkat'))
        $('#semesterPut').val($(x).attr('data-semester'))
        $('#prodiPut').val($(x).attr('data-prodiPut'))

        ckEditor.setData($(x).attr('data-deskripsiPut'))

    }

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
        "ajax": {
            "url": "<?= base_url() ?>/admin/matkul/data_matkul",
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
                title: 'Kode Mata Kuliah',
                data: "kodeMatkul"
            },
            {
                title: 'Nama Mata Kuliah',
                data: "namaMatkul"
            },
            {
                title: 'Tingkat',
                data: 'tingkat',
                render: function(data, type, row, full){
                    if (type === 'display') {
                        let html = 'TINGKAT ' + row['tingkat']
                        return html
                    }
                    return data
                }
            },
            {
                title: 'SKS',
                data: 'sks'
            },
            {
                title: 'semester',
                data: 'semester'
            },
            {
                title: "Aksi",
                data: "id",
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let grouping = '<div class="btn-group">'
                        let alignment = '<div class="d-flex justify-content-center">'
                        let close_group = '</div>'
                        if (row['flag'] == 1) {
                            htmlFlag = '<a class="btn btn-danger btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchFlag" data-id="' + data + '" data-name="' + row['namaMatkul'] + '" >Nonaktifkan</a>'
                        } else {
                            htmlFlag = '<a class="btn btn-success btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchFlag" data-id="' + data + '" data-name="' + row['namaMatkul'] + '">Aktifkan</a>'
                        }
                        html = '<a class="btn btn-primary btn-sm" onclick="updateData(this)" data-bs-toggle="modal" data-bs-target="#updateData" data-idPut="' + data + '" data-namePut="' + row['namaMatkul'] + '" data-kodePut="' + row['kodeMatkul'] + '" data-deskripsiPut="' + row['deskripsi'] + '" data-sks="' + row['sks'] + '" data-tingkat="' + row['tingkat'] + '" data-semester="' + row['semester'] + '" data-prodiPut="' + row['prodiID'] + '" >Ubah</a>' +
                            '<a class="btn btn-danger btn-sm" onclick="deleteData(this)" data-bs-toggle="modal" data-bs-target="#delData" data-idDel="' + data + '" data-nameDel="' + row['namaMatkul'] + '" >Hapus</a>'
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