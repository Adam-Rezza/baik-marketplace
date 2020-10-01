	<header class="main-header">
		<a href="" class="logo">
			<span class="logo-mini">
				<img src="<?= base_url(); ?>public/img/baik_logo3.png" style="width: 50px;" />
			</span>
			<span class="logo-lg"><b>Admin</b>Marketplace</span>
		</a>

		<nav class="navbar navbar-static-top" role="navigation">
			<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">
					<li>
						<a href="<?= site_url('/'); ?>" target="_blank">
							<i class="fa fa-home"></i> Lihat Web
						</a>
					</li>
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<img src="<?= base_url(); ?>public/img/avatars/avatar_default.png" class="user-image" alt="User Image">
							<span class="hidden-xs"><?= ucfirst($this->session->userdata(SESS . 'username')); ?></span>
						</a>
						<ul class="dropdown-menu">
							<li class="user-header">
								<img src="<?= base_url(); ?>public/img/avatars/avatar_default.png" class="img-circle" alt="User Image">
								<p>
									<?= ucfirst($this->session->userdata(SESS . 'username')); ?>
								</p>
							</li>
							<li class="user-footer">
								<div class="pull-left">
									<button type="button" class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal_change_password">Ganti Password</button>
								</div>
								<div class="pull-right">
									<a href="<?= site_url(); ?>logout" class="btn btn-danger btn-flat" role="button">Sign out</a>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>