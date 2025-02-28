<!--begin::Container-->
<div class="container-fluid">
    <!--begin::Row-->
    <div class="row">

        <?php foreach ($pengumuman as $p) : ?>
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="callout callout-info">
                        <h4 class="alert-heading"><?= $p->judul ?></h4>
                        <p><?= $p->isi ?></p>
                        <hr>
                        <p class="mb-0"><?= tgl_indo($p->created_at) ?></p>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
    <!--end::Row-->
</div>
<!--end::Container-->