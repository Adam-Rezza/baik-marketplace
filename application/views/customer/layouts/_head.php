<head>
    <title><?= $title ?></title>
    <meta name="format-detection" content="telephone=no">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat%7CRoboto:100,300,400,500,700,900%7CRoboto+Condensed:100,300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/icon-font-linea.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/style.css?12">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/effect.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/home.css?12">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/owl.theme.default.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/multirange.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/category.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/product.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/cartpage.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous" />

    <!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/icon-font-linea.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/multirange.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/bootstrap-theme.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/themify-icons.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/effect.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/product.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/slick.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/slick-theme.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/category.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/owl.theme.default.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/owl.carousel.min.css">
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>public/megastore/css/responsive.css"> -->
</head>
<style>
    p {
        margin: 0;
    }

    .clearfix .logo img {
        height: 38px;
        width: auto;
        overflow-x: hidden;
    }

    .category-image {
        width: 100%;
    }

    .category-title,
    .name-title-box {
        font-size: 20px !important;
    }

    .title-product a {
        text-transform: none;
        display: inline-block;
    }

    .title-merchant {
        margin: 0px;
        line-height: 10px;
    }

    .title-merchant a {
        font-weight: none;
        color: #2b2b2b;
        font-size: 12px;
        display: inline-block;
        letter-spacing: 0.25px;
        margin: 0px;
    }

    .title-merchant .icon-merchant {
        font-size: small;
    }

    .slide-v1 {
        width: auto;
        max-width: 1170px;
    }

    .product-sold {
        font-size: 11px;
        position: absolute;
        right: 5px;
    }

    .image-product {
        margin-bottom: 0px;
    }

    .btn-sub-qty,
    .btn-add-qty,
    .btn-qty {
        width: 30px;
        height: 30px;
        font-size: 20px;
        text-align: center;
        font-weight: bold;
    }

    .btn-qty {
        width: 30px;
        font-weight: normal !important;
    }

    .product-sold {
        font-size: 11px;
    }

    .image-product {
        margin-bottom: 0px;
    }

    .menu-web>ul li p,
    .menu-mobile-left-content>ul li p {
        padding-left: 30px;
    }

    .menu_more_header {
        display: none;
        height: auto;
        /* top: 181px;
        left: 24px; */
    }

    .subCategory {
        display: none;
    }

    .optGroup {
        font-weight: bold;
    }

    .price-old {
        font-size: 14px;
    }

    .price-new {
        font-size: 16px;
    }

    .price-old-sponsored {
        font-size: 10px;
        color: #959595;
        text-decoration: line-through;
    }

    .price-new-sponsored {
        font-size: 14px;
    }

    .price-product {
        height: auto;
        line-height: 10px;
    }

    .ranking-product-category {
        position: absolute;
        bottom: 5px;
        right: 15px;
    }

    .product-card {
        background-color: #fff;
        padding: 15px;
        border-radius: 5px;
    }

    .price-product-slide-product {
        height: auto;
        line-height: 10px;
        color: #fe6600;
        font-size: 20px;
        letter-spacing: -0.25px;
        font-family: 'Roboto Condensed', sans-serif;
    }

    .price-old-slide-product {
        font-size: 16px;
        color: #959595;
        text-decoration: line-through;
    }

    .price-new-slide-product {
        font-size: 20px;
    }

    .price-product-slide-product {
        height: auto;
        line-height: 10px;
    }

    .desc-slide-product {
        font-size: 13px;
        height: 64px;
        overflow: hidden;
    }

    .padding-5 {
        padding-left: 5px;
        padding-right: 5px;
        padding-bottom: 5px;
    }

    .msg-discuss {
        padding: 25px 10px 0px 10px;
        border: 1px solid #999999;
        border-radius: 20px;
        margin-top: 10px;
        margin-bottom: 10px;
        position: relative;
    }

    .msg-discuss:first-child() {
        margin-top: none;
    }

    .msg-discuss-start {
        background-color: #fff;
    }

    .msg-discuss-reply {
        margin-left: 25px;
        background-color: #659dfc;
        color: #fff;
    }

    .msg-discuss-reply:nth-child(2n) {
        background-color: #659dfc;
    }

    .msg-discuss-input {
        padding: 10px 90px 10px 10px;
        border: 1px solid #666;
        border-radius: 20px;
        width: 100%;
        resize: none;
        margin: 0px;
        position: relative;
        line-height: 16px;
    }

    .msg-discuss-input:focus {
        border: 1px solid #fff;
        border-radius: 20px;
    }

    .msg-review-input {
        padding: 10px 120px 10px 10px;
        border: 1px solid #666;
        border-radius: 20px;
        width: 100%;
        resize: none;
        margin: 0px;
        position: relative;
        line-height: 16px;
    }

    .msg-review-input:focus {
        border: 1px solid #fff;
        border-radius: 20px;
    }

    .msg-discuss-container {
        position: relative;
    }

    .msg-discuss-container button {
        bottom: 18px;
        right: 9px;
        border-radius: 10px;
    }

    .msg-discuss-container #btn-discuss-input-camera {
        bottom: 18px;
        right: 75px;
        border-radius: 10px;
    }

    .msg-sender {
        float: left;
        position: absolute;
        top: 5px;
        left: 12px;
        font-size: 12px;
    }

    .msg-time {
        float: right;
        position: absolute;
        top: 5px;
        right: 12px;
        font-size: 12px;
    }

    .msg-content {
        clear: both;
        bottom: 0px;
        line-height: 16px;
        padding-bottom: 10px;
    }

    .msg-content-reply,
    .msg-content-edit-reply {
        position: absolute;
        bottom: 5px;
        right: 12px;
    }

    .msg-content-edit {
        position: absolute;
        bottom: 5px;
        right: 32px;
    }

    .msg-content-star {
        position: absolute;
        bottom: 5px;
        right: 12px;
        color: #f68e56;
    }

    .msg-content-star-input {
        color: #f68e56;
        font-size: 25px;
        cursor: pointer;
    }

    #star-input {
        position: absolute;
        top: 40px;
        width: 0;
        height: 0;
        display: block;
        top: 10px;
        border: none;
    }

    #star-input:focus {
        z-index: -99;
        border: 1px solid black;
    }

    .msg-content-edit:hover,
    .msg-content-edit-reply:hover,
    .msg-content-reply:hover {
        cursor: pointer;
    }

    .msg-review {
        clear: both;
        bottom: 0px;
        line-height: 16px;
        padding-bottom: 10px;
        display: inline-block;
    }

    .img-review {
        max-width: 20%;
        display: block;
        padding-bottom: 10px;
    }

    .msg-review-star {
        position: absolute;
        bottom: 5px;
        right: 12px;
        color: #f68e56;
    }

    .btn-daftar-toko {
        border: none;
        outline: none;
        font-size: 20px;
        background: #ff6600;
        color: #fff;
        line-height: 30px;
        text-transform: none;
        width: auto;
        padding: 5px 10px;
        border-radius: 10px;
    }

    .btn-daftar-toko:hover {
        background: #c14e00;
    }

    .form-input .auth-redirect {
        clear: both;
        display: block;
        margin-top: 10px;
    }

    .form-input input[type="text"]:disabled {
        background: #dedede;
    }

    .form-input input.error,
    .form-input textarea.error {
        border: 1px solid #ff0000;
    }

    .form-input label.error,
    .form-input .input-group label.error {
        bottom: -20px;
        position: absolute;
        right: 0;
        width: auto !important;
    }

    .form-input label.error {
        color: #ff0000;
        font-size: 12px;
        margin: 0px;
        float: right;
        clear: both;
        display: block;
    }

    .menu-header-top li .name {
        padding: 0 20px;
        box-sizing: border-box;
        margin: 6px 0;
        font-size: 13px;
        display: block;
        color: #2b2b2b;
    }

    .badge-important {
        background-color: #ea0006;
    }

    .cart-detail-header:focus,
    .cart-notification-header:focus {
        outline: none;
    }

    .notif-text>a {
        color: #000;
    }

    .hidden {
        display: none;
    }

    @media only screen and (max-width: 480px) {
        .price-product {
            margin-bottom: 0;
        }

        .ranking-product-category {
            margin-top: 0;
        }

        .price-old {
            font-size: 12px;
        }

        .price-new {
            font-size: 14px;
        }
    }

    @media only screen and (max-width: 768px) {
        .merchant-header {
            padding-left: 10%;
            padding-right: 10%;
        }

        .merchant-form {
            padding-left: 10%;
            padding-right: 10%;
        }

    }
</style>