<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <div class="row g-0 mb-3">
                        <div class="col-3 col-sm-3 col-md-8 col-lg-8">
                            <button class="btn btn-sm btn-primary" onclick="add_data()"><i
                                    class="fa fa-plus"></i></button>
                        </div>
                        <div class="col-9 col-sm-9 col-md-4 col-lg-4">
                            <select name="select_periode" id="select_periode" class="form-control">
                                <option value="">--pilih periode--</option>
                                <?php foreach($periode as $pr){ ?>
                                <option value="<?= $pr->id ?>"><?= $pr->periode ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <table class="table table-bordered table-sm" id="table_periode">
                        <thead>
                            <tr class="table-dark">
                                <th>#</th>
                                <th>Group</th>
                                <th>Periode</th>
                                <th>Dosen Pembimbing</th>
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


<!-- Modal -->
<div class="modal" id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down">
        <div class="modal-content">
            <div class="modal-header bg-dark text-light">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="text-light btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('validation_group', 'id="form_group"') ?>
            <input type="hidden" name="act" id="action">
            <input type="hidden" name="id" id="id_group">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <label><b>Nama Group</b></label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <label><b>Periode</b></label>
                        <select name="periode" id="periode" required class="form-control">
                            <option value="">--pilih--</option>
                            <?php foreach($periode as $p){ ?>
                            <option value="<?= $p->id ?>"><?=$p->periode?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <label><b>Dosen Pembimbing</b></label>
                        <select name="dospem" id="dospem" class="form-control">
                            <option value="">--pilih--</option>
                            <?php foreach($dosen as $ds){ ?>
                            <option value="<?= $ds->id ?>"><?= $ds->nama_lengkap ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-12 table-responsive py-3">
                        <table class="table table-sm table-bordered w-100" id="table_mhs">
                            <thead>
                                <tr class="table-dark">
                                    <th colspan="3">List Mahasiswa</th>
                                    <th class="text-center">
                                        <button class="btn btn-sm btn-success" type="button" onclick="add_list_mhs()"><i
                                                class="fa fa-plus"></i></button>
                                    </th>
                                </tr>
                                <tr class="table-secondary">
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th class="text-center" width="10%"><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>


                    <div class="col-12 table-responsive py-3">
                        <table class="table table-sm table-bordered w-100" id="table_pemlap">
                            <thead>
                                <tr class="table-dark">
                                    <th colspan="4">List Pembimbing Lapang</th>
                                    <th class="text-center"><button class="btn btn-sm btn-success" type="button"
                                            onclick="add_list_pemlap()"><i class="fa fa-plus"></i></button></th>
                                </tr>
                                <tr class="table-secondary">
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Instansi</th>
                                    <th>Alamat Instansi</th>
                                    <th class="text-center" width="10%"><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal" id="modalMHS" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-light">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah List Mahasiswa</h1>
                <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered table-sm w-100" id="table_list_mahasiswa">
                    <thead>
                        <tr class="table-secondary">
                            <th class="text-center" width="10%">#</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th class="text-center" width="10%"><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal" id="modalPemlap" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-fullscreen-lg-down modal-dialog-scrollable">
        <div class="modal-content table-responsive">
            <div class="modal-header bg-primary text-light">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Pembimbing Lapangan</h1>
                <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm" id="table_list_pemlap">
                    <thead>
                        <tr class="table-secondary">
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Instansi</th>
                            <th>Alamat Instansi</th>
                            <th><i class="fa fa-cogs"></i></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<div class="modal" id="modalDetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-light">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Data</h1>
                <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-4 my-2">
                        <label><b>Nama Group</b></label>
                        <p id="group_name"></p>
                    </div>
                    <div class="col-sm-12 col-md-4 my-2">
                        <label><b>Dosen Pembimbing</b></label>
                        <p id="dospem_name"></p>
                    </div>
                    <div class="col-sm-12 col-md-4 my-2">
                        <label><b>Periode</b></label>
                        <p id="periode_name"></p>
                    </div>

                    <div class="col-12 my-2 table-responsive">
                        <table class="table table-sm table-bordered w-100" id="table_mahasiswa">
                            <thead>
                                <tr class="table-dark">
                                    <th colspan="3">List Mahasiswa</th>
                                </tr>
                                <tr class="table-secondary">
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <div class="col-12 my-2 table-responsive">
                        <table class="table table-sm table-bordered w-100" id="table_detail_pemlap">
                            <thead>
                                <tr class="table-dark">
                                    <th colspan="4">List Pembimbing Lapangan</th>
                                </tr>
                                <tr class="table-secondary">
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Instansi</th>
                                    <th>Alamat Instansi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>