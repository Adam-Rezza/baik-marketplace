<!-- Content Category -->
<div class="relative container-web bottom-margin-default">
	<div class="container">
		<div class="row ">
			<!-- Sider Bar -->
			<div class="col-md-3 relative top-padding-default top-margin-default" id="slide-bar-category">
				<div class="col-md-12 col-sm-12 col-xs-12 sider-bar-category border bottom-margin-default">
					<img class="img img-responsive merchant-header" src="<?= base_url() ?>public/img/profile/<?= $user->gambar ? $user->gambar : "user.png" ?>" alt="">
					<div class="text-center top-margin-15-default">
						<button id="btn-profil-foto">Upload foto</button>
						<input type="file" id="profil-foto" accept="image/*" class="hidden">
					</div>
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
			<div class="col-md-6 relative clear-padding top-padding-default left-padding-default">
				<div class="col-sm-12 col-xs-12 relative overfollow-hidden clear-padding button-show-sidebar">
					<p onclick="showSideBar()"><span class="ti-filter"></span> Menu</p>
				</div>
				<div class="bar-category bottom-margin-default border no-border-r no-border-l no-border-t">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<p class="title-category-page clear-margin">Informasi Akun</p>
						</div>
					</div>
				</div>
				<!-- Product Content Category -->
				<div class="relative clearfix">
					<ul class="title-tabs clearfix relative">
						<li onclick="event.preventDefault();changeTabsAuth(1)" class="title-tabs-auth-detail title-tabs-auth-1 border no-border-b <?= $on_shopping ? "" : "active-title-tabs" ?> bold uppercase">Informasi Dasar</li>
						<li onclick="event.preventDefault();changeTabsAuth(2)" class="title-tabs-auth-detail title-tabs-auth-2 border no-border-b <?= $on_shopping ? "active-title-tabs" : "" ?> bold uppercase">Alamat</li>
						<li onclick="event.preventDefault();changeTabsAuth(3)" class="title-tabs-auth-detail title-tabs-auth-3 border no-border-b bold uppercase">Ganti password</li>
					</ul>
					<div class="content-tabs-auth-detail relative content-tab-auth-1 border <?= $on_shopping ? "" : "active-tabs-auth-detail" ?> top-padding-15-default bottom-padding-15-default left-padding-default right-padding-default discussions">
						<form method="post" action="" id="basicInfoForm" enctype="multipart/form-data">
							<div class="form-input full-width clearfix relative">
								<label>Nama *</label>
								<input class="full-width" type="text" name="name_u" id="name_u" value="<?= $user->nama ?>">
							</div>
							<div class="form-input full-width clearfix relative">
								<label>Username *</label>
								<input class="full-width" type="text" name="username_u" id="username_u" value="<?= $user->username ?>" disabled readonly>
							</div>
							<div class="form-input full-width clearfix relative">
								<label>Nomor Telepon *</label>
								<input class="full-width" type="phone" name="phone_u" id="phone_u" value="<?= $user->telp ?>">
							</div>
							<div class="form-input full-width clearfix relative text-center top-padding-15-default">
								<button class="btn-daftar-toko full-width" id="saveBasicInfo">Simpan</button>
							</div>
						</form>
					</div>
					<div class="content-tabs-auth-detail relative content-tab-auth-2 border <?= $on_shopping ? "active-tabs-auth-detail" : "" ?> top-padding-15-default bottom-padding-15-default left-padding-default right-padding-default discussions">
						<form method="post" action="" id="addressForm" enctype="multipart/form-data">
							<input name="alamat_id" id="alamat_id" value="<?= $address ? $address->id : '' ?>" hidden>
							<div class="form-input full-width clearfix relative">
								<label>Alamat *</label>
								<textarea class="full-width" type="text" name="alamat" id="alamat" rows="2" style="resize: none; line-height: 1.6em; padding: 3px 8px"><?= $address ? $address->alamat : '' ?></textarea>
							</div>
							<div class="form-input form-group full-width clearfix relative">
								<label>Provinsi *</label>
								<select class="full-width" name="provinsi" id="provinsi">
									<option value="">--Pilih Provinsi--</option>
									<?php foreach ($province as $f) { ?>
										<option value="<?= $f->id_prov ?>" <?= $address ? ($address->provinsi == $f->id_prov ? 'selected' : '') : '' ?>><?= $f->nama ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-input form-group full-width clearfix relative">
								<label>Kota *</label>
								<select class="full-width" name="kabupaten" id="kabupaten">
									<?php if ($address) { ?>
										<option value="<?= $address->kota ?>"><?= $address->kab ?></option>
									<?php } else { ?>
										<option value="">--Pilih Kota--</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-input form-group full-width clearfix relative">
								<label>Kecamatan *</label>
								<select class="full-width" name="kecamatan" id="kecamatan">
									<?php if ($address) { ?>
										<option value="<?= $address->kecamatan ?>"><?= $address->kec ?></option>
									<?php } else { ?>
										<option value="">--Pilih Kecamatan--</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-input form-group full-width clearfix relative">
								<label>Kelurahan *</label>
								<select class="full-width" name="kelurahan" id="kelurahan">
									<?php if ($address) { ?>
										<option value="<?= $address->kelurahan ?>"><?= $address->kel ?></option>
									<?php } else { ?>
										<option value="">--Pilih Kelurahan--</option>
									<?php } ?>
								</select>
							</div>
							<div class="form-input full-width clearfix relative text-center top-padding-15-default">
								<button class="btn-daftar-toko full-width" id="saveAlamat">Simpan</button>
							</div>
						</form>
					</div>
					<div class="content-tabs-auth-detail relative content-tab-auth-3 border top-padding-15-default bottom-padding-15-default left-padding-default right-padding-default reviews">
						<form method="post" action="" id="passwordForm" enctype="multipart/form-data">
							<div class="form-input full-width clearfix relative">
								<label>Password Lama*</label>
								<div class="input-group">
									<input type="password" class="form-control" name="password_old_u" id="password_old_u">
									<span class="input-group-btn">
										<button class="btn btn-info btn-reveal" type="button" data-target="password_old_u"><i class="glyphicon glyphicon-eye-open"></i></button>
									</span>
								</div>
							</div>
							<div class="form-input full-width clearfix relative">
								<label>Password Baru*</label>
								<div class="input-group">
									<input type="password" class="form-control" name="password_u" id="password_u">
									<span class="input-group-btn">
										<button class="btn btn-info btn-reveal" type="button" data-target="password_u"><i class="glyphicon glyphicon-eye-open"></i></button>
									</span>
								</div>
							</div>
							<div class="form-input full-width clearfix relative">
								<label>Konfirmasi Password Baru*</label>
								<div class="input-group">
									<input type="password" class="form-control" name="password2_u" id="password2_u">
									<span class="input-group-btn">
										<button class="btn btn-info btn-reveal" type="button" data-target="password2_u"><i class="glyphicon glyphicon-eye-open"></i></button>
									</span>
								</div>
							</div>
							<div class="form-input full-width clearfix relative text-center top-padding-15-default">
								<button class="btn-daftar-toko full-width" id="savePassword">Simpan</button>
							</div>
						</form>
					</div>
				</div>
				<!-- End Product Content Category -->
			</div>
		</div>
	</div>
</div>