<script>
    function switchFlag(x) {
        $('#user_id').val($(x).attr('data-id'))
        $('#nameUser').text($(x).attr('data-name'))
    }

    function updateData(x) {
        $('#idPut').val($(x).attr('data-idPut'))
        $('#namePut').val($(x).attr('data-namePut'))
        $('#nipPut').val($(x).attr('data-nipPut'))
        $('#nikPut').val($(x).attr('data-nikPut'))
        $('#kodeDosenPut').val($(x).attr('data-kodeDosenPut'))
        $('#jenisKelaminPut').val($(x).attr('data-jenisKelaminPut'))
        $('#alamatPut').val($(x).attr('data-alamatPut'))
        $('#emailPut').val($(x).attr('data-emailPut'))
        $('#kontakPut').val($(x).attr('data-kontakPut'))

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
         
        // Function to fetch lecturers via AJAX
        function fetchProdi() {
            $.ajax({
                url: '<?= base_url()?>/admin/dosen/data_prodi', // Replace with your CI4 route
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    // Populate the <select> element with the received data
                    var select = $('#prodi');
                    select.empty(); // Clear existing options

                    $.each(data, function (index, list_prodi) {
                        select.append($('<option>', {
                            value: list_prodi.id,
                            text: list_prodi.strata +' '+  list_prodi.nama_prodi
                        }));
                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }

        fetchProdi();
    })

    let dataTable
    // Data Table
    dataTable = $("#dataTable").DataTable({
        "ajax": {
            "url": "<?= base_url() ?>/admin/dosen/data_dosen",
            "dataSrc": "list_dosen"
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
                title: 'Username',
                data: 'username'
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
                title: 'Kode Dosen',
                data: 'kodeDosen'
            },
            {
                title: 'JK',
                data: 'jenisKelamin',
                render: function(data, type, row, full) {
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
                        let alignment = '<div class="d-flex justify-content-center">'
                        let open_group = '<div class="btn-group">'
                        let base_url = "<?= base_url() ?>"
                        let button = '<a class="btn btn-sm btn-primary" href="' + base_url + '/admin/dosen/detail/' + row['user_id'] + '"> Detail </a>'
                        if (row['flag'] == 1) {
                            html = '<a class="btn btn-danger btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchDosen" data-id="' + row['user_id'] + '" data-name="' + row['nama'] + '" >Nonaktifkan</a>'
                        } else {
                            html = '<a class="btn btn-success btn-sm" onclick="switchFlag(this)" data-bs-toggle="modal" data-bs-target="#switchDosen" data-id="' + row['user_id'] + '" data-name="' + row['nama'] + '">Aktifkan</a>'
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
</script>