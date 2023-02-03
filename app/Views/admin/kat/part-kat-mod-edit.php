<div class="modal-header">
    <h5 class="modal-title" id="addPengajuanLabel">Ubah Kategori</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="<?= url_to('admin_edit_kategori', $a->idkategori) ?>" id="formEditKat" method="post">
        <div class="mb-3">
            <label class="form-label" for="name_kat">Nama Kategori</label>
            <input type="text" class="form-control" id="name_kat" name="nama_kategori" value="<?=$a->nama_kategori?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="desc_kat">Deskripsi Kategori</label>
            <input type="text" class="form-control" id="desc_kat" name="keterangan" value="<?=$a->keterangan?>" required>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
    <button type="submit" form="formEditKat" class="btn btn-primary">Ubah Kategori</button>
</div>