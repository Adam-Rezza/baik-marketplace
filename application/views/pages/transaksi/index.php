<section class="content-header">
	<h1><?= $title; ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?= site_url(); ?>admin/account/index"><i class="fa fa-home"></i> Home</a></li>
		<li class="active"><i class="fa fa-table"></i> <?= $title; ?></a></li>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body">
					<div class="table-responsive">
						<table id="datatables" class="table table-bordered small">
							<thead>
								<tr>
									<th>Pengirim</th>
									<th>Telp Pengirim</th>
									<th>Penerima</th>
									<th>Telp Penerima</th>
									<th>Pesanan</th>
									<th>Alamat</th>
									<th>Kelurahan</th>
									<th>Kecamatan</th>
									<th>Kota</th>
									<th>Provinsi</th>
									<th class="text-center" style="min-width: 80px;">Proses</th>
									<th class="text-center" style="min-width: 80px;">Pengiriman</th>
									<th class="text-center" style="min-width: 80px;">Diterima</th>
									<th class="text-center" style="min-width: 80px;">Gagal</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div id="modal_detail" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Detail Pesanan</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered table-sm">
					<thead>
						<tr>
							<th class="text-center">Produk</th>
							<th class="text-center">Harga</th>
							<th class="text-center">Qty</th>
						</tr>
					</thead>
					<tbody id="vdetail"></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>