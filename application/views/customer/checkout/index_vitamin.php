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
        $('.select2').select2();
        $('.btn-sub-qty').click(function(e) {
            e.preventDefault()
            id = $(this).data('id')
            val = parseInt($('#p-qty-' + id).data('value'))
            i = val < 2 ? 1 : val - 1
            parseInt($('#p-qty-' + id).data('value', i))
            parseInt($('#p-qty-' + id).html(i))
            $('#p-qty-' + id).trigger('change')
        })
        $('.btn-add-qty').click(function(e) {
            e.preventDefault()
            id = $(this).data('id')
            val = parseInt($('#p-qty-' + id).data('value'))
            i = val > 19 ? 20 : val + 1
            parseInt($('#p-qty-' + id).data('value', i))
            parseInt($('#p-qty-' + id).html(i))
            $('#p-qty-' + id).trigger('change')
        })
        $('.btn-qty').change(function(e) {
            e.preventDefault()
            cart_id = $(this).data('cart-id')
            produk_id = $(this).data('product-id')
            harga = parseInt($(this).data('harga'))
            qty = parseInt($(this).data('value'))
            variasi = $('.variasi-' + cart_id).val()
            $.ajax({
                method: 'post',
                dataType: 'json',
                data: {
                    variasi: variasi
                },
                url: "<?= base_url() ?>update_product_cart/" + produk_id + "/" + qty,
                success: function(res) {
                    // console.log(res)
                    $('#p-price-' + cart_id).html('Rp ' + rupiahFormat((harga * qty).toString()))
                    stringqty = `<span class="total-product-cart-son" id="cart-web-total-qty-item-${cart_id}">(x${qty})</span>`
                    $('#cart-web-total-price-item-' + cart_id).html('Rp ' + rupiahFormat((harga * qty).toString()) + stringqty)
                    update_cart_all()
                }
            });
        })
        $('#form_checkout').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Pembayaran?',
                text: "Anda akan membayaran pesanan anda",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url() ?>checkout_transaction",
                        dataType: "json",
                        method: 'post',
                        data: $('#form_checkout').serialize(),
                        success: function(res) {
                            console.log(res)
                            if (res == 'true') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Produk berhasil di checkout',
                                    showConfirmButton: false,
                                    timer: 0,
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                })
                                setTimeout(() => {
                                    window.location.href = '<?= base_url('my_order') ?>'
                                }, 1000)
                            } else if (res == '1') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Transaksi tidak dapat dilakukan',
                                    showConfirmButton: false,
                                    timer: 0,
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                })
                            } else if (res == '2') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Mohon lengkapi alamat terlebih dahulu',
                                    showConfirmButton: false,
                                    timer: 0,
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                })
                                setTimeout(() => {
                                    window.location.href = '<?= base_url('my_account/checkout') ?>'
                                }, 1000)
                            }
                        },
                        error: function(res) {
                            console.log(res);
                        }
                    });
                    return false;
                }
            });
            return false;
        });
        $('input[name="shipping"]').click(() => {
            update_cart_all()
        })

        function update_cart_all() {
            // var totalPriceFinal = parseInt($('input[name="shipping"]:checked').val())
            var totalPriceCart = 0
            var qtyTotal = 0
            $('.btn-qty').each(function(index, element) {
                harga = parseInt($(this).data('harga'))
                qty = parseInt($(this).data('value'))
                total = harga * qty
                qtyTotal += qty
                totalPriceCart += total
            })
            // totalPriceFinal += totalPriceCart
            totalPriceFinal = totalPriceCart
            $('#total-price-cart').html('Rp ' + rupiahFormat(totalPriceCart.toString()))
            $('#cart-web-total-price').html('Rp ' + rupiahFormat(totalPriceCart.toString()))
            $('#total-price-final').html('Rp ' + rupiahFormat(totalPriceFinal.toString()))
            $('#cart-web-total-qty').html(qtyTotal)
        }
    })

    function rupiahFormat(harga) {
        return (harga.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."))
    }
</script>