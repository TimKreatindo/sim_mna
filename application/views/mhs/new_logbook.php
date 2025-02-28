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
                    <?= form_open_multipart('validation_mylogbook', 'id="form_my_logbook"') ?>
                    <div class="row">

                        <div class="col-12 col-md-6 my-2">
                            <label><b>Dari Tanggal</b></label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>

                        <div class="col-12 col-md-6 my-2">
                            <label><b>Sampai Tanggal</b></label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>

                        <div class="col-12 col-md-6 my-2">
                            <label><b>Mengikuti Kegiatan</b></label>
                            <select name="mengikuti_kegiatan" id="mengikuti_kegiatan" class="form-control" required>
                                <option value="">--pilih--</option>
                                <option value="Iya">Iya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6 my-2" id="show_opt_kegiatan">
                        </div>

                        <div class="col-12 my-2">
                            <label><b>Uraian Kegiatan</b></label>
                            <textarea name="activity" id="activity" class="editor"></textarea>
                        </div>

                        <div class="col-12 my-2">
                            <label><b>Hasil Tindak Lanjut</b></label>
                            <textarea name="solve" id="solve" class="editor2"></textarea>
                        </div>


                        <div class="col-12 my-2">
                            <label><b>File Tugas</b></label>
                            <input type="file" name="file" id="file" required class="form-control">
                        </div>


                    </div>
                    <div class="row justify-content-center align-items-center my-2">
                        <div class="col-6 col-sm-6 col-md-3 col-lg-2">
                            <a href="<?= base_url('mhs/my-logbook') ?>" class="btn btn-sm btn-secondary w-100"><i
                                    class="fas fa-arrow-left"></i>
                                Kembali</a>
                        </div>
                        <div class="col-6 col-sm-6 col-md-3 col-lg-2">
                            <button class="btn btn-sm btn-success w-100" type="submit"><i
                                    class="fab fa-telegram-plane"></i> Kirim</button>
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
                    "ckeditor5":  "../assets/ckeditor/ckeditor5.js",
                    "ckeditor5/":  "../assets/ckeditor/"
                }
            }
    </script>