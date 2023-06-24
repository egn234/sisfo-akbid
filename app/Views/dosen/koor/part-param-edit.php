<div class="modal-header">
    <h5 class="modal-title" id="createBapLabel">Ubah Parameter Penilaian</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="form" id="subParam" method="post" action="<?= url_to('dosen/koordinator/edit-param-proc')?>">
        <input type="text" name="param_id" value="<?=$param_nilai->id?>" hidden>
        <div class="mb-3">
            <label for="paramTugas" class="form-label">Nilai Tugas (%)</label>
            <input type="number" class="form-control" id="paramTugas" name="paramTugas" value="<?=$param_nilai->paramTugas?>" min="0" max="100">
        </div>
        <div class="mb-3">
            <label for="paramPraktek" class="form-label">Nilai Praktek (%)</label>
            <input type="number" class="form-control" id="paramPraktek" name="paramPraktek" value="<?=$param_nilai->paramPraktek?>" min="0" max="100">
        </div>
        <div class="mb-3">
            <label for="paramUTS" class="form-label">Nilai UTS (%)</label>
            <input type="number" class="form-control" id="paramUTS" name="paramUTS" value="<?=$param_nilai->paramUTS?>" min="0" max="100">
        </div>
        <div class="mb-3">
            <label for="paramUAS" class="form-label">Nilai UAS (%)</label>
            <input type="number" class="form-control" id="paramUAS" name="paramUAS" value="<?=$param_nilai->paramUAS?>" min="0" max="100">
        </div>
        <div class="mb-3">
            <label for="paramKehadiran" class="form-label">Kehadiran (%)</label>
            <input type="number" class="form-control" id="paramKehadiran" name="paramKehadiran" value="<?=$param_nilai->paramKehadiran?>" min="0" max="100">
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    <button type="submit" form="subParam" id="submitBtn" class="btn btn-primary">Submit</button>
</div>


<script>
    document.getElementById('subParam').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        var var1 = parseInt(document.getElementById('paramTugas').value);
        var var2 = parseInt(document.getElementById('paramPraktek').value);
        var var3 = parseInt(document.getElementById('paramUTS').value);
        var var4 = parseInt(document.getElementById('paramUAS').value);
        var var5 = parseInt(document.getElementById('paramKehadiran').value);

        var total = var1 + var2 + var3 + var4 + var5;

        if (total != 100) {
            alert('Total parameter harus 100%');
            return;
        }

        // Proceed with form submission
        this.submit();
    });

</script>