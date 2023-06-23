<script>
    function detailKuesioner(x) {
        let id = $(x).attr('data-id')
        let base_url = '<?php echo base_url() ?>'
        window.location.href = base_url+'/mahasiswa/kuesioner/pertanyaan_kuesioner/'+id;
    }
    $(document).ready(function() {
        document.getElementsByClassName("flatpickr-basic").flatpickr({
            dateFormat: "Y-m-d"
        })
    })

    let dataTable
    // Data Table
    dataTable = $("#dataTable").DataTable({
        "ajax": {
            "url": "<?= base_url() ?>/mahasiswa/kuesioner/data_kuesioner",
            "dataSrc": "list_kuesioner"
        },
        columnDefs: [{
            searchable: true,
            orderable: false,
            targets: "_all",
            defaultContent: "-",
        }, ],
        data: [],
        columns: [{
                width: '5%',
                title: 'No',
                "render": function(data, type, row, meta) {
                    return meta.row + 1;
                }   
            },
            {
                title: 'Judul Kuesioner',
                data: "judul_kuesioner"
            },
            {
                title: 'Jumlah Pertanyaan',
                data: 'jumlah_pertanyaan'
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
                width: '7.5%',
                title: "Aksi",
                data: "id",
                render: function(data, type, row, full) {
                    if (type === 'display') {
                        let html, htmlFlag
                        html = '<a class="btn btn-primary btn-sm" style="margin-right:2%;" onclick="detailKuesioner(this)" data-id="' + data + '" >Detail</a>'
                        return html
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
    //     url: "<?= base_url() ?>/mahasiswa/kuesioner/data_kuesioner",
    //     type: "get"
    // }).done(function(result) {
    //     try {
    //         var data = jQuery.parseJSON(result);
    //         dataTable.clear().draw();
    //         dataTable.rows.add(data['list_kuesioner']).draw();
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