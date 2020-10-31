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
        qrCodeIdAnggota = $('#qrcode_id_anggota');

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
                resultContainer.innerHTML += `<div>[${countResults}] - ${qrCodeMessage}</div>`;
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
                    alert("Terjadi masalah dengan database, silahkan coba kembali");
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
</script>