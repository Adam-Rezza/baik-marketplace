<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>
<style>
    .button-product-list ul li:first-child a.btn-bg-grey,
    .button-product-list ul li:first-child a.btn-bg-grey:hover {
        background-color: #777;
        color: #fff;
        cursor: not-allowed;
    }

    .button-product-list ul li:first-child a,
    .button-product-list ul li a {
        display: inline-block;
        background: #fe6600;
        width: auto;
        padding: 0 10px;
        font-size: 12px;
    }

    .bg-grey {
        background-color: #777 !important;
        color: #fff;
    }

    .swal2-textarea {
        resize: none;
    }
</style>
<script>
    $(document).ready(function() {
        table = $('#tableOrders').DataTable({

        })
        $('.btn-order').click(function(e) {
            e.preventDefault()
            $.blockUI({
                message: '<img src="<?= base_url() ?>public/megastore/img/ajax-loader.gif" />',
                css: {
                    backgroundColor: 'none',
                    border: 'none',
                },
                baseZ: 1051
            })
            transaksi_id = $(this).data('id')
            $.ajax({
                method: "post",
                url: "<?= base_url() ?>get_transaction_detail/" + transaksi_id,
                dataType: "json",
                success: function(res) {
                    // console.log(res)
                    totalPrice = 0
                    listProduct = "Pesanan :"
                    $.each(res, function(i, v) {
                        totalPrice += (v.harga * v.qty)
                        listProduct += `
                                        <div style="clear: both">
                                            <p class="float-left"><b><a href="<?= base_url() ?>product/${v.produk_id}">${v.produk}</a></b> (x${v.qty})</p>
                                            <p class="float-right">Rp. ${rupiahFormat((v.harga * v.qty).toString())}</p>
                                        </div>`
                    })
                    customerDetail = `<table class="table no-padding">
                                            <tr>
                                                <td >Pengirim</td>
                                                <td>${res[0].pengirim}</td>
                                            </tr>
                                            <tr>
                                                <td >Telp Pengirim</td>
                                                <td>${res[0].telp_pengirim}</td>
                                            </tr>
                                            <tr>
                                                <td >Penerima</td>
                                                <td>${res[0].penerima}</td>
                                            </tr>
                                            <tr>
                                                <td>Telp Penerima</td>
                                                <td>${res[0].telp_penerima}</td>
                                            </tr>
                                            <tr>
                                                <td>Alamat</td>
                                                <td>${res[0].alamat}</td>
                                            </tr>
                                    </table>`
                    $('#order-invoice').html(res[0].invoice)
                    $('.btn-order-update').data('id', transaksi_id)
                    $('#list-product').html(listProduct)
                    $('#customer-detail').html(customerDetail)
                    $('#total-price').html('Rp. ' + rupiahFormat(totalPrice.toString()))
                    if (res[0].status == 10) {
                        $('#failed-reason').html('"' + res[0].failed_reason + '"');
                    }
                    $('.send-order').data('kurir', res[0].id_ekspedisi)
                    $('.kurir').html(res[0].id_ekspedisi.toUpperCase())
                    if(res[0].resi){
                        $('.resi-container').show()
                        $('.resi').html(res[0].resi.toUpperCase())
                    } else {
                        $('.resi-container').hide()
                    }
                    $.unblockUI()
                    $('#modalOrderDetail').modal('show')
                }
            })
        })
        $('#modalOrderDetail').on('shown.bs.modal', function() {
            $(document).off('focusin.modal');
        });
        $('.process-order').click(function(e) {
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
                        url: "<?= base_url() ?>process_order/" + id,
                        dataType: "json",
                        success: function(res) {
                            if (res == "true") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Produk berhasil diterima',
                                    showConfirmButton: false,
                                    timer: 0,
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                })
                                setTimeout(() => {
                                    window.location.href = (window.location.href).replaceAll('#', '')
                                }, 1000)
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Terjadi kesalahan pada server',
                                    showConfirmButton: false,
                                    timer: 1000,
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                })
                            }
                        }
                    })
                }
            })
        })
        $('.send-order').click(function(e) {
            e.preventDefault();
            id = $(this).data('id')
            kurir = $(this).data('kurir')
            Swal.fire({
                title: 'Masukan resi pengiriman ' + kurir.toUpperCase() + '',
                text: "Kirim pesanan",
                icon: 'warning',
                input: 'textarea',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value != "" && result.isConfirmed) {
                    $.ajax({
                        method: "post",
                        url: "<?= base_url() ?>send_order/" + id,
                        dataType: "json",
                        data: {
                            resi: result.value.toUpperCase()
                        },
                        success: function(res) {
                            if (res == "true") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Status produk di update',
                                    showConfirmButton: false,
                                    timer: 0,
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                })
                                setTimeout(() => {
                                    window.location.href = (window.location.href).replaceAll('#', '')
                                }, 1000)
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Terjadi kesalahan pada server',
                                    showConfirmButton: false,
                                    timer: 1000,
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                })
                            }
                        }
                    })
                } else if (result.value == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Resi harus di isi',
                        showConfirmButton: false,
                        timer: 1000,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        }
                    })
                }
            })
        })
        $('.cancel-order').click(function(e) {
            e.preventDefault();
            id = $(this).data('id')
            Swal.fire({
                title: 'Konfirmasi?',
                text: "Masukan alasan pembatalan",
                icon: 'warning',
                input: 'textarea',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                // console.log(result.value != null)
                if (result.value != "" && result.isConfirmed) {
                    $.ajax({
                        method: "post",
                        url: "<?= base_url() ?>cancel_order/" + id,
                        dataType: "json",
                        data: {
                            alasan: result.value
                        },
                        success: function(res) {
                            if (res == "true") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Produk berhasil dibatalkan',
                                    showConfirmButton: false,
                                    timer: 0,
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                })
                                setTimeout(() => {
                                    window.location.href = (window.location.href).replaceAll('#', '')
                                }, 1000)
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Terjadi kesalahan pada server',
                                    showConfirmButton: false,
                                    timer: 1000,
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                })
                            }
                        }
                    })
                } else if (result.value == "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'alasan harus di isi',
                        showConfirmButton: false,
                        timer: 1000,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        }
                    })
                }
            })
        })
    })

    function rupiahFormat(harga) {
        return (harga.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "."))
    }
</script>