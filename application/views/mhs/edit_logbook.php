<?php
    $decode_jadwal = json_decode($data->jadwal);
    $decode_file = json_decode($data->file_tugas);
    
    $option_kegiatan = ['Iya', 'Tidak'];
?>
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
                    <?= form_open_multipart('edit_mylogbook', 'id="form_my_logbook"') ?>
                    <input type="hidden" name="id" value="<?=sha1($data->id)?>">
                    <div class="row">

                        <div class="col-12 col-md-6 my-2">
                            <label><b>Dari Tanggal</b></label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required
                                value="<?= $decode_jadwal->start ?>">
                        </div>

                        <div class="col-12 col-md-6 my-2">
                            <label><b>Sampai Tanggal</b></label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required
                                value="<?= $decode_jadwal->end ?>">
                        </div>

                        <div class="col-12 col-md-6 my-2">
                            <label><b>Mengikuti Kegiatan</b></label>
                            <select name="mengikuti_kegiatan" id="mengikuti_kegiatan" class="form-control" required>
                                <option value="">--pilih--</option>
                                <?php 
                                    foreach($option_kegiatan as $ok){
                                        if($ok == $data->mengikuti){
                                            echo '<option selected value="'.$ok.'">'.$ok.'</option>';
                                        } else {
                                            echo '<option value="'.$ok.'">'.$ok.'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-12 col-md-6 my-2" id="show_opt_kegiatan"
                            data-kegiatan="<?=$data->jenis_kegiatan;?>">
                        </div>

                        <div class="col-12 my-2">
                            <label><b>Uraian Kegiatan</b></label>
                            <textarea name="activity" id="activity" class="editor"></textarea>
                            <div id="val_activity" data-value="<?= $data->uraian_kegiatan ?>"></div>
                        </div>

                        <div class="col-12 my-2">
                            <label><b>Hasil Tindak Lanjut</b></label>
                            <textarea name="solve" id="solve" class="editor2" value=""></textarea>
                            <div id="val_solve" data-value="<?= $data->hasil ?>"></div>
                        </div>


                        <div class="col-12 my-2">
                            <label><b>Update File Tugas</b></label>
                            <input type="file" name="file" id="file" class="form-control">
                            <small><a target="_blank"
                                    href="<?= base_url('assets/logbook/mhs/') . $decode_file->file_name ?>"><?= $decode_file->file_name ?></a></small>
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
                                    class="fab fa-telegram-plane"></i> Edit & Kirim</button>
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
                    "ckeditor5":  "../../assets/ckeditor/ckeditor5.js",
                    "ckeditor5/":  "../../assets/ckeditor/"
                }
            }
</script>