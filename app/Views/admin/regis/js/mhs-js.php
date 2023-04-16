<script>
    $(document).ready(function(){
        const listMahasiswa = $('#dataTable').DataTable({
            ajax: {
                url: '<?= base_url() ?>admin/registrasi/data-mhs/<?=$kelas_id?>',
                dataSrc: 'list_mhs'
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
                { data: 'nama' },
                { data: 'nim' },
                {
                    width: '15%',
                    data: null, 
                    render: function(data, type, row) {
                        const group = '<div class="d-flex gap-1 justify-content-center">'
                        const ending = '</div>'
                        const buttonDetail = '<button type="button" class="btn btn-sm btn-primary btn-open-modal" data-id="' + row.id + '">Cek Matkul</button>';
                        const buttonConfirm = '<button type="button" class="btn btn-sm btn-success btn-open-modal2" data-name="' + row.nama +'" data-id="' + row.id + '">Approve</button>';
                        const buttonReset = '<button type="button" class="btn btn-sm btn-danger btn-open-modal3" data-name="' + row.nama +'" data-id="' + row.id + '">Reset</button>';
                        return group + buttonDetail + buttonConfirm + buttonReset + ending;
                    }
                }
            ]
        })

        $('#dataTable tbody').on('click', '.btn-open-modal', function() {
            const id = $(this).data('id');
            // Pass the id to your modal here and open it
            $('#detailMatkul').data('id', id).modal('show');
        });
        
        $('#dataTable tbody').on('click', '.btn-open-modal2', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const link = '<?=base_url()?>admin/registrasi/acc-regis/'
            // Create the modal HTML content dynamically
            let modalHtml = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Approve registrasi dari ${name}?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="${link + id}" class="btn btn-success">Konfirmasi</a>
                        </div>
                    </div>
                </div>`;
            // Append the modal HTML to the body
            $('body').append('<div class="modal fade" id="confirmRemoveModal">' + modalHtml + '</div>');
            // Show the modal
            $('#confirmRemoveModal').modal('show');
            // Remove the modal from the DOM when it is closed
            $('#confirmRemoveModal').on('hidden.bs.modal', function () {
                $(this).remove();
            });
        });

        $('#dataTable tbody').on('click', '.btn-open-modal3', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const link = '<?=base_url()?>admin/registrasi/reset/'
            // Create the modal HTML content dynamically
            let modalHtml = `
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Reset registrasi dari ${name}?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <a href="${link + id}" class="btn btn-danger">Reset</a>
                        </div>
                    </div>
                </div>`;
            // Append the modal HTML to the body
            $('body').append('<div class="modal fade" id="confirmRemoveModal">' + modalHtml + '</div>');
            // Show the modal
            $('#confirmRemoveModal').modal('show');
            // Remove the modal from the DOM when it is closed
            $('#confirmRemoveModal').on('hidden.bs.modal', function () {
                $(this).remove();
            });
        });

        $('#detailMatkul').on('shown.bs.modal', function() {
            const id = $(this).data('id');
            $.ajax({
                url: '<?= base_url() ?>admin/registrasi/data-jadwal/' + id,
                success: function(data) {
                    $('#detailMatkulTable').DataTable({
                        data: JSON.parse(data),
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
                            { data: 'kodeMatkul' },
                            { data: 'namaMatkul' },
                            { data: 'tingkat' },
                            { data: 'kodeDosen' },
                            { data: 'day' },
                            { data: 'startTime' },
                            { data: 'kodeRuangan' }
                        ]
                    });
                }
            });
        });
    });
</script>