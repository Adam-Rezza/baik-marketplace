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
				<div class="box-header">
					<h3 class="box-title">List User</h3>
					<div class="box-tools">
						<button type="button" id="refresh_table" class="btn btn-info btn-sm" onclick="refreshTable();"> <i class="fa fa-refresh"></i> </button>
					</div>
				</div>
				<div class="box-body">
					<div class="table-responsive no-padding">
						<table id="datatables" class="table table-bordered table-hover small" style="width: 100%; min-height: 400px;">
							<thead>
								<tr>
									<th style="width: 20px;">#</th>
									<th style="width: 90px;"><i class="fa fa-image"></i></th>
									<th style="width: 100px;">Nama</th>
									<th>Alamat</th>
									<th style="width: 100px;">Email</th>
									<th style="width: 55px;">Telp</th>
									<th style="width: 60px;">Username</th>
									<th style="width: 40px;">Status</th>
									<th style="width: 60px;">Toko</th>
									<th class="text-center" style="width: 80px;"><i class="fa fa-cogs"></i></th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- modal lihat produk -->
<div class="modal fade" id="modal_lihat_produk">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">List Produk - <span id="nama_toko">nama toko</span></h4>
			</div>
			<div class="modal-body">
				<!-- isi list produk -->
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
