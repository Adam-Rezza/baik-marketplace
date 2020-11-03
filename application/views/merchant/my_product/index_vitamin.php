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

    .text-gray {
        color: #b3b3b3;
    }

    #addVariasi {
        font-size: 12px;
        color: #fff;
        margin-top: 5px;
        padding: 2px 5px;
        float: left;
        clear: both;
        display: block;
        cursor: pointer;
        background-color: #ff6600;
        border: none;
        border-radius: 8px;
    }

    .add-variasi {
        font-size: 12px;
        color: #fff;
        margin-top: 5px;
        padding: 2px 5px;
        float: right;
        clear: both;
        display: block;
        cursor: pointer;
        background-color: #ff6600;
        border: 1px solid #555;
        border-radius: 4px;
    }

    .add-variasi:active {
        border: 1px solid #555;
        color: #555;
        box-shadow: -1px -1px #333;
    }

    .parent-remove-variasi {
        padding-left: 0;
    }

    .label-input-variasi,
    .label-input-list-variasi {
        display: block;
    }

    input.input-variasi {
        width: calc(100% - 50px);
    }

    .input-list-variasi {
        width: calc(100% - 50px);
    }

    div.parent-list-variasi {
        margin-top: 5px;
    }

    div.parent-list-variasi:nth-of-type(1) {
        margin-top: 0px !important;
    }

    .remove-variasi,
    .add-list-variasi,
    .remove-list-variasi {
        font-size: 12px;
        text-align: left;
        color: #fff;
        margin-top: 5px;
        padding: 2px 5px;
        /* float: right; */
        clear: both;
        display: inline-block;
        cursor: pointer;
        background-color: #ff6600;
        border: 1px solid #555;
        border-radius: 4px;
    }

    .remove-variasi:active,
    .add-list-variasi:active,
    .remove-list-variasi:active {
        border: 1px solid #555;
        color: #555;
        box-shadow: -1px -1px #333;
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
        var rowVariasi = 0
        $('#modalAddProduct').on('shown.bs.modal', () => {
            $("#productForm").find('input.error').removeClass('error')
            tempImageContainer = []
            $('#image-add-product-sortable').html('')
            if ($('#produk_id').val() != '') {
                $('.image-add-container').hide()
                rowVariasi = 0
            } else {
                $('.image-add-container').show()
            }
        })
        $('body').find('.add-variasi').click(function(e) {
            e.preventDefault()
            row = $('body').find('.input-variasi:visible').length
            if (row < 2) {
                rowVariasi++
                field = `
                    <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <label class="label-input-variasi">Variasi</label>
                        <input class="input-variasi" type="text" name="variasi[]">
                        <input type="input" name="delete_variasi[]" value="false" class="delete_variasi hidden">
                        <input class="hidden" type="text" name="variasi_id[]" data-id="${rowVariasi}" value="${rowVariasi}">
                        <span class="remove-variasi" data-id=""><i class="fa fa-times" aria-hidden="true"></i></span>
                        <span class="add-list-variasi" data-id="${rowVariasi}"><i class="fa fa-plus" aria-hidden="true"></i></span>
                    </div>
                    <div class="col-xs-12 col-sm-6 list-variasi list-variasi-${rowVariasi}">
                        <label class="label-input-list-variasi">List Variasi</label>
                        <div class="parent-list-variasi parent-list-variasi-${rowVariasi}">
                            <input class="hidden" type="text" name="list_variasi_id[]" data-id="0" value="0">
                            <input class="hidden" type="text" name="list_variasi_parent[]" data-id="${rowVariasi}" value="${rowVariasi}">
                            <input type="input" name="delete_list_variasi[]" value="false" class="delete_list_variasi hidden">
                            <input type="input" name="active_list_variasi[]" value="true" class="input_active_list_variasi hidden">
                            <input type="checkbox" class="active_list_variasi" checked title="Aktif">
                            <input class="input-list-variasi" type="text" name="list_variasi[]">
                            <span class="remove-list-variasi" data-id=""><i class="fa fa-times" aria-hidden="true"></i></span>
                        </div>
                        <div class="parent-list-variasi parent-list-variasi-${rowVariasi}">
                            <input class="hidden" type="text" name="list_variasi_id[]" data-id="0" value="0">
                            <input class="hidden" type="text" name="list_variasi_parent[]" data-id="${rowVariasi}" value="${rowVariasi}">
                            <input type="input" name="delete_list_variasi[]" value="false" class="delete_list_variasi hidden">
                            <input type="input" name="active_list_variasi[]" value="true" class="input_active_list_variasi hidden">
                            <input type="checkbox" class="active_list_variasi" checked title="Aktif">
                            <input class="input-list-variasi" type="text" name="list_variasi[]">
                            <span class="remove-list-variasi" data-id=""><i class="fa fa-times" aria-hidden="true"></i></span>
                        </div>
                    </div>
                    </div>`
                $('.variasi').append(field)
            } else {
                Swal.fire({
                    text: "Maksimal 2 variasi",
                    icon: 'error',
                    timer: 1000
                })
            }
            $('.variasi-null').hide()
        })
        $(".variasi").on("click", ".remove-variasi", function(e) {
            e.preventDefault()
            id = $(this).data('id')
            if (id) {
                $(this).parent().find('.delete_variasi').val(true)
                console.log()
                $(this).parent().parent().hide()
            } else {
                $(this).parent().parent().remove()
            }
            //
            row = $('.input-variasi:visible').length
            if (row > 0) {
                $('.variasi-null').hide()
            } else {
                $('.variasi-null').show()
            }
        })
        $(".variasi").on("click", ".active_list_variasi", function(e) {
            val = $(this).prop("checked")
            $(this).parent().find('.input_active_list_variasi').val(val)
        })
        $(".variasi").on("click", ".add-list-variasi", function(e) {
            e.preventDefault()
            id = $(this).data('id')
            row = $('.parent-list-variasi-' + id + ':visible').length
            // rowListVariasi = $('body').find('.list-variasi-' + id).children('.input-list-variasi:last-child').data('id')
            if (row < 10) {
                field = `
                    <div class="parent-list-variasi parent-list-variasi-${id}">
                        <input class="hidden" type="text" name="list_variasi_id[]" data-id="0" value="0">
                        <input class="hidden" type="text" name="list_variasi_parent[]" data-id="${id}" value="${id}">
                        <input type="input" name="delete_list_variasi[]" value="false" class="delete_list_variasi hidden">
                        <input type="input" name="active_list_variasi[]" value="true" class="input_active_list_variasi hidden">
                        <input type="checkbox" class="active_list_variasi" checked title="Aktif">
                        <input class="input-list-variasi" type="text" name="list_variasi[]" data-id="0">
                        <span class="remove-list-variasi" data-id=""><i class="fa fa-times" aria-hidden="true"></i></span>
                    </div>
            `
                $('.list-variasi-' + id).append(field)
            } else {
                Swal.fire({
                    text: "Maksimal 10 list variasi",
                    icon: 'error',
                    timer: 1000
                })
            }
        })
        $(".variasi").on("click", ".remove-list-variasi", function(e) {
            e.preventDefault()
            id = $(this).data('id')
            row = $(this).parent().parent().find('.input-list-variasi:visible').length
            if (row > 1) {
                if (id) {
                    $(this).parent().find('.delete_list_variasi').val(true)
                    $(this).parent().hide()
                } else {
                    $(this).parent().remove()
                }
            } else {
                Swal.fire({
                    text: "Minimal 1 variasi",
                    icon: 'error',
                    timer: 1000
                })
            }
        })
        $('.add-product').click(function() {
            $('.title-modal-product').html('Tambah Produk');
            validator.resetForm()
            validator.reset()
            $('.add-variasi').show()
            $('.image-add-container').show()
            $('.variasi').html('')
            $("#productForm").find('input, textarea, select').val('')
            $("#productForm").find('input.error').removeClass('error')
            $('#modalAddProduct').modal('show')
        })
        $('.edit-product').click(function(e) {
            e.preventDefault()
            id = $(this).data('id')
            $('.variasi').html('')
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

                    $('.add-variasi').hide()
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
        $('.edit-variasi').click(function(e) {
            e.preventDefault()
            id = $(this).data('id')
            $('.variasi').html('')
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>get_variasi_product/" + id,
                dataType: "json",
                success: function(res) {
                    validator.resetForm()
                    validator.reset()
                    console.log(res)
                    if (Object.keys(res.variasi).length > 0) {
                        var field = ''
                        $.each(res.variasi, function(i, v) {
                            field += `
                                <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <label class="label-input-variasi">Variasi</label>
                                    <input class="input-variasi" type="text" name="variasi[]" value="${v.nama}">
                                    <input type="input" name="delete_variasi[]" value="false" class="delete_variasi hidden">
                                    <input class="hidden" type="text" name="variasi_id[]" data-id="${v.id}" value="${v.id}">
                                    <span class="remove-variasi" data-id="${v.id}"><i class="fa fa-times" aria-hidden="true"></i></span>
                                    <span class="add-list-variasi" data-id="${v.id}"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                </div>
                                <div class="col-xs-12 col-sm-6 list-variasi list-variasi-${v.id}">
                                    <label class="label-input-list-variasi">List Variasi</label>`
                            $.each(res.list_variasi[v.id], function(j, w) {
                                console.log(w)
                                field += `
                                    <div class="parent-list-variasi parent-list-variasi-${v.id}">
                                        <input class="hidden" type="text" name="list_variasi_id[]" data-id="${w.id}" value="${w.id}">
                                        <input class="hidden" type="text" name="list_variasi_parent[]" data-id="${w.parent}" value="${w.parent}">
                                        <input type="input" name="delete_list_variasi[]" value="${w.del == '1'? 'true' : 'false'}" class="delete_list_variasi hidden">
                                        <input type="input" name="active_list_variasi[]" value="${w.active == '1' ? 'true' : 'false'}" class="input_active_list_variasi hidden">
                                        <input type="checkbox" class="active_list_variasi" ${w.active == '1' ? 'checked' : ''} title="Aktif">
                                        <input class="input-list-variasi" type="text" name="list_variasi[]" value="${w.nama}">
                                        <span class="remove-list-variasi" data-id="${w.id}"><i class="fa fa-times" aria-hidden="true"></i></span>
                                    </div>`
                            })
                            field += `
                                </div>
                                </div>`
                            $('.list-variasi-' + id).append(field)
                            $('.variasi-null').hide()
                        })
                    } else {
                        $('.variasi-null').show()
                    }
                    $('#variasi_produk_id').val(id)
                    $('.variasi').append(field)

                    $('.title-modal-variasi').html('Edit Variasi Produk')
                    $('#modalVariasi').modal('show')
                },
                error: function(res) {
                    console.log(res)
                }
            }).then((res) => {
                // $('#sub_kategori').val(res.sub_kategori_id)
                // if (res.kategori_id) {
                //     $('#sub-kategori-parent').show();
                // }
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
                            if (res == 'true') {
                                Swal.fire({
                                    title: 'Berhasil',
                                    text: "Produk berhasil di hapus",
                                    icon: 'success'
                                })
                                setTimeout(() => {
                                    window.location.href = '<?= base_url('my_product') ?>'
                                }, 1000)
                            } else {
                                Swal.fire({
                                    title: 'Gagal',
                                    text: "Terjadi kesalahan pada server, \n silahkan coba beberapa saat lagi",
                                    icon: 'success'
                                })
                            }
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
        $.validator.prototype.checkForm = function() {
            //overriden in a specific page
            this.prepareForm();
            for (var i = 0, elements = (this.currentElements = this.elements()); elements[i]; i++) {
                if (this.findByName(elements[i].name).length !== undefined && this.findByName(elements[i].name).length > 1) {
                    for (var cnt = 0; cnt < this.findByName(elements[i].name).length; cnt++) {
                        this.check(this.findByName(elements[i].name)[cnt]);
                    }
                } else {
                    this.check(elements[i]);
                }
            }
            return this.valid();
        };
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
                // harga_disc: {
                //     required: true
                // },
                variasi: {
                    required: true
                },
                list_variasi: {
                    required: true
                },
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
                // harga_disc: {
                //     required: 'Masukkan harga produk'
                // },
                variasi: {
                    required: 'Masukkan judul variasi'
                },
                list_variasi: {
                    required: 'Masukkan nama variasi'
                },
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

        validator = $("#variasiForm").validate({
            rules: {
                variasi: {
                    required: true
                },
                list_variasi: {
                    required: true
                },
            },
            messages: {
                variasi: {
                    required: 'Masukkan judul variasi'
                },
                list_variasi: {
                    required: 'Masukkan nama variasi'
                },
            },
            submitHandler: function(form, e) {
                e.preventDefault()
                data = $(form).serializeArray()
                id = $('#variasi_produk_id').val()
                console.log(data)
                $.ajax({
                    type: "post",
                    url: "<?= base_url('save_variasi_product') ?>/" + id,
                    data: data,
                    success: function(res) {
                        if (res = 'true') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil disimpan',
                                showConfirmButton: false,
                                timer: 1000,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                            })
                            $('#modalVariasi').modal('hide')
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan pada server',
                                showConfirmButton: false,
                                timer: 1000,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                            })
                        }
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