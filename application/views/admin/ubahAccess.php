<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-9">
			<form action="<?= base_url('authentifikasi/changeAccess') ?>" method="post">
			<input type="hidden" value="<?= $anggota['id']; ?>" name="id">
			<div class="form-group row">
				<label for="email" class="col-sm-2 col-formlabel">Email</label>
				<div class="col-sm-10">
					<input type="text" class="form-control-plaintext" id="email" name="email" value="<?= $anggota['email']; ?>" readonly>
				</div>
			</div>
			<div class="form-group row">
				<label for="nama" class="col-sm-2 col-formlabel">Nama Lengkap</label>
				<div class="col-sm-10">
					<input type="text" class="form-control-plaintext" id="nama" name="nama" value="<?= $anggota['nama']; ?>" readonly>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">Gambar</div>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-3">
								<img src="<?= base_url('asset/img/profile/') . $anggota['image']; ?>" class="img-thumbnail" alt="">
							</div>
							<div class="col-sm-9 row">
								<div class="form-check mr-3">
								  <input class="form-check-input" type="radio" name="role" id="member" value="2" <?php if($anggota['role_id'] == 2){?> checked <?php } ?>>
								  <label class="form-check-label" for="member">
								    Member
								  </label>
								</div>
								<div class="form-check">
								  <input class="form-check-input" type="radio" name="role" id="admin" value="1"<?php if($anggota['role_id'] == 1){?> checked <?php } ?>>
								  <label class="form-check-label" for="admin">
								    Administrator
								  </label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group row justify-content-end">
					<div class="col-sm-10">
						<button type="submit" class="btn btn-primary">Ubah</button>
						<button class="btn btn-dark" onclick="window.history.go(-1)">Kembali</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->