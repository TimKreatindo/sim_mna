<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <?php if($access > 0){ ?>
                    <a href="<?= base_url('mhs/new-logbook') ?>" class="btn btn-sm btn-success mb-3"><i
                            class="fa fa-plus"></i></a>
                    <?php } ?>
                    <table class="table table-bordered table-sm w-100" id="my-table">
                        <thead>
                            <tr class="table-dark">
                                <th>#</th>
                                <th>Tgl Kegiatan</th>
                                <th>Mengikuti Kegiatan</th>
                                <th>Jenis Kegiatan</th>
                                <th>Status</th>
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
<div class="modal" id="modalLog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-light">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Log</h1>
                <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table class="table table-bordered table-sm w-100">
                    <thead>
                        <tr class="table-secondary">
                            <th>Tanggal</th>
                            <th>Keterangan</th>
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