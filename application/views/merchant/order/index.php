<!-- Content Category -->
<div class="col-md-9 relative clear-padding top-padding-default left-padding-default">
    <div class="col-sm-12 col-xs-12 relative overfollow-hidden clear-padding button-show-sidebar">
        <p onclick="showSideBar()"><span class="ti-filter"></span> Sidebar</p>
    </div>
    <div class="bar-category bottom-margin-default border no-border-r no-border-l no-border-t">
        <div class="row">
            <div class="col-md-5 col-sm-5 col-xs-4">
            <?php if($status == 1) { ?>
                <p class="title-category-page clear-margin">Pesanan masuk</p>
            <?php } else if($status == 2) { ?>
                <p class="title-category-page clear-margin">Pesanan Perlu Dikirim</p>
            <?php } else if($status == 3) { ?>
                <p class="title-category-page clear-margin">Pesanan Dikirim</p>
            <?php } else if($status == 9) { ?>
                <p class="title-category-page clear-margin">Pesanan selesai</p>
            <?php } ?>
            </div>
        </div>
    </div>
    <!-- Product Content Category -->
    <div class="relative clearfix">
        <?php
        if (count($transaction) > 0) {
        ?>
            <?php
            foreach ($transaction as $f) {
                $total_price = 0;
            ?>
                <div class="col-md-12 clear-padding border no-border-t no-border-l no-border-r product-category bottom-margin-default product-category-list relative">
                    <div class="relative overfollow-hidden info-product-list right-padding-default">
                        <?php foreach ($order[$f->id] as $g) { ?>
                            <div style="clear: both">
                                <p class="float-left"><?= $g->produk ?></p>
                                <p class="float-right">(x<?= $g->qty ?>)</p>
                            </div>
                        <?php
                            $total_price += $g->harga * $g->qty;
                        }
                        ?>
                    </div>
                    <div class="relative overfollow-hidden info-product-list left-margin-default">
                        Total:
                        <p class="clearfix price-product">
                            Rp <?= number_format($total_price, 0, ",", ".") ?>
                        </p>
                        <p class="intro-product-category"><?= $f->alamat ?></p>
                        <div class="relative button-product-list clearfix">
                            <ul class="clear-margin">
                                <?php if($status == 1) { ?>
                                    <li class=""><a href="#" class="animate-default process-order" data-id="<?= $f->id ?>">Terima Pesanan</a></li>
                                <?php } else if($status == 2) { ?>
                                    <li class=""><a href="#" class="animate-default send-order" data-id="<?= $f->id ?>">Kirim Pesanan</a></li>
                                <?php } else if($status == 3) { ?>
                                    <li class=""><a href="#" class="animate-default delivered-order btn-bg-grey" data-id="<?= $f->id ?>" disabled>Sedang dikirim</a></li>
                                <?php } else if($status == 9) { ?>
                                    <li class=""><a href="#" class="animate-default complete-order btn-bg-grey" data-id="<?= $f->id ?>" disabled>Selesai</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="col-md-12 clear-padding product-category left-margin-default product-category-list relative" style="color: grey">
                <?php if($status == 1) { ?>
                    <h3>Tidak ada data</h3>
                <?php } else if($status == 2) { ?>
                    <h3>Tidak ada data</h3>
                <?php } else if($status == 3) { ?>
                    <h3>Tidak ada data</h3>
                <?php } else if($status == 9) { ?>
                    <h3>Tidak ada data</h3>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <!-- End Product Content Category -->
</div>
