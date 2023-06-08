<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-10">
			<?php if(validation_errors()){?>
				<div class="alert alert-danger" role="alert">
					<?= validation_errors();?>
				</div>
			<?php }?>

			<?= $this->session->userdata('pesan'); ?>

			<a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#bukuBaruModal">
				<i class="fas fa-file-alt"></i> Buku Baru
			</a>

			<table class="table table-hover text-center">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Nama</th>
						<th scope="col">Alamat</th>
						<th scope="col">E-mail</th>
						<th scope="col">Role ID</th>
						<th scope="col">Aktif</th>
						<th scope="col">Member Sejak</th>
						<th scope="col">Foto</th>
						<?php if($user['role_id'] == 3){ ?>
							<th scope="col">Akses</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php $n = 1; foreach ($anggota as $a) { ?>
						<?php if ($a['role_id'] != 3): ?>
							<tr>
								<th scope="row"><?= $n++; ?></th>
								<td><?= $a['nama']; ?></td>
								<td><?= $a['alamat']; ?></td>
								<td><?= $a['email']; ?></td>
								<td><?= $a['role_id']; ?></td>
								<td><?php if($a['is_active'] == 1){echo "aktif";}else{echo "tidak aktif";} ?></td>
								<td><?= date('Y', $a['tanggal_input']); ?></td>
								<td>
									<picture>
										<source srcset="" type="image/svg+xml">
										<img src="<?= base_url('asset/img/profile/') . $a['image'];?>" class="img-fluid img-thumbnail" alt="..." width="50%">
									</picture>
								</td>
								<?php if ($user['role_id'] == 3): ?>
								<td>
									<a href="<?= base_url('authentifikasi/ubahAccess/').$a['id'];?>" class="badge badge-info">
										<i class="fas fa-edit"></i> Ubah Access
									</a>
								</td>
								<?php endif ?>
							</tr>
						<?php endif ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->