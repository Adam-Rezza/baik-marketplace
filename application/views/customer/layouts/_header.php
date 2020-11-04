<!-- push menu-->
<!-- end push menu-->
<!-- Menu Mobile -->
<div class="menu-mobile-left-content">
	<ul>
		<?php foreach ($category as $f) { ?>
			<li class="parentCategory">
				<!-- <a href="<?= base_url() ?>category"> -->
				<a href="<?= base_url() ?>category=<?= $f->id ?>%26page=1" data-id="<?= $f->id ?>">
					<?php if (count($sub_category[$f->id]) > 0) { ?>
						<i class="fa fa-caret-right" aria-hidden="true"></i>
					<?php } ?>
					<p><?= $f->nama ?></p>
				</a>
			</li>
			<?php foreach ($sub_category[$f->id] as $g) { ?>
				<li class="subCategory" data-id="<?= $f->id ?>">
					<!-- <a href="<?= base_url() ?>category"> -->
					<a href="<?= base_url() ?>category/<?= $f->id ?>/<?= $g->id ?>">
						<p><?= $g->nama ?></p>
					</a>
				</li>
			<?php } ?>
		<?php } ?>
	</ul>
</div>
<!-- Header Box -->
<header class="relative full-width">
	<div class=" container-web relative bottom-margin-default">
		<div class=" container">
			<div class="row">
				<div class=" header-top">
					<?php if (!($this->session->userdata(SESSUSER . 'id') === null)) { ?>
						<div class="menu-header-top text-right col-md-8 col-xs-12 col-sm-6 clear-padding">
							<ul class="clear-margin">
								<li class="relative"><span class='name'>Hi, <?= $this->session->userdata(SESSUSER . 'nama') ?></span></li>
								<li class="relative">
									<a href="<?= base_url() ?>my_account">
										Akun
									</a>
								</li>
								<li class="relative">
									<a href="<?= base_url() ?>merchant" id="userMerchant">
										Toko Saya
									</a>
								</li>
								<li class="relative">
									<a href="#" onclick="return false;">
										<b style="color:#ff8000;">
											Saldo Rp.<?= number_format($this->session->userdata(SESSUSER . 'saldo'), 0, ',', '.'); ?>
										</b>
									</a>
								</li>
								<li class="relative"><a href="<?= base_url() ?>user/logout">Keluar</a></li>
							</ul>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="row">
				<div class="clearfix header-content full-width relative">
					<div class="clearfix relative logo">
						<a href="<?= base_url() ?>"><img alt="Logo" src="<?= base_url(); ?>public\img\logo.jpg" /></a>
						<a class="btn-daftar-toko btn-logo" href="<?= base_url() ?>">Ke halaman utama</a>
					</div>
					<div class="search-box relative float-left top-margin-15-default">
						<form id="searchform" class="searchform" data-ajax="false">
							<div class="clearfix category-box relative">
								<select name="cate_search" id="cate_search">
									<option class="optGroup" value="">Semua Kategori</option>
									<?php foreach ($category as $f) {
										$selected = $search_category ? ($search_category->id == $f->id ? "selected" : "") : "";
									?>
										<option class="optGroup" data-id="<?= $f->id ?>" value="<?= $f->id ?>" data-type="1" <?= $selected ?>><?= $f->nama ?></option>
										<?php foreach ($sub_category[$f->id] as $g) {
											$selected_sub = $search_sub_category ? ($search_sub_category->id == $g->id ? "selected" : "") : "";
										?>
											<option class="optChild" data-id="<?= $f->id ?>" value="<?= $g->id ?>" data-type="2" <?= $selected_sub ?>>&nbsp;&nbsp;&nbsp;<?= $g->nama ?></option>
										<?php } ?>
									<?php } ?>
								</select>
							</div>
							<input type="text" name="keyword" id="keyword" placeholder="Enter keyword here . . ." value="<?= $keyword ?>" required>
							<button type="submit" class="animate-default button-hover-red">Search</button>
						</form>
					</div>
					<div class="clearfix icon-search-mobile absolute">
						<i onclick="showBoxSearchMobile()" class="data-icon data-icon-basic icon-basic-magnifier"></i>
					</div>
					<div class="cart-detail-header border" tabindex="0" onblur="showCartBoxDetail()">
						<div class="relative">

							<?php
							$total_qty_cart = 0;
							$total_price_cart = 0;
							foreach ($cart as $f) {
								$total_price_item = $f->harga * $f->qty;
								$total_qty_cart += $f->qty;
								$total_price_cart += $total_price_item;
							?>
								<div class="product-cart-son clearfix bottom-padding-15-default">
									<div class="image-product-cart float-left center-vertical-image ">
										<a href="#"><img src="<?= base_url() ?>public/img/produk/<?= $f->gambar ?>" alt="" /></a>
									</div>
									<div class="info-product-cart float-left">
										<p class="title-product title-hover-black"><a class="animate-default" href="#"><?= $f->produk ?></a></p>
										<?php if ($varians_cart[$f->id]) { ?>
											<p class="title-product title-hover-black" style="margin-top: 0px;">(<?= join(', ', $varians_cart[$f->id]) ?>)</p>
										<?php } ?>
										<p class="clearfix price-product" id="cart-web-total-price-item-<?= $f->id ?>">Rp <?= number_format($total_price_item, 0, ",", ".") ?> <span class="total-product-cart-son" id="cart-web-total-qty-item-<?= $f->id ?>">(x<?= $f->qty ?>)</span></p>
									</div>
								</div>
							<?php } ?>
						</div>
						<div class="relative border no-border-l no-border-r total-cart-header">
							<p class="bold clear-margin">Subtotal:</p>
							<p class=" clear-margin bold" id="cart-web-total-price">Rp <?= number_format($total_price_cart, 0, ",", ".") ?></p>
						</div>
						<div class="relative btn-cart-header text-right">
							<a href="#" class="uppercase bold animate-default hidden">view cart</a>
							<a href="<?= base_url() ?>checkout" class="uppercase bold button-hover-red animate-default float-right">checkout</a>
						</div>
					</div>
					<div class="cart-notification-header border" tabindex="0" onblur="showNotification()">
						<div class="relative">
							<?php $i = 1 ?>
							<?php foreach ($notification as $f) { ?>
								<div class="product-cart-son notification-son clearfix <?= $f->read ? '' : 'bg-red' ?>" id="notification-son-<?= $i ?>" data-view="<?$f->read?>" data-id="<?= $f->id ?>">
									<div class="info-product-cart float-left">
										<p style="margin-bottom: 0"><?= date('Y-m-d H:i', strtotime($f->datetime)) ?></p>
										<p class="notif-text title-hover-black">
											<a class="animate-default" href="<?= base_url($f->url) ?>"><?= $f->msg ?></a>
										</p>
									</div>
								</div>
								<?php $i++; ?>
							<?php } ?>
						</div>
						<div class="relative btn-cart-header text-right clearfix">
							<a href="#" class="uppercase bold button-hover-red animate-default float-left" id="notifPrev" onclick="return false">
								<<</a> <a href="#" class="uppercase bold button-hover-red animate-default float-left" id="notifCurrent" onclick="return false" disabled data-value='1'>1
							</a>
							<a href="#" class="uppercase bold button-hover-red animate-default float-right" id="notifNext" onclick="return false">>></a>
						</div>
					</div>
					<?php if (!($this->session->userdata(SESSUSER . 'id') === null)) { ?>
						<div class="clearfix bell-website absolute" onclick="showNotification()" id="showNotification">
							<span class="icon-web"><i class="fa fa-bell"></i></span>
							<p class="count-total-shopping absolute"><?= $unread_notification ?></p>
						</div>
						<div class="clearfix cart-website absolute" onclick="showCartBoxDetail()">
							<span class="icon-web"><i class="fa fa-shopping-cart"></i></span>
							<p class="count-total-shopping absolute" id="cart-web-total-qty"><?= $total_qty_cart ?></p>
						</div>
					<?php } else { ?>
						<div class="clearfix login-website absolute" id="userAccount">
							<span class="icon-web"><i class="fa fa-sign-in"></i></span>
						</div>
					<?php } ?>
					<div class="mask-search absolute clearfix" onclick="hiddenBoxSearchMobile()"></div>
					<div class="clearfix box-search-mobile">
					</div>
				</div>
			</div>
			<div class="row">
				<a class="menu-vertical hidden-md hidden-lg" onclick="showMenuMobie()">
					<span class="animate-default"><i class="fa fa-list" aria-hidden="true"></i> all
						categories</span>
				</a>
			</div>
		</div>
	</div>
	<div class="menu-header-v3 hidden-sm hidden-xs">
		<div class="container">
			<div class="row">
				<!-- Menu Page -->
				<div class="menu-header full-width">
					<ul class="clear-margin">
						<li id="categoriMenu">
							<a class="animate-default" href="#">
								<i class="fa fa-list" aria-hidden="true"></i> Semua Kategori
							</a>
						</li>
					</ul>
				</div>
				<!-- End Menu Page -->
			</div>
		</div>
	</div>
	<div class="clearfix menu_more_header menu-web menu-bg-white">
		<ul>
			<?php foreach ($category as $f) { ?>
				<li class="parentCategory">
					<!-- <a href="<?= base_url() ?>category"> -->
					<a href="<?= base_url() ?>category=<?= $f->id ?>%26page=1" data-id="<?= $f->id ?>">
						<?php if (count($sub_category[$f->id]) > 0) { ?>
							<i class="fa fa-caret-right" aria-hidden="true"></i>
						<?php } ?>
						<p><?= $f->nama ?></p>
					</a>
				</li>
				<?php foreach ($sub_category[$f->id] as $g) { ?>
					<li class="subCategory" data-id="<?= $f->id ?>">
						<!-- <a href="<?= base_url() ?>category"> -->
						<a href="<?= base_url() ?>category=<?= $f->id ?>%26subcategory=<?= $g->id ?>%26page=1">
							<p><?= $g->nama ?></p>
						</a>
					</li>
				<?php } ?>
			<?php } ?>
		</ul>
	</div>
</header>
<!-- End Header Box -->