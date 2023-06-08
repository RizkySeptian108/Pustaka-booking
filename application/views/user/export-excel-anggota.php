<?php 
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=$title.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>

<h3><center>Laporan Data Buku Perputakaan Online</center></h3>

<br>
<br>

<table class="table-data">
	<thead>
		<tr>
			<th scope="col">#</th>
			<th scope="col">Nama</th>
			<th scope="col">Alamat</th>
			<th scope="col">E-Mail</th>
			<th scope="col">Aktif</th>
			<th scope="col">Member Sejak</th>
		</tr>
	</thead>

	<tbody>
		<?php $n = 1; foreach ($anggota as $a) { ?>
		<tr>
			<th scope="row"><?= $n++; ?></th>
			<td><?= $a['nama']; ?></td>
			<td><?= $a['alamat']; ?></td>
			<td><?= $a['email']; ?></td>
			<td><?php if($a['is_active'] == 1){echo "aktif";}else{echo "tidak aktif";} ?></td>
			<td><?= date('Y', $a['tanggal_input']); ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

