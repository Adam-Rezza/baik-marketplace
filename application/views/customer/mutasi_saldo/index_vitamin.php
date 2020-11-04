<link rel="stylesheet" href="<?= base_url(); ?>vendor/components/jqueryui/themes/base/jquery-ui.css" />
<script type="text/javascript" src="<?= base_url(); ?>public/js/jquery.qrcode.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>public/js/html5-qrcode.min.js"></script>
<style>
    .form-input>.select2,
    .form-input>select,
    .form-input>label {
        display: block;
        width: 100 % !important;
    }

    .form-input.select2-selection {
        border: 1 px solid #444;
    }

    .has-error .select2-selection,
    .has-error input,
    .has-error textarea {
        border: 2px solid red !important;
    }

    .has-error .select2-selection:focus,
    .has-error input:focus,
    .has-error textarea:focus {
        border: 2px solid red !important;
    }

    @media only screen and (max-width: 610px) {
        .title-tabs li {
            font-size: 12px;
            padding: 5px;
        }
    }

    .col-centered {
        float: none;
        margin: 0 auto;
    }
</style>

<script src="<?= base_url(); ?>vendor/components/jqueryui/jquery-ui.min.js">
</script>
<script>
    let datepick = $('.datepicker'),
        from = $('#from'),
        to = $('#to'),
        formFilter = $('#form_filter'),
        vresult = $('#vresult'),
        vbody = $('#vbody'),
        modalTransfer = $('#modal_transfer'),
        vTerimaTF = $('#vTerimaTF'),
        vKirimTF = $('#vKirimTF'),
        qrCodeIdAnggota = $('#qrcode_id_anggota'),
        idTujuan = $('#id_tujuan'),
        formTopupDariSukarela = $('#form_topup_dari_sukarela'),
        modalTopupDariSukarela = $('#modal_topup_dari_sukarela'),
        idUserTopup = $('#id_user_topup'),
        nominalTopupSukarela = $('#nominal_topup_sukarela');

    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete" ||
            document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    }

    docReady(function() {
        var resultContainer = document.getElementById('qr_result');
        var lastResult, countResults = 0;

        function onScanSuccess(qrCodeMessage) {
            if (qrCodeMessage !== lastResult) {
                ++countResults;
                lastResult = qrCodeMessage;

                $.ajax({
                    url: `<?= site_url(); ?>get_target_info`,
                    method: 'get',
                    dataType: 'json',
                    data: {
                        id_target: qrCodeMessage
                    },
                    beforeSend: function() {
                        $.blockUI();
                    },
                }).always(function(res) {
                    $.unblockUI();
                }).fail(function(res) {
                    console.log(res);
                }).done(function(res) {
                    console.log(res);

                    if (res.code == 404) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'warning',
                            title: 'ID Tidak Ditemukan',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else if (res.code == 401) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'warning',
                            title: 'Saldo Tidak mencukupi',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else if (res.code == 500) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Terjadi kesalahan dengan database, silahkan refresh halaman',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else if (res.code == 200) {
                        resultContainer.innerHTML += `
                        <div class="row" style="margin-top: 10px;">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <form class="form" id="form_transfer" action="#">
                                    <div class="form-group">
                                        <label for="nama_tujuan">Nama Tujuan</label>
                                        <input type="text" class="form-control" id="nama_tujuan" name="nama_tujuan" value="${res.nama}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="nominal_tf">Nominal TF</label>
                                        <input type="number" class="form-control" id="nominal_tf" name="nominal_tf" value="0" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" id="id_tujuan" name="id_tujuan" value="${qrCodeMessage}">
                                        <button type="submit" class="btn btn-primary btn-block">Transfer</button>
                                    </div>
                                </form>
                            </div>
                        </div>`;

                        $('#form_transfer').on('submit', function(e) {
                            e.preventDefault();

                            $.ajax({
                                url: `<?= site_url(); ?>proses_transfer`,
                                method: 'post',
                                dataType: 'json',
                                data: $('#form_transfer').serialize(),
                                beforeSend: function() {
                                    $.blockUI();
                                },
                            }).always(function(res) {
                                $.unblockUI();
                            }).fail(function(res) {
                                console.log(res);
                            }).done(function(res) {
                                console.log(res);

                                if (res.code == 404) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'warning',
                                        title: 'ID Tidak Ditemukan',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                } else if (res.code == 401) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'warning',
                                        title: 'Saldo Tidak mencukupi',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                } else if (res.code == 500) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: 'Terjadi kesalahan dengan database, silahkan refresh halaman',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                } else if (res.code == 200) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Proses Transfer Berhasil',
                                        showConfirmButton: false,
                                        timer: 2000
                                    }).then(function(r) {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'error',
                                        title: 'unknown response',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                }
                            });
                        });
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'unknown response',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                });
            }
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr_scan", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess);
    });

    $(document).ready(function() {
        qrCodeIdAnggota.qrcode({
            text: '<?= $this->session->userdata(SESSUSER . 'id'); ?>'
        });

        datepick.datepicker({
            dateFormat: 'dd/mm/yy',
            showAnim: 'slide',
            changeMonth: true
        });

        formFilter.on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= site_url(); ?>get_data_mutasi_dompet',
                method: 'get',
                dataType: 'json',
                data: formFilter.serialize(),
                beforeSend: function() {
                    vresult.block();
                }
            }).always(function(res) {
                console.log(res);
                vresult.unblock();
            }).fail(function(res) {
                console.log(res);
            }).done(function(res) {
                console.log(res);
                let html = '';
                if (res.code == 404) {
                    html = `
                    <tr>
                    <td colspan="5" class="text-center">Data Tidak Ditemukan</td>
                    </tr>
                    `;
                } else if (res.code == 500) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Terjadi masalah dengan database, silahkan coba kembali',
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    $.each(res.data, function(i, k) {
                        html += `
                        <tr>
                        <td>${k.tanggal}</td>
                        <td>${k.keterangan}</td>
                        <td>${k.debit}</td>
                        <td>${k.kredit}</td>
                        <td>${k.saldo}</td>
                        </tr>
                        `;
                    });
                }

                vbody.html(html);
            });
        });
    });

    function transfer() {
        modalTransfer.modal('show');
    }

    function terimaTF() {
        vTerimaTF.show('slow');
        vKirimTF.hide('slow');
    }

    function kirimTF() {
        vTerimaTF.hide('slow');
        vKirimTF.show('slow');
    }

    function comingSoon() {
        Swal.fire(
            'Segera Hadir',
            'Sedang dalam tahap pengerjaan',
            'info'
        )
    }

    function topupSukarela() {
        modalTopupDariSukarela.modal('show');

        formTopupDariSukarela.on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: `<?= site_url(); ?>topup_sukarela`,
                method: 'post',
                dataType: 'json',
                data: {
                    id: idUserTopup.val(),
                    nominal: nominalTopupSukarela.val()
                },
                beforeSend: function(res) {
                    $.blockUI();
                }
            }).always(function(res) {
                $.unblockUI();
            }).fail(function(res) {
                console.log(res);
            }).done(function(res) {
                console.log(res);

                if (res.code == 200) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proses Topup dari Sukarela Berhasil',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function(result) {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Terjadi kesalahan dengan database, silahkan refesh halaman',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            });
        });
    }
</script>