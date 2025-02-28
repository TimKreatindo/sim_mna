<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Logbook MNA | <?= $title ?></title>
	<!--begin::Primary Meta Tags-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="title" content="AdminLTE | Dashboard v3" />
	<meta name="author" content="ColorlibHQ" />
	<meta name="description" content="Website Sistem Informasi Manajemen Logbook Magang Program Studi Manajemen Agribisnis" />
	<meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard" />

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" />

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css" integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />

	<link rel="stylesheet" href="<?= base_url('assets/dist/') ?>css/adminlte.css" />
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url('assets') ?>/plugins/fontawesome-free/css/all.min.css">

	<!-- jQuery -->
	<script src="<?= base_url('assets') ?>/plugins/jquery/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
	<script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap4.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
	<script src="<?= base_url('assets/plugins/yearpicker/dist/yearpicker.js') ?>"></script>

	<script src="<?= base_url('assets/tinymce/tinymce.min.js') ?>"></script>

	<link rel="stylesheet" href="<?= base_url('assets') ?>/ckeditor/ckeditor5.css">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
	<div id="base_url" data-val="<?= base_url() ?>"></div>
	<!--begin::App Wrapper-->
	<div class="app-wrapper">
		<!--begin::Header-->
		<nav class="app-header navbar navbar-expand bg-body">
			<!--begin::Container-->
			<div class="container-fluid">
				<!--begin::Start Navbar Links-->
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
							<i class="bi bi-list"></i>
						</a>
					</li>

				</ul>
				<!--end::Start Navbar Links-->
				<!--begin::End Navbar Links-->
				<ul class="navbar-nav ms-auto">
					<div class="dropdown-divider"></div>



					<li class="nav-item dropdown user-menu">
						<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
							<img src="<?= base_url('assets/') ?>dist/assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow" alt="User Image" />
							<span class="d-none d-md-inline"><?= $user->nama_lengkap ?></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
							<!--begin::User Image-->
							<li class="user-header text-bg-primary">
								<img src="<?= base_url('assets/') ?>dist/assets/img/user2-160x160.jpg" class="rounded-circle shadow" alt="User Image" />
								<p>
									<?= $user->email ?>
									<small><?= $user->nama_role ?></small>
								</p>
							</li>
							<!--end::User Image-->
							<!--begin::Menu Body-->
							<li class="user-body">
								<!--begin::Row-->
								<div class="row">
									<div class="col-4 text-center"><a href="#">Profile</a></div>
									<div class="col-4 text-center"></div>
									<div class="col-4 text-center"><a href="<?= base_url('auth/logout') ?>">Logout</a></div>
								</div>
								<!--end::Row-->
							</li>
							<!--end::Menu Body-->
							<!--begin::Menu Footer-->

							<!--end::Menu Footer-->
						</ul>
					</li>
					<!--end::User Menu Dropdown-->
				</ul>
				<!--end::End Navbar Links-->
			</div>
			<!--end::Container-->
		</nav>
		<!--end::Header-->
		<!--begin::Sidebar-->
		<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
			<!--begin::Sidebar Brand-->
			<div class="sidebar-brand">
				<!--begin::Brand Link-->
				<a href="./index.html" class="brand-link">
					<!--begin::Brand Image-->
					<img src="<?= base_url('assets/') ?>img/Logo_Polije.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
					<!--end::Brand Image-->
					<!--begin::Brand Text-->
					<span class="brand-text fw-light">Logbook MNA</span>
					<!--end::Brand Text-->
				</a>
				<!--end::Brand Link-->
			</div>
			<!--end::Sidebar Brand-->
			<!--begin::Sidebar Wrapper-->
			<div class="sidebar-wrapper">
				<nav class="mt-2">
					<!--begin::Sidebar Menu-->
					<ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

						<?php
						$menu = $this->model->get_data_menu()->result();
						foreach ($menu as $m) {
							if ($m->type == 1) {
								echo    '<li class="nav-item">
                                            <a href="' . base_url() . $m->url . '" class="nav-link">
                                                ' . $m->icon . '
                                                <p>
                                                    ' . $m->label . '
                                                </p>
                                            </a>
                                        </li>';
							} else if ($m->type == 2) {

								$submenu = $this->model->get_data_menu($m->id)->result();
								$html = '';
								foreach ($submenu as $sm) {
									$html .= '  <li class="nav-item">
                                                    <a href="' . base_url($sm->url) . '" class="nav-link">
                                                        ' . $sm->icon . '
                                                        <p>' . $sm->label . '</p>
                                                    </a>
                                                </li>';
								}

								echo    '<li class="nav-item">
                                            <a href="#" class="nav-link">
                                                ' . $m->icon . '
                                                <p>
                                                    ' . $m->label . '
                                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                                </p>
                                            </a>
                                            <ul class="nav nav-treeview">
                                                ' . $html . '
                                            </ul>
                                        </li>';
							}
						}
						?>
						<li class="nav-item">
							<a href="<?= base_url('auth/logout') ?>" class="nav-link">
								<i class="nav-icon fas fa-sign-out-alt"></i>
								<p>
									Logout
								</p>
							</a>
						</li>
					</ul>
					<!--end::Sidebar Menu-->
				</nav>
			</div>
			<!--end::Sidebar Wrapper-->
		</aside>
		<!--end::Sidebar-->
		<!--begin::App Main-->
		<main class="app-main">
			<!--begin::App Content Header-->
			<div class="app-content-header">
				<!--begin::Container-->
				<div class="container-fluid">
					<!--begin::Row-->
					<div class="row">
						<div class="col-sm-6">
							<h3 class="mb-0"><?= $title ?></h3>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-end">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
							</ol>
						</div>
					</div>
					<!--end::Row-->
				</div>
				<!--end::Container-->
			</div>
			<div class="app-content">
				<?php $this->load->view($view); ?>

			</div>
			<!--end::App Content-->
		</main>
		<!--end::App Main-->
		<!--begin::Footer-->
		<footer class="app-footer">
			<!--begin::To the end-->
			<div class="float-end d-none d-sm-inline">Logbook MNA</div>
			<!--end::To the end-->
			<!--begin::Copyright-->
			<strong>
				Copyright &copy; <?= date('Y') ?>&nbsp;
				<a href="https://adminlte.io" class="text-decoration-none">Manajemen Agribisnis</a>.
			</strong>
			All rights reserved.
			<!--end::Copyright-->
		</footer>
		<!--end::Footer-->

		<script>
			const base_url = $("#base_url").data("val");
			let editor1;
			let editor2;
		</script>

		<?php

		if (isset($js_module)) {
			echo '<script src="' . base_url('assets/js/') . $js_module . '" type="module"></script>';
		}

		if (isset($js)) {
			foreach ($js as $j) {
				echo '<script src="' . base_url('assets/js/' . $j . '.js') . '"></script>';
			}
		}
		?>
	</div>
	<!--end::App Wrapper-->
	<!--begin::Script-->
	<!--begin::Third Party Plugin(OverlayScrollbars)-->
	<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ=" crossorigin="anonymous"></script>
	<!--end::Third Party Plugin(OverlayScrollbars)-->
	<!--begin::Required Plugin(popperjs for Bootstrap 5)-->
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
	<!--end::Required Plugin(popperjs for Bootstrap 5)-->
	<!--begin::Required Plugin(Bootstrap 5)-->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
	<!--end::Required Plugin(Bootstrap 5)-->
	<!--begin::Required Plugin(AdminLTE)-->
	<script src="<?= base_url('assets/dist/') ?>js/adminlte.js"></script>
	<!--end::Required Plugin(AdminLTE)-->
	<!--begin::OverlayScrollbars Configure-->
	<script>
		const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
		const Default = {
			scrollbarTheme: 'os-theme-light',
			scrollbarAutoHide: 'leave',
			scrollbarClickScroll: true,
		};
		document.addEventListener('DOMContentLoaded', function() {
			const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
			if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
				OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
					scrollbars: {
						theme: Default.scrollbarTheme,
						autoHide: Default.scrollbarAutoHide,
						clickScroll: Default.scrollbarClickScroll,
					},
				});
			}
		});
	</script>
	<!--end::OverlayScrollbars Configure-->


	<script>
		// cookie
		$(function() {
			$('[data-toggle="tooltip"]').tooltip()
		})


		function createCookie(name, value, days) {
			var expires;
			if (days) {
				var date = new Date();
				date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
				expires = "; expires=" + date.toGMTString();
			} else {
				expires = "";
			}
			document.cookie = name + "=" + value + expires + "; path=/";
		}

		function readCookie(name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for (var i = 0; i < ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) === ' ') {
					c = c.substring(1, c.length);
				}
				if (c.indexOf(nameEQ) === 0) {
					return c.substring(nameEQ.length, c.length);
				}
			}
			return null;
		}

		function eraseCookie(name) {
			createCookie(name, "", -1);
		}

		function loading_animation() {
			Swal.fire({
				title: 'Loading..',
				html: 'Please wait..',
				timerProgressBar: true,
				draggable: true,
				allowOutsideClick: false,
				didOpen: () => {
					Swal.showLoading()
				},
			})
		}

		function error_alert(msg) {
			Swal.fire({
				icon: "error",
				title: "Error",
				text: msg,
			});
		}
	</script>

	<!--end::Script-->
</body>
<!--end::Body-->

</html>