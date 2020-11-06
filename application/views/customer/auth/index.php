<!-- Content Box -->
<div class="relative clearfix full-width">
    <div class="clearfix box-product full-width top-padding-default bg-gray">
        <div class=" container">
            <div class="row ">
                <?php
                if ($this->session->userdata(SESSUSER . 'merchant_id') == null) {
                ?>
                    <div class="col-md-3 col-sm-offset-4 relative left-content-shoping merchant-header-container">
                        <img class="img merchant-header" src="<?= base_url() ?>public/img/profile_toko/merchant.png" alt="">
                    </div>
                    <form method="post" action="" id="registerMerchantForm" enctype="multipart/form-data">
                        <div class="col-md-8 col-sm-12 col-xs-12 relative">
                            <p class="title-shoping-cart">Daftar Toko</p>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 relative left-content-shoping merchant-form">
                            <div class="form-input full-width clearfix relative">
                                <label for="nama">Nama Toko *</label>
                                <input class="full-width" type="text" name="nama" id="nama" placeholder="Nama Toko">
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label for="telp">Nomor Telepon *</label>
                                <input class="full-width" type="text" name="telp" id="telp" placeholder="Nomor Telepon">
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label for="desc">Deskripsi Toko *</label>
                                <textarea class="full-width" name="desc" id="desc" rows="4" style="resize:none; line-height: 18px;" placeholder="Deskripsi Toko"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12 relative left-content-shoping merchant-form">
                            <div class="form-input full-width clearfix relative">
                                <label for="alamat">Alamat *</label>
                                <textarea class="full-width" type="text" name="alamat" id="alamat" style="resize:none;" placeholder="Alamat"></textarea>
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label for="provinsi">Provinsi *</label>
                                <select class="full-width" type="password" name="provinsi" id="provinsi">
                                    <option value="">--Pilih Provinsi--</option>
                                    <?php foreach ($province as $f) { ?>
                                        <option value="<?= $f->id_prov ?>"><?= $f->nama ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label for="kabupaten">Kota *</label>
                                <select class="full-width" type="password" name="kabupaten" id="kabupaten">
                                    <option value="">--Pilih Kota--</option>
                                </select>
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label for="kecamatan">Kecamatan *</label>
                                <select class="full-width" type="password" name="kecamatan" id="kecamatan">
                                    <option value="">--Pilih Kecamatan--</option>
                                </select>
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label for="kelurahan">Kelurahan *</label>
                                <select class="full-width" type="password" name="kelurahan" id="kelurahan">
                                    <option value="">--Pilih Kelurahan--</option>
                                </select>
                            </div>
                            <div class="form-input full-width clearfix relative" style="margin-top: 20px;">
                                <fieldset>
                                    <legend>Ekspedisi *</legend>
                                    <?php
                                    foreach ($ekspedisis->result() as $ekspedisi) {
                                    ?>
                                        <div>
                                            <input type="checkbox" id="<?= $ekspedisi->id; ?>" name="ekspedisi[]" value="<?= $ekspedisi->id; ?>">
                                            <label for="<?= $ekspedisi->id; ?>"><?= $ekspedisi->nama; ?></label>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </fieldset>
                            </div>
                            <div class="form-input full-width clearfix relative text-center">
                                <button class="btn-daftar-toko full-width top-margin-15-default">Daftarkan Toko</button>
                            </div>
                        </div>
                    </form>
            </div>
        <?php } else if ($this->session->userdata(SESSUSER . 'merchant_active') == 0) { ?>
            <div class="col-md-12 col-sm-offset-12 relative left-content-shoping merchant-header-container" style="min-height: 400px">
                <h2>Toko anda belum aktif</h2>
            </div>
        <?php } else if ($this->session->userdata(SESSUSER . 'merchant_ban') == 1) { ?>
            <div class="col-md-12 col-sm-offset-12 relative left-content-shoping merchant-header-container" style="min-height: 400px">
                <h2>Toko anda di banned</h2>
            </div>
        <?php } ?>
        </div>
    </div>
</div>
<!-- End Content Box -->