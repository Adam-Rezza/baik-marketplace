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
				"url": `<?= site_url('datatables/banner') ?>`,
				"type": "POST"
			},
			"columns": [{
					"data": "id"
				},
				{
					"data": "gambar"
				},
				{
					"data": "url"
				},
				{
					"data": "urutan"
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
				"targets": [1, 3, 4],
				"orderable": false,
			}, {
				"targets": [0, 1, 3, 4],
				"class": "text-center"
			}],
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

	function gantiStatus(id, status) {
		let url = `<?= site_url(); ?>banner/ganti_status`;

		let new_status = '1';
		let text_status = 'Aktif';
		if (status == '1') {
			new_status = '0';
			text_status = 'Non Aktif';
		}

		Swal.fire({
			title: 'Apakah kamu yakin?',
			text: `Kamu akan mengganti status menjadi ${text_status}`,
			icon: 'question',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Ganti!'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: url,
					method: 'post',
					dataType: 'json',
					data: {
						id: id,
						status: new_status
					},
					beforeSend: function() {
						$.blockUI();
					}
				}).fail(function(res) {
					console.log(res);
				}).done(function(res) {
					console.log(res);

					if (res.code == 404) {
						Swal.fire(
							'404',
							'Banner tidak ditemukan, silahkan, refresh halaman',
							'error'
						);
					} else if (res.code == 200) {
						Swal.fire(
							'Success',
							'Proses Ganti Status Berhasil',
							'success'
						);
					} else if (res.code == 500) {
						Swal.fire(
							'500',
							'Proses Ganti Status Gagal',
							'error'
						);
					} else {
						console.log("unknown response");
					}

					table.draw();
					$.unblockUI();
				});
			}
		})


	}
</script>