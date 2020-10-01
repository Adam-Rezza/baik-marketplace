<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>
<script>
	$(document).ready(function() {

		table = $('#datatables').DataTable({
			"destroy": true,
			"responsive": true,
			"processing": true,
			"scrollX": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				"url": `<?= site_url('datatables/transaksi') ?>`,
				"type": "POST"
			},
			"columns": [{
					"data": "pengirim"
				},
				{
					"data": "telp_pengirim"
				},
				{
					"data": "penerima"
				},
				{
					"data": "telp_penerima"
				},
				{
					"data": null,
					"render": function(res) {
						let html = `<button type="button" class="btn btn-info btn-xs" onclick="showPesanan('${res.id}');"><i class="fa fa-search"></i></button>`;
						return html;
					}
				},
				{
					"data": "alamat"
				},
				{
					"data": "kelurahan"
				},
				{
					"data": "kecamatan"
				},
				{
					"data": "kota"
				},
				{
					"data": "provinsi"
				},
				{
					"data": null,
					"render": function(res) {
						let html = `<span class="label bg-red"><i class="fa fa-times"></i></span>`;
						if (res.process_date != null) {
							html = `
							<span class="label bg-green"><i class="fa fa-check"></i></span>
							<br />
							${res.process_date}
							`;
						}

						return html;
					}
				},
				{
					"data": null,
					"render": function(res) {
						let html = `<span class="label bg-red"><i class="fa fa-times"></i></span>`;
						if (res.shipment_date != null) {
							html = `
							<span class="label bg-green"><i class="fa fa-check"></i></span>
							<br />
							${res.shipment_date}
							`;
						}

						return html;
					}
				},
				{
					"data": null,
					"render": function(res) {
						let html = `<span class="label bg-red"><i class="fa fa-times"></i></span>`;
						if (res.delivery_date != null) {
							html = `
							<span class="label bg-green"><i class="fa fa-check"></i></span>
							<br />
							${res.delivery_date}
							`;
						}

						return html;
					}
				},
				{
					"data": null,
					"render": function(res) {
						let html = `<span class="label bg-red"><i class="fa fa-times"></i></span>`;
						if (res.failed_date != null) {
							html = `
							<span class="label bg-green"><i class="fa fa-check"></i></span>
							<br />
							${res.failed_date}
							<br />
							<button class="btn btn-xs btn-danger" onclick="alert('${res.failed_reason}')"><i class="fa fa-info-circle"></i></button>
							`;
						}

						return html;
					}
				},
			],
			"columnDefs": [{
					"targets": [4],
					"orderable": false,
				},
				{
					"targets": [4, 10, 11, 12, 13],
					"class": "text-center"
				},
				{
					"targets": [],
					"class": "text-right"
				}
			],
		});

	});

	function showPesanan(id) {
		$.ajax({
			url: `<?= site_url(); ?>transaksi/show`,
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
				html = `<tr><td colspan="3" class="text-center">${res.msg}</td></tr>`;
			} else if (res.code == 200) {
				$.each(res.data, function(i, k) {
					html += `
					<tr>
					<td class="text-center">${k.nama_produk}</td>
					<td class="text-center">${k.harga}</td>
					<td class="text-center">${k.qty}</td>
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