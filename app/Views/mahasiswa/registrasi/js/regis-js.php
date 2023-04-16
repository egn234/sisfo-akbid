<script>
    $(document).ready(function() {
        const availableTable = $('#available-items').DataTable({
            ajax: {
                url: '<?= base_url() ?>mahasiswa/registrasi/data-jadwal',
                dataSrc: 'list_jadwal'
            },
            columns: [
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        // Calculate row index
                        const index = meta.row + meta.settings._iDisplayStart + 1;
                        // Return row index as a string
                        return index.toString();
                    }
                },
                { data: 'id', visible: false },
                { data: 'kodeMatkul' },
                { data: 'namaMatkul' },
                {
                    data: 'tingkat',
                    render: function(data, type, row, meta){
                        if (type === 'display') {
                            let text = 'TINGKAT ' + data
                            return text
                        }
                        return data
                    }
                },
                { data: 'sks' },
                { data: null, defaultContent: '<button type="button" class="add btn btn-sm btn-success">Tambah</button>' }
            ]
        });

        const selectedTable = $('#selected-items').DataTable({
            ajax: {
                url: '<?= base_url() ?>mahasiswa/registrasi/data-jadwal2',
                dataSrc: 'list_jadwal'
            },
            columns: [
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        // Calculate row index
                        const index = meta.row + meta.settings._iDisplayStart + 1;
                        // Return row index as a string
                        return index.toString();
                    }
                },
                { data: 'id', visible: false },
                { data: 'kodeMatkul' },
                { data: 'namaMatkul' },
                { data: 'tingkat' },
                { data: 'sks' },
                { data: null, defaultContent: '<button type="button" class="remove btn btn-sm btn-danger">Hapus</button>' }
            ]
        });

        $('#available-items tbody').on('click', '.add', function() {
            const data = availableTable.row($(this).parents('tr')).data();
            selectedTable.row.add(data).draw();
            availableTable.row($(this).parents('tr')).remove().draw();
            calculateTotal();
        });

        $('#selected-items tbody').on('click', '.remove', function() {
            const data = selectedTable.row($(this).parents('tr')).data();
            availableTable.row.add(data).draw();
            selectedTable.row($(this).parents('tr')).remove().draw();
            calculateTotal();
        });

        $('#add-selected').on('click', function() {
            const selectedData = selectedTable.rows().data().toArray();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>mahasiswa/registrasi/regis-proc',
                data: { selectedData: selectedData },
                    success: function() {
                        window.location.href = '<?= base_url() ?>mahasiswa/registrasi/regis-proc';
                    }
            });
        });

        function calculateTotal() {
            const selectedData = selectedTable.rows().data().toArray();
            let totalSks = 0;
            for (let i = 0; i < selectedData.length; i++) {
                const sks = parseInt(selectedData[i].sks);
                if (!isNaN(sks)) { // Check if the sks value is a number
                totalSks += sks;
                }
            }
            if (!isNaN(totalSks)) { // Check if the totalSks value is a number
                $('#total-sks').text(totalSks);
            } else {
                $('#total-sks').text('Error');
            }
        }

        // ===========================================
        // FUNGSI BUTTON UNTUK CEK JADWAL MATA KULIAH YANG DIPILIH
        let selectedIds = [];

        // Bind click event to check-schedule button
        $('#check-schedule').on('click', function() {
            // Collect IDs from selected table
            selectedIds = [];
            $('#selected-items tbody tr').each(function() {
                const id = selectedTable.rows('.selected').data().map(row => row.id);
                selectedIds.push(id);
            });

            // Make AJAX call to get schedule data
            $.ajax({
                url: 'mahasiswa/registrasi/cek_jadwal',
                type: 'POST',
                data: {ids: selectedIds},
                dataType: 'json',
                success: function(data) {
                    // Show schedule data in modal with datatable
                    const modalTable = $('#schedule-modal-table').DataTable({
                        data: data,
                        columns: [
                            {
                                data: null,
                                render: function(data, type, row, meta) {
                                    // Calculate row index
                                    const index = meta.row + meta.settings._iDisplayStart + 1;
                                    // Return row index as a string
                                    return index.toString();
                                }
                            },
                            { data: 'day' },
                            { data: 'time' },
                            { data: 'course' },
                            { data: 'room' }
                        ]
                    });
                    $('#schedule-modal').modal('show');
                },
                error: function() {
                    alert('Error getting schedule data.');
                }
            });
        });

    });
</script>