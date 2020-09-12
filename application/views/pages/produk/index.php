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
						<table id="datatables" class="table table-bordered small" style="width: 100%;">
							<thead>
								<tr>
									<th>Toko</th>
									<th>Nama</th>
									<th>Harga Asli</th>
									<th>Harga Disc</th>
									<th>Terjual</th>
									<th>Rating</th>
									<th class="text-center" style="min-width: 80px;">Status</th>
									<th class="text-center" style="min-width: 220px;"><i class="fa fa-cogs"></i></th>
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
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Detail Produk <span id="nama_produk"></span></h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered table-sm">
					<thead>
						<tr>
							<th class="text-center">Gambar</th>
							<th class="text-center"><i class="fa fa-cog"></i></th>
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
