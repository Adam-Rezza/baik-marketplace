<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('merchant/layouts/_head') ?>

<body>
	<?php $this->load->view('merchant/layouts/_header') ?>

	<div class="wrappage">

		<!-- Content Category -->
		<div class="relative container-web">
			<div class="container">
				<div class="row ">
					<!-- Sider Bar -->
					<div class="col-md-3 relative top-padding-default" id="slide-bar-category">
						<div class="col-md-12 col-sm-12 col-xs-12 sider-bar-category border bottom-margin-default">
							<img class="img img-responsive merchant-header" src="<?= base_url() ?>public/img/profil_merchant/merchant.png" alt="">
							<ul class="clear-margin list-siderbar">
								<li><a href="<?= base_url() ?>my_profile">Produk saya</a></li>
								<li><a href="<?= base_url() ?>my_product">Produk saya</a></li>
								<li><a href="<?= base_url() ?>order/1">Pesanan masuk</a></li>
								<li><a href="<?= base_url() ?>order/2">Pesanan perlu dikirim</a></li>
								<li><a href="<?= base_url() ?>order/3">Pesanan dikirim</a></li>
								<li><a href="<?= base_url() ?>order/9">Pesanan selesai</a></li>
							</ul>
						</div>
					</div>
					<!-- End Sider Bar -->

					<?php $this->load->view('merchant/' . $content) ?>

				</div>
			</div>
		</div>

	</div>

	<?php $this->load->view('merchant/layouts/_footer') ?>

	<!-- <script src="<?= base_url() ?>public/megastore/js/jquery-2.2.4.min.js" defer=""></script>
    <script src="<?= base_url() ?>public/megastore/js/jquery-3.3.1.min.js" defer=""></script> -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/gridstack@2.0.0/dist/gridstack.all.js"></script>
	<script src="<?= base_url() ?>public/megastore/js/bootstrap.min.js" defer=""></script>
	<script src="<?= base_url() ?>public/megastore/js/jquery.validate.min.js" defer=""></script>
	<script src="<?= base_url() ?>public/megastore/js/multirange.js" defer=""></script>
	<script src="<?= base_url() ?>public/megastore/js/owl.carousel.min.js" defer=""></script>
	<!-- <script src="<?= base_url() ?>public/megastore/js/sync_owl_carousel.js" defer=""></script> -->
	<script src="<?= base_url() ?>public/megastore/js/scripts.js?123" defer=""></script>
	<script src="<?= base_url() ?>public/megastore/js/slick.min.js" defer=""></script>
	<script src="<?= base_url() ?>public/megastore/js/sweetalert2@9" defer=""></script>
	<script src="<?= base_url() ?>public/js/jquery.blockUI.min.js" defer=""></script>
</body>

<?php $this->load->view('merchant/' . $vitamin) ?>
<script>
	$(document).ready(function() {})
</script>

</html>