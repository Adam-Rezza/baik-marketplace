<!-- Content Box -->
<div class="relative clearfix full-width">
    <!-- Content Product -->
    <div class="clearfix box-product full-width top-padding-default bg-gray">
        <div class=" container">
            <div class="row ">
                <?php if (count($product_pictures) > 0 && $product != null && $product->del == 0  && $product->ban == 0) { ?>
                    <!-- Content Category -->
                    <div class="col-md-9 relative clear-padding">
                        <!-- Product Content Detail -->
                        <div class="top-product-detail relative container">
                            <div class="row">
                                <!-- Slide Product Detail -->
                                <div class="col-md-7 relative col-sm-12 col-xs-12">
                                    <div id="owl-big-slide" class="relative sync-owl-big-image">
                                        <?php foreach ($product_pictures as $f) { ?>
                                            <div class="item center-vertical-image">
                                                <img src="<?= base_url(); ?>public/img/produk/<?= $f->gambar ?>" alt="Image Big Slide">
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="relative thumbnail-slide-detail">
                                        <div id="owl-thumbnail-slide" class="sync-owl-thumbnail-image" data-items="3,4,3,2">
                                            <?php foreach ($product_pictures as $f) { ?>
                                                <div class="item center-vertical-image">
                                                    <img src="<?= base_url(); ?>public/img/produk/<?= $f->gambar ?>" alt="Image Thumbnail Slide">
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
                                        <h1 class="name-product">
                                            <?= $product->nama ?><br />
                                            <small>
                                                <?php
                                                if ($product->kategori_id == 0) {
                                                    echo 'Semua Kategori';
                                                } else {
                                                    echo $product->nama_kategori;
                                                }

                                                if ($product->sub_kategori_id != 0) {
                                                    echo ' > ' . $product->nama_sub_kategori;
                                                }
                                                ?>
                                            </small>
                                        </h1>
                                        <div class=" ranking-color ">
                                            <?php
                                            $rate = $product->rating;
                                            for ($i = 0; $i < 5; $i++) {
                                                $star = ($rate - $i >= 1) ? "star" : ($rate - $i >= 0.5 ? "star-half-o" : "star-o");
                                                echo '<i class="fa fa-' . $star . '" aria-hidden="true"></i>';
                                            }
                                            ?>
                                        </div>
                                        <p class="clearfix price-product">
                                            <span class="price-old <?= $product->disc < 1 ? "hidden" : "" ?>">Rp <?= number_format($product->harga_asli, '0', ',', '.') ?></span>
                                            Rp <?= number_format($product->harga_disc, '0', ',', '.') ?>
                                        </p>
                                    </div>
                                    <div class="relative intro-product-detail bottom-margin-15-default bottom-padding-15-default border no-border-r no-border-t no-border-l">
                                        <p class="clear-margin">
                                            <?= $product->desc ?>
                                        </p>
                                    </div>
                                    <div class="relative button-product-list clearfix full-width clear-margin text-center no-padding">
                                        <button class="btn-sub-qty" id="btn-sub-qty">-</button>
                                        <button class="btn-qty" id="btn-qty" disabled="" data-value="1">1</button>
                                        <button class="btn-add-qty" id="btn-add-qty">+</button>
                                    </div>
                                    <div class="relative button-product-list clearfix full-width clear-margin text-center no-padding">
                                        <ul class="clear-margin top-margin-default clearfix bottom-margin-default">
                                            <li class="button-hover-red"><a href="#" class="animate-default" id="add-to-cart" data-id="<?= $product->id ?>">Masukkan keranjang</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="info-product-detail bottom-margin-default relative container">
                            <div class="row">
                                <div class="col-md-6 relative overfollow-hidden">
                                    <ul class="title-tabs clearfix relative">
                                        <li onclick="changeTabsProductDetail(1)" class="title-tabs-product-detail title-tabs-1 border no-border-b active-title-tabs bold uppercase">Diskusi</li>
                                        <li onclick="changeTabsProductDetail(2)" class="title-tabs-product-detail title-tabs-2 border no-border-b bold uppercase">Review</li>
                                    </ul>
                                    <div class="content-tabs-product-detail relative content-tab-1 border active-tabs-product-detail bottom-padding-default top-padding-default left-padding-default right-padding-default discussions">
                                        <div class="msg-discuss-container full-width relative">
                                            <form action="<?= base_url() ?>insert_qna/<?= $product->id ?>" method="post" class="qna-form">
                                                <textarea class="msg-discuss-input" name="discuss-input" rows="4" placeholder="Tanya tentang produk disini.." required></textarea>
                                                <button class="btn btn-info absolute" name="btn-discuss-input">Submit</button>
                                            </form>
                                        </div>
                                        <?php if (count($qna) > 0) { ?>
                                            <?php foreach ($qna as $f) { ?>
                                                <div class="msg-discuss msg-discuss-start">
                                                    <span class="msg-sender"><i class="fa fa-user icon-merchant"></i>
                                                        <?= $f->nama ?> <?= $f->toko_id > 0 ? "<b>(Penjual)</b>" : "" ?>
                                                    </span>
                                                    <span class="msg-time"><?= date('d-M-Y H:i', strtotime($f->created)) ?></span>
                                                    <p class="msg-content"><?= nl2br($f->msg) ?>
                                                        <span class="msg-content-reply" data-id="<?= $f->id ?>">
                                                            <i class="fa fa-reply"></i>
                                                        </span>
                                                        <?php if ($this->session->userdata(SESSUSER . 'id') == $f->user_id) { ?>
                                                            <span class="msg-content-edit" data-id="<?= $f->id ?>">
                                                                <i class="fa fa-edit"></i>
                                                            </span>
                                                        <?php } ?>
                                                    </p>
                                                </div>
                                                <div class="msg-discuss-container full-width relative">
                                                    <form class="reply-qna qna-form" id="reply-qna-<?= $f->id ?>" action="<?= base_url() ?>reply_qna/<?= $product->id ?>/<?= $f->id ?>" method="post" style="display:none">
                                                        <textarea class="msg-discuss-input" name="discuss-input" rows="4" placeholder="Jawab pertanyaan ini.." required></textarea>
                                                        <button class="btn btn-info absolute" name="btn-discuss-input">Submit</button>
                                                    </form>
                                                </div>
                                                <?php if ($this->session->userdata(SESSUSER . 'id') == $f->user_id) { ?>
                                                    <div class="msg-discuss-container full-width relative">
                                                        <form class="edit-qna qna-form" id="edit-qna-<?= $f->id ?>" action="<?= base_url() ?>edit_qna/<?= $product->id ?>/<?= $f->id ?>" method="post" style="display:none">
                                                            <textarea class="msg-discuss-input" name="discuss-input" rows="4" placeholder="" required><?= $f->msg ?></textarea>
                                                            <button class="btn btn-info absolute" name="btn-discuss-input">Submit</button>
                                                        </form>
                                                    </div>
                                                <?php } ?>
                                                <?php foreach ($reply_qna[$f->id] as $g) { ?>
                                                    <div class="msg-discuss msg-discuss-reply">
                                                        <span class="msg-sender"><i class="fa fa-user icon-merchant"></i>
                                                            <?= $g->nama ?> <?= $g->toko_id > 0 ? "<b>(Penjual)</b>" : "" ?>
                                                        </span>
                                                        <span class="msg-time"><?= date('d-M-Y H:i', strtotime($g->created)) ?></span>
                                                        <p class="msg-content"><?= nl2br($g->msg) ?>
                                                            <?php if ($this->session->userdata(SESSUSER . 'id') == $g->user_id) { ?>
                                                                <span class="msg-content-edit-reply" data-id="<?= $g->id ?>">
                                                                    <i class="fa fa-edit"></i>
                                                                </span>
                                                            <?php } ?>
                                                        </p>
                                                    </div>
                                                    <?php if ($this->session->userdata(SESSUSER . 'id') == $g->user_id) { ?>
                                                        <div class="msg-discuss-container full-width relative">
                                                            <form class="edit-qna qna-form" id="edit-qna-<?= $g->id ?>" action="<?= base_url() ?>edit_qna/<?= $product->id ?>/<?= $g->id ?>" method="post" style="display:none">
                                                                <textarea class="msg-discuss-input" name="discuss-input" rows="4" placeholder="" required><?= $g->msg ?></textarea>
                                                                <button class="btn btn-info absolute" name="btn-discuss-input">Submit</button>
                                                            </form>
                                                        </div>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <div class="text-center top-padding-default">Belum ada pertanyaan</div>
                                        <?php } ?>
                                    </div>
                                    <div class="content-tabs-product-detail relative content-tab-2 border bottom-padding-default top-padding-default left-padding-default right-padding-default reviews">
                                        <div class="msg-discuss-container full-width relative">
                                            <span class="msg-content-star-input">
                                                <i class="fa fa-star-o star-input" id="star-1" data-id="1" aria-hidden="true"></i>
                                                <i class="fa fa-star-o star-input" id="star-2" data-id="2" aria-hidden="true"></i>
                                                <i class="fa fa-star-o star-input" id="star-3" data-id="3" aria-hidden="true"></i>
                                                <i class="fa fa-star-o star-input" id="star-4" data-id="4" aria-hidden="true"></i>
                                                <i class="fa fa-star-o star-input" id="star-5" data-id="5" aria-hidden="true"></i>
                                            </span>
                                            <form action="<?= base_url() ?>insert_review/<?= $product->id ?>" method="post" enctype="multipart/form-data" data-qualified="<?= $review_qualified > 0 ? true : false ?>" id="form-review">
                                                <select class="" name="star-review" id="star-input" required>
                                                    <option value="">Pilih tingkat kepuasan</option>
                                                    <option value="1"><i class="fa fa-star-o"></i></option>
                                                    <option value="2"><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></option>
                                                    <option value="3"><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></option>
                                                    <option value="4"><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></option>
                                                    <option value="5"><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i></option>
                                                </select>
                                                <textarea class="msg-review-input" name="msg-review" rows="4" placeholder="Tulis penilaian anda.." required></textarea>
                                                <input class="hidden" type="file" name="image-review" id="image-review" />
                                                <button class="btn btn-sm btn-info absolute" id="btn-discuss-input-camera" onclick="return false">
                                                    <i class="fa fa-camera" aria-hidden="true"></i>
                                                </button>
                                                <button class="btn btn-sm btn-info absolute">Submit</button>
                                            </form>
                                        </div>

                                        <?php if (count($review) > 0) { ?>
                                            <?php foreach ($review as $f) { ?>
                                                <div class="msg-discuss msg-discuss-start">
                                                    <span class="msg-sender"><i class="fa fa-user icon-merchant"></i> Aang</span>
                                                    <span class="msg-time"><?= date('d-M-Y H:i', strtotime($f->created)) ?></span>
                                                    <p class="msg-review"><?= $f->msg ?>
                                                        <span class="msg-review-star">
                                                            <?php
                                                            $rateReview = $f->rating;
                                                            for ($i = 0; $i < 5; $i++) {
                                                                $star = ($rateReview - $i >= 1) ? "star" : "star-o";
                                                                echo '<i class="fa fa-' . $star . '" aria-hidden="true"></i>';
                                                            }
                                                            ?>
                                                        </span>
                                                    </p>
                                                    <?php if ($f->gambar) { ?>
                                                        <img class="img-review" style="max-width: 20%; display: block" src="<?= base_url('public/img/review/' . $f->gambar) ?>">
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <div class="text-center top-padding-default">Belum ada review</div>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Product Content Category -->
                    </div>
                <?php } else { ?>
                    <div class="clearfix content-product-box full-width">
                        <div class="col-sm-12 product-category padding-5 text-grey" style="min-height: 400px">
                            <h2>Produk tidak di temukan</h2>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- End Content Product -->
</div>
<!-- End Content Box -->