<!-- Content Box -->
<div class="relative clearfix full-width">
    <div class="clearfix box-product full-width top-padding-default bg-gray">
        <div class=" container">
            <div class="row ">
                <div class="col-md-3 col-sm-offset-4 relative left-content-shoping">
                    <img class="img img-responsive merchant-header" src="<?= base_url() ?>public/img/profil_merchant/merchant.png" alt="">
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 relative left-content-shoping merchant-form">
                    <form method="post" action="" id="registerMerchantForm" enctype="multipart/form-data">
                        <p class="title-shoping-cart">Daftar Toko</p>
                        <div class="form-input full-width clearfix relative">
                            <label>Nama Toko *</label>
                            <input class="full-width" type="text" name="nama" id="nama">
                        </div>
                        <div class="form-input full-width clearfix relative">
                            <label>Nomor Telepon *</label>
                            <input class="full-width" type="text" name="telp" id="telp">
                        </div>
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
                        <!-- <div class="form-input full-width clearfix relative">
                            <label>Provinsi *</label>
                            <select class="full-width" name="alamat" id="alamat">
                                <option value="1">DKI Jakarta</option>
                                <option value="2" selected>Jawa barat</option>
                                <option value="3">Jawa Tengah</option>
                                <option value="4">Sumatera Barat</option>
                            </select>
                        </div>
                        <div class="form-input full-width clearfix relative">
                            <label>Kota *</label>
                            <select class="full-width" name="alamat" id="alamat">
                                <option value="1">Kab. Bogor</option>
                                <option value="2">Bekasi</option>
                                <option value="3">Bandung</option>
                                <option value="4">Purwakarta</option>
                            </select>
                        </div> -->
                        <div class="form-input full-width clearfix relative text-center">
                            <button class="btn-daftar-toko full-width top-margin-15-default">Daftarkan Toko</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content Box -->