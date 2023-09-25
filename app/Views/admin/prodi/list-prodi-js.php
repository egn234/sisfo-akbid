<script type="text/javascript">

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
        $('#prodiPut').val($(x).attr('data-prodiPut'))
        $('#strataPut').val($(x).attr('data-strataPut'))
        $('.ckeditor2').val($(x).attr('data-deskripsiPut'))
        console.log($(x).attr('data-deskripsiPut'));
        console.log(ckEditor);
        ckEditor.setData($(x).attr('data-deskripsiPut'));
    }

    ClassicEditor
        .create(document.querySelector('.ckeditor1'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
            height: '500px'
        })
        .catch(error => {
            console.error(error);
        });


    var table = $('#dataTable').DataTable({
        ajax: {
            url: "<?= base_url() ?>admin/prodi/data-prodi",
            dataSrc: "list_prodi",
        },
        columnDefs: [{
            searchable: true,
            orderable: false,
            targets: "_all",
            defaultContent: "-",
        }],
        columns: [{
                title: "No",
                "render": function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                title: "Program Studi",
                render: function(data, type, row) {
                    return row.strata + " " + row.nama_prodi;
                }
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
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let grouping = '<div class="btn-group">'
                        let alignment = '<div class="d-flex justify-content-center">'
                        let close_group = '</div>'
                        html = '<a class="btn btn-primary btn-sm" onclick="updateData(this)" data-bs-toggle="modal" data-bs-target="#updateData" data-idPut="' + data + '" data-prodiPut="' + row['nama_prodi'] + '" data-strataPut="' + row['strata'] + '" data-deskripsiPut="' + row['deskripsi'] + '" >Ubah</a>'
                        return alignment + grouping + html + close_group + close_group
                    }
                    return data
                }
            }
        ],
        responsive: true,
    });

    table.draw();
</script>