<script>
    $(document).ready(function() {
        $('#btn-sub-qty').click(function(e) {
            e.preventDefault()
            val = parseInt($('#btn-qty').data('value'))
            i = val < 2 ? 1 : val - 1
            parseInt($('#btn-qty').data('value', i))
            parseInt($('#btn-qty').html(i))
        })
        $('#btn-add-qty').click(function(e) {
            e.preventDefault()
            val = parseInt($('#btn-qty').data('value'))
            i = val > 19 ? 20 : val + 1
            parseInt($('#btn-qty').data('value', i))
            parseInt($('#btn-qty').html(i))
        })
        $('#add-to-cart').click(function(e) {
            e.preventDefault()
            if (<?= $this->session->userdata(SESS . 'id') !== null ? 1 : 0 ?>) {
                produk_id = $(this).data('id')
                qty = $('#btn-qty').data('value')
                $.ajax({
                    url: "<?= base_url() ?>add_to_cart/" + produk_id + "/" + qty,
                    success: function(res) {
                        // console.log(res)
                        if (res == "true") {
                            Swal.fire({
                                icon: 'success',
                                text: 'Produk ditambahkan kedalam keranjang',
                                showConfirmButton: false,
                                timer: 0,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                            })
                            setTimeout(() => {
                                window.location.href = '<?= base_url() ?>checkout'
                            }, 1000);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                text: 'Produk tidak valid',
                                showConfirmButton: false,
                                timer: 1000,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                },
                            })
                        }
                    }
                });
            } else {
                $('#modalAuth').modal('show');
            }
        })
    })
</script>