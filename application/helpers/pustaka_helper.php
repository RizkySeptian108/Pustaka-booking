<?php
function cek_login()
{
	$ci = get_instance();
	if (!$ci->session->userdata('email')) {
		$ci->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Akses ditolak. Anda belum login!!</div>');
		if($ci->session->user_data('role_id') == 1 OR $ci->session->user_data('role_id') == 3){
			redirect('authentifikasi');
		}else{
			redirect('home');
		}
		
	} else {
		$role_id = $ci->session->userdata('role_id');
		$id_user = $ci->session->userdata('id_user');
	}
}

function cek_user()
{
	$ci = get_instance();

	$role_id = $ci->session->userdata('role_id');
	if ($role_id == 2) {
 		redirect('authentifikasi/blok');
	}
}