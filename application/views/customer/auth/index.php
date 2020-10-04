<!-- Content Box -->
<div class="relative clearfix full-width">
    <div class="clearfix box-product full-width top-padding-default bg-gray">
        <div class=" container">
            <div class="row ">
                <?php if ($this->session->userdata(SESSUSER . 'merchant_active') == 1 && $this->session->userdata(SESSUSER . 'merchant_ban') == 0) { ?>
                    <div class="col-md-3 col-sm-offset-4 relative left-content-shoping merchant-header-container">
                        <img class="img merchant-header" src="<?= base_url() ?>public/img/profile_toko/merchant.png" alt="">
                    </div>
                    <form method="post" action="" id="registerMerchantForm" enctype="multipart/form-data">
                        <div class="col-md-8 col-sm-12 col-xs-12 relative">
                            <p class="title-shoping-cart">Daftar Toko</p>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 relative left-content-shoping merchant-form">
                            <div class="form-input full-width clearfix relative">
                                <label>Nama Toko *</label>
                                <input class="full-width" type="text" name="nama" id="nama">
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label>Nomor Telepon *</label>
                                <input class="full-width" type="text" name="telp" id="telp">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 relative left-content-shoping merchant-form">
                            <div class="form-input full-width clearfix relative">
                                <label>Alamat *</label>
                                <textarea class="full-width" type="text" name="alamat" id="alamat" style="resize:none"></textarea>
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label>Provinsi *</label>
                                <select class="full-width" type="password" name="provinsi" id="provinsi">
                                    <option value="">--Pilih Provinsi--</option>
                                    <?php foreach ($province as $f) { ?>
                                        <option value="<?= $f->id_prov ?>"><?= $f->nama ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label>Kota *</label>
                                <select class="full-width" type="password" name="kabupaten" id="kabupaten">
                                    <option value="">--Pilih Kota--</option>
                                </select>
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label>Kecamatan *</label>
                                <select class="full-width" type="password" name="kecamatan" id="kecamatan">
                                    <option value="">--Pilih Kecamatan--</option>
                                </select>
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label>Kelurahan *</label>
                                <select class="full-width" type="password" name="kelurahan" id="kelurahan">
                                    <option value="">--Pilih Kelurahan--</option>
                                </select>
                            </div>
                            <div class="form-input full-width clearfix relative text-center">
                                <button class="btn-daftar-toko full-width top-margin-15-default">Daftarkan Toko</button>
                            </div>
                        </div>
                    </form>
            </div>
        <?php } else if ($this->session->userdata(SESSUSER . 'merchant_active') == 0){ ?>
            <div class="col-md-12 col-sm-offset-12 relative left-content-shoping merchant-header-container" style="min-height: 400px">
                <h2>Toko anda belum aktif</h2>
            </div>
        <?php } else if ($this->session->userdata(SESSUSER . 'merchant_ban') == 1){ ?>
            <div class="col-md-12 col-sm-offset-12 relative left-content-shoping merchant-header-container" style="min-height: 400px">
                <h2>Toko anda di banned</h2>
            </div>
        <?php } ?>
        </div>
    </div>
</div>
<!-- End Content Box -->