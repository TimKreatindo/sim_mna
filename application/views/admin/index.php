<!--begin::Container-->
<div class="container-fluid">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
                <span class="info-box-icon text-bg-primary shadow-sm">
                    <i class="fas fa-users"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Mahasiswa</span>
                    <span class="info-box-number">
                        <?= $total_mahasiswa ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
                <span class="info-box-icon text-bg-success shadow-sm">
                    <i class="fas fa-user-tie"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">Dosen</span>
                    <span class="info-box-number"> <?= $total_dosen ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
                <span class="info-box-icon text-bg-warning shadow-sm">
                    <i class="fas fa-chalkboard-teacher"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text">DPL</span>
                    <span class="info-box-number"><?= $total_pemlap ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!--begin::Row-->
    <div class="row">
        <!-- Start col -->
        <div class="col-md-6">
            <!--begin::Latest Order Widget-->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Logbook Pembimbing Lapang</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Item</th>
                                    <th>Status</th>
                                    <th>Popularity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a>
                                    </td>
                                    <td>Call of Duty IV</td>
                                    <td><span class="badge text-bg-success"> Shipped </span></td>
                                    <td>
                                        <div id="table-sparkline-1"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a>
                                    </td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="badge text-bg-warning">Pending</span></td>
                                    <td>
                                        <div id="table-sparkline-2"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                    </td>
                                    <td>iPhone 6 Plus</td>
                                    <td><span class="badge text-bg-danger"> Delivered </span></td>
                                    <td>
                                        <div id="table-sparkline-3"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                    </td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="badge text-bg-info">Processing</span></td>
                                    <td>
                                        <div id="table-sparkline-4"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a>
                                    </td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="badge text-bg-warning">Pending</span></td>
                                    <td>
                                        <div id="table-sparkline-5"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                    </td>
                                    <td>iPhone 6 Plus</td>
                                    <td><span class="badge text-bg-danger"> Delivered </span></td>
                                    <td>
                                        <div id="table-sparkline-6"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a>
                                    </td>
                                    <td>Call of Duty IV</td>
                                    <td><span class="badge text-bg-success">Shipped</span></td>
                                    <td>
                                        <div id="table-sparkline-7"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-primary float-start">
                        Place New Order
                    </a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-end">
                        View All Orders
                    </a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-6">
            <!--begin::Latest Order Widget-->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Logbook Mahasiswa</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                            <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                            <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Item</th>
                                    <th>Status</th>
                                    <th>Popularity</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a>
                                    </td>
                                    <td>Call of Duty IV</td>
                                    <td><span class="badge text-bg-success"> Shipped </span></td>
                                    <td>
                                        <div id="table-sparkline-1"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a>
                                    </td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="badge text-bg-warning">Pending</span></td>
                                    <td>
                                        <div id="table-sparkline-2"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                    </td>
                                    <td>iPhone 6 Plus</td>
                                    <td><span class="badge text-bg-danger"> Delivered </span></td>
                                    <td>
                                        <div id="table-sparkline-3"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                    </td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="badge text-bg-info">Processing</span></td>
                                    <td>
                                        <div id="table-sparkline-4"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR1848</a>
                                    </td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="badge text-bg-warning">Pending</span></td>
                                    <td>
                                        <div id="table-sparkline-5"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR7429</a>
                                    </td>
                                    <td>iPhone 6 Plus</td>
                                    <td><span class="badge text-bg-danger"> Delivered </span></td>
                                    <td>
                                        <div id="table-sparkline-6"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="pages/examples/invoice.html" class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">OR9842</a>
                                    </td>
                                    <td>Call of Duty IV</td>
                                    <td><span class="badge text-bg-success">Shipped</span></td>
                                    <td>
                                        <div id="table-sparkline-7"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    <a href="javascript:void(0)" class="btn btn-sm btn-primary float-start">
                        Place New Order
                    </a>
                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-end">
                        View All Orders
                    </a>
                </div>
                <!-- /.card-footer -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!--end::Row-->


</div>