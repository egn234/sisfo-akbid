<script>
    let dataArr = []
    $(document).ready(function() {
        const availableTable = $('#available-items').DataTable({
            ajax: {
                url: '<?= base_url() ?>mahasiswa/registrasi/data-jadwal',
                dataSrc: 'list_jadwal'
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        // Calculate row index
                        const index = meta.row + meta.settings._iDisplayStart + 1;
                        // Return row index as a string
                        return index.toString();
                    }
                },
                {
                    data: 'id',
                    visible: false
                },
                {
                    data: 'kodeMatkul'
                },
                {
                    data: 'namaMatkul'
                },
                {
                    data: 'tingkat',
                    render: function(data, type, row, meta) {
                        if (type === 'display') {
                            let text = 'TINGKAT ' + data
                            return text
                        }
                        return data
                    }
                },
                {
                    data: 'sks'
                },
                {
                    data: null,
                    defaultContent: '<button type="button" class="add btn btn-sm btn-success">Tambah</button>'
                }
            ]
        });

        const selectedTable = $('#selected-items').DataTable({
            ajax: {
                url: '<?= base_url() ?>mahasiswa/registrasi/data-jadwal2',
                dataSrc: 'list_jadwal'
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        // Calculate row index
                        const index = meta.row + meta.settings._iDisplayStart + 1;
                        // Return row index as a string
                        return index.toString();
                    }
                },
                {
                    data: 'id',
                    visible: false
                },
                {
                    data: 'kodeMatkul'
                },
                {
                    data: 'namaMatkul'
                },
                {
                    data: 'tingkat'
                },
                {
                    data: 'sks'
                },
                {
                    data: null,
                    defaultContent: '<button type="button" class="remove btn btn-sm btn-danger">Hapus</button>'
                }
            ]
        });

        $('#available-items tbody').on('click', '.add', function() {
            const data = availableTable.row($(this).parents('tr')).data();
            dataArr.push(data)
            var filteredData = availableTable
                .rows()
                .indexes()
                .filter(function(value, index) {
                    return availableTable.row(value).data().kodeMatkul == data.kodeMatkul;
                });
            selectedTable.row.add(data).draw();
            availableTable.rows(filteredData).remove().draw();
            calculateTotal();
        });

        $('#selected-items tbody').on('click', '.remove', function() {
            const data = selectedTable.row($(this).parents('tr')).data();
            let indexArr = dataArr.findIndex(item => item.id == data.id)
            dataArr.splice(indexArr, 1)
            availableTable.row.add(data).draw();
            selectedTable.row($(this).parents('tr')).remove().draw();
            calculateTotal();
        });

        $('#add-selected').on('click', function() {
            const selectedData = selectedTable.rows().data().toArray();
            $.ajax({
                type: 'POST',
                url: '<?= base_url() ?>mahasiswa/registrasi/regis-proc',
                data: {
                    selectedData: selectedData
                },
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
                data: {
                    ids: selectedIds
                },
                dataType: 'json',
                success: function(data) {
                    // Show schedule data in modal with datatable
                    const modalTable = $('#schedule-modal-table').DataTable({
                        data: data,
                        columns: [{
                                data: null,
                                render: function(data, type, row, meta) {
                                    // Calculate row index
                                    const index = meta.row + meta.settings._iDisplayStart + 1;
                                    // Return row index as a string
                                    return index.toString();
                                }
                            },
                            {
                                data: 'day'
                            },
                            {
                                data: 'time'
                            },
                            {
                                data: 'course'
                            },
                            {
                                data: 'room'
                            }
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

    function cekJadwal(x) {
        var timetable = new Timetable();
        timetable.setScope(6, 23); // optional, only whole hours between 0 and 23
        timetable.useTwelveHour(); //optional, displays hours in 12 hour format (1:00PM)
        timetable.addLocations(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']);
        for (let i = 0; i < dataArr.length; i++) {
            let day = dataArr[i].day
            let start = dataArr[i].startTime.split(':')
            let end = dataArr[i].endTime.split(':')
            let namaMatkul = dataArr[i].namaMatkul
            timetable.addEvent(namaMatkul, day, new Date(2023, 7, 17, start[0], start[1]), new Date(2023, 7, 17, end[0], end[1]));
        }

        var renderer = new Timetable.Renderer(timetable);
        renderer.draw('.timetable'); // any css selector
        $('.room-timeline').attr('style', 'width: 1632px;')
        $('.syncscroll').attr('style', 'width:1372.46; height:46;')
    }
</script>