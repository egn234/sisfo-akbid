<script>
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
        $('#judulPut').val($(x).attr('data-judulPut'))
        $('#deskripsiPut').val($(x).attr('data-deskripsiPut'))

        ckEditor.setData($(x).attr('data-deskripsiPut'))
    }

    ClassicEditor
        .create(document.querySelector('.ckeditor1'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote']
        })
        .catch(error => {
            console.error(error);
        });

    ClassicEditor
        .create(document.querySelector('.ckeditor3'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote']
        })
        .catch(error => {
            console.error(error);
        });

    let dataTable
    // Data Table
    dataTable = $("#dataTable").DataTable({
        "ajax": {
            "url": "<?= base_url() ?>/admin/posting/data_posting",
            "dataSrc": "list_posting"
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
                title: 'Judul',
                data: "judul"
            },
            {
                title: "Aksi",
                data: "id",
                width: "10%",
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let grouping = '<div class="btn-group">'
                        let alignment = '<div class="d-flex justify-content-center">'
                        let close_group = '</div>'
                        let html
                        html ='<a class="btn btn-primary btn-sm" href="<?= base_url('admin/posting/detail/')?>'+data+'" >Detail</a>' +
                         '<a class="btn btn-primary btn-sm" onclick="updateData(this)" data-bs-toggle="modal" data-bs-target="#updateData" data-idPut="' + data + '" data-judulPut="' + row['judul'] + '" data-deskripsiPut="' + row['deskripsi'] + '" data-attachmentPut="' + row['attachment'] + '" >Ubah</a>' +
                            '<a class="btn btn-danger btn-sm" onclick="deleteData(this)" data-bs-toggle="modal" data-bs-target="#delData" data-idDel="' + data + '" data-nameDel="' + row['judul'] + '" >Hapus</a>'
                        return alignment + grouping + html + close_group + close_group
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
    //     url: "<?= base_url() ?>/admin/posting/data_posting",
    //     type: "get"
    // }).done(function(result) {
    //     try {
    //         var data = jQuery.parseJSON(result);
    //         dataTable.clear().draw();
    //         dataTable.rows.add(data['list_posting']).draw();
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