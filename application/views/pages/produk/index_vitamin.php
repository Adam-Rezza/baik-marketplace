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
					"data": "harga_asli"
				},
				{
					"data": "harga_disc"
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
						let active = `Tidak Aktif`;
						if (res.active == 1) {
							active = `Aktif`;
						}
						return active;
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

		$('#form_add').on('submit', function(e) {
			e.preventDefault();

			let isiData = $(this)[0];
			let formData = new FormData(isiData);

			$.ajax({
				url: `<?= site_url(); ?>banner/store`,
				method: 'post',
				contentType: false,
				processData: false,
				dataType: 'json',
				data: formData,
				beforeSend: function() {
					$('#add_submit').attr('disabled', true);
					$.blockUI();
				}
			}).done(function(res) {
				if (res.code == 200) {
					$('#gambar').val(null);
					$('#url').val("#");
					$('#active').val('1').trigger('change');
					table.draw();
				}
				alert(res.msg);
				$('#add_submit').attr('disabled', false);
				$.unblockUI();
			});
		});

		$('#form_edit').on('submit', function(e) {
			e.preventDefault();

			let isiData = $(this)[0];
			let formData = new FormData(isiData);

			$.ajax({
				url: `<?= site_url(); ?>banner/update`,
				method: 'post',
				dataType: 'json',
				data: formData,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$('#edit_submit').attr('disabled', true);
					$.blockUI();
				}
			}).done(function(res) {
				if (res.code == 200) {
					table.draw();
					$('#modal-edit').modal('hide');
				}
				alert(res.msg);
				$('#edit_submit').attr('disabled', false);
				$.unblockUI();
			});
		});

	});

	function deleteData(id) {
		let c = confirm('Hapus Banner ?');

		if (c == true) {
			$.ajax({
					url: `<?= site_url(); ?>banner/destroy`,
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
						$('#modal-sub').modal('hide');
					}

					alert(res.msg);
					$.unblockUI();

				});
		}
	}

	function editData(id) {
		$.ajax({
			url: `<?= site_url(); ?>banner/show`,
			method: 'get',
			dataType: 'JSON',
			data: {
				id: id
			},
			beforeSend: function() {
				$.blockUI();
				$('#edit_id').val(id);
				$('#modal-sub').modal('hide');
			}
		}).done(function(res) {
			console.log(res);
			if (res.code == 404) {
				alert(res.msg);
			} else {
				$('#id_edit').val(res.id);
				$('#gambar_edit').attr('src', res.gambar);
				$('#url_edit').val(res.url);
				$('#active_edit').val(res.active).trigger('change');
				$('#modal-edit').modal('show');
			}

			$.unblockUI();
		});
	}

	function upData(id) {
		if (id == null) {
			alert("ID tidak ditemukan");
		} else {
			$.ajax({
				url: `<?= site_url(); ?>banner/up`,
				method: 'get',
				dataType: 'json',
				data: {
					id: id
				},
				beforeSend: function() {
					$.blockUI();
				},
				error: function(res) {
					$.unblockUI();
				}
			}).done(function(res) {
				console.log(res);
				if (res.code == 200) {
					table.draw();
				} else {
					alert(res.msg)
				}
				$.unblockUI();
			});
		}
	}

	function downData(id) {
		if (id == null) {
			alert("ID tidak ditmeukan");
		} else {
			$.ajax({
				url: `<?= site_url(); ?>banner/down`,
				method: 'get',
				dataType: 'json',
				data: {
					id: id
				},
				beforeSend: function() {
					$.blockUI();
				},
				error: function(res) {
					$.unblockUI();
				}
			}).done(function(res) {
				console.log(res);
				if (res.code == 200) {
					table.draw();
				} else {
					alert(res.msg)
				}
				$.unblockUI();
			});
		}
	}
</script>