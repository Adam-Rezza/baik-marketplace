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
                                <div class="relative product-in-cart-col-3" style="min-width: 110px;">
                                    <span class="ti-close relative remove-product"></span>
                                    <input type="text" class="variasi-<?= $f->id ?> hidden" data-value='<?= $f->variasi_id ?>' value='<?= $f->variasi_id ?>'>
                                    <p class="text-red price-shoping-cart" id="p-price-<?= $f->id ?>">Rp <?= number_format($total_price_item, 0, ",", ".") ?></p>
                                    <button class="btn-sub-qty" data-id="<?= $f->id ?>">-</button>
                                    <button class="btn-qty" id="p-qty-<?= $f->id ?>" data-value="<?= $f->qty ?>" data-harga="<?= $f->harga ?>" data-product-id="<?= $f->produk_id ?>" data-cart-id="<?= $f->id ?>" disabled><?= $f->qty ?></button>
                                    <button class="btn-add-qty" data-id="<?= $f->id ?>">+</button>
                                    <a class="btn bg-orange btn-delete-cart top-margin-15-default" href="<?= base_url('delete_cart/') . $f->id ?>"><b>Hapus</b></a>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="relative full-width text-center top-margin-default">
                            <h3 style="color: #777">Keranjang belanja anda kosong</h3>
                        </div>
                    <?php } ?>

                    <div class="text-center top-margin-15-default">
                        <a class="btn-daftar-toko" href="<?= base_url() ?>">Lanjut Belanja</a>
                    </div>

                </div>
                <!-- End Content Shoping Cart -->
                <!-- Content Right -->
                <form id="form_checkout">
                    <div class="col-md-4 col-sm-12 col-xs-12 right-content-shoping top-padding-default relative clear-padding-right">
                        <p class="title-shoping-cart">Total Pembayaran</p>
                        <div class="full-width relative cart-total bg-gray clearfix">
                            <div class="relative justify-content bottom-padding-15-default border no-border-t no-border-r no-border-l">
                                <p>Subtotal</p>
                                <p class="text-red price-shoping-cart" id="total-price-cart">Rp <?= number_format($total_price_cart, 0, ",", ".") ?></p>
                            </div>
                            <div class="relative border top-margin-15-default bottom-padding-15-default no-border-t no-border-r no-border-l">
                                <p class="bottom-margin-15-default">Pengiriman</p>
                                <?php
                                foreach ($arr_ekspedisi as $k) {
                                ?>
                                    <div class="relative justify-content">
                                        <div class="form-input full-width clearfix relative" style="margin-top: 10px;">
                                            <?= '<p>' . $k['nama_toko'] . '</p>'; ?>
                                            <input type="hidden" name="id_toko[]" value="<?= $k['toko_id']; ?>">
                                            <select class="select2" name="id_ekspedisi[]" data-placeholder="Pilih Ekspedisi" required>
                                                <option value=""></option>
                                                <?php
                                                foreach ($k['ekspedisi'] as $kk) {
                                                    echo '<option value="' . $kk['id_ekspedisi'] . '">' . $kk['nama_ekspedisi'] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <div class="relative justify-content top-margin-15-default">
                                <p class="bold">Total</p>
                                <p class="text-red price-shoping-cart" id="total-price-final">Rp <?= number_format($total_price_cart, 0, ",", ".") ?></p>
                            </div>
                            <div class="relative justify-content top-margin-15-default">
                                <p class="bold">Saldo</p>
                                <p class="text-red price-shoping-cart" id="total-price-final">
                                    Rp <?= number_format($this->session->userdata(SESSUSER . 'saldo'), 0, ',', '.'); ?>
                                </p>
                            </div>
                            <div class="relative justify-content top-margin-15-default">
                                <p class="bold">Sisa Saldo</p>
                                <p class="text-red price-shoping-cart" id="total-price-final">
                                    Rp
                                    <?php
                                    $total = $total_price_cart;
                                    $saldo = $this->session->userdata(SESSUSER . 'saldo');
                                    $gt = $saldo - $total;
                                    echo number_format($gt, 0, ',', '.');
                                    ?>
                                </p>
                            </div>
                        </div>
                        <button type="submit" class="btn-proceed-checkout button-hover-red full-width top-margin-15-default" id="checkout">Checkout</button>
                    </div>
                </form>
                <!-- End Content Right -->
            </div>
        </div>
    </div>
</div>
<!-- End Content Box -->