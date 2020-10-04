<style>
    .image-product-container,
    .image-add-product-container {
        display: inline;
        padding-top: 30px;
    }

    .image-product-item {
        border: 2px solid #ddd;
        display: inline-block;
        width: calc(25% - 15px);
        position: relative;
        margin-right: 10px;
        margin-bottom: 11px;
        text-align: center;
        padding: 5px;
    }

    .image-product-add-item {
        border: 2px solid #ddd;
        display: inline-block;
        width: calc(25% - 15px);
        position: relative;
        margin-right: 8px;
        margin-bottom: 11px;
        text-align: center;
        padding: 5px;
    }

    .image-product-item img,
    .image-product-add-item img {
        padding-bottom: 5px;
    }

    .image-product-item .image-product-item-remove,
    .image-product-item .add-image-product-item-remove {
        position: absolute;
        right: -10px;
        top: -10px;
        background-color: #dddddd;
        border-radius: 50%;
        border: 1px solid black;
        width: 15px;
        height: 15px;
        text-align: center;
        font-size: 10px;
    }

    .image-product-item .image-product-item-remove:focus,
    .image-product-item .add-image-product-item-remove {
        border-radius: 50%;
        border: none;
    }

    .image-product-item-content {
        overflow: hidden !important;
    }

    .image-product-item-content img {
        width: 100%;
        height: auto;
        display: inline-block;
    }

    .image-product-item-content .input-image-product {
        display: inline-block;
        margin-left: 20px;
    }

    .bg-orange {
        background-color: #fe6600 !important;
        color: #fff !important;
    }

    .bg-orange:hover {
        background-color: #fe9900 !important;
        color: #dfdfdf !important;
    }

    .modal-cropper {
        min-height: auto;
        width: auto;
    }

    #crop {
        bottom: 0;
        right: 0;
    }

    .no-image-product {
        font-size: 14px;
        color: red;
        top: 0;
    }

    @media(max-width:679px) {
        .button-product-list ul li a {
            font-size: 14px;
            padding: 5px 5px !important;
        }
    }
</style>
<script>
    $(document).ready(function() {
        var grid
        var gridLength
        $('#modalAddProduct').on('shown.bs.modal', () => {
            $("#productForm").find('input.error').removeClass('error')
            tempImageContainer = []
            $('#image-add-product-sortable').html('')
            if ($('#produk_id').val() != '') {
                $('.image-add-container').hide()
            } else {
                $('.image-add-container').show()
            }
        })
        $('.add-product').click(function() {
            $('.title-modal-product').html('Tambah Produk');
            validator.resetForm()
            validator.reset()
            $('.image-add-container').show()
            $("#productForm").find('input, textarea, select').val('')
            $("#productForm").find('input.error').removeClass('error')
            $('#modalAddProduct').modal('show')
        })
        $('.edit-product').click(function(e) {
            e.preventDefault()
            id = $(this).data('id')
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>get_product_detail/" + id,
                dataType: "json",
                success: function(res) {
                    validator.resetForm()
                    validator.reset()

                    $('#produk_id').val(res.id)
                    $('#nama').val(res.nama)
                    $('#harga_asli').val(res.harga_asli)
                    $('#disc').val(res.disc ? res.disc : 0)
                    $('#harga_disc').val(res.harga_disc)
                    $('#desc').val(res.desc)
                    $('#kategori').val(res.kategori_id)
                    $('#kategori').trigger("change")
                    $('#harga_asli').trigger("change")
                    $('#harga_asli').trigger("change")

                    $('.title-modal-product').html('Edit Produk')
                    $('#modalAddProduct').modal('show')

                    $('.image-add-container').hide()
                },
                error: function(res) {
                    console.log(res)
                }
            }).then((res) => {
                $('#sub_kategori').val(res.sub_kategori_id)
                if (res.kategori_id) {
                    $('#sub-kategori-parent').show();
                }
            })
        })
        $('.delete-product').click(function(e) {
            e.preventDefault()
            id = $(this).data('id')
            Swal.fire({
                title: 'Konfirmasi?',
                text: "Hapus produk",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "<?= base_url() ?>delete_product/" + id,
                        dataType: "json",
                        success: function(res) {
                            $.unblockUI()
                            Swal.fire({
                                title: 'Berhasil',
                                text: "Produk berhasil di hapus",
                                icon: 'success'
                            })
                            setTimeout(() => {
                                window.location.href = '<?= base_url('my_product') ?>'
                            }, 1000)
                        },
                        error: function(res) {
                            console.log(res)
                        }
                    })
                }
            })
        })
        $('.edit-image-product').click(function(e) {
            e.preventDefault()
            $.blockUI({
                message: '<img src="<?= base_url() ?>public/megastore/img/ajax-loader.gif" />',
                css: {
                    backgroundColor: 'none',
                    border: 'none',
                },
                baseZ: 1051
            })
            produk_id = $(this).data('id')
            produk_name = $(this).data('product-name')
            $.ajax({
                url: "<?= base_url() ?>get_images_product/" + produk_id,
                dataType: "json",
                success: function(res) {
                    imageProduct = ''
                    $.each(res, function(i, v) {
                        imageProduct += `
                        <div class="image-product-item" id="image-product-item-${v.id}" data-produk-id="${v.produk_id}" data-gambar-id="${v.id}">
                            <div class="image-product-item-content">
                                <img src="<?= base_url() ?>public/img/produk/${v.gambar}" id="image-product-${v.id}">
                                <input type="file" class="input-image-product hidden" id="update-image-${v.id}" data-produk-id="${v.produk_id}" data-gambar-id="${v.id}" accept="image/*">
                                <button class="btn-image-product" data-target="update-image-${v.id}">Update</button>
                            </div>
                            <button class="image-product-item-remove" data-id="${v.id}" data-produk-id="${v.produk_id}"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>`
                    })
                    if (res.length < 4) {
                        $('#image-product-container-add').show()
                        $('#add-image-new').data('produk-id', produk_id)
                    } else {
                        $('#image-product-container-add').hide()
                        $('#add-image-new').data('produk-id', null)
                    }
                    $("#image-product-sortable").data('produk-id', produk_id)
                    $('#image-product-sortable').html(imageProduct)
                    $('#title-product').html(produk_name)
                    $('#modalImageProduct').modal('show')
                }
            }).done(() => {
                $.unblockUI()
            })
        })
        $("#image-product-sortable").sortable({
            cursor: "move",
            cancel: ".image-product-add-item",
            stop: function(e, ui) {},
        })
        $("#image-product-sortable").disableSelection();

        function update_sort_image() {
            listElements = $('#image-product-sortable').children()
            produk_id = $('#image-product-sortable').data('produk-id')
            data = []
            firstImage = {}
            if (listElements.length > 0) {
                $('#no-image-product-' + produk_id).hide();
                $.each(listElements, function(i, val) {
                    item = {
                        id: $('body').find(val).data('gambar-id'),
                        urutan: i + 1
                    }
                    data.push(item)
                    if (i == 0) {
                        firstImage = {
                            gambar: $('body').find('#image-product-' + item.id).attr('src')
                        }
                    }
                })
            } else {
                $('#no-image-product-' + produk_id).show();
                firstImage = {
                    gambar: '<?= base_url() ?>public/megastore/img/no-image-available.png'
                }
            }
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>sort_image_product/",
                dataType: "json",
                data: {
                    data: JSON.stringify(data)
                },
                beforeSend: function() {
                    $.blockUI({
                        message: '<img src="<?= base_url() ?>public/megastore/img/ajax-loader.gif" />',
                        css: {
                            backgroundColor: 'none',
                            border: 'none',
                        },
                        baseZ: 1051
                    })
                },
                success: function(res) {
                    if (res = 'true') {
                        $.unblockUI()
                    }
                }
            }).then((res) => {
                $('body').find('#image-product-' + produk_id).attr('src', firstImage.gambar)
            })
        }
        $("body").on('click', '.btn-image-product', function(e) {
            e.preventDefault()
            target = $(this).data('target')
            $('#' + target).click()
        })
        $("body").on('click', '.image-product-item-remove', function(e) {
            e.preventDefault()
            Swal.fire({
                title: 'Konfirmasi?',
                text: "Hapus gambar",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    gambar_id = $(this).data('id')
                    produk_id = $(this).data('produk-id')
                    $('body').find('#image-product-item-' + gambar_id).remove()
                    $.ajax({
                        type: "post",
                        url: "<?= base_url() ?>delete_image_product/",
                        data: {
                            id: gambar_id,
                            produk_id: produk_id
                        },
                        dataType: "json",
                        beforeSend: function() {
                            $.blockUI({
                                message: '<img src="<?= base_url() ?>public/megastore/img/ajax-loader.gif" />',
                                css: {
                                    backgroundColor: 'none',
                                    border: 'none',
                                },
                                baseZ: 1051
                            })
                        },
                        success: function(res) {
                            if (res = 'true') {
                                $('#image-product-container-add').show()
                                update_sort_image()
                                $.unblockUI()
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: "Gambar berhasil dihapus",
                                    icon: 'success',
                                    timer: 1000,
                                })
                            }
                        }
                    })
                }
            })
        })
        $("body").on('click', '.add-image-product-item-remove', function(e) {
            $.blockUI({
                message: '<img src="<?= base_url() ?>public/megastore/img/ajax-loader.gif" />',
                css: {
                    backgroundColor: 'none',
                    border: 'none',
                },
                baseZ: 1051
            })
            e.preventDefault()
            id = $(this).data('id')
            tempImageContainer.splice(id, 1)
            $('#add-image-product-' + id).remove()
            $('#image-add-product-container').show()

            $.unblockUI()
        })
        $('#save_sort').click(function(e) {
            e.preventDefault()
            update_sort_image()
            $('#modalImageProduct').modal('hide')
        })

        // CROP IMAGE /////////////////////////////////////////////////////////////
        var $modal = $('#modalCropImage')
        var image = document.getElementById('image')
        var cropper

        $("body").on("change", ".input-image-product", function(e) {
            $('#crop').data('gambar-id', $(this).data('gambar-id'))
            $('#crop').data('produk-id', $(this).data('produk-id'))
            var files = e.target.files
            var done = function(url) {
                image.src = url
                $modal.modal('show')
            }
            var reader
            var file
            var url

            if (files && files.length > 0) {
                file = files[0]

                if (URL) {
                    done(URL.createObjectURL(file))
                } else if (FileReader) {
                    reader = new FileReader()
                    reader.onload = function(e) {
                        done(reader.result)
                    }
                    reader.readAsDataURL(file)
                }
            }
        })

        $modal.on('shown.bs.modal', function() {
            widthContainer = $(this).width()
            $('#image').height(widthContainer)
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                preview: '.preview'
            })
        }).on('hidden.bs.modal', function() {
            cropper.destroy()
            cropper = null
            $('.image-product-sortable').html('')
            $('.input-image-product').val('')
        })

        $("#crop").click(function() {
            $.blockUI({
                message: '<img src="<?= base_url() ?>public/megastore/img/ajax-loader.gif" />',
                css: {
                    backgroundColor: 'none',
                    border: 'none',
                },
                baseZ: 1051
            })
            var produk_id = $(this).data('produk-id')
            var gambar_id = $(this).data('gambar-id')
            canvas = cropper.getCroppedCanvas({
                width: 600,
                height: 600,
            })
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob)
                var reader = new FileReader()
                reader.readAsDataURL(blob)
                reader.onloadend = function() {
                    var base64data = reader.result
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "<?= base_url() ?>upload_image_product",
                        data: {
                            image: base64data,
                            gambar_id: gambar_id,
                            produk_id: produk_id
                        },
                        success: function(res) {
                            if (res != "false") {
                                if (gambar_id) {
                                    $('body').find('#image-product-' + gambar_id).attr('src', '<?= base_url('public/img/produk/') ?>' + res.gambar)
                                    if (res.urutan == 1) {
                                        $('#image-product-' + produk_id).attr('src', '<?= base_url('public/img/produk/') ?>' + res.gambar)
                                    }
                                } else {
                                    newImageAdded =
                                        `<div class="image-product-item" id="image-product-item-${res.id}" data-produk-id="${res.produk_id}" data-gambar-id="${res.id}">
                                            <div class="image-product-item-content">
                                                <img src="<?= base_url() ?>public/img/produk/${res.gambar}" id="image-product-${res.id}">
                                                <input type="file" class="input-image-product hidden" id="update-image-${res.id}" data-produk-id="${res.produk_id}" data-gambar-id="${res.id}" accept="image/*">
                                                <button class="btn-image-product" data-target="update-image-${res.id}">Update</button>
                                            </div>
                                            <button class="image-product-item-remove" data-id="${res.id}" data-produk-id="${res.produk_id}"><i class="fa fa-times" aria-hidden="true"></i></button>
                                        </div>`
                                    $('#image-product-sortable').append(newImageAdded)
                                    if (res.urutan > 3) {
                                        $('#image-product-container-add').hide()
                                    }
                                    if (res.urutan == 1) {
                                        $('#image-product-' + produk_id).attr('src', '<?= base_url('public/img/produk/') ?>' + res.gambar)
                                    }
                                }
                            }
                        }
                    }).then(function() {
                        $modal.modal('hide')
                        $.unblockUI()
                    })
                }
            })
        })

        // CROP IMAGE BUAT TAMBAH PRODUK /////////////////////////////////////////////////////////////
        var $modalCropNewProduct = $('#modalCropNewProduct')
        var imageNewProduct = document.getElementById('imageNewProduct')
        var cropperNewProduct
        var tempImageContainer = []

        $("body").on("change", ".input-new-image-product", function(e) {
            var files = e.target.files
            var done = function(url) {
                imageNewProduct.src = url
                $modalCropNewProduct.modal('show')
            }
            if (files && files.length > 0) {
                file = files[0]
                if (URL) {
                    done(URL.createObjectURL(file))
                } else if (FileReader) {
                    reader = new FileReader()
                    reader.onload = function(e) {
                        done(reader.result)
                    }
                    reader.readAsDataURL(file)
                }
            }
        })

        $modalCropNewProduct.on('shown.bs.modal', function() {
            widthContainer = $(this).width()
            $('#imageNewProduct').height(widthContainer)
            cropperNewProduct = new Cropper(imageNewProduct, {
                aspectRatio: 1,
                viewMode: 1,
                preview: '.preview'
            })
        }).on('hidden.bs.modal', function() {
            cropperNewProduct.destroy()
            cropperNewProduct = null
            $('.input-new-image-product').val('')
        })

        $("#cropNewProduct").click(function() {
            $.blockUI({
                message: '<img src="<?= base_url() ?>public/megastore/img/ajax-loader.gif" />',
                css: {
                    backgroundColor: 'none',
                    border: 'none',
                },
                baseZ: 1051
            })
            var produk_id = $(this).data('produk-id')
            var gambar_id = $(this).data('gambar-id')
            canvas = cropperNewProduct.getCroppedCanvas({
                width: 600,
                height: 600,
            })
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob)
                var reader = new FileReader()
                reader.readAsDataURL(blob)
                reader.onloadend = function() {
                    var base64data = reader.result
                    tempImageContainer.push(base64data)
                    id = tempImageContainer.length - 1
                    newImageAdded =
                        `<div class="image-product-item" id="add-image-product-${id}">
                            <div class="image-product-item-content btn-image-product">
                                <img src="${base64data}" alt="No image" id="add-image-${id}">
                            </div>
                            <button class="add-image-product-item-remove" data-id="${id}"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>`
                    $('#image-add-product-sortable').append(newImageAdded)
                    $modalCropNewProduct.modal('hide')
                    if (id == 3) {
                        $('#image-add-product-container').hide()
                    }
                    $.unblockUI()
                }
            })
        })

        ///add new product////////////////////////////////

        validator = $("#productForm").validate({
            rules: {
                nama: {
                    required: true
                },
                harga_asli: {
                    required: true
                },
                disc: {
                    required: true,
                    min: 0,
                    max: 100
                },
                harga_disc: {
                    required: true
                }
            },
            messages: {
                nama: {
                    required: 'Masukkan nama produk'
                },
                harga_asli: {
                    required: 'Masukkan harga produk'
                },
                disc: {
                    required: 'Masukkan disc produk'
                },
                harga_disc: {
                    required: 'Masukkan harga produk'
                }
            },
            submitHandler: function(form, e) {
                e.preventDefault()
                data = $(form).serializeArray()
                if (tempImageContainer.length > 0) {
                    data.push({
                        name: "gambar",
                        value: JSON.stringify(tempImageContainer)
                    })
                }
                text = $('#produk_id').val() ? 'Produk berhasil diupdate' : 'Produk berhasil ditambahkan'
                $.ajax({
                    type: "post",
                    url: "<?= base_url('insert_update_product') ?>",
                    data: data,
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: text,
                            showConfirmButton: false,
                            timer: 0,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                        })
                        setTimeout(() => {
                            window.location.href = '<?= base_url('my_product') ?>'
                        }, 1000)
                    },
                    error: function(res) {
                        console.log(res)
                    }
                })
            }
        })

        $('#kategori').change(function(e) {
            e.preventDefault()
            kategori = $("#kategori option:selected").val()
            if (kategori > 0) {
                $.ajax({
                    url: "<?= base_url() ?>on_change_category/" + kategori,
                    dataType: "json",
                    success: function(res) {
                        subKategori = '<option value="">Semua Sub Kategori</option>'
                        if (res.length) {
                            $.each(res, function(i, v) {
                                subKategori += `<option value="${v.id}">${v.nama}</option>`
                            })
                            $('#sub_kategori').html(subKategori)
                            $('#sub-kategori-parent').show()
                        } else {
                            $('#sub_kategori').html('<option value="">Semua Sub Kategori</option>')
                            $('#sub-kategori-parent').hide()
                        }
                    }
                })
            } else {
                $('#sub_kategori').html('<option value="">Semua Sub Kategori</option>')
                $('#sub-kategori-parent').hide()
            }
        })
    })

    $('#disc').on({
        keyup: function(e) {
            discChange()
            calcFinalPrice()
        },
        change: function(e) {
            discChange()
            calcFinalPrice()
        },
        blur: function(e) {
            discChange()
            calcFinalPrice()
        },
    })
    $('#harga_asli').on({
        keyup: function(e) {
            hargaFormat($(this))
            calcFinalPrice()
        },
        change: function(e) {
            hargaFormat($(this))
            calcFinalPrice()
        },
        blur: function(e) {
            hargaFormat($(this))
            calcFinalPrice()
        },
    })

    function discChange() {
        disc = parseInt($('#disc').val())
        disc = disc ? (disc < 0 ? 0 : (disc > 100 ? 100 : disc)) : 0
        $('#disc').val(disc)
    }

    function hargaFormat(field) {
        harga = $(field).val()
        $(field).val(harga.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."))
    }

    function calcFinalPrice() {
        firstPrice = parseInt(($('#harga_asli').val()).replaceAll('.', ''))
        disc = parseInt($('#disc').val())
        finalPrice = parseInt(firstPrice - (firstPrice * (disc / 100)))
        finalPrice = finalPrice.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        $('#harga_disc').val(finalPrice)
    }

    $('.modal').on("hidden.bs.modal", function(e) {
        if ($('.modal:visible').length) {
            $('body').addClass('modal-open');
        }
    });
</script>