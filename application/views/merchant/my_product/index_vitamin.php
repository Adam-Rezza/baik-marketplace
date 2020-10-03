<style>
    .image-product-container {
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

    .image-product-item .image-product-item-remove {
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

    .image-product-item .image-product-item-remove:focus {
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

    #image {
        width: 400px;
        height: 400px;
    }

    .cropper-container {
        min-width: 400px;
        min-height: 400px;
    }

    #crop {
        bottom: 0;
        right: 0;
    }
</style>
<script>
    $(document).ready(function() {
        var grid
        var gridLength
        $('#modalAddProduct').on('shown.bs.modal', () => {
            $("#productForm").find('input.error').removeClass('error')
        })
        $('.add-product').click(function() {
            $('.title-modal-product').html('Tambah Produk');
            validator.resetForm()
            validator.reset()
            $("#productForm").find('input, textarea, select').val('')
            $("#productForm").find('input.error').removeClass('error')
            $('#modalAddProduct').modal('show')
        })
        $('.edit-product').click(function() {
            id = $(this).data('id')
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>get_product_detail/" + id,
                dataType: "json",
                success: function(res) {
                    console.log('success', res)
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

                    $('.title-modal-product').html('Edit Produk');
                    $('#modalAddProduct').modal('show')
                },
                error: function(res) {
                    // console.log('error', res)
                    console.log(res)
                }
            }).then((res) => {
                $('#sub_kategori').val(res.sub_kategori_id)
                if (res.kategori_id) {
                    $('#sub-kategori-parent').show();
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
                    // console.log(res)
                    imageProduct = ''
                    $.each(res, function(i, v) {
                        imageProduct += `
                        <div class="image-product-item" id="image-product-item-${v.id}" data-produk-id="${v.produk_id}" data-gambar-id="${v.id}">
                            <div class="image-product-item-content">
                                <img src="<?= base_url() ?>public/img/produk/${v.gambar}" id="image-product-${v.id}" alt="No image">
                                <input type="file" class="input-image-product hidden" id="update-image-${v.id}" data-produk-id="${v.produk_id}" data-gambar-id="${v.id}" accept="image/*">
                                <button class="btn-image-product" data-target="update-image-${v.id}">Update</button>
                            </div>
                            <button class="image-product-item-remove" data-id="${v.id}" data-produk-id="${res.produk_id}"><i class="fa fa-times" aria-hidden="true"></i></button>
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
                    console.log()
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

        function update_sort_image() {
            listElements = $('#image-product-sortable').children()
            produk_id = $('#image-product-sortable').data('produk-id')
            data = []
            firstImage = {}
            $.each(listElements, function(i, val) {
                item = {
                    id: $('body').find(val).data('gambar-id'),
                    urutan: i + 1
                }
                data.push(item)
                if (i == 0) {
                    firstImage = {
                        id: $('body').find(val).data('produk-id'),
                        gambar: $('body').find('#image-product-' + item.id).attr('src')
                    }
                    // console.log(firstImage)
                }
            })
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
                $('body').find('#image-product-' + firstImage.id).attr('src', firstImage.gambar)
            })
        }
        $("body").on('click', '.btn-image-product', function() {
            target = $(this).data('target')
            $('#' + target).click()
        })
        $("body").on('click', '.image-product-item-remove', function() {
            gambar_id = $(this).data('id')
            produk_id = $(this).data('produk-id')
            $('body').find('#image-product-item-' + gambar_id).remove()
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>sort_image_product/",
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
                        update_sort_image()
                        $.unblockUI()
                    }
                }
            })
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
            // console.log($('#crop').data())
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
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                preview: '.preview'
            })
        }).on('hidden.bs.modal', function() {
            cropper.destroy()
            cropper = null
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
                                        `<div class="image-product-item" data-produk-id="${res.produk_id}" data-gambar-id="${res.id}">
                                            <div class="image-product-item-content">
                                                <img src="<?= base_url() ?>public/img/produk/${res.gambar}" id="image-product-${res.id}" alt="No image">
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
                data = $(form).serialize()
                // console.log(data)
                $.ajax({
                    type: "post",
                    url: "<?= base_url('insert_update_product') ?>",
                    data: data,
                    success: function(res) {
                        // console.log('success', res)
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Produk berhasil ditambahkan',
                            showConfirmButton: false,
                            timer: 0,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                        })
                        setTimeout(() => {
                            window.location.href = '<?= base_url('merchant') ?>'
                        }, 1000)
                    },
                    error: function(res) {
                        // console.log('error', res)
                        console.log(res)
                    }
                })
            }
        })

        $('#kategori').change(function(e) {
            e.preventDefault()
            kategori = $("#kategori option:selected").val()
            // console.log(kategori)
            if (kategori > 0) {
                $.ajax({
                    url: "<?= base_url() ?>on_change_category/" + kategori,
                    dataType: "json",
                    success: function(res) {
                        // console.log(res)
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
</script>