<script>

    $(document).ready(function() {
        var table = $('#dataTable').DataTable({
            ajax: {
                url: "<?= base_url() ?>mahasiswa/jadwal/data-jadwal",
                dataSrc: "data"
            },
            columnDefs: [{
                searchable: true,
                orderable: false,
                targets: "_all",
                defaultContent: "-",
            }],
            columns: [
                { 
                    title: "No",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    title: "Mata Kuliah",
                    render: function(data, type, row) {
                        return row.kodeMatkul + " - " + row.namaMatkul;
                    }
                },
                {
                    title: "Kode Dosen",
                    data: "kodeDosen"
                },
                {
                    title: "Hari",
                    data: "day"
                },
                {
                    title: "Jam",
                    render: function(data, type, row) {
                        return row.startTime + " - " + row.endTime;
                    }
                },
                {
                    title: "Ruangan",
                    data: "kodeRuangan"
                }
            ],
            scrollX: true
        });

        table.draw();
    });

</script>