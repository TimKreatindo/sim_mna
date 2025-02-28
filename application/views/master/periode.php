<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">

                    <button class="btn btn-sm btn-success mb-3" onclick="add_data()"><i class="fa fa-plus"></i></button>

                    <table class="table table-sm table-bordered w-100" id="main_table">
                        <thead>
                            <tr class="table-dark">
                                <th>#</th>
                                <th>Periode</th>
                                <th>Tgl Pembuatan</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($data as $d){ ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $d->periode ?></td>
                                <td><?php $c = date_create($d->create_at); echo date_format($c, 'd F Y'); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="delete_data('<?= md5($d->id) ?>')"><i
                                            class="fas fa-trash"></i></button>
                                    <button onclick="edit_data('<?= md5($d->id) ?>', '<?= $d->periode ?>')"
                                        class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('act_master_periode') ?>" method="post" id="form_periode">
                <input type="hidden" name="id" id="id_periode">
                <input type="hidden" name="act" id="act_periode">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Periode</label>
                        <input type="text" name="periode" id="periode" required class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>