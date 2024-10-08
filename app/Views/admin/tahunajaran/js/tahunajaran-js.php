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
        
        $('#regisAwal').val($(x).attr('data-regisAwal'))
        $('#regisAkhir').val($(x).attr('data-regisAkhir'))

        $('#idPut').val($(x).attr('data-idPut'))
        $('#tahunPut1').val($(x).attr('data-tahunPut1'))
        $('#tahunPut2').val($(x).attr('data-tahunPut2'))
        $('#semesterPut').val($(x).attr('data-semesterPut'))
        $('#deskripsiPut').val($(x).attr('data-deskripsiPut'))
        $('#flagPut').val($(x).attr('data-flagPut'))
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
            "url": "<?= base_url() ?>/admin/tahun-ajaran/data_tahunajaran",
            "dataSrc": "list_tahunajaran"
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
                width: '5%',
                "render": function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                title: 'Tahun Periode',
                data: "tahunPeriode",
                width: '12%'
            },
            {
                title: 'Semester',
                data: "semester",
                width: '10%'
            },
            {
                title: 'Deskripsi',
                data: 'deskripsi',
            },
            {
                title: 'Status',
                data: 'flag',
                width: '7%',
                render: function(data, type, row) {
                    if (type === 'display') {
                        let html
                        if (data == 1) {
                            html = '<span class="badge bg-success">Aktif</span>'
                        } else {
                            html = '<span class="badge bg-danger">Non-Aktif</span>'
                        }
                        return '<div class="text-center">' + html + '</div>'
                    }
                    return data
                }
            },
            {
                title: "Aksi",
                data: "id",
                width: '13%',
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let html
                        let tahun1 = row['tahunPeriode'].slice(0, 4)
                        let tahun2 = row['tahunPeriode'].slice(5, 9)
                        let grouping = '<div class="btn-group">'
                        let alignment = '<div class="d-flex justify-content-center">'
                        let close_group = '</div>'
                        if (row['flag'] == 1) {
                            htmlFlag = ''
                            // <a class="btn btn-danger btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchTahunAjaran" data-id="' + data + '" data-name="' + row['tahunPeriode'] + '" >Nonaktifkan</a>
                        } else {
                            htmlFlag = '<a class="btn btn-success btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchTahunAjaran" data-id="' + data + '" data-name="' + row['tahunPeriode'] + '">Aktifkan</a>'
                        }
                        html = '<a class="btn btn-primary btn-sm" onclick="updateData(this)" data-bs-toggle="modal" data-bs-target="#updateData"' +
                            ' data-idPut="' + data + '" data-tahunPut1="' + tahun1 + '" data-tahunPut2="' + tahun2 + '" data-semesterPut="' + row['semester'] + '" data-deskripsiPut="' + row['deskripsi'] + '"  data-flagPut="' + row['flag'] + '" data-regisAwal="'+row['registrasi_awal']+'" data-regisAkhir="'+row['registrasi_akhir']+'" >Ubah</a>' +
                            '<a class="btn btn-danger btn-sm" onclick="deleteData(this)" data-bs-toggle="modal" data-bs-target="#delData" data-idDel="' + data + '" data-nameDel="' + row['tahunPeriode'] + '" >Hapus</a>'
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
</script>