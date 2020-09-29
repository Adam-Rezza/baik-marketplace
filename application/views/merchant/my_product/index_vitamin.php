<style>
    .grid-stack-item {
        border-bottom: 1px solid #333;
        position: relative;
        display: inline-block;
    }

    .grid-stack-item:last-child {
        border-bottom: none;
    }

    .grid-stack-item-content {
        overflow: hidden !important;
    }

    .grid-stack-item-content img {
        width: calc(25% - 15px);
        height: auto;
        display: inline-block;
    }

    .grid-stack-item-content .input-image-product {
        display: inline-block;
        margin-left: 20px;
    }

    #image {
        width: 400px;
        width: 400px;
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
        $('.edit-image-product').click(function() {
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
                    // gridLength = (res.length + 1) * 3
                    imageProduct = ''
                    if (grid) {
                        grid.removeAll()
                        $('#grid-stack-container').html('<div class="grid-stack" id="grid-stack"></div>')
                    } else {
                        $('#grid-stack').html('')
                    }
                    var j = 1
                    $.each(res, function(i, v) {
                        imageProduct = `
                        <div id="gsi-${v.id}" class="grid-stack-item" data-gs-width="12" data-gs-height="3">
                            <div class="grid-stack-item-content">
                                <img src="<?= base_url() ?>public/img/produk/${v.gambar}">
                                <input type="file" class="input-image-product" data-gambar-id="${v.id}" data-produk-id="${produk_id}" data-urutan="${j++}">
                            </div>
                        </div>`
                        $('#grid-stack').append(imageProduct)
                        if (grid) {
                            grid.makeWidget('gsi-' + v.id)
                        }
                    })
                    if (res.length < 4) {
                        imageProduct = `
                        <div id="gsi-new" class="grid-stack-item" data-gs-width="12" data-gs-height="3">
                            <div class="grid-stack-item-content">
                                <img src="<?= base_url() ?>public/megastore/img/add-image.png" alt="No image">
                                <input type="file" class="input-image-product" data-produk-id="${produk_id}" data-urutan="${j++}">
                            </div>
                        </div>`
                        $('#grid-stack').append(imageProduct)
                        if (grid) {
                            grid.makeWidget('gsi-new')
                        }
                    }
                    // $('#grid-stack').html(imageProduct)
                    // console.log(produk_name)
                    $('#title-product').html(produk_name)
                    $('#modalImageProduct').modal('show')
                }
            }).done(() => {
                // console.log(gridLength)
                setTimeout(() => {
                    if (!grid) {
                        // console.log(grid)
                        grid = GridStack.init({
                            resizable: {
                                handles: 's'
                            },
                            column: 12,
                            row: 12
                            // row: gridLength
                        })
                    }
                    $.unblockUI()
                }, 1000)
            })
        })
        $('#kategori').change(function(e) {
            e.preventDefault()
            kategori = $( "#kategori option:selected" ).val()
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

        // CROP IMAGE
        var $modal = $('#modalCropImage')
        var image = document.getElementById('image')
        var cropper

        $("body").on("change", ".input-image-product", function(e) {
            $('#crop').data('gambar-id', $(this).data('gambar-id'))
            $('#crop').data('produk-id', $(this).data('produk-id'))
            $('#crop').data('urutan', $(this).data('urutan'))
            // console.log($('#crop').data())
            var files = e.target.files
            var done = function(url) {
                image.src = url
                $modal.modal('show')
            }
            var reader
            var file
            var url

            // console.log(files)
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
            var urutan = $(this).data('urutan')
            var gambar_id = $(this).data('gambar-id')
            // console.log(produk_id, urutan)
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
                            produk_id: produk_id,
                            urutan: urutan
                        },
                        success: function(data) {
                            // console.log(data)
                            $modal.modal('hide')
                            $.ajax({
                                url: "<?= base_url() ?>get_images_product/" + produk_id,
                                dataType: "json",
                                success: function(res) {
                                    // console.log(res)
                                    gridLength = (res.length + 1) * 3
                                    imageProduct = ''
                                    if (grid) {
                                        grid.removeAll()
                                        $('#grid-stack-container').html('<div class="grid-stack" id="grid-stack"></div>')
                                    } else {
                                        $('#grid-stack').html('')
                                    }
                                    var j = 1
                                    $.each(res, function(i, v) {
                                        imageProduct = `
                                    <div id="gsi-${v.id}" class="grid-stack-item" data-gs-width="12" data-gs-height="3">
                                        <div class="grid-stack-item-content">
                                            <img src="<?= base_url() ?>public/img/produk/${v.gambar}">
                                            <input type="file" class="input-image-product" data-gambar-id="${v.id}" data-produk-id="${produk_id}" data-urutan="${j++}">
                                        </div>
                                    </div>`
                                        $('#grid-stack').append(imageProduct)
                                        if (grid) {
                                            grid.makeWidget('gsi-' + v.id)
                                        }
                                    })
                                    if (res.length < 4) {
                                        imageProduct = `
                                    <div id="gsi-new" class="grid-stack-item" data-gs-width="12" data-gs-height="3">
                                        <div class="grid-stack-item-content">
                                            <img src="<?= base_url() ?>public/megastore/img/add-image.png" alt="No image">
                                            <input type="file" class="input-image-product" data-produk-id="${produk_id}" data-urutan="${j++}">
                                        </div>
                                    </div>`
                                        $('#grid-stack').append(imageProduct)
                                        if (grid) {
                                            grid.makeWidget('gsi-new')
                                        }
                                    }
                                    // $('#grid-stack').html(imageProduct)
                                    $('#modalImageProduct').modal('hide')
                                }
                            }).done(() => {
                                // console.log(gridLength)
                                setTimeout(() => {
                                    if (!grid) {
                                        // console.log(grid)
                                        grid = GridStack.init({
                                            resizable: {
                                                handles: 's'
                                            },
                                            column: 12,
                                            row: gridLength
                                        })
                                    }
                                    $('#modalImageProduct').modal('show')
                                    $.unblockUI()
                                }, 1000)
                            })
                        }
                    })
                }
            })
        })
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
        // END CROP IMAGE
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