<style>
    .form-input>.select2,
    .form-input>select,
    .form-input>label {
        display: block;
        width: 100% !important;
    }
</style>

<script>
    $(document).ready(function() {
        //////////////////////////////////////////////////////////////////////
        $('#provinsi').select2();
        $('#kabupaten').select2();
        $('#kecamatan').select2();
        $('#kelurahan').select2();
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
        // Basic Info ///////////////////////////////////////////////////////
        $("#saveBasicInfo").validate({
            rules: {
                name_u: {
                    required: true,
                },
                username_u: {
                    required: true,
                },
                phone_u: {
                    required: true,
                },
            },
            messages: {
                name_u: {
                    required: "Nama wajib diisi",
                },
                username_u: {
                    required: "Username wajib diisi",
                },
                phone_u: {
                    required: "Phone wajib diisi",
                },
            },
            submitHandler: function(form, e) {
                e.preventDefault()
                data = $(form).serialize()
                $.ajax({
                    type: "post",
                    url: "<?= base_url('save_basic_info') ?>",
                    data: data,
                    success: function(res) {
                        // console.log('success', res)
                        if (res == 'true') {
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
                    url: "<?= base_url('save_address') ?>",
                    data: data,
                    success: function(res) {
                        console.log('success<?= $on_shopping ?>', res)
                        if (<?= $on_shopping ? "true" : "false" ?>) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Alamat tersimpan',
                                text: 'Kembali ke halaman checkout',
                                showConfirmButton: false,
                                timer: 0,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                            })
                            setTimeout(() => {
                                window.location.href = '<?= base_url('checkout') ?>'
                            }, 1000)
                        } else if (res == 'true') {
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
                        }
                    },
                    error: function(res) {
                        console.log('error', res)
                    }
                })
            }
        })
    })
</script>