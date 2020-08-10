<section class="content-header">
	<h1><?= $title; ?></h1>
	<ol class="breadcrumb">
		<li><a href="<?= site_url(); ?>admin/account/index"><i class="fa fa-home"></i> Home</a></li>
		<li class="active"><i class="fa fa-table"></i> Admin Management</a></li>
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
									<th>Username</th>
									<th class="text-center" style="min-width: 200px;"><i class="fa fa-cogs"></i></th>
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
					<h3 class="box-title">Tambah Admin</h3>
				</div>

				<form class="form-horizontal" method="post" action="<?= site_url(); ?>admins">
					<div class="box-body">

						<div class="form-group">
							<label for="username" class="col-sm-4 col-sm-offset-1 control-label">Username</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="username" name="username" placeholder="Username" minlength="3" maxlength="100" value="<?= set_value('username'); ?>" required>
								<?= form_error('username'); ?>
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="col-sm-4 col-sm-offset-1 control-label">Password</label>
							<div class="col-sm-6">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" minlength="3" maxlength="100" value="<?= set_value('password'); ?>" required>
								<?= form_error('password'); ?>
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="col-sm-4 col-sm-offset-1 control-label">Verify Password</label>
							<div class="col-sm-6">
								<input type="password" class="form-control" id="verify_password" name="verify_password" placeholder="Verify Password" minlength="3" maxlength="100" required>
								<?= form_error('verify_password'); ?>
							</div>
						</div>

					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-warning btn-block">Tambah</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<form id="form_reset" action="#" method="post">
	<div class="modal fade" id="modal-reset">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Reset Password</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="reset_username_text">Username</label>
						<input type="text" class="form-control" id="reset_username_text" name="reset_username_text" disabled>
					</div>
					<div class="form-group">
						<label for="reset_password">New Password</label>
						<input type="password" class="form-control" id="reset_password" name="reset_password" required>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" id="reset_id" name="reset_id">
					<input type="hidden" id="reset_username" name="reset_username">
					<button type="submit" id="reset_submit" class="btn btn-primary">Reset</button>
					<button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</form>
