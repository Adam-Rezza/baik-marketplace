<!-- Content Category -->
<div class="col-md-9 relative clear-padding top-padding-default left-padding-default">
    <div class="col-sm-12 col-xs-12 relative overfollow-hidden clear-padding button-show-sidebar">
        <p onclick="showSideBar()"><span class="ti-filter"></span> Sidebar</p>
    </div>
    <div class="bar-category bottom-margin-default border no-border-r no-border-l no-border-t">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <?php if ($status == 1) { ?>
                    <p class="title-category-page clear-margin">Pesanan Masuk</p>
                <?php } else if ($status == 2) { ?>
                    <p class="title-category-page clear-margin">Pesanan Perlu Dikirim</p>
                <?php } else if ($status == 3) { ?>
                    <p class="title-category-page clear-margin">Pesanan Dikirim</p>
                <?php } else if ($status == 9) { ?>
                    <p class="title-category-page clear-margin">Pesanan Selesai</p>
                <?php } else if ($status == 10) { ?>
                    <p class="title-category-page clear-margin">Pesanan Gagal</p>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Product Content Category -->
    <div class="relative clearfix full-width" style="overflow-x: scroll">
        <table class="table" id="tableOrders">
            <thead>
                <tr>
                    <th>Pembeli</th>
                    <th>Telp Pembeli</th>
                    <th>Alamat</th>
                    <th>Total Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaction as $f) { ?>
                    <tr>
                        <td><?= $f->penerima ?></td>
                        <td><?= $f->telp_penerima ?></td>
                        <td style="max-width: 250px"><?= $f->alamat ?></td>
                        <td>
                            Rp <?= number_format($f->total_harga, 0, ",", ".") ?>
                        </td>
                        <td><button class="btn btn-sm btn-info btn-order" data-id="<?= $f->id ?>">Detail</button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        if (count($transaction) > 0 && false) { ?>
            <div class="col-md-12 clear-padding product-category left-margin-default product-category-list relative" style="color: grey">
                <?php if ($status == 1) { ?>
                    <h3>Tidak ada data</h3>
                <?php } else if ($status == 2) { ?>
                    <h3>Tidak ada data</h3>
                <?php } else if ($status == 3) { ?>
                    <h3>Tidak ada data</h3>
                <?php } else if ($status == 9) { ?>
                    <h3>Tidak ada data</h3>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <!-- End Product Content Category -->
</div>

<div class="modal fade bs-example-modal-lg out" id="modalOrderDetail" tabindex="-1" role="dialog" aria-hidden="true" style="display: none">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="relative">
                    <button type="button" class="close-modal animate-default" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="ti-close"></span>
                    </button>
                    <div class="col-md-12 relative overfollow-hidden bottom-margin-15-default">
                        <h3 class="title-modal-product">Detail Pesanan <span id="order-invoice"></span></h3>
                        <div class="col-md-12 clear-padding product-category bottom-margin-default relative">
                            <div class="col-md-6">
                                <div class="relative overfollow-hidden">
                                    <div class="top-margin-15-default" id="customer-detail"></div>
                                </div>
                            </div>
                            <div class="relative overfollow-hidden">
                                <div class="top-margin-15-default" id="list-product"></div>
                                <div class="top-margin-default">
                                    Total :
                                    <p class="price-product" id="total-price">
                                        Rp <?= number_format(100000, 0, ",", ".") ?>
                                    </p>
                                </div>
                                <div class="top-margin-default">
                                    Kurir :
                                    <b class="kurir"></b>
                                </div>
                                <div class="resi-container">
                                    Resi :
                                    <b class="resi"></b>
                                </div>
                                <div class="">
                                    Status :
                                    <?php if ($status == 1) { ?>
                                        Pesanan masuk
                                    <?php } else if ($status == 2) { ?>
                                        Pesanan Diproses
                                    <?php } else if ($status == 3) { ?>
                                        Pesanan sedang dikirim
                                    <?php } else if ($status == 9) { ?>
                                        Pesanan selesai
                                    <?php } else if ($status == 10) { ?>
                                        Pesanan dibatalkan dengan alasan
                                        <b>
                                            <p id="failed-reason">aaa</p>
                                        </b>
                                    <?php } ?>
                                    <div class="col-md-6">
                                        <div class="relative button-product-list clearfix">
                                            <?php if ($status == 1) { ?>
                                                <a href="#" class="btn animate-default btn-order-update process-order bg-orange top-margin-15-default" data-id="0">Terima Pesanan</a>
                                                <a href="#" class="btn animate-default btn-order-update cancel-order bg-grey top-margin-15-default" data-id="0">Tolak Pesanan</a>
                                            <?php } else if ($status == 2) { ?>
                                                <a href="#" class="btn animate-default btn-order-update send-order bg-orange top-margin-15-default" data-id="0">Kirim Pesanan</a>
                                            <?php } else if ($status == 3) { ?>
                                                <a href="#" class="btn animate-default btn-order-update delivered-order btn-bg-grey bg-grey top-margin-15-default" data-id="0" disabled>Sedang dikirim</a>
                                            <?php } else if ($status == 9) { ?>
                                                <a href="#" class="btn animate-default btn-order-update complete-order btn-bg-grey bg-grey top-margin-15-default" data-id="0" disabled>Selesai</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>