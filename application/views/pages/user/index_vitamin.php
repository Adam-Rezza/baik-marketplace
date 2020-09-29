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
				"url": `<?= site_url('datatables/user') ?>`,
				"type": "POST"
			},
			"columns": [{
					"data": "no"
				},
				{
					"data": null,
					"render": function(res) {
						html = `<img src="<?= base_url(); ?>public/img/user/${res.gambar}" class="img-thumbnail" style="width: 80px;" />`;
						return html;
					}
				},
				{
					"data": "nama",
				},
				{
					"data": "alamat",
				},
				{
					"data": "email"
				},
				{
					"data": "telp"
				},
				{
					"data": 'username'
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
					"data": 'nama_toko'
				},
				{
					"data": null,
					"render": function(res) {
						let tombolBan,
							tombolReset;

						if (res.ban == '1') {
							tombolBan = `<a onclick="gantiStatus('${res.id}', '${res.ban}');"><i class="fa fa-check fa-fw"></i> Unban User</a>`;
						} else {
							tombolBan = `<a onclick="gantiStatus('${res.id}', '${res.ban}');"><i class="fa fa-times fa-fw"></i> Ban User</a>`;
						}

						tombolReset = `<a onclick="resetPassword('${res.id}', '${res.nama}')"><i class="fa fa-key fa-fw"></i> Reset Password</a>`;

						html = `
						<div class="text-center">
							<div class="btn-group" role="group">
								<button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Actions <span class="fa fa-caret-down fa-fw"></span>
								</button>
								<ul class="dropdown-menu dropdown-menu-right">
									<li>${ tombolBan }</li>
									<li>${ tombolReset }</li>
								</ul>
							</div>
						</div>
						`;
						return html;
					}
				},
			],
			"columnDefs": [{
					"targets": [1, 9],
					"orderable": false,
				},
				{
					"targets": [0, 1, 6, 7, 8],
					"className": "text-center"
				}
			],
		});

	});

	function refreshTable() {
		table.ajax.reload();
	}

	function gantiStatus(id, status) {
		let newStatus;
		let targetURL;
		let confirmMessage;

		if (status == 1) {
			confirmMessage = "Unban Toko ?"
		} else {
			confirmMessage = "Ban Toko ?"
		}

		let cek_confirm = confirm(confirmMessage);

		if (cek_confirm === true) {

			targetURL = `<?= site_url(); ?>user/change_status`;

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

	function resetPassword(id, nama) {

		$('#nama_user').text(nama);
		$('#new_password').text('');
		$('#modal_reset').modal('show');

		$('#form_reset').on('submit', function(e) {
			e.preventDefault();

			let new_password = $('#new_password');

			Swal.fire({
				title: `Reset Password ${nama} ?`,
				text: "Jika password direset maka user tidak dapat login dengan password lama",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Reset Password!'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: `<?= site_url(); ?>user/reset_password`,
						method: 'post',
						dataType: 'json',
						data: {
							id: id,
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
							Swal.fire({
								position: 'top-end',
								icon: 'success',
								title: 'Reset Password berhasil',
								showConfirmButton: false,
								timer: 1500
							});
							$('#nama_user').text('');
							$('#new_password').val('');
							$('#modal_reset').modal('hide');
						} else {
							Swal.fire({
								position: 'top-end',
								icon: 'error',
								title: 'Reset Password gagal, silahkan coba kembali',
								showConfirmButton: false,
								timer: 1500
							});
						}

						refreshTable();

						return false;
					});
				}
			});

		});

	}
</script>