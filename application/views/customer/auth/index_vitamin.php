<script>
$(document).ready(function () {
    $("#registerMerchantForm").validate({
        rules: {
            nama: {
                required: true,
                namespace: true
            },
            telp: {
                required: true,
                phone: true
            },
            alamat: {
                required: true,
                minlength: 8
            }
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
            alamat: {
                required: "Masukkan alamat",
                minlength: "Alamat terlalu pendek"
            }
        },
        submitHandler: function(form, e) {
            e.preventDefault()
            data = $(form).serialize()
            $.ajax({
                type: "post",
                url: "<?=base_url('register_merchant')?>",
                data: data,
                success: function (res) {
                    console.log('success', res)
                    Swal.fire({
                        icon:  'success',
                        title: 'Berhasil mendaftarkan toko',
                        text:  'Masuk ke dalam aplikasi merchant',
                        showConfirmButton: false,
                        timer: 0,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                    })
                    setTimeout(() => {
                        // window.location.href = "<?=base_url()?>"
                        // window.location.href = window.location.href
                    }, 1000);
                },
                error: function(res){
                    console.log('error', res)
                    console.log(res)
                }
            })
        }
    })
    
});

</script>