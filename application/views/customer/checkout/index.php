<!-- Content Box -->
<div class="relative clearfix full-width">
    <div class="relative container-web">
        <div class="container">
            <div class="row relative">
                <!-- Content Shoping Cart -->
                <div class="col-md-8 col-sm-12 col-xs-12 relative top-padding-default left-content-shoping clear-padding-left">
                    <p class="title-shoping-cart">Keranjang Belanja</p>
                    <?php
                    $total_qty_cart = 0;
                    $total_price_cart = 0;
                    if (count($cart) > 0) {
                        foreach ($cart as $f) {
                            $total_price_item = $f->harga * $f->qty;
                            $total_qty_cart += $f->qty;
                            $total_price_cart += $total_price_item;
                    ?>
                            <div class="relative full-width product-in-cart border no-border-l no-border-r overfollow-hidden">
                                <div class="relative product-in-cart-col-1 center-vertical-image">
                                    <img src="<?= base_url(); ?>public/img/produk/<?= $f->gambar ?>" alt="">
                                </div>
                                <div class="relative product-in-cart-col-2">
                                    <p class="title-hover-black"><a href="#" class="animate-default"><?= $f->produk ?></a></p>

                                    <h3 class="title-merchant clearfix full-width title-hover-black">
                                        <i class="fa fa-user icon-merchant"></i>
                                        <a href="#"><?= $f->toko ?></a>
                                    </h3>
                                </div>
                                <div class="relative product-in-cart-col-3">
                                    <span class="ti-close relative remove-product"></span>
                                    <p class="text-red price-shoping-cart" id="p-price-<?= $f->produk_id ?>">Rp <?= number_format($total_price_item, 0, ",", ".") ?></p>
                                    <button class="btn-sub-qty" data-id="<?= $f->produk_id ?>">-</button>
                                    <button class="btn-qty" id="p-qty-<?= $f->produk_id ?>" data-value="<?= $f->qty ?>" data-harga="<?= $f->harga ?>" data-id="<?= $f->produk_id ?>" disabled><?= $f->qty ?></button>
                                    <button class="btn-add-qty" data-id="<?= $f->produk_id ?>">+</button>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="relative full-width text-center top-margin-default">
                            <h3 style="color: #777">Keranjang belanja anda kosong</h3>
                        </div>
                    <?php } ?>

                </div>
                <!-- End Content Shoping Cart -->
                <!-- Content Right -->
                <div class="col-md-4 col-sm-12 col-xs-12 right-content-shoping top-padding-default relative clear-padding-right">
                    <p class="title-shoping-cart">Total Pembayaran</p>
                    <div class="full-width relative cart-total bg-gray  clearfix">
                        <div class="relative justify-content bottom-padding-15-default border no-border-t no-border-r no-border-l">
                            <p>Subtotal</p>
                            <p class="text-red price-shoping-cart" id="total-price-cart">Rp <?= number_format($total_price_cart, 0, ",", ".") ?></p>
                        </div>
                        <div class="relative border top-margin-15-default bottom-padding-15-default no-border-t no-border-r no-border-l">
                            <p class="bottom-margin-15-default">Pengiriman</p>
                            <div class="relative justify-content">
                                <ul class="check-box-custom title-check-box-black clear-margin clear-margin">
                                    <li>
                                        <label>Pengiriman Standar
                                            <input type="radio" name="shipping" value="25000" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                                <p class="price-sidebar">Rp 25.000</p>
                            </div>
                            <div class="relative justify-content">
                                <ul class="check-box-custom title-check-box-black clear-margin clear-margin">
                                    <li>
                                        <label>Pengiriman Kilat
                                            <input type="radio" name="shipping" value="50000">
                                            <span class="checkmark"></span>
                                        </label>
                                    </li>
                                </ul>
                                <p class="price-sidebar">Rp 50.000</p>
                            </div>
                        </div>
                        <div class="relative justify-content top-margin-15-default">
                            <p class="bold">Total</p>
                            <p class="text-red price-shoping-cart" id="total-price-final">Rp <?= number_format($total_price_cart + 25000, 0, ",", ".") ?></p>
                        </div>
                    </div>
                    <button class="btn-proceed-checkout button-hover-red full-width top-margin-15-default" id="checkout">Checkout</button>
                </div>
                <!-- End Content Right -->
            </div>
        </div>
    </div>
</div>
<!-- End Content Box -->