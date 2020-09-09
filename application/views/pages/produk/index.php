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
									<th>URL</th>
									<th class="text-center">Urutan</th>
									<th class="text-center">Status</th>
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
					<h3 class="box-title">Tambah Banner</h3>
				</div>

				<form id="form_add" class="form-horizontal" enctype="multipart/form-data">
					<div class="box-body">

						<div class="form-group">
							<label for="gambar" class="col-sm-3 control-label">Gambar</label>
							<div class="col-sm-8">
								<input type="file" class="form-control" id="gambar" name="gambar" placeholder="Gambar" accept="image/*" required>
							</div>
						</div>

						<div class="form-group">
							<label for="url" class="col-sm-3 control-label">URL</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="url" name="url" placeholder="URL" value="#" required>
							</div>
						</div>

						<div class="form-group">
							<label for="active" class="col-sm-3 control-label">Status</label>
							<div class="col-sm-8">
								<select class="form-control" id="active" name="active" required>
									<option value="1">Aktif</option>
									<option value="0">Tidak Aktif</option>
								</select>
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

<form id="form_edit" enctype="multipart/form-data">
	<div class="modal fade" id="modal-edit">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Edit Banner</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="gambar_edit">Gambar</label>
						<input type="file" class="form-control" id="gambar_edit" name="gambar_edit" placeholder="Gambar" accept="image/*" required>
					</div>
					<div class="form-group">
						<label for="url_edit">URL</label>
						<input type="text" class="form-control" id="url_edit" name="url_edit" placeholder="URL" value="#" required>
					</div>
					<div class="form-group">
						<label for="active_edit">Status</label>
						<select class="form-control" id="active_edit" name="active_edit" required>
							<option value="1">Aktif</option>
							<option value="0">Tidak Aktif</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="id_edit" name="id_edit">
					<button type="submit" id="edit_submit" class="btn btn-primary">Edit</button>
					<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</form>