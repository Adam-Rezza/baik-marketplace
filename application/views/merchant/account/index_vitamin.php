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

    .form-input>.select2,
    .form-input>select,
    .form-input>label {
        display: block;
        width: 100% !important;
    }

    @media only screen and (max-width: 610px) {
        .title-tabs li {
            font-size: 12px;
            padding: 5px;
        }
    }
</style>
<script>
    $(document).ready(function() {
        $('#provinsi').select2()
        $('#kabupaten').select2()
        $('#kecamatan').select2()
        $('#kelurahan').select2()
        $('#provinsi').change(function(e) {
            e.preventDefault()
            parent = $(this).val()
            if (parent) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url() ?>get_kabupaten/" + parent,
                    dataType: 'json',
                    success: function(res) {
                        // console.log('success', res)
                        kab = '<option value="">--Pilih Kota--</option>'
                        kec = '<option value="">--Pilih Kecamatan--</option>'
                        kel = '<option value="">--Pilih Kelurahan--</option>'
                        $.each(res, function(i, v) {
                            kab += '<option value="' + v.id_kab + '">' + v.nama + '</option>'
                        })
                        $('#kabupaten').html(kab)
                        $('#kecamatan').html(kec)
                        $('#kelurahan').html(kel)
                    },
                    error: function(res) {
                        console.log('error', res)
                    }
                })
            } else {
                kab = '<option value="">--Pilih Kota--</option>'
                kec = '<option value="">--Pilih Kecamatan--</option>'
                kel = '<option value="">--Pilih Kelurahan--</option>'
                $('#kabupaten').html(kab)
                $('#kecamatan').html(kec)
                $('#kelurahan').html(kel)
            }
        })
        $('#kabupaten').change(function(e) {
            e.preventDefault()
            parent = $(this).val()
            if (parent) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url() ?>get_kecamatan/" + parent,
                    dataType: 'json',
                    success: function(res) {
                        // console.log('success', res)
                        kec = '<option value="">--Pilih Kecamatan--</option>'
                        kel = '<option value="">--Pilih Kelurahan--</option>'
                        $.each(res, function(i, v) {
                            kec += '<option value="' + v.id_kec + '">' + v.nama + '</option>'
                        })
                        $('#kecamatan').html(kec)
                        $('#kelurahan').html(kel)
                    },
                    error: function(res) {
                        console.log('error', res)
                    }
                })
            }
        })
        $('#kecamatan').change(function(e) {
            e.preventDefault()
            parent = $(this).val()
            if (parent) {
                $.ajax({
                    type: "post",
                    url: "<?= base_url() ?>get_kelurahan/" + parent,
                    dataType: 'json',
                    success: function(res) {
                        // console.log('success', res)
                        kel = '<option value="">--Pilih Kelurahan--</option>'
                        $.each(res, function(i, v) {
                            kel += '<option value="' + v.id_kel + '">' + v.nama + '</option>'
                        })
                        $('#kelurahan').html(kel)
                    },
                    error: function(res) {
                        console.log('error', res)
                    }
                })
            }
        })
        // Basic Info ///////////////////////////////////////////////////////
        $("#basicInfoForm").validate({
            highlight: function(element) {
                $(element)
                    .closest('.form-input')
                    .addClass('has-error')
            },
            unhighlight: function(element) {
                $(element)
                    .closest('.form-input')
                    .removeClass('has-error')
            },
            rules: {
                name_t: {
                    required: true,
                },
                phone_t: {
                    required: true,
                    phone: true,
                },
            },
            messages: {
                name_t: {
                    required: "Nama wajib diisi",
                },
                phone_t: {
                    required: "Phone wajib diisi",
                    phone: "Nomor handphone tidak valid"
                },
            },
            submitHandler: function(form, e) {
                e.preventDefault()
                data = $(form).serialize()
                $.ajax({
                    type: "post",
                    url: "<?= base_url('save_profile_merchant') ?>",
                    data: data,
                    dataType: 'json',
                    success: function(res) {
                        // console.log('success', res)
                        if (res == 'true') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil menyimpan',
                                showConfirmButton: false,
                                timer: 0,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                            })
                            setTimeout(() => {
                                window.location.href = (window.location.href).replaceAll('#', '')
                            }, 1000);
                        }
                    },
                    error: function(res) {
                        console.log('error', res)
                    }
                })
            }
        })
        // Address ///////////////////////////////////////////////////////
        $("#addressForm").validate({
            highlight: function(element) {
                $(element)
                    .closest('.form-input')
                    .addClass('has-error')
            },
            unhighlight: function(element) {
                $(element)
                    .closest('.form-input')
                    .removeClass('has-error')
            },
            rules: {
                alamat: {
                    required: true,
                },
                provinsi: {
                    required: true,
                },
                kabupaten: {
                    required: true,
                },
                kecamatan: {
                    required: true,
                },
                kelurahan: {
                    required: true,
                },
            },
            messages: {
                alamat: {
                    required: "Alamat wajib diisi",
                },
                provinsi: {
                    required: "Provinsi wajib diisi",
                },
                kabupaten: {
                    required: "Kabupaten wajib diisi",
                },
                kecamatan: {
                    required: "Kecamatan wajib diisi",
                },
                kelurahan: {
                    required: "Kelurahan wajib diisi",
                },
            },
            submitHandler: function(form, e) {
                e.preventDefault()
                data = $(form).serialize()
                $.ajax({
                    type: "post",
                    url: "<?= base_url('save_address_merchant') ?>",
                    data: data,
                    dataType: 'json',
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Alamat tersimpan',
                            showConfirmButton: false,
                            timer: 0,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                        })
                        setTimeout(() => {
                            window.location.href = (window.location.href).replaceAll('#', '')
                        }, 1000);
                    },
                    error: function(res) {
                        console.log('error', res)
                    }
                })
            }
        })
    })
</script>