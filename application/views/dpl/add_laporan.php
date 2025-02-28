<style>
.ck-editor__editable {
    min-height: 400px;
    max-height: 500px;
}
</style>


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?= form_open('add_report', 'id="form_main"') ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 my-2">
                            <label class="text-muted"><b>Dari Tanggal</b></label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>

                        <div class="col-sm-12 col-md-6 my-2">
                            <label class="text-muted"><b>Sampai Tanggal</b></label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>

                        <div class="col-12 my-2">
                            <label class="text-muted"><b>Uraian Kegiatan</b></label>
                            <textarea name="kegiatan" id="kegiatan" class="editor"></textarea>
                        </div>

                        <div class="col-12 my-2">
                            <label class="text-muted"><b>Hasil / Temuan / Tindak Lanjut</b></label>
                            <textarea name="temuan" id="temuan" class="editor2"></textarea>
                        </div>

                        <div class="col-sm-12 col-md-6 my-2">
                            <label class="text-muted"><b>File Dokumentasi</b></label>
                            <input type="file" name="file" id="file" class="form-control" required>
                        </div>

                        <div class="col-12 my-2">
                            <a href="<?= base_url('report-pemlap') ?>" class="btn btn-sm btn-secondary"><i
                                    class="fas fa-arrow-left"></i> Kembali</a>

                            <button type="submit" class="btn btn-sm btn-success" id="to_send"><i
                                    class="fas fa-paper-plane"></i>
                                Kirim</button>
                        </div>

                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="importmap">
    {
                "imports": {
                    "ckeditor5":  "./assets/ckeditor/ckeditor5.js",
                    "ckeditor5/":  "./assets/ckeditor/"
                }
            }
</script>