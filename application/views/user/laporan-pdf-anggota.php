<!DOCTYPE html>
<html><head>
<title></title>
</head><body>
	<style type="text/css">
		.table-data{
			width: 100%;
			border-collapse: collapse;
		}
		.table-data tr th, .table-data tr td{
			border:1px solid black;
			font-size: 11pt;
			font-family:Verdana;
			padding: 10px 10px 10px 10px;
			margin-top: 3rem;
		}

		h3 {
			font-family:Verdana;
		}
	</style>

	<h3><center>Laporan Data Anggota Perputakaan Online</center></h3>

	<br>
	<br>

	<table class="table-data">
		<tr>
			<th scope="col">#</th>
			<th scope="col">Nama</th>
			<th scope="col">Alamat</th>
			<th scope="col">E-Mail</th>
			<th scope="col">Aktif</th>
			<th scope="col">Member Sejak</th>
		</tr>
		<?php $n = 1; foreach($anggota as $a){ ?>
		<tr>
			<th scope="row"><?= $n++; ?></th>
			<td><?= $a['nama']; ?></td>
			<td><?= $a['alamat']; ?></td>
			<td><?= $a['email']; ?></td>
			<td><?php if($a['is_active'] == 1){echo "aktif";}else{echo "tidak aktif";} ?></td>
			<td><?= date('Y', $a['tanggal_input']); ?></td>
		</tr>
		<?php } ?>
	</table>
</body></html>