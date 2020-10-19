<!-- Content Category -->
<div class="relative container-web bottom-margin-default">
	<div class="container">
		<div class="row ">
			<?php if ($toko) { ?>
				<!-- Sider Bar -->
				<div class="col-md-3 relative top-padding-default top-margin-default" id="slide-bar-category">
					<div class="col-md-12 col-sm-12 col-xs-12 sider-bar-category border bottom-margin-default">
						<img class="img img-responsive merchant-header" src="<?= base_url() ?>public/img/profile_toko/<?= $toko->gambar ? $toko->gambar : "merchant.png" ?>" alt="">
						<div class="row top-margin-15-default">
							<div class="col-sm-12 col-md-12">
								<table class="merchant-detail-table">
									<tr>
										<td scope="row">Nama Toko</td>
										<td scope="row">:</td>
										<td scope="row"></td>
									</tr>
									<tr>
										<td class="left-padding-15-default" colspan="3"><?= $toko->nama ?></td>
									</tr>
									<tr>
										<td scope="row">Telpon</td>
										<td scope="row">:</td>
										<td scope="row"></td>
									</tr>
									<tr>
										<td class="left-padding-15-default" colspan="3"><?= $toko->telp ?></td>
									</tr>
									<tr>
										<td scope="row">Deskripsi</td>
										<td scope="row">:</td>
										<td scope="row"></td>
									</tr>
									<tr>
										<td class="left-padding-15-default" colspan="3"><?= $toko->desc ?></td>
									</tr>
									<tr>
										<td scope="row">Alamat</td>
										<td scope="row">:</td>
										<td scope="row"></td>
									</tr>
									<tr>
										<td class="left-padding-15-default" colspan="3"><?= $toko->alamat . ', ' . $toko->kel . ', ' . $toko->kec . ', ' . $toko->kab . ', ' . $toko->prov ?></td>
									</tr>
								</table>
								<div class="col-sm-12 text-center top-margin-15-default hidden">
									<a class="btn-daftar-toko" href="<?= base_url('merchant_product/' . $toko->id) ?>">Lihat Produk Toko</a>
								</div>
							</div>
						</div>
						<div class="text-center top-margin-15-default">
							<a class="btn-daftar-toko" href="<?= base_url() ?>" style="font-size: 16px">Ke halaman utama</a>
						</div>
					</div>
				</div>
				<!-- End Sider Bar -->
				<div class="col-md-9 relative clear-padding top-padding-default">
					<div class="col-sm-12 col-xs-12 relative overfollow-hidden clear-padding button-show-sidebar">
						<p onclick="showSideBar()"><span class="ti-filter"></span> Menu</p>
					</div>
					<div class="bar-category bottom-margin-default border no-border-r no-border-l no-border-t">
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<p class="title-category-page clear-margin">Toko <b><?= $toko->nama ?></b></p>
							</div>
						</div>
					</div>
					<!-- Product Content Category -->
					<div class="relative">
						<!-- Content Product -->
						<div class="clearfix box-product full-width">
							<div class=" row">
								<?php if (count($product) > 0) { ?>
									<div class="clearfix content-product-box full-width">
										<?php foreach ($product as $f) { ?>
											<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 product-category padding-5 bg-gray">
												<div class="product-card relative effect-hover-boxshadow animate-default" data-id="<?= $f->id ?>">
													<div class="image-product relative overfollow-hidden">
														<a href="<?= base_url() ?>product/<?= $f->id ?>">
															<div class="center-vertical-image">
																<img src="<?= base_url(); ?>public/img/produk/<?= $f->gambar ?>" alt="Product">
															</div>
														</a>
													</div>
													<h3 class="title-product clearfix full-width title-hover-black">
														<a href="<?= base_url() ?>product/<?= $f->id ?>"><?= $f->nama ?></a>
														<?php if ($f->terjual > 0) { ?>
															<span class="product-sold float-right">(<?= $f->terjual ?> Terjual)</span>
														<?php } ?>
													</h3>
													<h3 class="title-merchant clearfix full-width title-hover-black">
														<i class="fa fa-user icon-merchant"></i>
														<a href="<?= base_url() ?>merchant_detail/<?= $f->toko_id ?>"><?= $f->toko ?></a>
													</h3>
													<p class="clearfix price-product">
														<span class="price-old">Rp <?= number_format($f->harga_asli, 0, ",", ".") ?></span>
														<span class="price-new">Rp <?= number_format($f->harga_disc, 0, ",", ".") ?></span>
													</p>
													<div class="clearfix ranking-product-category ranking-color">
														<?php
														$rate = $f->rating;
														for ($i = 0; $i < 5; $i++) {
															$star = ($rate - $i >= 1) ? "star" : ($rate - $i >= 0.5 ? "star-half" : "star-o");
															echo '<i class="fa fa-' . $star . '" aria-hidden="true"></i>';
														}
														?>
													</div>
												</div>
											</div>
										<?php } ?>
									</div>
									<div class="row">
										<div class="pagging relative">
											<ul>
												<?php for ($i = 1; $i <= $page_max; $i++) { ?>
													<?php if ($i == 1) { ?>
														<li><a href="#"><i class="fa fa-angle-left" aria-hidden="true"></i> First</a></li>
													<?php } ?>
													<?php if ($i == $page - 2) { ?>
														<li class="dots-pagging">. . .</li>
													<?php } else if ($i == $page - 1) { ?>
														<li><a href="#"><?= $i ?></a></li>
													<?php } else if ($i == $page) { ?>
														<li class="active-pagging"><a href="#"><?= $i ?></a></li>
													<?php } else if ($i == $page + 1) { ?>
														<li><a href="#"><?= $i ?></a></li>
													<?php } else if ($i == $page + 2) { ?>
														<li class="dots-pagging">. . .</li>
													<?php } ?>
													<?php if ($i == $page_max) { ?>
														<li><a href="#">Last <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
													<?php } ?>
												<?php } ?>
											</ul>
										</div>
									</div>
								<?php } else { ?>
									<div class="clearfix content-product-box full-width">
										<div class="col-sm-12 product-category padding-5 text-grey" style="min-height: 400px">
											<h2>Tidak ada produk di temukan</h2>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<!-- End Content Product -->


					</div>
					<!-- End Product Content Category -->
				</div>
			<?php } else { ?>
				<div class="col-sm-12 col-md-12 text-center" style="min-height: 350px; color:#b3b3b3">
					<h2>Toko tidak ditemukan</h2>
				</div>
			<?php } ?>
		</div>
	</div>
</div>