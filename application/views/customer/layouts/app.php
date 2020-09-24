<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('customer/layouts/_head') ?>

<body>
    <?php $this->load->view('customer/layouts/_header') ?>

    <div class="wrappage">

        <?php $this->load->view('customer/' . $content) ?>

    </div>

    <?php $this->load->view('customer/layouts/_footer') ?>

    <div class="modal fade bs-example-modal-lg out" id="modalAuth" tabindex="-1" role="dialog" aria-hidden="true" style="display: none">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="relative">
                        <button type="button" class="close-modal animate-default" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="ti-close"></span>
                        </button>
                        <div class="col-md-12 relative overfollow-hidden bottom-margin-15-default">
                            <ul class="title-tabs clearfix relative">
                                <li onclick="event.preventDefault();changeTabsAuth(1)" class="title-tabs-auth-detail title-tabs-auth-1 border no-border-b active-title-tabs bold uppercase">Masuk</li>
                                <li onclick="event.preventDefault();changeTabsAuth(2)" class="title-tabs-auth-detail title-tabs-auth-2 border no-border-b bold uppercase">Daftar</li>
                            </ul>
                            <div class="content-tabs-auth-detail relative content-tab-auth-1 border active-tabs-auth-detail top-padding-15-default bottom-padding-15-default left-padding-default right-padding-default discussions">
                                <form method="post" action="" id="loginForm" enctype="multipart/form-data">
                                    <div class="form-input full-width clearfix relative">
                                        <label>Username *</label>
                                        <input class="full-width" type="text" name="username" id="username">
                                    </div>
                                    <div class="form-input full-width clearfix relative">
                                        <label>Password *</label>
                                        <input class="full-width" type="password" name="password" id="password">
                                        <a class="float-right" href="#" onclick="event.preventDefault();changeTabsAuth(2)">Belum punya akun?</a>
                                    </div>
                                    <div class="form-input full-width clearfix relative text-center">
                                        <button class="btn-daftar-toko full-width" id="login">Masuk</button>
                                    </div>
                                </form>
                            </div>
                            <div class="content-tabs-auth-detail relative content-tab-auth-2 border top-padding-15-default bottom-padding-15-default left-padding-default right-padding-default reviews">
                                <form method="post" action="" id="registerForm" enctype="multipart/form-data">
                                    <div class="form-input full-width clearfix relative">
                                        <label>Nama *</label>
                                        <input class="full-width" type="text" name="name_r" id="name_r">
                                    </div>
                                    <div class="form-input full-width clearfix relative">
                                        <label>Username *</label>
                                        <input class="full-width" type="text" name="username_r" id="username_r">
                                    </div>
                                    <div class="form-input full-width clearfix relative">
                                        <label>Nomor Telepon *</label>
                                        <input class="full-width" type="phone" name="phone_r" id="phone_r">
                                    </div>
                                    <div class="form-input full-width clearfix relative">
                                        <label>Password *</label>
                                        <input class="full-width" type="password" name="password_r" id="password_r">
                                    </div>
                                    <div class="form-input full-width clearfix relative">
                                        <label>Konfirmasi Password *</label>
                                        <input class="full-width" type="password" name="password2_r" id="password2_r">
                                        <a class="float-right auth-redirect" href="#" onclick="event.preventDefault();changeTabsAuth(1)">Sudah punya akun?</a>
                                    </div>
                                    <div class="form-input full-width clearfix relative text-center">
                                        <button class="btn-daftar-toko full-width top-margin-15-default" id="register">Daftar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="<?= base_url() ?>public/megastore/js/jquery-2.2.4.min.js" defer=""></script>
    <script src="<?= base_url() ?>public/megastore/js/jquery-3.3.1.min.js" defer=""></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>public/megastore/js/bootstrap.min.js" defer=""></script>
    <script src="<?= base_url() ?>public/megastore/js/jquery.validate.min.js" defer=""></script>
    <script src="<?= base_url() ?>public/megastore/js/multirange.js" defer=""></script>
    <script src="<?= base_url() ?>public/megastore/js/owl.carousel.min.js" defer=""></script>
    <!-- <script src="<?= base_url() ?>public/megastore/js/sync_owl_carousel.js" defer=""></script> -->
    <script src="<?= base_url() ?>public/megastore/js/scripts.js?123" defer=""></script>
    <script src="<?= base_url() ?>public/megastore/js/slick.min.js" defer=""></script>
    <script src="<?= base_url() ?>public/megastore/js/sweetalert2@9" defer=""></script>
    <script src="<?= base_url() ?>public/js/select2.min.js"></script>
</body>

<?php $this->load->view('customer/' . $vitamin) ?>
<script>
    $(document).ready(function() {
        $('#userAccount').click(function(e) {
            e.preventDefault()
            $('#modalAuth').modal('show')
        })
        $.validator.addMethod('phone', function(value, element) {
            return this.optional(element) || /\(?(?:\+62|62|0)(?:\d{2,3})?\)?[ .-]?\d{2,4}[ .-]?\d{2,4}[ .-]?\d{2,4}/.test(value);
        }, "Please enter a valid phone number");
        $.validator.addMethod('alphanumericDash', function(value, element) {
            return this.optional(element) || /^[a-z0-9\_]+$/i.test(value);
        }, "Please enter a valid phone number");
        $.validator.addMethod('namespace', function(value, element) {
            return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
        }, "Please enter a valid phone number");
        $("#registerForm").validate({
            rules: {
                name_r: {
                    required: true,
                    namespace: true
                },
                username_r: {
                    required: true,
                    alphanumericDash: true,
                    remote: {
                        url: "<?= base_url() ?>username_check_r",
                        type: "post"
                    }
                },
                phone_r: {
                    required: true,
                    phone: true
                },
                password_r: {
                    required: true,
                    minlength: 5
                },
                password2_r: {
                    equalTo: "#password_r"
                }
            },
            messages: {
                name_r: {
                    required: "Masukkan nama",
                    namespace: "Nama mengandung karakter terlarang"
                },
                username_r: {
                    required: 'Masukkan Username',
                    alphanumericDash: 'Username mengandung karakter terlarang',
                    remote: 'Username sudah dipakai'
                },
                phone_r: {
                    required: "Masukkan nomor telepon",
                    phone: "Nomor handphone tidak valid"
                },
                password_r: {
                    required: "Masukkan Password",
                    minlength: "Password minimal 5 digit character"
                },
                password2_r: "Password tidak sama",
                email: "Please enter a valid email address"
            },
            submitHandler: function(form, e) {
                e.preventDefault()
                // console.log($(form).serialize())
                data = $('#registerForm').serialize()
                $.ajax({
                    type: "post",
                    url: "<?= base_url('user/register') ?>",
                    data: data,
                    success: function(res) {
                        // console.log('success', res)
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil mendaftar',
                            text: 'Masuk ke dalam aplikasi',
                            showConfirmButton: false,
                            timer: 0,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                        })
                        setTimeout(() => {
                            window.location.href = window.location.href
                        }, 1000);
                    },
                    error: function(res) {
                        // console.log('error', res)
                        console.log(res)
                    }
                })
            }
        })
        $("#loginForm").validate({
            // Specify validation rules
            rules: {
                username: "required",
                password: {
                    required: true
                },
            },
            messages: {
                username: "Masukkan username",
                password: {
                    required: "Masukkan Password",
                }
            },
            submitHandler: function(form, e) {
                e.preventDefault()
                // console.log($(form).serialize())
                data = $('#loginForm').serialize()
                $.ajax({
                    type: "post",
                    url: "<?= base_url('user/login') ?>",
                    data: data,
                    success: function(res) {
                        // console.log('success', res)
                        if (res == 'true') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil masuk',
                                text: 'Masuk ke dalam aplikasi',
                                showConfirmButton: false,
                                timer: 0,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                            })
                            setTimeout(() => {
                                window.location.href = window.location.href
                            }, 1000);
                        } else if (res == 'false') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Username atau password salah',
                                showConfirmButton: false,
                                timer: 0
                            })
                        }
                    },
                    error: function(res) {
                        console.log('error', res)
                        // console.log(res)
                    }
                })
                return false
            }
        })
        $('#categoriMenu').click(function() {
            var box_offset = $('.menu-header ul li:first-child').offset()
            var box_h = $('.menu-header ul li:first-child').height()
            check = $('.menu_more_header').css('display') == 'none' ? 0 : 1
            if ($(window).width() >= 980 && !check) {
                $(".menu_more_header").slideDown(500)
                $(".menu_more_header").css({
                    top: box_offset.top + box_h,
                    left: box_offset.left
                })
            } else {
                $(".menu_more_header").slideUp(500)
            }
        })
        $('.parentCategory a').click(function(e) {
            var caret = $(this).children('.fa')
            var dataId = $(this).data('id')
            if (caret.hasClass('fa-caret-right')) {
                e.preventDefault()
                $('.parentCategory').find('i.fa-caret-down').removeClass('fa-caret-down').addClass('fa-caret-right')
                $('.subCategory').slideUp(100)
                caret.removeClass('fa-caret-right')
                caret.addClass('fa-caret-down')
                expandCategory(dataId)
            } else {
                caret.removeClass('fa-caret-down')
                caret.addClass('fa-caret-right')
                collapseCategory(dataId)
            }
        })

        function expandCategory(dataId) {
            $('.subCategory[data-id="' + dataId + '"]').slideDown(100)
        }

        function collapseCategory(dataId) {
            $('.subCategory[data-id="' + dataId + '"]').slideUp(100)
        }
        $('.searchform').submit(function(e) {
            e.preventDefault()
            // 'search%26keyword=(:any)%26category=(:any)%26subcategory=(:any)'
            var category = $('#cate_search option:selected')
            var param1 = $('#keyword').val()
            var url = "<?= base_url() ?>search%26keyword=" + param1
            if (category.data('type') == 1) {
                param2 = category.val()
                url += "%26category=" + param2
            } else if (category.data('type') == 2) {
                param2 = category.data('id')
                param3 = category.val()
                url += "%26category=" + param2 + "%26subcategory=" + param3
            }
            url += "%26page=1"
            window.location.href = url
        })
    })
</script>

</html>