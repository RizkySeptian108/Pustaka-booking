<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-9">
			<?= $this->session->flashdata('pesan'); ?>
			<?= form_open_multipart('buku/ubahBuku'); ?>
			<input type="hidden" value="<?= $buku['id']; ?>" name="id">
			<div class="form-group row">
				<label for="judul_buku" class="col-sm-2 col-form-label">Judul Buku</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="judul_buku" name="judul_buku" value="<?= $buku['judul_buku']; ?>">
					<?= form_error('judul_buku', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
			</div>
			<div class="form-group row">
				<label for="id_kategori" class="col-sm-2 col-form-label">Pilih Kategori</label>
				<div class="col-sm-10">
					<select name="id_kategori" class="form-control">
						<option value="">Pilih Kategori</option>
						<?php foreach ($kategori as $k) { ?>
							<option value="<?= $k['id_kategori'];?>" <?php if($buku['id_kategori'] == $k['id_kategori']) {?>selected <?php }?> ><?= $k['nama_kategori'];?></option>
						<?php } ?>
					</select>
					<?= form_error('id_kategori', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
			</div>
			<div class="form-group row">
				<label for="pengarang" class="col-sm-2 col-form-label">Pengarang</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="pengarang" name="pengarang" value="<?= $buku['pengarang']; ?>">
					<?= form_error('pengarang', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
			</div>
			<div class="form-group row">
				<label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="penerbit" name="penerbit" value="<?= $buku['penerbit']; ?>">
					<?= form_error('penerbit', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
			</div>
			<div class="form-group row">
				<label for="tahun" class="col-sm-2 col-form-label">Tahun Terbit</label>
				<div class="col-sm-10">
					<select name="tahun" class="form-control">
							<option value="">Pilih Tahun</option>
							<?php for ($i=date('Y'); $i > 1000 ; $i--) { ?>
								<option value="<?= $i;?>" <?php if($buku['tahun_terbit'] == $i) {?>selected <?php }?>><?= $i;?></option>
							<?php } ?> 
						</select>
						<?= form_error('tahun', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
			</div>
			<div class="form-group row">
				<label for="isbn" class="col-sm-2 col-form-label">ISBN</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="isbn" name="isbn" value="<?= $buku['isbn']; ?>">
					<?= form_error('isbn', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
			</div>
			<div class="form-group row">
				<label for="stok" class="col-sm-2 col-form-label">Stok</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="stok" name="stok" value="<?= $buku['stok']; ?>">
					<?= form_error('stok', '<small class="text-danger pl-3">', '</small>'); ?>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-2">Gambar</div>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-sm-3">
								<img src="<?= base_url('asset/img/upload/') . $buku['image']; ?>" class="img-thumbnail" alt="">
							</div>
							<div class="col-sm-9">
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="image" name="image" value="<?= $buku['image']; ?>">
									<label class="custom-file-label" for="image">Pilih file</label>
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