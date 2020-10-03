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
							<img class="img img-responsive merchant-header" src="<?= base_url() ?>public/img/profile_toko/<?= $merchant->gambar ? $merchant->gambar : "merchant.png" ?>" alt="">
							<div class="text-center top-margin-15-default">
								<button id="btn-profil-merchant-foto">Upload foto</button>
								<input type="file" id="profil-merchant-foto" class="hidden">
							</div>
							<ul class="clear-margin list-siderbar top-margin-15-default relative">
								<li><a href="<?= base_url() ?>my_profile">Informasi Toko </a></li>
								<li><a href="<?= base_url() ?>my_product">Produk saya </a></li>
								<li>
									<a href="<?= base_url() ?>order/1">
										Pesanan masuk
										<?php if ($order_1 > 0) { ?><span class="total-order"><?= $order_1 ?></span><?php } ?>
									</a>
								</li>
								<li>
									<a href="<?= base_url() ?>order/2">
										Pesanan perlu dikirim
										<?php if ($order_2 > 0) { ?><span class="total-order"><?= $order_2 ?></span><?php } ?>
									</a>
								</li>
								<li>
									<a href="<?= base_url() ?>order/3">
										Pesanan dikirim
										<?php if ($order_3 > 0) { ?><span class="total-order"><?= $order_3 ?></span><?php } ?>
									</a>
								</li>
								<li><a href="<?= base_url() ?>order/9">Pesanan selesai </a></li>
								<li><a href="<?= base_url() ?>order/10">Pesanan gagal </a></li>
							</ul>
							<div class="text-center top-margin-15-default">
								<a class="btn-daftar-toko" href="<?= base_url() ?>">Ke halaman utama</a>
							</div>
						</div>
					</div>
					<!-- End Sider Bar -->

					<?php $this->load->view('merchant/' . $content) ?>

				</div>
			</div>
		</div>

	</div>

    <div class="modal fade bs-example-modal-lg out" id="modalCropImageProfile" tabindex="-1" role="dialog" aria-hidden="true" style="display: none" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document" style="min-height: 229.25px; width: 830px!important">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="relative">
                        <button type="button" class="close-modal animate-default" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="ti-close"></span>
                        </button>
                        <div class="col-md-12 relative overfollow-hidden bottom-margin-15-default grid-stack-container">
                            <h3>Upload foto profil</h3>

                            <div class="img-container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <img id="imageProfileCrop" src="https://avatars0.githubusercontent.com/u/3456749">
                                    </div>
                                    <div class="full-width clearfix relative text-center">
                                        <button class="btn-daftar-toko full-width top-margin-15-default" id="cropImageProfile">Simpan</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
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
    <script src="<?= base_url() ?>public/js/select2.min.js"></script>
	<script src="<?= base_url() ?>public/megastore/js/sweetalert2@9" defer=""></script>
	<script src="<?= base_url() ?>public/js/jquery.blockUI.min.js" defer=""></script>
	<script src="<?= base_url() ?>public/js/jquery-ui-sortable.min.js" defer=""></script>
</body>

<?php $this->load->view('merchant/' . $vitamin) ?>
<script>
	$(document).ready(function() {
		//////////////////////////////////////////////////////////////////////
		$('#btn-profil-merchant-foto').click(function(e) {
			e.preventDefault()
			$('#profil-merchant-foto').click()
		})
		//////////////////////////////////////////////////////////////////////
		var $modal = $('#modalCropImageProfile')
		// var image = $('#imageProfileCrop')
		var image = document.getElementById('imageProfileCrop')
		var cropper

		$("body").on("change", "#profil-merchant-foto", function(e) {
			// console.log($('#crop').data())
			var files = e.target.files
			var done = function(url) {
				image.src = url
				$modal.modal('show')
			}
			var reader
			var file
			var url
			if (files && files.length > 0) {
				if ((files[0].type).search("image") > -1) {
					file = files[0]
					console.log(files[0])
					if (URL) {
						done(URL.createObjectURL(file))
					} else if (FileReader) {
						reader = new FileReader()
						reader.onload = function(e) {
							done(reader.result)
						}
						reader.readAsDataURL(file)
					}
				}
			}
		})

		$modal.on('shown.bs.modal', function() {
			cropper = new Cropper(image, {
				aspectRatio: 1,
				viewMode: 1,
				preview: '.preview'
			})
		}).on('hidden.bs.modal', function() {
			cropper.destroy()
			cropper = null
			$('#profil-foto').val('')
		})

		$("#cropImageProfile").click(function() {
			$.blockUI({
				message: '<img src="<?= base_url() ?>public/megastore/img/ajax-loader.gif" />',
				css: {
					backgroundColor: 'none',
					border: 'none',
				},
				baseZ: 1051
			})
			// console.log(produk_id, urutan)
			canvas = cropper.getCroppedCanvas({
				width: 600,
				height: 600,
			})
			canvas.toBlob(function(blob) {
				url = URL.createObjectURL(blob)
				var reader = new FileReader()
				reader.readAsDataURL(blob)
				reader.onloadend = function() {
					var base64data = reader.result
					$.ajax({
						type: "POST",
						dataType: "json",
						url: "<?= base_url() ?>upload_image_profile",
						data: {
							image: base64data,
							modul: 'toko'
						},
						success: function(res) {
							// console.log(data)
							if (res == "true") {
								$.unblockUI()
								$modal.modal('hide')
								Swal.fire({
									icon: 'success',
									title: 'Foto berhasil di upload',
									showConfirmButton: false,
									timer: 0,
									onBeforeOpen: () => {
										Swal.showLoading()
									},
								})
								setTimeout(() => {
									window.location.href = (window.location.href).replaceAll('#', '')
								}, 1000)
							}
						}
					})
				}
			})
		})
	})
</script>

</html>