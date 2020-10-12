<style>
    .merchant-header-container {
        text-align: center;
    }

    .left-content-shoping .merchant-header {
        max-height: 150px;
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
        $("#registerMerchantForm").validate({
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
                nama: {
                    required: true,
                    namespace: true
                },
                telp: {
                    required: true,
                    phone: true
                },
                desc: {
                    required: true,
                },
                alamat: {
                    required: true,
                    minlength: 8
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
                ekspedisi: {
                    required: true,
                },
            },
            messages: {
                nama: {
                    required: "Masukkan nama toko",
                    namespace: "Nama mengandung karakter terlarang"
                },
                telp: {
                    required: "Masukkan nomor telepon",
                    phone: "Nomor handphone tidak valid"
                },
                desc: {
                    required: "Masukan Deskripsi Toko",
                },
                alamat: {
                    required: "Masukkan alamat",
                    minlength: "Alamat terlalu pendek"
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
                ekspedisi: {
                    required: "Ekspedisi wajib diisi",
                },
            },
            submitHandler: function(form, e) {
                e.preventDefault()
                data = $(form).serialize()
                $.ajax({
                    type: "post",
                    url: "<?= base_url('register_merchant') ?>",
                    data: data,
                    success: function(res) {
                        console.log('success', res)
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil mendaftarkan toko',
                            text: 'Masuk ke dalam aplikasi merchant',
                            showConfirmButton: false,
                            timer: 0,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                            },
                        })
                        setTimeout(() => {
                            // window.location.href = "<?= base_url() ?>"
                            window.location.href = (window.location.href).replaceAll('#', '')
                        }, 1000);
                    },
                    error: function(res) {
                        console.log('error', res)
                        console.log(res)
                    }
                })
            }
        })

    });
</script>