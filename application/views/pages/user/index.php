<section class="content-header">
	<h1><?= $title; ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?= site_url('dashboard'); ?>"><i class="fa fa-home"></i> Home</a></li>
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

<form id="form_reset">
	<div class="modal fade" id="modal_reset">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span></button>
					<h4 class="modal-title">Reset Password - <span id="nama_user"></span></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="new_password">New Password</label>
						<input type="password" class="form-control" id="new_password" name="new_password" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="id_user" name="id_user">
					<button type="submit" class="btn btn-success">Update Password</button>
					<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</form>