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
                                    text: 'Pesanan berhasil diupdate',
                                    showConfirmButton: false,
                                    timer: 0,
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                })
                                setTimeout(() => {
                                    window.location.href = '<?=base_url('my_recent_order')?>'
                                }, 1000)
                            }
                        }
                    })
                }
            })
        })
        $('.complain-order').click(function(e) {
            e.preventDefault()
            Swal.fire({
                icon: 'warning',
                title: 'Fitur sedang dikembangkan',
                showConfirmButton: false,
                timer: 1500,
                onBeforeOpen: () => {
                    Swal.showLoading()
                },
            })
        })
        $('.review-order').click(function(e) {
            e.preventDefault()
            id = $(this).data('id')
            $.ajax({
                url: "<?= base_url() ?>review_transaction/" + id,
                dataType: "json",
                success: function(res) {
                    if (res) {
                        listProduct = `
                                <div class="review ranking-color" style="clear: both">
                                <h4>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                </h4>
                                </div>`
                        $.each(res, function(i, v) {
                            listProduct += `
                                <div class="review" style="clear: both; text-align: left">
                                    <h5><a target="_blank" href="<?= base_url() ?>product/${v.id}">${v.nama}</a></h5>
                                </div>`
                        })
                        Swal.fire({
                            title: 'Review Pesanan Selesai',
                            html: listProduct,
                            showConfirmButton: false,
                            timer: 0,
                        })
                    }
                }
            })
        })
    })
</script>