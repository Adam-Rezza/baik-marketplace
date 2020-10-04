<section class="content-header">
	<h1><?= $title; ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?= site_url(); ?>admin/account/index"><i class="fa fa-home"></i> Home</a></li>
		<li class="active"><i class="fa fa-table"></i> <?= $title; ?></a></li>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-8">
			<div class="box box-info">
				<div class="box-body">
					<div class="table-responsive">
						<table id="datatables" class="table table-bordered small" style="width: 100%;">
							<thead>
								<tr>
									<th class="text-center">ID</th>
									<th>Gambar</th>
									<th>Kategori</th>
									<th class="text-center">Status</th>
									<th class="text-center">Urutan</th>
									<th class="text-center" style="min-width: 240px;"><i class="fa fa-cogs"></i></th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-4">
			<div class="box box-warning">
				<div class="box-header with-border">
					<h3 class="box-title">Tambah Kategori</h3>
				</div>

				<form id="form_add" class="form-horizontal" enctype="multipart/form-data">
					<div class="box-body">

						<div class="form-group">
							<label for="nama" class="col-sm-4 col-sm-offset-1 control-label">Kategori</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="nama" name="nama" placeholder="Kategori" minlength="3" maxlength="100" required>
							</div>
						</div>

						<div class="form-group">
							<label for="parent" class="col-sm-4 col-sm-offset-1 control-label">Parent</label>
							<div class="col-sm-6">
								<select class="form-control" id="parent" name="parent" required>
									<option value="no">No Parent</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="active" class="col-sm-4 col-sm-offset-1 control-label">Status</label>
							<div class="col-sm-6">
								<select class="form-control" id="active" name="active" required>
									<option value="1">Aktif</option>
									<option value="0">Tidak Aktif</option>
								</select>
							</div>
						</div>

						<div class="form-group gambar">
							<label for="active" class="col-sm-4 col-sm-offset-1 control-label">Gambar</label>
							<div class="col-sm-6">
								<input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
							</div>
						</div>

					</div>
					<div class="box-footer">
						<button type="submit" id="add_submit" class="btn btn-warning btn-block">Tambah</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<form id="form_edit" method="post" enctype="multipart/form-data">
	<div class="modal fade" id="modal-edit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Edit Kategori</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="nama_edit">Kategori</label>
						<input type="text" class="form-control" id="nama_edit" name="nama_edit" required>
					</div>
					<div class="form-group">
						<label for="active_edit">Status</label>
						<select class="form-control" id="active_edit" name="active_edit" required>
							<option value="1">Aktif</option>
							<option value="0">Tidak Aktif</option>
						</select>
					</div>
					<div class="form-group">
						<label for="gambar_edit">Gambar</label>
						<input type="file" class="form-control" id="gambar_edit" name="gambar_edit" accept="image/*">
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="id_edit" name="id_edit">
					<input type="hidden" id="nama_gambar_edit" name="nama_gambar_edit">
					<button type="submit" id="edit_submit" class="btn btn-primary">Edit</button>
					<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</form>

<form id="form_edit_sub">
	<div class="modal fade" id="modal-edit_sub">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Edit Sub Kategori</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="nama_edit">Sub Kategori</label>
						<input type="text" class="form-control" id="nama_edit_sub" name="nama_edit_sub" required>
					</div>
					<div class="form-group">
						<label for="parent_edit">Parent</label>
						<select class="form-control" id="parent_edit_sub" name="parent_edit_sub" required>
							<option value="no">No Parent</option>
						</select>
					</div>
					<div class="form-group">
						<label for="active_edit">Status</label>
						<select class="form-control" id="active_edit_sub" name="active_edit_sub" required>
							<option value="1">Aktif</option>
							<option value="0">Tidak Aktif</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="id_edit_sub" name="id_edit_sub">
					<input type="hidden" id="prev_parent_edit" name="prev_parent_edit">
					<button type="submit" id="edit_submit_sub" class="btn btn-primary">Edit</button>
					<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</form>

<div class="modal fade" id="modal-sub">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">List Sub Kateori <span id="nama_parent"></span></h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered" id="vsub">
					<thead>
						<tr>
							<th class="text-center">ID</th>
							<th>Sub Kategori</th>
							<th class="text-center">Urutan</th>
							<th>Status</th>
							<th class="text-center"><i class="fa fa-cogs"></i></th>
						</tr>
					</thead>
					<tbody id="vsubbody"></tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>