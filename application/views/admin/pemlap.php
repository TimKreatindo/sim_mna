<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <table class="table table-bordered table-sm" id="main_table">
                        <thead>
                            <tr class="table-dark">
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Instansi</th>
                                <th>Alamat Instansi</th>
                                <th>Status</th>
                                <th><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach($data as $d){ ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= $d->nama_lengkap ?></td>
                                <td><?= $d->email ?></td>
                                <td><?= $d->instansi_magang ?></td>
                                <td><?= $d->alamat_magang ?></td>
                                <td>
                                    <?php
                                        switch($d->is_active){
                                            case '1':
                                                echo 'Aktif';
                                                break;
                                            case '0':
                                                echo 'Nonaktif';
                                                break;
                                            default:
                                                echo 'Unknow';
                                            break;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" onclick="delete_data('<?= md5($d->id) ?>')"
                                                    href="#!">Hapus</a></li>
                                            <?php if($d->is_active == 1){ ?>
                                            <li><a class="dropdown-item" href="#!"
                                                    onclick="status_account('<?= md5($d->id) ?>', '0')">Nonaktif</a>
                                            </li>
                                            <?php } else { ?>
                                            <li><a class="dropdown-item" href="#!"
                                                    onclick="status_account('<?= md5($d->id) ?>', '1')">Aktifkan</a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
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