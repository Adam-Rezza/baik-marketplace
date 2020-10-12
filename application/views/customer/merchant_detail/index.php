<!-- Content Category -->
<div class="relative container-web bottom-margin-default">
	<div class="container">
		<div class="row ">
			<!-- Sider Bar -->
			<div class="col-md-3 relative top-padding-default top-margin-default" id="slide-bar-category">
				<div class="col-md-12 col-sm-12 col-xs-12 sider-bar-category border bottom-margin-default">
					<img class="img img-responsive merchant-header" src="<?= base_url() ?>public/img/profile_toko/<?= $toko->gambar ? $toko->gambar : "merchant.png" ?>" alt="">
					<div class="text-center top-margin-15-default">
						<a class="btn-daftar-toko" href="<?= base_url() ?>">Lanjut Belanja</a>
					</div>
				</div>
			</div>
			<!-- End Sider Bar -->
			<div class="col-md-6 relative clear-padding top-padding-default left-padding-default">
				<div class="col-sm-12 col-xs-12 relative overfollow-hidden clear-padding button-show-sidebar">
					<p onclick="showSideBar()"><span class="ti-filter"></span> Menu</p>
				</div>
				<div class="bar-category bottom-margin-default border no-border-r no-border-l no-border-t">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<p class="title-category-page clear-margin">Detail Toko <b><?= $toko->nama ?></b></p>
						</div>
					</div>
				</div>
				<!-- Product Content Category -->
				<div class="relative clearfix">
					<div class="content-tabs-auth-detail relative content-tab-auth-1 border active-tabs-auth-detail top-padding-15-default bottom-padding-15-default left-padding-default right-padding-default discussions">
						<div class="row">
							<div class="col-sm-12 col-md-12">
								<table class="merchant-detail-table">
									<tr>
										<td scope="row">Nama Toko</td>
										<td> : </td>
										<td><?= $toko->nama ?></td>
									</tr>
									<tr>
										<td scope="row">Telpon</td>
										<td> : </td>
										<td><?= $toko->telp ?></td>
									</tr>
									<tr>
										<td scope="row">Deskripsi</td>
										<td> : </td>
										<td><?= $toko->desc ?></td>
									</tr>
									<tr>
										<td scope="row">Alamat</td>
										<td> : </td>
										<td><?= $toko->alamat.', '.$toko->kel.', '.$toko->kec.', '.$toko->kab.', '.$toko->prov ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- End Product Content Category -->
			</div>
		</div>
	</div>
</div>