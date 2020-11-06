<!-- Header Box -->
<header class="relative full-width">
	<div class=" container-web relative">
		<div class=" container">
			<div class="row">
				<div class=" header-top">
					<div class="menu-header-top text-right col-md-8 col-xs-12 col-sm-6 clear-padding">
						<ul class="clear-margin">
							<?php if (($this->session->userdata(SESSUSER . 'id') !== null || $this->session->userdata(SESSUSER . 'id') !== "")) { ?>
								<li class="relative"><span class='name'>Hi, <?= $this->session->userdata(SESSUSER . 'nama') ?></span></li>
							<?php } ?>
							<li class="relative"><a href="<?= base_url() ?>my_account">Akun</a></li>
							<li class="relative"><a href="<?= base_url() ?>merchant" id="userMerchant">Toko Saya</a></li>
							<li class="relative">
								<a href="<?= site_url(); ?>mutasi_dompet">
									<b style="color:#ff8000;">
										Saldo Rp.<?= number_format($this->session->userdata(SESSUSER . 'saldo'), 0, ',', '.'); ?>
									</b>
								</a>
							</li>
							<li class="relative"><a href="<?= base_url() ?>user/logout">Keluar</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- End Header Box -->