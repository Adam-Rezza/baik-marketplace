
<!-- Content Box -->
<div class="relative clearfix full-width">
    <!-- Content Product -->
    <div class="clearfix box-product full-width top-padding-default bg-gray">
        <div class=" container">
            <div class="row ">
                <!-- Content Category -->
                <div class="col-md-9 relative clear-padding">
                    <!-- Product Content Detail -->
                    <div class="top-product-detail relative container">
                        <div class="row">
                            <!-- Slide Product Detail -->
                            <div class="col-md-7 relative col-sm-12 col-xs-12">
                                <div id="owl-big-slide" class="relative sync-owl-big-image">
                                    <?php foreach($product_pictures as $f){ ?>
                                        <div class="item center-vertical-image">
                                            <img src="<?=base_url();?>public/img/produk/<?=$f->gambar?>" alt="Image Big Slide">
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="relative thumbnail-slide-detail">
                                    <div id="owl-thumbnail-slide" class="sync-owl-thumbnail-image" data-items="3,4,3,2">
                                        <?php foreach($product_pictures as $f){ ?>
                                            <div class="item center-vertical-image">
                                                <img src="<?=base_url();?>public/img/produk/<?=$f->gambar?>" alt="Image Thumbnail Slide">
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="relative nav-prev-detail btn-slide-detail"></div>
                                    <div class="relative nav-next-detail btn-slide-detail"></div>
                                </div>
                            </div>
                            <!-- Info Top Product -->
                            <div class="col-md-5 col-sm-12 col-xs-12">
                                <div class="name-ranking-product relative bottom-padding-15-default bottom-margin-15-default border no-border-r no-border-t no-border-l">
                                    <h1 class="name-product"><?=$product->nama?></h1>
                                    <div class=" ranking-color ">
                                        <?php 
                                            $rate = $product->rating;
                                            for($i = 0; $i < 5; $i++){
                                                $star = ($rate - $i >= 1) ? "star" : ($rate - $i >= 0.5 ? "star-half" : "star-o");
                                                echo '<i class="fa fa-'.$star.'" aria-hidden="true"></i>';
                                            }
                                        ?>
                                    </div>
                                    <p class="clearfix price-product">
                                        <span class="price-old">Rp <?=number_format($product->harga_asli, '0', ',', '.')?></span> 
                                        Rp <?=number_format($product->harga_disc, '0', ',', '.')?>
                                    </p>
                                </div>
                                <div class="relative intro-product-detail bottom-margin-15-default bottom-padding-15-default border no-border-r no-border-t no-border-l">
                                    <p class="clear-margin">Meet the iPhone X - the device that’s so smart that it responds to a tap, your voice, and even a glance. Elegantly designed with a large 14.73 cm (5.8) Super Retina screen and a durable front-and-back glass, this smartphone is designed to impress. What’s more, you can charge this iPhone wirelessly.</p>
                                </div>
                                <div class="relative button-product-list clearfix full-width clear-margin text-center no-padding">
                                    <button class="btn-sub-qty" id="btn-sub-qty">-</button>
                                    <button class="btn-qty" id="btn-qty" disabled="" data-value="1">1</button>
                                    <button class="btn-add-qty" id="btn-add-qty">+</button>
                                </div>
                                <div class="relative button-product-list clearfix full-width clear-margin text-center no-padding">                                  
                                    <ul class="clear-margin top-margin-default clearfix bottom-margin-default">
                                        <li class="button-hover-red"><a href="#" class="animate-default" id="add-to-cart" data-id="<?=$product->id?>">Masukkan keranjang</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="info-product-detail bottom-margin-default relative container">
                        <div class="row">
                            <div class="col-md-12 relative overfollow-hidden">
                                <ul class="title-tabs clearfix relative">
                                    <li onclick="changeTabsProductDetail(1)" class="title-tabs-product-detail title-tabs-1 border no-border-b active-title-tabs bold uppercase">Diskusi</li>
                                    <li onclick="changeTabsProductDetail(2)" class="title-tabs-product-detail title-tabs-2 border no-border-b bold uppercase">Review</li>
                                </ul>
                                <div class="content-tabs-product-detail relative content-tab-1 border active-tabs-product-detail bottom-padding-default top-padding-default left-padding-default right-padding-default discussions">
                                    <div class="msg-discuss msg-discuss-start">
                                        <span class="msg-sender"><i class="fa fa-user icon-merchant"></i> Zuko Firelord</span>
                                        <span class="msg-time">28 Agustus 2020 10:55</span>
                                        <p class="msg-content">Lorem Ipsum Dolor <span class="msg-content-reply"><i class="fa fa-reply"></i></span></p>
                                    </div>
                                    <div class="msg-discuss msg-discuss-reply">
                                        <span class="msg-sender"><i class="fa fa-user icon-merchant"></i> Aang</span>
                                        <span class="msg-time">28 Agustus 2020 10:55</span>
                                        <p class="msg-content">Lorem Ipsum Dolor</p>
                                    </div>
                                    <div class="msg-discuss msg-discuss-reply">
                                        <span class="msg-sender"><i class="fa fa-user icon-merchant"></i> Aang</span>
                                        <span class="msg-time">28 Agustus 2020 10:55</span>
                                        <p class="msg-content">Lorem Ipsum Dolor</p>
                                    </div>
                                    <div class="msg-discuss msg-discuss-start">
                                        <span class="msg-sender"><i class="fa fa-user icon-merchant"></i> Uncle Iroh</span>
                                        <span class="msg-time">28 Agustus 2020 10:55</span>
                                        <p class="msg-content">Lorem Ipsum Dolor <span class="msg-content-reply"><i class="fa fa-reply"></i></span></p>
                                    </div>
                                    <div class="msg-discuss msg-discuss-reply">
                                        <span class="msg-sender"><i class="fa fa-user icon-merchant"></i> Aang</span>
                                        <span class="msg-time">28 Agustus 2020 10:55</span>
                                        <p class="msg-content">Lorem Ipsum Dolor</p>
                                    </div>
                                    <div class="msg-discuss msg-discuss-start">
                                        <span class="msg-sender"><i class="fa fa-user icon-merchant"></i> Albert</span>
                                        <span class="msg-time">28 Agustus 2020 10:55</span>
                                        <p class="msg-content">Lorem Ipsum Dolor <span class="msg-content-reply"><i class="fa fa-reply"></i></span></p>
                                    </div>
                                    <div class="msg-discuss msg-discuss-reply">
                                        <span class="msg-sender"><i class="fa fa-user icon-merchant"></i> Aang</span>
                                        <span class="msg-time">28 Agustus 2020 10:55</span>
                                        <p class="msg-content">Lorem Ipsum Dolor</p>
                                    </div>
                                </div>
                                <div class="content-tabs-product-detail relative content-tab-2 border bottom-padding-default top-padding-default left-padding-default right-padding-default reviews">
                                    <div class="msg-discuss msg-discuss-start">
                                        <span class="msg-sender"><i class="fa fa-user icon-merchant"></i> Aang</span>
                                        <span class="msg-time">28 Agustus 2020 10:55</span>
                                        <p class="msg-content">Lorem Ipsum Dolor
                                            <span class="msg-content-star">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="msg-discuss msg-discuss-start">
                                        <span class="msg-sender"><i class="fa fa-user icon-merchant"></i> Aang</span>
                                        <span class="msg-time">28 Agustus 2020 10:55</span>
                                        <p class="msg-content">Lorem Ipsum Dolor
                                            <span class="msg-content-star">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="msg-discuss msg-discuss-start">
                                        <span class="msg-sender"><i class="fa fa-user icon-merchant"></i> Aang</span>
                                        <span class="msg-time">28 Agustus 2020 10:55</span>
                                        <p class="msg-content">Lorem Ipsum Dolor
                                            <span class="msg-content-star">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                                <i class="fa fa-star-o" aria-hidden="true"></i>
                                            </span>
                                        </p>
                                    </div>
                                    
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
</div>
<!-- End Content Box -->