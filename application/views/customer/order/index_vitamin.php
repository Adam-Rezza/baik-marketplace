<style>
    .button-product-list ul li:first-child a.btn-bg-grey,
    .button-product-list ul li:first-child a.btn-bg-grey:hover {
        background-color: #777;
        color: #fff;
        cursor: not-allowed;
    }
</style>
<script>
    $(document).ready(function() {
        $('.delivered-order').click(function(e) {
            e.preventDefault();
            id = $(this).data('id')
            Swal.fire({
                title: 'Konfirmasi?',
                text: "Terima pesanan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url() ?>delivered_order/" + id,
                        dataType: "json",
                        success: function(res) {
                            if (res) {
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
                                    window.location.href = window.location.href
                                }, 1000)
                            }
                        }
                    })
                }
            })
        })
    })
</script>