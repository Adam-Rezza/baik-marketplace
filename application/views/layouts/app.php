<!DOCTYPE html>
<html>
<?php $this->load->view('layouts/_head'); ?>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition skin-yellow-light sidebar-collapse sidebar-mini">
	<div class="wrapper">

		<!-- Main Header -->
		<?php $this->load->view('layouts/_header'); ?>
		<!-- Left sidebar -->
		<?php $this->load->view('layouts/_sidebar'); ?>


		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">

			<!-- Main content -->
			<section class="content container-fluid">
				<?php $this->load->view('pages/' . $content); ?>
			</section>
		</div>

		<!-- Footer -->
		<?php $this->load->view('layouts/_footer'); ?>

	</div>

	<form action="#" id="form_change_password">
		<div id="modal_change_password" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title">Change Password</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="form-group">
								<label for="current_pass" class="col-sm-12">Current Password</label>
								<div class="col-md-12">
									<input type="password" id="current_pass" name="current_pass" class="form-control" required />
								</div>
							</div>
							<div class="form-group">
								<label for="current_pass" class="col-sm-12">New Password</label>
								<div class="col-md-12">
									<input type="password" id="new_pass" name="new_pass" class="form-control" required />
								</div>
							</div>
							<div class="form-group">
								<label for="verify_pass" class="col-sm-12">Verify Password</label>
								<div class="col-md-12">
									<input type="password" id="verify_pass" name="verify_pass" class="form-control" required />
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Change Password</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<!-- REQUIRED JS SCRIPTS -->
	<script src="<?= base_url(); ?>vendor/almasaeed2010/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="<?= base_url(); ?>vendor/almasaeed2010/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="<?= base_url(); ?>vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
	<script src="<?= base_url(); ?>public/js/jquery.blockUI.js"></script>
	<script src="<?= base_url(); ?>public/js/sweetalert2.all.min.js"></script>

	<script>
		$('#form_change_password').on('submit', function(e) {
			e.preventDefault();

			let current_pass = $('#current_pass').val();
			let new_pass = $('#new_pass').val();
			let verify_pass = $('#verify_pass').val();

			if (new_pass != verify_pass) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'New Password & Verify Password tidak sama, silahkan cek kembali',
				});
				return false;
			}

			$.ajax({
				url: `<?= site_url(); ?>change_password`,
				method: 'post',
				dataType: 'json',
				data: {
					current_pass: current_pass,
					new_pass: new_pass
				},
				beforeSend: function() {
					$.blockUI();
				}
			}).fail(function(res) {
				console.log(res);
				Swal.fire({
					icon: 'error',
					title: 'Error Fail',
					text: 'Terjadi kesalahan, silahkan hubungi Team IT',
				});
				$.unblockUI();
			}).done(function(res) {
				console.log(res);
				if (res.code == 404) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'User tidak ditemukan, proses logout dimulai',
					}).then(function(result) {
						if (result.isConfirmed) {
							window.location.replace(`<?= site_url(); ?>logout`);
						}
					});
				} else if (res.code == 500) {
					Swal.fire({
						icon: 'error',
						title: 'Error 500',
						text: 'Terjadi kesalahan, silahkan hubungi Team IT',
					});

					$.unblockUI();
					return false;
				} else if (res.code == 501) {
					Swal.fire({
						icon: 'error',
						title: 'Error 501',
						text: 'Current Password salah, silahkan coba kembali',
					});
					$('#current_password').focus();
					$.unblockUI();
					return false;
				} else if (res.code == 200) {
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: 'Proses Ganti Password Berhasil, harap ingat baik-baik password baru kamu!',
					}).then(function(result) {
						if (result.isConfirmed) {
							$('#modal_change_password').modal('hide');
							$.unblockUI();
						}
					});
				}
			});
		});
	</script>

	<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->

	<?php $this->load->view('pages/' . $vitamin); ?>
</body>

</html>