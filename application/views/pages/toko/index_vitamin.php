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
				"url": `<?= site_url('datatables/toko') ?>`,
				"type": "POST"
			},
			"columns": [{
					"data": "no"
				},
				{
					"data": null,
					"render": function(res) {
						html = `<img src="<?= base_url(); ?>public/img/toko_logo/${res.gambar}" class="img-thumbnail" style="width: 80px;" />`;
						return html;
					}
				},
				{
					"data": "nama",
				},
				{
					"data": "alamat"
				},
				{
					"data": "telp"
				},
				{
					"data": 'nama'
				},
				{
					"data": null,
					"render": function(res) {
						let statusActive;
						if (res.ban == '0') {
							statusActive = `Aktif`;
						} else {
							statusActive = `Non Aktif`;
						}
						return statusActive;
					}
				},
				{
					"data": null,
					"render": function(res) {
						let tombolDelete;
						let tombolEdit;
						let tombolStatus;
						let tombolBan;
						let tombolLihatProduk;

						tombolDelete = `<a onclick="deleteData('${res.id}');"><i class="fa fa-trash fa-fw"></i> Delete</a>`;
						tombolEdit = `<a onclick="editData('${res.id}');"><i class="fa fa-pencil fa-fw"></i> Edit</a>`;

						if (res.active == '1') {
							tombolStatus = `<a onclick="gantiStatus('${res.id}', '${res.active}', 'status');"><i class="fa fa-times fa-fw"></i> Non Aktifkan</a>`;
						} else {
							tombolStatus = `<a onclick="gantiStatus('${res.id}', '${res.active}', 'status');"><i class="fa fa-check fa-fw"></i> Aktifkan</a>`;
						}

						if (res.ban == '1') {
							tombolBan = `<a onclick="gantiStatus('${res.id}', '${res.ban}', 'ban');"><i class="fa fa-check fa-fw"></i> Unban Toko</a>`;
						} else {
							tombolBan = `<a onclick="gantiStatus('${res.id}', '${res.ban}', 'ban');"><i class="fa fa-times fa-fw"></i> Ban Toko</a>`;

						}

						tombolLihatProduk = `<a href="javascript:;" onclick="lihatProduk('${res.id}');"><i class="fa fa-search fa-fw"></i> Lihat Produk</a>`;



						// UNTUK SEMENTARA FITUR EDIT & DELETE DI NONAKTIFKAN
						html = `
						<div class="text-center">
							<div class="btn-group" role="group">
								<button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Actions <span class="fa fa-caret-down fa-fw"></span>
								</button>
								<ul class="dropdown-menu dropdown-menu-right">
									<li>${tombolLihatProduk}</li>
									<li role="separator" class="divider"></li>
									<li>${ tombolStatus }</li>
									<li>${ tombolBan }</li>
								</ul>
							</div>
						</div>
						`;
						return html;
					}
				},
			],
			"columnDefs": [{
					"targets": [1, 7],
					"orderable": false,
				},
				{
					"targets": [0, 1, 6, 7],
					"className": "text-center"
				}
			],
		});

	});

	function refreshTable() {
		table.ajax.reload();
	}

	function lihatProduk(id) {
		$.ajax({
			url: `<?= site_url(); ?>toko/show`,
			method: 'get',
			data: {
				id: id
			},
			dataType: 'json',
			beforeSend: function() {
				$.blockUI();
			},
			statusCode: {
				200: function() {
					$.unblockUI();
				},
				404: function() {
					$.unblockUI();
					alert(`<?= ERROR_400_MSG; ?>`);
				},
				500: function() {
					$.unblockUI();
					alert(`<?= ERROR_500_MSG; ?>`);
				},
				503: function() {
					$.unblockUI();
					alert(`<?= ERROR_503_MSG; ?>`);
				},
			},
		}).done(function(res) {
			console.log(res);
			let htmlnya = '';
			if (res.code == 404 || res.total_data == 0) {
				alert("Toko belum memiliki Produk");
			} else {
				no = 1;
				htmlnya = `
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th>Nama Produk</th>
							<th>Kategori</th>
							<th>Harga Asli</th>
							<th>Harga Disc</th>
							<th>Terjual</th>
							<th>Rating</th>
							<th>Tanggal Terdaftar</th>
						</tr>
					</thead>
					<tbody>
				`;
				$.each(res.data, function(i, k) {
					htmlnya += `
							<tr>
								<td>${no}</td>
								<td>${k.nama_produk}</td>
								<td>${k.nama_kategori}</td>
								<td>${k.harga_asli}</td>
								<td>${k.harga_disc}</td>
								<td>${k.terjual}</td>
								<td>${k.rating}</td>
								<td>${k.created_date}</td>
							</tr>
					`;
					no++;
				});

				htmlnya += `</tbody></table>`;

				$('#modal_lihat_produk #nama_toko').html(res.nama_toko);
				$('#modal_lihat_produk .modal-body').html(htmlnya);
				$('#modal_lihat_produk').modal('show');

			}
			$.unblockUI();

		});
	}

	function deleteData(id) {
		let c = confirm('Hapus Akun ?');

		if (c == true) {
			$.ajax({
				url: `<?= site_url(); ?>toko/destroy`,
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
					alert('Hapus Akun Berhasil');
					table.draw();
				} else {
					alert('Hapus Akun Gagal');
				}
				$.unblockUI();

			});
		}
	}

	function gantiStatus(id, status, tipe) {
		let newStatus;
		let targetURL;
		let confirmMessage;

		if (tipe == 'status') {
			if (status == 1) {
				confirmMessage = "Non Aktifkan Toko ?"
			} else {
				confirmMessage = "Aktifkan Toko ?"
			}
		} else {
			if (status == 1) {
				confirmMessage = "Unban Toko ?"
			} else {
				confirmMessage = "Ban Toko ?"
			}
		}

		let cek_confirm = confirm(confirmMessage);

		if (cek_confirm === true) {

			if (tipe == 'status')
				targetURL = `<?= site_url(); ?>toko/change_status/status_toko`;
			else
				targetURL = `<?= site_url(); ?>toko/change_status/ban_toko`;

			$.ajax({
				url: targetURL,
				method: 'post',
				dataType: 'json',
				data: {
					id: id,
					status: status
				},
				beforeSend: function() {
					$.blockUI();
				},
				statusCode: {
					200: function() {
						$.unblockUI();
					},
					404: function() {
						$.unblockUI();
						alert(`<?= ERROR_400_MSG; ?>`);
					},
					500: function() {
						$.unblockUI();
						alert(`<?= ERROR_500_MSG; ?>`);
					},
					503: function() {
						$.unblockUI();
						alert(`<?= ERROR_503_MSG; ?>`);
					},
				},
			}).done(function(res) {
				$.unblockUI();
				if (res.code == 200) {
					alert('Update data berhasil');
				} else {
					alert('Update data gagal, silahkan coba kembali');
				}

				refreshTable();
			});
		}

	}
</script>