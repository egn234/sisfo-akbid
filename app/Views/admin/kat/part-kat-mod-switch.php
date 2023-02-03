<div class="modal-header">
    <h5 class="modal-title" id="myModalLabel">Konfirmasi</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="mb-3">
        <?=($a->flag == 1)?'Nonaktifkan':'Aktifkan'?> kategori ini?
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
    <?php if($a->flag == 1){?>
    <a href="<?= url_to('admin_switch_kategori', $a->idkategori) ?>" class="btn btn-danger">Nonaktifkan</a>
    <?php }else{?>
    <a href="<?= url_to('admin_switch_kategori', $a->idkategori) ?>" class="btn btn-success">Aktifkan</a>
    <?php }?>
</div>
