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
					"data": "nama_kategori"
				},
				{
					"data": "nama_sub_kategori"
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
					"targets": [9],
					"orderable": false,
				},
				{
					"targets": [7, 8, 9],
					"class": "text-center"
				},
				{
					"targets": [5, 6, 7],
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
			}).done(function(res) {
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
			}).done(function(res) {
				if (res.code == 200) {
					table.draw();
				}

				alert(res.msg);
				$.unblockUI();

			});
		}
	}

	function showDetail(id) {
		$.ajax({
			url: `<?= site_url(); ?>produk/show`,
			method: 'get',
			data: {
				id: id,
			},
			dataType: 'json',
			beforeSend: function() {
				$.blockUI();
			},
			errors: function() {
				$.unblockUI();
				alert("<?= ERROR_500_MSG; ?>");
			}
		}).done(function(res) {
			let html = ``;
			if (res.code == 404) {
				html = `<tr><td colspan="2" class="text-center">${res.msg}</td></tr>`;
			} else if (res.code == 200) {
				$.each(res.data, function(i, k) {
					html += `
					<tr>
					<td class="text-center"><img src="${k.gambar}" class="img-thumbnail img-responsive" style="width: 180px;" /></td>
					<td class="text-center" style="vertical-align: middle;">${k.actions}</td>
					</tr>
					`;
				});
			}

			console.log(html);

			$('#vdetail').html(html);
			$('#modal_detail').modal('show');

			$.unblockUI();

		});

	}

	function deleteDataGambar(id, id_produk) {
		let c = confirm('Hapus Gambar Produk ?');

		if (c == true) {
			$.ajax({
				url: `<?= site_url(); ?>produk/destroy_gambar`,
				method: 'post',
				data: {
					id: id
				},
				dataType: 'json',
				beforeSend: function() {
					$('#modal_detail').block();
				},
				errors: function() {
					$('#modal_detail').unblock();
					alert("<?= ERROR_500_MSG; ?>");
				}
			}).done(function(res) {
				if (res.code == 200) {
					showDetail(id_produk);
				}

				alert(res.msg);
				$('#modal_detail').unblock();

			});
		}
	}
</script>