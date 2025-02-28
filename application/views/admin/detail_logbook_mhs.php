<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-12 col-md-4 my-2">
                            <label class="text-muted"><b>Tanggal</b></label>
                            <?php
                                $jadwal = json_decode($data->jadwal);
                                $start_date = date_create($jadwal->start);
                                $end_date = date_create($jadwal->end);

                                $start = date_format($start_date, 'd F Y');
                                $end = date_format($end_date, 'd F Y');
                                echo '<p>'. $start .' - '. $end . '</p>';
                            ?>
                        </div>
                        <div class="col-sm-12 col-md-4 my-2">
                            <label class="text-muted"><b>Mengikuti Kegiatan</b></label>
                            <?php 
                                if($data->mengikuti == 'Iya'){
                                    $mengikuti = 'Mengikuti';
                                } else {
                                    $mengikuti = 'Tidak Mengikuti';
                                } 
                                echo '<p>'.$mengikuti.'</p>'
                            ?>
                        </div>
                        <div class="col-sm-12 col-md-4 my-2">
                            <label class="text-muted"><b>Jenis Kegiatan</b></label>
                            <p><?= $data->jenis_kegiatan ?></p>
                        </div>

                        <div class="col-12 my-2">
                            <label class="text-muted"><b>Uraian Kegiatan</b></label>
                            <?= $data->uraian_kegiatan ?>
                        </div>

                        <div class="col-12 my-2">
                            <label class="text-muted"><b>Hasil Tindak Lanjut</b></label>
                            <?= $data->hasil ?>
                        </div>

                        <div class="col-12 my-2">
                            <label class="text-muted"><b>File Dokumentasi</b></label>
                            <?php
                                $decode_file = json_decode($data->file_tugas);
                                $filename = $decode_file->file_name;
                                $file_ext = $decode_file->file_path;

                                echo '<p><a target="_blank" href="'.base_url('assets/logbook/mhs/').$filename.'">'.$filename.'</a></p>'
                            ?>
                        </div>


                        <?php if($user->id_role == 9 && $data->status == 2 || $user->id_role == 2 && $data->status == 11){ ?>
                        <div class="col-12 my-2">
                            <label><b>Catatan</b></label> <br>
                            <small class="text-danger">* harus diisi jika ada revisi</small>
                            <textarea name="notes" id="notes" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="col-12 my-2">
                            <button class="btn btn-sm btn-danger" onclick="reject_logbook()"><i
                                    class="fas fa-times"></i> Tolak</button>
                            <button class="btn btn-sm btn-success" onclick="approve_logbook()"><i
                                    class="fas fa-check"></i> Terima</button>
                        </div>
                        <?php } ?>

                    </div>

                </div>
            </div>


            <?php
                $decode_ctt = json_decode($data->ctt);
                if($decode_ctt){
            ?>
            <div class="card my-3">
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

<div id="uri" data-value="<?= $this->uri->segment(3) ?>"></div>