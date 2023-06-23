<div class="modal-header">
    <h5 class="modal-title" id="createBapLabel">Masukkan Nilai</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="form" id="inputNilai" method="post" action="<?= url_to('dosen/nilai/submit-nilai')?>">
        <input type="text" name="mhs_id" value="<?=$mhs_id?>" hidden>
        <input type="text" name="matkul_id" value="<?=$matkul_id?>" hidden>
        <div class="mb-3">
            <label for="nilaiTugas" class="form-label">Nilai Tugas (0-100)</label>
            <input type="number" class="form-control" id="nilaiTugas" name="nilaiTugas" value="<?=($flag==1)?$nilai->nilaiTugas:''?>" min="0" max="100">
        </div>
        <div class="mb-3">
            <label for="nilaiPraktek" class="form-label">Nilai Praktek (0-100)</label>
            <input type="number" class="form-control" id="nilaiPraktek" name="nilaiPraktek" value="<?=($flag==1)?$nilai->nilaiPraktek:''?>" min="0" max="100">
        </div>
        <div class="mb-3">
            <label for="nilaiUTS" class="form-label">Nilai UTS (0-100)</label>
            <input type="number" class="form-control" id="nilaiUTS" name="nilaiUTS" value="<?=($flag==1)?$nilai->nilaiUTS:''?>" min="0" max="100">
        </div>
        <div class="mb-3">
            <label for="nilaiUAS" class="form-label">Nilai UAS (0-100)</label>
            <input type="number" class="form-control" id="nilaiUAS" name="nilaiUAS" value="<?=($flag==1)?$nilai->nilaiUAS:''?>" min="0" max="100">
        </div>
        <div class="mb-3">
            <label for="nilaiKehadiran" class="form-label">Kehadiran (%)</label>
            <input type="number" class="form-control" id="nilaiKehadiran" name="nilaiKehadiran" value="<?=($flag==1)?$nilai->nilaiKehadiran:($kehadiran->ratio*100)?>" readonly>
        </div>
        <div class="mb-3">
            <label for="total" class="form-label">Nilai Akhir</label>
            <input type="text" class="form-control" id="total" name="total" value="<?=($flag==1)?$nilai->nilaiAkhir:''?>" readonly>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    <button type="submit" form="inputNilai" id="submitBtn" class="btn btn-primary">Submit</button>
</div>


<script>
    // Get references to the input fields and the total field
    const nilaiTugasInput = document.getElementById('nilaiTugas');
    const nilaiPraktekInput = document.getElementById('nilaiPraktek');
    const nilaiUTSInput = document.getElementById('nilaiUTS');
    const nilaiUASInput = document.getElementById('nilaiUAS');
    const totalInput = document.getElementById('total');

    // Add event listeners to the input fields
    nilaiTugasInput.addEventListener('input', calculateTotal);
    nilaiPraktekInput.addEventListener('input', calculateTotal);
    nilaiUTSInput.addEventListener('input', calculateTotal);
    nilaiUASInput.addEventListener('input', calculateTotal);

    // Calculate the total based on the input values
    function calculateTotal() {
        const nilaiTugas = parseInt(nilaiTugasInput.value) || 0;
        const nilaiPraktek = parseInt(nilaiPraktekInput.value) || 0;
        const nilaiUTS = parseInt(nilaiUTSInput.value) || 0;
        const nilaiUAS = parseInt(nilaiUASInput.value) || 0;
        const nilaiKehadiran = <?=$kehadiran->ratio*100?>;
        
        const paramTugas = <?=$param_nilai->paramTugas?> / 100
        const paramPraktek = <?=$param_nilai->paramPraktek?> / 100
        const paramUTS = <?=$param_nilai->paramUTS?> / 100
        const paramUAS = <?=$param_nilai->paramUAS?> / 100
        const paramKehadiran = <?=$param_nilai->paramKehadiran?> / 100

        const hitungTugas = nilaiTugas * paramTugas;
        const hitungPraktek = nilaiPraktek * paramPraktek;
        const hitungUTS = nilaiUTS * paramUTS;
        const hitungUAS = nilaiUAS * paramUAS;
        const hitungKehadiran = nilaiKehadiran * paramKehadiran;
        
        const total = hitungTugas + hitungPraktek + hitungUTS + hitungUAS + hitungKehadiran;
        totalInput.value = total;
    }
</script>