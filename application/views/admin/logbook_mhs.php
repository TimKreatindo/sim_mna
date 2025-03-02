<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">

                    <?php if($user->id_role == 1) { 
                        $filter_dosen = $filter['dosen'];
                        $filter_periode = $filter['periode'];    
                    ?>
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-md-5 mb-3">
                            <label><b>Periode</b></label>
                            <select name="periode" id="periode" class="form-control">
                                <option value="">--pilih--</option>
                                <?php foreach($filter_periode as $fp){ ?>
                                <option value="<?= $fp->id ?>"><?= $fp->periode ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-5 mb-3">
                            <label><b>Dosen</b></label>
                            <select name="dosen" id="dosen" class="form-control">
                                <option value="">--pilih--</option>
                                <?php foreach($filter_dosen as $fd){ ?>
                                <option value="<?= $fd->id ?>"><?= $fd->nama ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-2 mb-3">
                            <button class="btn btn-sm btn-primary w-100" onclick="filter_data()">
                                <i class="fas fa-filter"></i> Filter Data
                            </button>
                        </div>
                    </div>
                    <?php } else if($user->id_role == 2 || $user->id_role == 9){ 
                        $filter_group = $filter['group'];    
                        $filter_periode = $filter['periode'];    
                    ?>
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-md-5 mb-3">
                            <label><b>Periode</b></label>
                            <select name="periode" id="periode" class="form-control">
                                <option value="">--pilih--</option>
                                <?php foreach($filter_periode as $fp){ ?>
                                <option value="<?= $fp->id ?>"><?= $fp->periode ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-5 mb-3">
                            <label><b>Group</b></label>
                            <select name="group" id="group" class="form-control">
                                <option value="">--pilih--</option>
                                <?php foreach($filter_group as $mff){
                                    echo '<option value="'.$mff->id_group.'">'.$mff->nama_group.'</option>';
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-2 mb-3">
                            <button class="btn btn-sm btn-primary w-100" onclick="filter_data()">
                                <i class="fas fa-filter"></i> Filter Data
                            </button>
                        </div>
                    </div>
                    <?php } ?>


                    <table class="table table-bordered table-sm w-100" id="list_mahasiswa">
                        <thead>
                            <tr class="table-secondary">
                                <th>#</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>