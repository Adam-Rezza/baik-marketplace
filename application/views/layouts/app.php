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
			<!-- BREADCRUB -->

			<!-- Main content -->
			<section class="content container-fluid">
				<?php $this->load->view('pages/' . $content); ?>
			</section>
		</div>

		<!-- Footer -->
		<?php $this->load->view('layouts/_footer'); ?>

	</div>

	<!-- REQUIRED JS SCRIPTS -->
	<script src="<?= base_url(); ?>vendor/almasaeed2010/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
	<script src="<?= base_url(); ?>vendor/almasaeed2010/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="<?= base_url(); ?>vendor/almasaeed2010/adminlte/dist/js/adminlte.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70.0-2014.11.23/jquery.blockUI.min.js" integrity="sha512-Z84iqqN8wVpPeBsDTKA6zWs3nguaCk7bvDD+KNLbDFNmWVLHsRDJd0Xr/wKrl95o7mSvN8YF69hXuZVzMGzgGw==" crossorigin="anonymous"></script>

	<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->

	<?php $this->load->view('pages/' . $vitamin); ?>
</body>

</html>
