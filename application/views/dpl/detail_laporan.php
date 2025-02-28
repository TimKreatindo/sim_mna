<?php
    $decode_tgl = json_decode($data->tanggal);
    $decode_ctt = json_decode($data->ctt);
    $decode_file = json_decode($data->dokumentasi);
    
    $create_start = date_create($decode_tgl->start);
    $create_end = date_create($decode_tgl->end);
    
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-12 col-md-6 py-2">
                            <label><b>Tanggal</b></label>
                            <p><?= date_format($create_start, 'd F Y') .' - '. date_format($create_end, 'd F Y') ?></p>
                        </div>
                        <div class="col-12 py-2">
                            <label><b>Uraian Kegiatan</b></label>
                            <?= $data->uraian ?>
                        </div>
                        <div class="col-12 py-2">
                            <label><b>Hasil / Temuan / Tindak Lanjut</b></label>
                            <?= $data->hasil ?>
                        </div>
                        <div class="col-sm-12 col-md-6 py-2">
                            <label><b>File Dokumentasi</b></label> <br>
                            <a href="<?= base_url('assets/logbook/pemlap/') . $decode_file->file_name ?>"
                                target="_blank"><?= $decode_file->file_name ?></a>
                        </div>


                    </div>

                </div>
            </div>

            <?php if($decode_ctt){ ?>
            <div class="card mt-3">
                <div class="card-body">
                    <h5>Catatan</h5>
                    <?php
                        foreach($decode_ctt as $dc){
                        $create_date = date_create($dc->date);
                    ?>
                    <div class="my-2">
                        <label><b><?= $dc->from ?></b></label> <br>
                        <small class="text-muted"><?= date_format($create_date, 'd F Y H:i') ?></small>
                        <p><?= $dc->ctt ?></p>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>