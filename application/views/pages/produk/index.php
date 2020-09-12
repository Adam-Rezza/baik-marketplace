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
									<th class="text-center">Toko</th>
									<th>Nama</th>
									<th>Harga Asli</th>
									<th>Harga Disc</th>
									<th>Terjual</th>
									<th>Rating</th>
									<th class="text-center" style="min-width: 80px;">Status</th>
									<th class="text-center" style="min-width: 80px;"><i class="fa fa-cogs"></i></th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
