<div class="col-md-6 relative clear-padding top-padding-default bottom-padding-default left-padding-default">
    <div class="col-sm-12 col-xs-12 relative overfollow-hidden clear-padding button-show-sidebar">
        <p onclick="showSideBar()"><span class="ti-filter"></span> Menu</p>
    </div>
    <div class="bar-category bottom-margin-default border no-border-r no-border-l no-border-t">
        <div class="row">
            <div class="col-md-5 col-sm-5 col-xs-4">
                <p class="title-category-page clear-margin">Informasi Akun</p>
            </div>
        </div>
    </div>
    <!-- Product Content Category -->
    <div class="relative clearfix">
        <ul class="title-tabs clearfix relative">
            <li onclick="event.preventDefault();changeTabsAuth(1)" class="title-tabs-auth-detail title-tabs-auth-1 border no-border-b active-title-tabs bold uppercase">Informasi Dasar</li>
            <li onclick="event.preventDefault();changeTabsAuth(2)" class="title-tabs-auth-detail title-tabs-auth-2 border no-border-b bold uppercase">Alamat</li>
        </ul>
        <div class="content-tabs-auth-detail relative content-tab-auth-1 border active-tabs-auth-detail top-padding-15-default bottom-padding-15-default left-padding-default right-padding-default discussions">
            <form method="post" action="" id="basicInfoForm" enctype="multipart/form-data">
                <div class="form-input full-width clearfix relative">
                    <label>Nama *</label>
                    <input class="full-width" type="text" name="name_t" id="name_t" value="<?= $toko->nama ?>">
                </div>
                <div class="form-input full-width clearfix relative">
                    <label>Nomor Telepon *</label>
                    <input class="full-width" type="phone" name="phone_t" id="phone_t" value="<?= $toko->telp ?>">
                </div>
                <div class="form-input full-width clearfix relative">
                    <label>Deskripsi Toko</label>
                    <textarea class="full-width" name="desc_t" id="desc_t" value="" rows="4" style="resize:none; line-height: 18px; "><?= $toko->desc ?></textarea>
                </div>
                <div class="form-input full-width clearfix relative text-center top-padding-15-default">
                    <button class="btn-daftar-toko full-width" id="saveBasicInfo">Simpan</button>
                </div>
            </form>
        </div>
        <div class="content-tabs-auth-detail relative content-tab-auth-2 border top-padding-15-default bottom-padding-15-default left-padding-default right-padding-default discussions">
            <form method="post" action="" id="addressForm" enctype="multipart/form-data">
                <div class="form-input full-width clearfix relative">
                    <label>Alamat *</label>
                    <textarea class="full-width" type="text" name="alamat" id="alamat" rows="2" style="resize: none; line-height: 1.6em; padding: 3px 8px"><?= $toko->alamat ?></textarea>
                </div>
                <div class="form-input full-width clearfix relative">
                    <label>Provinsi *</label>
                    <select class="full-width" name="provinsi" id="provinsi">
                        <option value="">--Pilih Provinsi--</option>
                        <?php foreach ($province as $f) { ?>
                            <option value="<?= $f->id_prov ?>" <?= $toko->provinsi == $f->id_prov ? 'selected' : '' ?>><?= $f->nama ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-input full-width clearfix relative">
                    <label>Kota *</label>
                    <select class="full-width" name="kabupaten" id="kabupaten">
                        <option value="<?= $toko->kota ?>"><?= $toko->kab ?></option>
                    </select>
                </div>
                <div class="form-input full-width clearfix relative">
                    <label>Kecamatan *</label>
                    <select class="full-width" name="kecamatan" id="kecamatan">
                        <option value="<?= $toko->kecamatan ?>"><?= $toko->kec ?></option>
                    </select>
                </div>
                <div class="form-input full-width clearfix relative">
                    <label>Kelurahan *</label>
                    <select class="full-width" name="kelurahan" id="kelurahan">
                        <option value="<?= $toko->kelurahan ?>"><?= $toko->kel ?></option>
                    </select>
                </div>
                <div class="form-input full-width clearfix relative text-center top-padding-15-default">
                    <button class="btn-daftar-toko full-width" id="saveAlamat">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End Product Content Category -->
</div>