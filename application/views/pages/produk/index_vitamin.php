<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>
<script>
	$(document).ready(function() {

		table = $('#datatables').DataTable({
			"destroy": true,
			"responsive": true,
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				"url": `<?= site_url('datatables/produk') ?>`,
				"type": "POST"
			},
			"columns": [{
					"data": "nama_toko"
				},
				{
					"data": "nama"
				},
				{
					"data": "harga_asli_rp"
				},
				{
					"data": "harga_disc_rp"
				},
				{
					"data": "terjual"
				},
				{
					"data": "rating"
				},
				{
					"data": null,
					"render": function(res) {
						let ban = `Tidak Aktif`;
						if (res.ban == 0) {
							ban = `Aktif`;
						}
						return ban;
					}
				},

				{
					"data": "actions",
				},
			],
			"columnDefs": [{
					"targets": [7],
					"orderable": false,
				},
				{
					"targets": [5, 6, 7],
					"class": "text-center"
				},
				{
					"targets": [2, 3, 4],
					"class": "text-right"
				}
			],
		});

	});

	function deleteData(id) {
		let c = confirm('Hapus Produk ?');

		if (c == true) {
			$.ajax({
					url: `<?= site_url(); ?>produk/destroy`,
					method: 'post',
					data: {
						id: id
					},
					dataType: 'json',
					beforeSend: function() {
						$.blockUI();
					},
					errors: function() {
						$.unblockUI();
						alert("<?= ERROR_500_MSG; ?>");
					}
				})
				.done(function(res) {
					if (res.code == 200) {
						table.draw();
					}

					alert(res.msg);
					$.unblockUI();

				});
		}
	}

	function banData(id, ban) {
		let pesan = ``;
		if (ban == 0) {
			pesan = `Non Aktifkan Produk ?`;
		} else {
			pesan = `Aktifkan Produk ?`;
		}
		let c = confirm(pesan);

		if (c == true) {
			$.ajax({
					url: `<?= site_url(); ?>produk/ban`,
					method: 'post',
					data: {
						id: id,
						ban: ban,
					},
					dataType: 'json',
					beforeSend: function() {
						$.blockUI();
					},
					errors: function() {
						$.unblockUI();
						alert("<?= ERROR_500_MSG; ?>");
					}
				})
				.done(function(res) {
					if (res.code == 200) {
						table.draw();
					}

					alert(res.msg);
					$.unblockUI();

				});
		}
	}
</script>
