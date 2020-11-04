<!-- Content Category -->
<div class="relative container-web bottom-margin-default">
	<div class="container">
		<div class="row ">
			<!-- Sider Bar -->
			<div class="col-md-3 relative top-padding-default top-margin-default" id="slide-bar-category">
				<div class="col-md-12 col-sm-12 col-xs-12 sider-bar-category border bottom-margin-default">
					<h4 class="text-center"><?= $this->session->userdata(SESSUSER . 'nama'); ?></h4>
					<img class="img img-responsive merchant-header" src="<?= base_url() ?>public/img/profile/<?= $user->gambar ? $user->gambar : "user.png" ?>" alt="PP">
					<div class="text-center top-margin-15-default">
						<button id="btn-profil-foto">Upload foto</button>
						<input type="file" id="profil-foto" accept="image/*" class="hidden">
					</div>
					<h4 class="text-center" style="margin-top:30px !important;">
						<a href="mutasi_dompet" class="btn btn-info">
							Saldo Rp.<?= number_format($this->session->userdata(SESSUSER . 'saldo'), 0, ',', '.'); ?>
						</a>
					</h4>
					<ul class="clear-margin list-siderbar top-margin-15-default">
						<li><a href="<?= base_url() ?>my_account">Akun saya</a></li>
						<li><a href="<?= base_url() ?>my_order">Pesanan saya</a></li>
						<li><a href="<?= base_url() ?>my_recent_order">Pesanan selesai</a></li>
					</ul>
					<div class="text-center top-margin-15-default">
						<a class="btn-daftar-toko" href="<?= base_url() ?>">Lanjut Belanja</a>
					</div>
				</div>
			</div>
			<!-- End Sider Bar -->
			<div class="col-md-9 relative clear-padding top-padding-default left-padding-default">
				<div class="col-sm-12 col-xs-12 relative overfollow-hidden clear-padding button-show-sidebar">
					<p onclick="showSideBar()"><span class="ti-filter"></span> Menu</p>
				</div>
				<div class="bar-category bottom-margin-default border no-border-r no-border-l no-border-t">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<p class="title-category-page clear-margin">Mutasi Dompet</p>
							<div class="pull-right">
								<div class="btn-group">
									<button type="button" class="btn btn-info" onclick="comingSoon();">
										<i class="fa fa-money fa-fw"></i> Dari Sukarela
									</button>
									<button type="button" class="btn btn-info" onclick="comingSoon();">
										<i class="fa fa-money fa-fw"></i> Topup Dari Petugas
									</button>
									<button type="button" class="btn btn-info" onclick="transfer();">
										<i class="fa fa-exchange fa-fw"></i> Transfer
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">Pencarian Data</h3>
							</div>
							<div class="panel-body">
								<form action="#" class="form-inline" id="form_filter">
									<div class="form-group">
										<label for="from">Dari Tanggal</label>
										<input type="text" class="form-control datepicker" id="from" name="from" value="<?= date('d/m/Y'); ?>" placeholder="dd/mm/yyyy" required>
									</div>
									<div class="form-group">
										<label for="to">Sampai Tanggal</label>
										<input type="text" class="form-control datepicker" id="to" name="to" value="<?= date('d/m/Y'); ?>" placeholder="dd/mm/yyyy" required>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary btn-block">Tampilkan</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Data Mutasi Dompet</h3>
							</div>
							<div class="panel-body" id="vresult">
								<div class="table-responsive" style="min-height: 200px;">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Tanggal</th>
												<th>Keterangan</th>
												<th>Debit</th>
												<th>Kredit</th>
												<th>Saldo</th>
											</tr>
										</thead>
										<tbody id="vbody">

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="modal_transfer">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Transfer</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
						<button type="button" class="btn btn-warning btn-lg" onclick="terimaTF();">Terima</button>
						<button type="button" class="btn btn-warning btn-lg" onclick="kirimTF();">Kirim</button>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="vTerimaTF" style="display:none;">
						<div id="qrcode_id_anggota" class="img-thumbnail" style="margin-top: 20px;"></div>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center" id="vKirimTF" style="display:none;">
						Fitur Scan Barcode
						<div id="qr_scan" class="col-centered"></div>
						<div id="qr_result" style="text-align: center;"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>