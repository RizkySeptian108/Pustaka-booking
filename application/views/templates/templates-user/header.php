<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Pustaka-Booking | <?= $judul; ?></title>
	<link rel="icon" type="image/png" href="<?= base_url('asset/img/logo/'); ?>logo-pb.png">
	<link rel="stylesheet" href="<?= base_url('asset/'); ?>user/css/bootstrap.css">
	<link href="<?= base_url('asset/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url('asset/vendor/'); ?>datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="<?= base_url(); ?>">Pustaka</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controlls="navbarNavAltMarkup" aria-expanded="false" arial-abel="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<a class="nav-item nav-link active" href="<?= base_url(); ?>">
						Beranda <span class="sronly">(current)</span>
					</a>
					<?php if (!empty($this->session->userdata('email'))) { ?>
						<a class="nav-item nav-link" href="<?= base_url('booking'); ?>">
							Booking <b><?= $this->ModelBooking->getDataWhere('temp', ['email_user' => $this->session->userdata('email')])->num_rows(); ?></b> Buku
						</a>
						<a class="nav-item nav-link" href="<?= base_url('member/myprofil'); ?>">Profil Saya</a>
						<a class="nav-item nav-link" href="<?= base_url('member/logout'); ?>">
							<i class="fas fw falogin"></i> Log out
						</a>
					<?php } else { ?>
						<a class="nav-item nav-link" href="<?= base_url('authentifikasi/registrasi'); ?>">
							<i class="fas fw fa-login"></i> Daftar
						</a>
						<a class="nav-item nav-link" href="<?= base_url('authentifikasi'); ?>">
							<i class="fas fw fa-login"></i> Log in
						</a>
					<?php } ?>
					<span class="nav-item nav-link" style="display:block; margin-left:20px;">
						Selamat Datang <b><?= $user; ?></b>
					</span>
				</div>
			</div>
		</div>
	</nav>
	<div class="container mt-5">