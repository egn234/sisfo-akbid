<div class="modal-header">
    <h5 class="modal-title" id="createBapLabel">Masukkan Nilai</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form class="form" id="inputNilai" method="post" action="<?= url_to('admin/nilai/submit-nilai')?>">
        <input type="text" name="mhs_id" value="<?=$mhs_id?>" hidden>
        <input type="text" name="matkul_id" value="<?=$matkul_id?>" hidden>
        <div class="mb-3">
            <label for="total" class="form-label">Nilai Akhir</label>
            <input type="text" class="form-control" id="total" name="total" value="<?=($flag==1)?$nilai->nilaiAkhir:''?>">
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
    <button type="submit" form="inputNilai" id="submitBtn" class="btn btn-primary">Submit</button>
</div>
