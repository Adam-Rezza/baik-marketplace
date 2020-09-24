<!-- Content Category -->
<div class="relative container-web" style="min-height: 600px;">
	<div class="container">
		<div class="row ">
			<!-- Sider Bar -->
			<div class="col-md-3 relative top-padding-default top-margin-default" id="slide-bar-category">
				<div class="col-md-12 col-sm-12 col-xs-12 sider-bar-category border bottom-margin-default">
					<ul class="clear-margin list-siderbar">
						<li><a href="<?=base_url()?>my_account">Akun saya</a></li>
						<li><a href="<?=base_url()?>my_order">Pesanan saya</a></li>
						<li><a href="<?=base_url()?>my_recent_order">Pesanan selesai</a></li>
					</ul>
				</div>
			</div><!-- Content Category -->
			<div class="col-md-9 relative clear-padding top-padding-default left-padding-default">
				<div class="col-sm-12 col-xs-12 relative overfollow-hidden clear-padding button-show-sidebar">
					<p onclick="showSideBar()"><span class="ti-filter"></span> Sidebar</p>
				</div>
				<div class="bar-category bottom-margin-default border no-border-r no-border-l no-border-t">
					<div class="row">
						<div class="col-md-5 col-sm-5 col-xs-4">
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
							<div class="col-md-12 clear-padding border no-border-t no-border-l no-border-r product-category bottom-margin-default product-category-list relative">
								<div class="relative overfollow-hidden info-product-list right-padding-default">
									<?php foreach ($order[$f->id] as $g) { ?>
										<div style="clear: both">
											<p class="float-left"><?= $g->produk ?></p>
											<p class="float-right">(x<?= $g->qty ?>)</p>
										</div>
									<?php
										$total_price += $g->harga * $g->qty;
									}
									?>
								</div>
								<div class="relative overfollow-hidden info-product-list left-margin-default">
									Total:
									<p class="clearfix price-product">
										Rp <?= number_format($total_price, 0, ",", ".") ?>
									</p>
									<p class="intro-product-category"><?= $f->alamat ?></p>
									<div class="relative button-product-list clearfix">
										<ul class="clear-margin">
											<?php if ($f->status == 1) { ?>
												<li class=""><a href="#" class="animate-default process-order btn-bg-grey" data-id="<?= $f->id ?>">Sedang diproses</a></li>
											<?php } else if ($f->status == 2) { ?>
												<li class=""><a href="#" class="animate-default send-order btn-bg-grey" data-id="<?= $f->id ?>">Sedang dikirim</a></li>
											<?php } else if ($f->status == 3) { ?>
												<li class=""><a href="#" class="animate-default delivered-order" data-id="<?= $f->id ?>" disabled>Terima pesanan</a></li>
											<?php } else if ($f->status == 9) { ?>
												<li class=""><a href="#" class="animate-default complete-order btn-bg-grey" data-id="<?= $f->id ?>" disabled>Selesai</a></li>
											<?php } ?>
										</ul>
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