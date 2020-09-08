<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap.min.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap.min.js"></script>
<script>
	$(document).ready(function() {
		getListParent();

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
					"data": "urutan"
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
				url: `<?= site_url(); ?>kategori/store`,
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
					$('#nama').val(null);
					$('#parent').val('no').trigger('change');
					$('#active').val('1').trigger('change');
					table.draw();
				}
				alert(res.msg);
				$('#add_submit').attr('disabled', false);
				$.unblockUI();
				getListParent();
			});
		});

		$('#form_edit').on('submit', function(e) {
			e.preventDefault();

			let isiData = $(this)[0];
			let formData = new FormData(isiData);

			$.ajax({
				url: `<?= site_url(); ?>kategori/update`,
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

	function getListParent(id = null) {
		$.ajax({
			url: `<?= site_url(); ?>kategori/get_parent`,
			method: 'get',
			dataType: 'json',
			beforeSend: function() {
				$('#form_add').block();
				$('#form_edit').block();
			}
		}).done(function(res) {
			let list_parent = `<option value="no">No Parent</option>`;

			if (res.code == 200) {
				$.each(res.data, function(i, k) {
					if (k.id != id) {
						list_parent += `<option value="${k.id}">${k.nama}</option>`;
					}
				});
			}

			$('#parent').html(list_parent);
			$('#parent_edit').html(list_parent);

			$('#form_add').unblock();
			$('#form_edit').unblock();
		});
	}

	function deleteData(id) {
		let c = confirm('Hapus Kategori ?');

		if (c == true) {
			$.ajax({
					url: `<?= site_url(); ?>kategori/destroy`,
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
					getListParent();
					$.unblockUI();

				});
		}
	}

	function editData(id) {
		$.ajax({
			url: `<?= site_url(); ?>kategori/show`,
			method: 'get',
			dataType: 'JSON',
			data: {
				id: id
			},
			beforeSend: function() {
				$.blockUI();
				$('#edit_id').val(id);
				getListParent(id);
				$('#modal-sub').modal('hide');
			}
		}).done(function(res) {
			console.log(res);
			if (res.code == 404) {
				alert(res.msg);
			} else {
				$('#id_edit').val(res.id);
				$('#nama_edit').val(res.nama);
				$('#parent_edit').val(res.parent).trigger('change');
				$('#active_edit').val(res.active).trigger('change');
				$('#modal-edit').modal('show');
			}

			$.unblockUI();
		});
	}

	function detailData(id) {
		$.ajax({
			url: `<?= site_url(); ?>kategori/sub`,
			method: 'get',
			dataType: 'JSON',
			data: {
				id: id
			},
			beforeSend: function() {
				$.blockUI();
			}
		}).done(function(res) {
			console.log(res)

			if (res.code == 404) {
				$('#vsubbody').html(`<tr><td colspan="5" class="text-center">${res.msg}</td></tr>`)
			} else {
				let html = ``;
				let tombol = ``;
				let updown = ``;
				let totalData = res.items.length;

				$.each(res.items, function(i, k) {

					if (k.urutan == 1) {
						updown = `<button class="btn btn-warning btn-xs" onclick="downData('${k.id}', 'child');"><i class="fa fa-arrow-down fa-fw"></i></button>`;
					} else if (k.urutan == totalData) {
						updown = `<button class="btn btn-success btn-xs" onclick="upData('${k.id}', 'child');"><i class="fa fa-arrow-up fa-fw"></i></button>`;
					} else {
						updown = `
						<button class="btn btn-success btn-xs" onclick="upData('${k.id}', 'child');"><i class="fa fa-arrow-up fa-fw"></i></button>
						<button class="btn btn-warning btn-xs" onclick="downData('${k.id}', 'child');"><i class="fa fa-arrow-down fa-fw"></i></button>
						`;
					}

					tombol = `
					<div class="btn-group">
						<button class="btn btn-danger btn-xs" onclick="deleteData('${k.id}');"><i class="fa fa-trash fa-fw"></i> Delete</button>
						<button class="btn btn-info btn-xs" onclick="editData('${k.id}');"><i class="fa fa-pencil fa-fw"></i> Edit</button>
						${updown}
					</div>
					`;
					html += `
					<tr>
						<td class="text-center">${k.id}</td>
						<td>${k.nama}</td>
						<td class="text-center">${k.urutan}</td>
						<td>${k.active}</td>
						<td class="text-center">${tombol}</td>
					</tr>
					`;
				});
				$('#vsubbody').html(html);
			}
			$('#modal-sub').modal('show');

			$.unblockUI();
			getListParent();

			// $('#form_edit').on('submit', function(e) {
			// 	e.preventDefault();

			// 	let isiData = $(this)[0];
			// 	let formData = new FormData(isiData);

			// 	$.ajax({
			// 		url: `<?= site_url(); ?>kategori/update`,
			// 		method: 'post',
			// 		dataType: 'json',
			// 		data: formData,
			// 		contentType: false,
			// 		processData: false,
			// 		beforeSend: function() {
			// 			$('#edit_submit').attr('disabled', true);
			// 			$.blockUI();
			// 		}
			// 	}).done(function(res) {
			// 		if (res.code == 200) {
			// 			table.draw();
			// 			$('#modal-edit').modal('hide');
			// 		}
			// 		alert(res.msg);
			// 		$('#edit_submit').attr('disabled', false);
			// 		$.unblockUI();
			// 	});
			// });
		});


	}

	function upData(id, type) {
		if (id == null) {
			alert("ID tidak ditemukan");
		} else {
			if (type == 'parent') {
				url = `<?= site_url(); ?>kategori/up_parent`;
			} else {
				url = `<?= site_url(); ?>kategori/up_child`;
			}
			$.ajax({
				url: url,
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
					if (type != 'parent') {
						detailData(res.id_parent);
					}
				} else {
					alert(res.msg)
				}
				$.unblockUI();
			});
		}
	}

	function downData(id, type) {
		if (id == null) {
			alert("ID tidak ditmeukan");
		} else {
			if (type == 'parent') {
				url = `<?= site_url(); ?>kategori/down_parent`;
			} else {
				url = `<?= site_url(); ?>kategori/down_child`;
			}
			$.ajax({
				url: url,
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
