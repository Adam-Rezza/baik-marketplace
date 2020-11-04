<!-- Content Category -->
<div class="relative container-web" style="min-height: 600px;">
	<div class="container">
		<div class="row ">
			<!-- Sider Bar -->
			<div class="col-md-3 relative top-padding-default top-margin-default" id="slide-bar-category">
				<div class="col-md-12 col-sm-12 col-xs-12 sider-bar-category border bottom-margin-default">
					<img class="img img-responsive merchant-header" src="<?= base_url() ?>public/img/profile/<?= $user->gambar ? $user->gambar : "user.png" ?>" alt="">
					<div class="text-center top-margin-15-default">
						<button id="btn-profil-foto">Upload foto</button>
						<input type="file" id="profil-foto" accept="image/*" class="hidden">
					</div>
					<ul class="clear-margin list-siderbar top-margin-15-default">
						<li><a href="<?= base_url() ?>my_account">Akun saya</a></li>
						<li><a href="<?= base_url() ?>my_order">Pesanan saya</a></li>
						<li><a href="<?= base_url() ?>my_recent_order">Pesanan selesai</a></li>
					</ul>
					<div class="text-center top-margin-15-default">
						<a class="btn-daftar-toko" href="<?= base_url() ?>">Lanjut Belanja</a>
					</div>
				</div>
			</div><!-- Content Category -->
			<div class="col-md-9 col-sm-12 relative clear-padding top-padding-default left-padding-default">
				<div class="col-sm-12 col-xs-12 relative overfollow-hidden clear-padding button-show-sidebar">
					<p onclick="showSideBar()"><span class="ti-filter"></span> Menu</p>
				</div>
				<div class="bar-category bottom-margin-default border no-border-r no-border-l no-border-t">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<p class="title-category-page clear-margin">Pesanan Saya</p>
						</div>
					</div>
				</div>
				<!-- Product Content Category -->
				<div class="relative clearfix">
					<?php
					if (count($transaction) > 0) {
					?>
						<?php
						foreach ($transaction as $f) {
							$total_price = 0;
						?>
							<div class="col-md-12 col-sm-12 clear-padding border no-border-t no-border-l no-border-r product-category bottom-margin-default product-category-list relative">
								<div class="col-md-6 col-sm-12 relative">
									<div class="relative overfollow-hidden">
										<div style="clear: both">
											<p class="float-left">No Pesanan: <?= $f->invoice ?></p>
										</div>
										<div style="clear: both">
											<p class="float-left">Penjual : <b><?= $f->toko ?></b></p>
										</div>
										<div class="top-padding-15-default" style="clear: both">
											<p class="float-left">Pesanan :</p>
											<?php foreach ($order[$f->id] as $g) { ?>
												<div class="left-padding-15-default" style="clear: both">
													<p class="float-left"><b><a href="<?= base_url() ?>product/<?= $f->produk_id ?>"><?= $g->produk ?></a></b> (x<?= $g->qty ?>)</p>
													<p class="float-right">Rp <?= number_format(($g->harga * $g->qty), 0, ",", ".") ?></p>
												</div>
												<?php if($varians_order[$g->cart_id]){ ?>
													<div class="left-padding-15-default" style="clear: both">
														<p class="float-left">(<?= join(', ', $varians_order[$g->cart_id]) ?>)</p>
													</div>
												<?php } ?>
											<?php
												$total_price += $g->harga * $g->qty;
											}
											?>
										</div>
										<div class="top-padding-15-default" style="clear: both">
											<p>Status :</p>
											<?php if ($f->created_date) { ?>
												<p class="left-padding-15-default margin-bottom-none">
													<?= date('d-m-Y H:i', strtotime($f->created_date)) ?> =>
													Pesanan di teruskan ke <b><?= $f->toko ?></b>
												</p>
											<?php  } ?>
											<?php if ($f->proccess_date) { ?>
												<p class="left-padding-15-default margin-bottom-none">
													<?= date('d-m-Y H:i', strtotime($f->proccess_date)) ?> =>
													Pesanan diproses oleh <b><?= $f->toko ?></b>
												</p>
											<?php  } ?>
											<?php if ($f->shipment_date) { ?>
												<p class="left-padding-15-default margin-bottom-none">
													<?= date('d-m-Y H:i', strtotime($f->shipment_date)) ?> =>
													Pesanan dikirim oleh <b><?= $f->toko ?></b>
												</p>
											<?php  } ?>
											<?php if ($f->delivery_date) { ?>
												<p class="left-padding-15-default margin-bottom-none">
													<?= date('d-m-Y H:i', strtotime($f->delivery_date)) ?> =>
													Pesanan diterima
												</p>
											<?php  } ?>
											<?php if ($f->failed_date) { ?>
												<p class="left-padding-15-default margin-bottom-none">
													<?= date('d-m-Y H:i', strtotime($f->failed_date)) ?> =>
													Pesanan dibatalkan oleh <b><?= $f->toko ?></b>
												</p>
												<p class="left-padding-15-default margin-bottom-none">
													Alasan :
													<b><?= $f->failed_reason ?></b>
												</p>
											<?php  } ?>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-12 relative">
									<div class="relative overfollow-hidden">
										Total:
										<p class="clearfix price-product">
											Rp <?= number_format($total_price, 0, ",", ".") ?>
										</p>
										<p class="intro-product-category"><?= $f->alamat ?></p>
										<div class="top-margin-15-default">
											Kurir :
											<b class="kurir"><?= strtoupper($f->id_ekspedisi) ?></b>
										</div>
										<?php if ($f->resi) { ?>
											<div class="resi-container">
												Resi :
												<b class="resi"><?= strtoupper($f->resi) ?></b>
											</div>
										<?php } ?>
										<div class="relative button-product-list clearfix">
											<ul class="clear-margin">
												<?php if ($f->status == 1) { ?>
													<li class=""><a href="#" class="animate-default process-order btn-bg-grey top-margin-15-default" data-id="<?= $f->id ?>">Sedang diproses</a></li>
												<?php } else if ($f->status == 2) { ?>
													<li class=""><a href="#" class="animate-default send-order btn-bg-grey top-margin-15-default" data-id="<?= $f->id ?>">Sedang dikirim</a></li>
												<?php } else if ($f->status == 3) { ?>
													<li class=""><a href="#" class="animate-default delivered-order top-margin-15-default" data-id="<?= $f->id ?>" disabled>Terima pesanan</a></li>
													<li class=""><a href="#" class="animate-default complain-order top-margin-15-default" data-id="<?= $f->id ?>" disabled>Komplain</a></li>
												<?php } else if ($f->status == 9) { ?>
													<?php if ($review_qualified[$f->id]) { ?>
														<li class=""><a href="#" class="animate-default review-order top-margin-15-default" data-id="<?= $f->id ?>" disabled>Review</a></li>
													<?php } else { ?>
														<li class=""><a href="#" class="animate-default complete-order btn-bg-grey  top-margin-15-default" data-id="<?= $f->id ?>" disabled>Selesai</a></li>
													<?php } ?>
												<?php } ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					<?php } else { ?>
						<div class="col-md-12 clear-padding product-category left-margin-default product-category-list relative" style="color: grey">
							<h3>Tidak ada data</h3>
						</div>
					<?php } ?>
				</div>
				<!-- End Product Content Category -->
			</div>
		</div>
	</div>
</div>