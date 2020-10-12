<!-- Content Box -->
<div class="relative clearfix full-width">
    <!-- Menu & Slide -->
    <div class="clearfix container-web relative">
        <div class=" container relative">
            <div class="row">
                <div class="clearfix relative menu-slide clear-padding bottom-margin-default">
                    <div class="clearfix slide-box-home slide-v1 relative">
                        <div class="clearfix slide-home owl-carousel owl-theme">
                            <?php foreach ($banner as $f) { ?>
                                <div class="item">
                                    <img src="<?= base_url() ?>public/img/banner/<?= $f->gambar ?>" alt="Banner">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Product -->
    <div class="clearfix box-product full-width top-padding-default bg-gray">
        <div class=" container">
            <div class="row ">
                <!-- Content Category -->
                <div class="col-md-12 relative">

                    <div class="bar-category bottom-margin-default border no-border-r no-border-l no-border-t">
                        <div class="row">
                            <div class="col-md-5 col-sm-5 col-xs-4">
                                <p class="title-category-page clear-margin">Kategori</p>
                            </div>
                        </div>
                    </div>
                    <!-- Product Content Category -->
                    <div class="row">
                        <div class="clearfix title-box full-width border">
                            <div class="category-image float-left border">
                                <div class="owl-carousel owl-theme owl-loaded owl-drag">
                                    <div class="owl-stage-outer">
                                        <div class="owl-stage" style="transform: translate3d(-742px, 0px, 0px); transition: all 0.25s ease 0s; width: 2043px;">
                                            <?php foreach ($category as $f) { ?>
                                                <div class="owl-item" style="width: 185.667px;">
                                                    <div class=" category-image-slide relative full-width">
                                                        <div class="clearfix effect-hover-zoom overfollow-hidden img-categorys-slide center-vertical-image relative">
                                                            <img class="animate-default" src="<?= base_url() ?>public\img\kategori\<?= $f->gambar ?>" alt="<?= $f->nama ?>">
                                                            <a href="<?= base_url('category=' . $f->id . '%26page=1') ?>"></a>
                                                        </div>
                                                        <a href="#">
                                                            <p class="uppercase bold"><?= $f->nama ?></p>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="owl-nav disabled">
                                        <button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>
                                    </div>
                                    <div class="owl-dots disabled"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Product Content Category -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Content Product -->
    <!-- Content Product -->
    <div class="clearfix box-product full-width top-padding-default bg-gray">
        <div class=" container">
            <div class="row">
                <!-- Title Product -->
                <div class="clearfix title-box full-width bottom-margin-default border bg-white">
                    <div class="clearfix name-title-box title-hot-bg relative">
                        <img src="<?= base_url(); ?>public/megastore/img/icon_percent.png" class="absolute" alt="Icon Hot Deals" />
                        <p class="category-title">DISKON!!</p>
                    </div>
                </div>
            </div>
            <div class="clearfix content-product-box full-width">
                <div class="row">
                    <div class="slide-product col-lg-4 col-md-12 col-sm-12 col-xs-12 product-category padding-5">
                        <div class="owl-carousel owl-theme owl-loaded owl-drag">
                            <div class="owl-stage-outer">
                                <div class="owl-stage" style="transform: translate3d(-742px, 0px, 0px); transition: all 0.25s ease 0s; width: 2043px;">
                                    <?php foreach ($sponsored as $f) { ?>
                                        <div class="owl-item">
                                            <div class="product-card relative effect-hover-boxshadow animate-default" data-id="<?= $f->id ?>">
                                                <div class="relative overfollow-hidden">
                                                    <a href="<?= base_url() ?>product/<?= $f->id ?>">
                                                        <div class="center-vertical-image">
                                                            <img src="<?= base_url(); ?>public/img/produk/<?= $f->gambar ?>" alt="Product">
                                                        </div>
                                                    </a>
                                                </div>
                                                <h3 class="title-product clearfix full-width title-hover-black">
                                                    <a href="<?= base_url() ?>product/<?= $f->id ?>"><?= $f->nama ?></a>
                                                    <?php if ($f->terjual) { ?>
                                                        <span class="product-sold float-right">(<?= $f->terjual ?> Terjual)</span>
                                                    <?php } ?>
                                                </h3>
                                                <div class="desc-slide-product clearfix full-width title-hover-black">
                                                    <p><?= $f->desc ?></p>
                                                </div>
                                                <h3 class="title-merchant clearfix full-width title-hover-black">
                                                    <i class="fa fa-user icon-merchant"></i>
                                                    <a href="<?= base_url() ?>merchant_detail/<?= $f->toko_id ?>"><?= $f->toko ?></a>
                                                </h3>
                                                <p class="clearfix price-product-slide-product">
                                                    <span class="price-old-slide-product">Rp <?= number_format($f->harga_asli, 0, ",", ".") ?></span>
                                                    <span class="price-new-slide-product">Rp <?= number_format($f->harga_disc, 0, ",", ".") ?></span>
                                                </p>
                                                <div class="clearfix ranking-product-category ranking-color">
                                                    <?php
                                                    $rate = $f->rating;
                                                    for ($i = 0; $i < 5; $i++) {
                                                        $star = ($rate - $i >= 1) ? "star" : ($rate - $i >= 0.5 ? "star-half-o" : "star-o");
                                                        echo '<i class="fa fa-' . $star . '" aria-hidden="true"></i>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="owl-nav disabled">
                                <button type="button" role="presentation" class="owl-prev" style="display:none"><span aria-label="Previous">‹</span></button><button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>
                            </div>
                            <div class="owl-dots disabled"></div>
                        </div>
                    </div>
                    <?php foreach ($sponsored as $f) { ?>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-6 product-category padding-5">
                            <div class="product-card relative effect-hover-boxshadow animate-default" data-id="<?= $f->id ?>">
                                <div class="image-product relative overfollow-hidden">
                                    <a href="<?= base_url() ?>product/<?= $f->id ?>">
                                        <div class="center-vertical-image">
                                            <img src="<?= base_url(); ?>public/img/produk/<?= $f->gambar ?>" alt="Product">
                                        </div>
                                    </a>
                                </div>
                                <h3 class="title-product clearfix full-width title-hover-black">
                                    <a href="<?= base_url() ?>product/<?= $f->id ?>"><?= $f->nama ?></a>
                                    <?php if ($f->terjual) { ?>
                                        <span class="product-sold float-right">(<?= $f->terjual ?> Terjual)</span>
                                    <?php } ?>
                                </h3>
                                <h3 class="title-merchant clearfix full-width title-hover-black">
                                    <i class="fa fa-user icon-merchant"></i>
                                    <a href="<?= base_url() ?>merchant_detail/<?= $f->toko_id ?>"><?= $f->toko ?></a>
                                </h3>
                                <p class="clearfix price-product">
                                    <span class="price-old-sponsored">Rp <?= number_format($f->harga_asli, 0, ",", ".") ?></span>
                                    <span class="price-new-sponsored">Rp <?= number_format($f->harga_disc, 0, ",", ".") ?></span>
                                </p>
                                <div class="clearfix ranking-product-category ranking-color">
                                    <?php
                                    $rate = $f->rating;
                                    for ($i = 0; $i < 5; $i++) {
                                        $star = ($rate - $i >= 1) ? "star" : ($rate - $i >= 0.5 ? "star-half-o" : "star-o");
                                        echo '<i class="fa fa-' . $star . '" aria-hidden="true"></i>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="pagging relative">
                        <ul>
                            <li><a href="<?= base_url() ?>discount%26page=1">Lebih banyak <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content Product -->
    <!-- Content Product -->
    <div class="clearfix box-product full-width top-padding-default bg-gray">
        <div class=" container">
            <div class="row">
                <!-- Title Product -->
                <div class="clearfix title-box full-width bottom-margin-default border bg-white">
                    <div class="clearfix name-title-box title-hot-bg relative">
                        <img src="<?= base_url(); ?>public/megastore/img/love.png" class="absolute" alt="Icon Hot Deals" />
                        <p class="category-title">Produk Terbaru</p>
                    </div>
                </div>
            </div>
            <div class="clearfix content-product-box full-width">
                <div class="row">
                    <?php foreach ($latest as $f) { ?>
                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 product-category padding-5">
                            <div class="product-card relative effect-hover-boxshadow animate-default" data-id="<?= $f->id ?>">
                                <div class="image-product relative overfollow-hidden">
                                    <a href="<?= base_url() ?>product/<?= $f->id ?>">
                                        <div class="center-vertical-image">
                                            <img src="<?= base_url() ?>public/img/produk/<?= $f->gambar ?>" alt="Product">
                                        </div>
                                    </a>
                                </div>
                                <h3 class="title-product clearfix full-width title-hover-black">
                                    <a href="<?= base_url() ?>product/<?= $f->id ?>"><?= $f->nama ?></a>
                                </h3>
                                <h3 class="title-merchant clearfix full-width title-hover-black">
                                    <i class="fa fa-user icon-merchant"></i>
                                    <a href="<?= base_url() ?>merchant_detail/<?= $f->toko_id ?>"><?= $f->toko ?></a>
                                </h3>
                                <p class="clearfix price-product">
                                    <span class="price-old">Rp <?= number_format($f->harga_asli, 0, ",", ".") ?></span>
                                    <span class="price-new">Rp <?= number_format($f->harga_disc, 0, ",", ".") ?></span>
                                </p>
                                <div class="clearfix ranking-product-category ranking-color">
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="pagging relative">
                        <ul>
                            <li><a href="<?= base_url() ?>latest%26page=1">Lebih banyak <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content Product -->
</div>
<!-- End Content Box -->