<!-- Content Category -->
<div class="col-md-9 relative clear-padding top-padding-default left-padding-default">
    <div class="col-sm-12 col-xs-12 relative overfollow-hidden clear-padding button-show-sidebar">
        <p onclick="showSideBar()"><span class="ti-filter"></span> Sidebar</p>
    </div>
    <div class="bar-category bottom-margin-default border no-border-r no-border-l no-border-t">
        <div class="row">
            <div class="col-md-5 col-sm-5 col-xs-4">
                <p class="title-category-page clear-margin">Produk saya</p>
                <button class="btn btn-add-product add-product"><i class="fa fa-plus"></i> Produk baru</button>
            </div>
        </div>
    </div>
    <!-- Product Content Category -->
    <div class="relative">
        <?php
        if (count($product) > 0) {
        ?>
            <?php foreach ($product as $f) {  ?>
                <div class="col-md-12 clear-padding border no-border-t no-border-l no-border-r product-category bottom-margin-default product-category-list relative">
                    <div class="image-product image-product-merhcant relative overfollow-hidden">
                        <div class="center-vertical-image">
                            <?php if ($f->gambar) { ?>
                                <img src="<?= base_url(); ?>public/img/produk/<?= $f->gambar ?>" id="image-product-<?= $f->id ?>" alt="Product">
                            <?php } else { ?>
                                <img src="<?= base_url(); ?>public/megastore/img/no-image-available.png" id="image-product-<?= $f->id ?>" alt="No image">
                            <?php } ?>
                        </div>
                        <ul class="option-product animate-default clear-margin">
                            <li class="relative">
                                <a href="#" class="edit-image-product" data-id="<?= $f->id ?>" data-product-name="<?= $f->nama ?>">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="relative overfollow-hidden info-product-list">
                        <h3 class="title-product clearfix full-width title-hover-black clear-margin">
                            <a href="#"><?= $f->nama ?></a>
                            <?php if (!$f->gambar) { ?>
                                <span>(Belum aktif, tambah gambar)</span>
                            <?php } ?>
                        </h3>

                        <p class="clearfix price-product">
                            <span class="price-old">Rp <?= number_format($f->harga_asli, 0, ",", ".") ?></span>
                            Rp <?= number_format($f->harga_disc, 0, ",", ".") ?>
                        </p>
                        <p class="intro-product-category"><?= $f->desc ?></p>
                        <div class="relative button-product-list clearfix">
                            <ul class="clear-margin">
                                <li class=""><a href="#" class="animate-default edit-product" data-id="<?= $f->id ?>">Edit</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="col-md-12 clear-padding product-category left-margin-default product-category-list relative" style="color: grey">
                <h3>Tidak ada data</h3>
            </div>
        <?php } ?>
    </div>
    <?php
    //disable sementara
    if (count($product) > 0 && false) {
    ?>
        <div class="row">
            <div class="pagging relative">
                <ul>
                    <li><a href="#"><i class="fa fa-angle-left" aria-hidden="true"></i> First</a></li>
                    <li class="active-pagging"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li class="dots-pagging">. . .</li>
                    <li><a href="#">102</a></li>
                    <li><a href="#">Last <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
    <?php } ?>
    <!-- End Product Content Category -->
</div>

<div class="modal fade bs-example-modal-lg out" id="modalAddProduct" tabindex="-1" role="dialog" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="relative">
                    <button type="button" class="close-modal animate-default" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="ti-close"></span>
                    </button>
                    <div class="col-md-12 relative overfollow-hidden bottom-margin-15-default">
                        <h3 class="title-modal-product">Tambah Produk Baru</h3>
                        <form method="post" action="" id="productForm" enctype="multipart/form-data">
                            <input class="full-width" type="text" name="produk_id" id="produk_id" style="display: none">
                            <div class="form-input full-width clearfix relative">
                                <label>Nama Produk *</label>
                                <input class="full-width" type="text" name="nama" id="nama">
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label>Harga *</label>
                                <input class="full-width" type="text" name="harga_asli" id="harga_asli">
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label>Diskon (%)</label>
                                <input class="full-width" type="number" name="disc" id="disc" value="0">
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label>Harga setelah diskon</label>
                                <input class="full-width" type="text" name="harga_disc" id="harga_disc" readonly>
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label>Kategori</label>
                                <select class="full-width" name="kategori" id="kategori">
                                    <option value="">Semua Kategori</option>
                                    <?php foreach ($category as $f) { ?>
                                        <option value="<?= $f->id ?>"><?= $f->nama ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-input full-width clearfix relative" id="sub-kategori-parent" style="display: none">
                                <label>Sub Kategori</label>
                                <select class="full-width" name="sub_kategori" id="sub_kategori">
                                    <option value="">Semua Sub Kategori</option>
                                </select>
                            </div>
                            <div class="form-input full-width clearfix relative">
                                <label>Deskripsi *</label>
                                <textarea class="full-width" name="desc" id="desc" style="resize: none; line-height: 22px; padding: 7px" rows='5'></textarea>
                            </div>
                            <div class="form-input full-width clearfix relative text-center">
                                <button class="btn-daftar-toko full-width top-margin-15-default" id="register">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg out" id="modalImageProduct" tabindex="-1" role="dialog" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document" style="min-height: 229.25px;">
        <div class="modal-content">
            <div class="modal-body">
                <div class="relative">
                    <button type="button" class="close-modal animate-default" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="ti-close"></span>
                    </button>
                    <div class="col-md-12 relative overfollow-hidden bottom-margin-15-default">
                        <div class="col-md-12" style="display: block; margin-bottom: 30px">
                            <h3>Gambar Produk > <span id="title-product">Product</span></h3>
                        </div>
                        <div class="image-product-container" id="image-product-sortable" data-produk-id="45">
                            <div class="image-product-item" id="image-product-item-example-1">
                                <div class="image-product-item-content">
                                    <img src="<?= base_url(); ?>public/megastore/img/add-image.png" alt="No image">
                                    <input type="file" class="input-image-product hidden">
                                    <button>Update</button>
                                </div>
                                <button class="image-product-item-remove"><i class="fa fa-times" aria-hidden="true"></i></button>
                            </div>
                            <div class="image-product-item" id="image-product-item-example-2">
                                <div class="image-product-item-content">
                                    <img src="<?= base_url(); ?>public/megastore/img/add-image.png" alt="No image">
                                    <input type="file" class="input-image-product hidden">
                                    <button>Update</button>
                                </div>
                            </div>
                            <div class="image-product-item" id="image-product-item-example-3">
                                <div class="image-product-item-content">
                                    <img src="<?= base_url(); ?>public/megastore/img/add-image.png" alt="No image">
                                    <input type="file" class="input-image-product hidden">
                                    <button>Update</button>
                                </div>
                            </div>
                            <div class="image-product-add-item" id="image-product-item-example-4">
                                <div class="image-product-item-content">
                                    <img src="<?= base_url(); ?>public/megastore/img/add-image.png" alt="No image">
                                    <input type="file" class="input-image-product hidden">
                                    <button>Tambah</button>
                                </div>
                            </div>
                        </div>
                        <div class="image-product-container" id="image-product-container-add" style="display: none">
                            <div class="image-product-add-item" id="image-product-item-example-4">
                                <div class="image-product-item-content">
                                    <img src="<?= base_url(); ?>public/megastore/img/add-image.png" alt="No image">
                                    <input type="file" class="input-image-product hidden" id="add-image-new" accept="image/*">
                                    <button class="btn-image-product" data-target="add-image-new">Tambah</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-input full-width clearfix relative text-center">
                            <button class="btn-daftar-toko full-width top-margin-15-default" id="save_sort">Simpan</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg out" id="modalCropImage" tabindex="-1" role="dialog" aria-hidden="true" style="display: none" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document" style="min-height: 229.25px; width: 830px!important">
        <div class="modal-content">
            <div class="modal-body">
                <div class="relative">
                    <button type="button" class="close-modal animate-default" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="ti-close"></span>
                    </button>
                    <div class="col-md-12 relative overfollow-hidden bottom-margin-15-default">
                        <h3>Simpan Gambar</h3>

                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-12">
                                    <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                                </div>
                                <div class="full-width clearfix relative text-center">
                                    <button class="btn-daftar-toko full-width top-margin-15-default" id="crop">Simpan</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>