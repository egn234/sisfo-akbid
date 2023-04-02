<script>
    function switchFlag(x) {
        $('#user_id').val($(x).attr('data-id'))
        $('#nameUser').text($(x).attr('data-name'))
    }
    function updateData(x) {
        $('#idPut').val($(x).attr('data-idPut'))
        $('#namePut').val($(x).attr('data-namePut'))
        $('#nimPut').val($(x).attr('data-nimPut'))
        $('#nikPut').val($(x).attr('data-nikPut'))
        $('#jenisKelaminPut').val($(x).attr('data-jenisKelaminPut'))
        $('#tempatLahirPut').val($(x).attr('data-tempatLahirPut'))
        $('#tanggalLahirPut').val($(x).attr('data-tanggalLahirPut'))
        $('#alamatPut').val($(x).attr('data-alamatPut'))
        $('#emailPut').val($(x).attr('data-emailPut'))
        $('#kontakPut').val($(x).attr('data-kontakPut'))
        $('#namaIbuPut').val($(x).attr('data-namaIbuPut'))
        $('#kontakIbuPut').val($(x).attr('data-kontakIbuPut'))
        $('#namaAyahPut').val($(x).attr('data-namaAyahPut'))
        $('#kontakAyahPut').val($(x).attr('data-kontakAyahPut'))
        $('#namaWaliPut').val($(x).attr('data-namaWaliPut'))
        $('#kontakWaliPut').val($(x).attr('data-kontakWaliPut'))

    }
    $(document).ready(function() {
        document.getElementsByClassName("flatpickr-basic").flatpickr({
            dateFormat: "Y-m-d"
        })
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
                        console.log(row);
                        let html
                        let htmlPut = '<a class="btn btn-primary btn-sm" style="margin-right:2%;" onclick="updateData(this)" data-bs-toggle="modal" data-bs-target="#updateData" '+
                        ' data-idPut="' + data + '" data-namePut="' + row['nama'] + '" data-emailPut="' + row['email'] + '" data-jenisKelaminPut="' + row['jenisKelamin'] + '"  data-nimPut="' + row['nim'] + '"  data-nikPut="' + row['nik'] +'"'+ 
                        ' data-kontakAyahPut="' + row['kontakAyah'] + '" data-kontakIbuPut="' + row['kontakIbu'] + '" data-kontakWaliPut="' + row['kontakWali'] + '"'+
                        ' data-namaAyahPut="' + row['namaAyah'] + '" data-namaIbuPut="' + row['namaIbu'] + '" data-namaWaliPut="' + row['namaWali'] + '"'+
                        ' data-tanggalLahirPut="' + row['tanggalLahir'] + '" data-tempatLahirPut="' + row['tempatLahir'] + '"  data-alamatPut="' + row['alamat'] + '"  data-kontakPut="' + row['kontak'] + '" >Ubah</a>' 

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
</script>