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
                            <div class="form-input full-width clearfix relative">
                                <label for="ekspedisi">Ekspedisi *</label>
                                <select class="full-width" name="ekspedisi[]" id="ekspedisi" style="height: 180px; padding-top: 5px;" multiple>
                                    <option value="pos">POS Indonesia (POS)</option>
                                    <option value="lion">Lion Parcel (LION)</option>
                                    <option value="ninja">Ninja Xpress (NINJA)</option>
                                    <option value="sicepat">SiCepat Express (SICEPAT)</option>
                                    <option value="jne">Jalur Nugraha Ekakurir (JNE)</option>
                                    <option value="tiki">Citra Van Titipan Kilat (TIKI)</option>
                                    <option value="pandu">Pandu Logistics (PANDU)</option>
                                    <option value="wahana">Wahana Prestasi Logistik (WAHANA)</option>
                                    <option value="j&t">J&T Express (J&T)</option>
                                    <option value="pahala">Pahala Kencana Express (PAHALA)</option>
                                </select>
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