<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentifikasi extends CI_Controller
{
	public function index()
	{
		// jika statusnya sudah login, maka tidak bisa mengakses halaman login 
		if($this->session->userdata('email')){
			if($this->session->userdata('role_id') == 1){
				redirect('admin');
			}else{
				redirect('home');
			}		
		}

		$this->form_validation->set_rules('email', 'Alamat Email',
				'required|trim|valid_email', [
				'required' => 'Email Harus diisi!!',
				'valid_email' => 'Email Tidak Benar!!'
		]);

		$this->form_validation->set_rules('password', 'Password',
				'required|trim', [
				'required' => 'Password Harus diisi!!'
		]);

		if ($this->form_validation->run() == false) {
			$data['judul'] = 'Login';
			$data['user'] = '';
			//kata 'login' merupakan nilai dari variabel judul dalam array $data dikirimkan ke view aute_header
			$this->load->view('templates/auth_header', $data);
			$this->load->view('authentifikasi/login');
			$this->load->view('templates/auth_footer');
		} else {
			$this->_login();
		}
	}

	private function _login()
	{
		$email = htmlspecialchars($this->input->post('email', true));
		$password = $this->input->post('password', true);
		$user = $this->ModelUser->cekData(['email' => $email])->row_array();
		
		//jika usernya ada
		if ($user) {
			//jika user sudah aktif
			if ($user['is_active'] == 1) {
				//cek password
				if (password_verify($password, $user['password'])) {
					$data = [
						'email' => $user['email'],
						'role_id' => $user['role_id']
					];

					$this->session->set_userdata($data);

					if ($user['role_id'] == 1 OR $user['role_id'] == 3) {
						redirect('admin');
					} else {
						if ($user['image'] == 'default.jpg') {
							$this->session->set_flashdata('pesan',
							'<div class="alert alert-info alert-message" role="alert">Silahkan
							Ubah Profile Anda untuk Ubah Photo Profil</div>');
						}
						redirect('home');
					}
				} else {
					$this->session->set_flashdata('pesan', '<div
					class="alert alert-danger alert-message" role="alert">Password
					salah!!</div>');

					redirect('authentifikasi');
				} 
			} else {
				$this->session->set_flashdata('pesan', '<div
				class="alert alert-danger alert-message" role="alert">User belum
				diaktifasi!!</div>');

				redirect('authentifikasi');
			}
 		} else {
			$this->session->set_flashdata('pesan', '<div
			class="alert alert-danger alert-message" role="alert">Email tidak
			terdaftar!!</div>');

			redirect('authentifikasi');
 		}
 	}

 	public function cekData($where = null)
	{
		return $this->db->get_where('user', $where);
	}

	public function blok()
	{
		$this->load->view('authentifikasi/blok');
	}

	public function gagal()
	{
		$this->load->view('authentifikasi/gagal');
	}

	public function registrasi()
	{
		if ($this->session->userdata('email')) {
			redirect('user');
		}
		//membuat rule untuk inputan nama agar tidak boleh kosong dengan membuat pesan error dengan
		//bahasa sendiri yaitu 'Nama Belum diisi'
		$this->form_validation->set_rules('nama', 'Nama Lengkap', 'required', 
			['required' => 'Nama Belum diis!!']
		);

		//membuat rule untuk inputan email agar tidak boleh kosong, tidak ada spasi, format email harus valid
		//dan email belum pernah dipakai sama user lain dengan membuat pesan error dengan bahasa sendiri
		//yaitu jika format email tidak benar maka pesannya 'Email Tidak Benar!!'. jika email belum diisi,
		//maka pesannya adalah 'Email Belum diisi', dan jika email yang diinput sudah dipakai user lain,
		//maka pesannya 'Email Sudah dipakai'
		$this->form_validation->set_rules('email', 'Alamat Email', 'required|trim|valid_email|is_unique[user.email]', 
			[
				'valid_email' => 'Email Tidak Benar!!',
				'required' => 'Email Belum diisi!!',
				'is_unique' => 'Email Sudah Terdaftar!'
			]
		);

		// aturan alamat
		$this->form_validation->set_rules('alamat', 'Alamat', 'required|trim', 
			['required' => 'Alamat Belum diis!!']
		);

		//membuat rule untuk inputan password agar tidak boleh kosong, tidak ada spasi, tidak boleh kurang dari
		//dari 3 digit, dan password harus sama dengan repeat password dengan membuat pesan error dengan
		//bahasa sendiri yaitu jika password dan repeat password tidak diinput sama, maka pesannya
		//'Password Tidak Sama'. jika password diisi kurang dari 3 digit, maka pesannya adalah
		//'Password Terlalu Pendek'.
		$this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', 
			[
				'matches' => 'Password Tidak Sama!!',
				'min_length' => 'Password Terlalu Pendek'
			]
		);
		$this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|matches[password1]');
		
		//jika jida disubmit kemudian validasi form diatas tidak berjalan, maka akan tetap berada di
		//tampilan registrasi. tapi jika disubmit kemudian validasi form diatas berjalan, maka data yang
		//diinput akan disimpan ke dalam tabel user
		if ($this->form_validation->run() == false) {
			$data['judul'] = 'Registrasi Member';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('authentifikasi/registrasi');
			$this->load->view('templates/auth_footer');
		} else {
			//buat akun user
			$email = $this->input->post('email', true);
			$data = [
				'nama' => htmlspecialchars($this->input->post('nama', true)),
				'alamat' => htmlspecialchars($this->input->post('alamat', true)),
				'email' => htmlspecialchars($email),
				'image' => 'default.svg',
				'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
				'role_id' => 2,
				'is_active' => 0,
				'tanggal_input' => time()
			];
			$this->ModelUser->simpanData($data); //menggunakan model

			// siapkan token
			$token = base64_encode(random_bytes(32));
			$user_token = [
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			];

			$this->db->insert('user_token', $user_token);

			// panggil method kirim email
			$this->_sendEmail($token, 'verify');

			// alihkan user ke halaman login
			$this->session->set_flashdata(
				'pesan', '<div class="alert alert-success alert-message" role="alert">Selamat!!
				Akun member anda sudah dibuat. Cek email anda untuk aktifasi akun</div>'
			);
				redirect('authentifikasi');
		}
	}

	// kirim email
	private function _sendEmail($token, $tipePenggunaan)
	{
		// buat konfigurasi email
		$config = [
			'protocol' => 'smtp', //simple mail transfer protocol
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_user' => 'rizkydeveloper878@gmail.com',
			'smtp_pass' => 'dhgebvxofgfmfqpk',
			'smtp_port' => 465,
			'mailtype' => 'html',
			'charset' => 'utf-8',
			'newline' => "\r\n"
		];

		//inisalisasi dan kirim email
		$this->email->initialize($config);
		$this->email->from('rizkydeveloper878@gmail.com', 'Pustaka-Booking .Inc');
		$this->email->to($this->input->post('email'));

		if($tipePenggunaan == 'verify'){
			//untuk verifikasi akun
			$this->email->subject('Verifikasi Akun Anda');
			$this->email->message('Klik link dibawah ini untuk aktifasi akun :<a href="'.base_url(). 'authentifikasi/verify?email='.$this->input->post('email').'&token='.urlencode($token).'">Activate</a><br>link ini hanya berlaku untuk 24 jam');
		} else if ($tipePenggunaan == "forgot") {
			// untuk lupa password
			$this->email->subject('Reset Password');
			$this->email->message('Click this link to reset your password :<a href="'.base_url(). 'authentifikasi/resetPassword?email='.$this->input->post('email').'&token='.urlencode($token).'">Reset Password</a><br>link ini hanya berlaku untuk 24 jam');
		}

		$this->email->send();

	}

	// melakukan verifikasi akun
	public function verify()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('user', ['email' => $email])->row_array();

		// jika email ada
		if ($user){
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			// jika token ada
			if($user_token){
				// jika token belum expired
				if(time() - $user_token['date_created'] < (60*60*24)){
					// aktivkan akun
					$this->db->set('is_active', 1);
					$this->db->where('email', $email);
					$this->db->update('user');

					// hapus token
					$this->db->delete('user_token', ['email' => $email]);

					$this->session->set_flashdata('massage', '<div class="alert alert-success" role="alert">
					Akun '.$email.' telah diaktifasi! Silahkan login
					</div>');
					redirect('authentifikasi');
				}else{

					$this->db->delete('user', ['email' => $email]);
					$this->db->delete('user_token', ['email' => $email]);

					$this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">
					Aktifasi akun gagal. Token sudah kadaluarsa! 
					</div>');
					redirect('authentifikasi');
				}
			}else{
				$this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">
				Aktifasi akun gagal. Token tidak valid! 
				</div>');
				redirect('authentifikasi');
			}
		}else{
			$this->session->set_flashdata('massage', '<div class="alert alert-danger" role="alert">
				Aktifasi akun gagal. email salah! 
			</div>');
			redirect('authentifikasi');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Anda telah logout!!</div>');
		redirect('authentifikasi');
	}

	public function ubahAccess()
	{
		$data['judul'] = 'Ubah Akses';
		$data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
		$data['anggota'] = $this->ModelUser->getUserWhere(['id' => $this->uri->segment(3)])->row_array();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/sidebar', $data);
		$this->load->view('templates/topbar', $data);
		$this->load->view('admin/ubahAccess', $data);
		$this->load->view('templates/footer');	
	}

	public function changeAccess()
	{
		$id = $this->input->post('id');
		$role = $this->input->post('role');


		$this->db->set('role_id', $role);
		$this->db->where('id', $id);
		$this->db->update('user');

		$nama = $this->ModelUser->getUserWhere('id', $id)->row_array();
		$this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Akses '.$nama['nama'].' berhasil diubah</div>');
		redirect('user/anggota');
	}

	public function forgotPassword()
	{	
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
		if($this->form_validation->run()== FALSE){
			$data['judul'] = 'Forgot Password';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('authentifikasi/forgotPassword');
			$this->load->view('templates/auth_footer');
		}else{
			$email = $this->input->post('email');
			$user = $this->ModelUser->getUserWhere(['email' => $email])->row_array();

			if(!$user){
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
						Akun belum terdaftar! 
					</div>');
				redirect('authentifikasi/forgotPassword');
			}else if($user['is_active'] != 1){
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
						Akun belum diaktifasi! 
					</div>');
				redirect('authentifikasi/forgotPassword');
			}else{
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				];

				$this->db->insert('user_token', $user_token);

				$this->_sendEmail($token, 'forgot');

				$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
						Cek email anda untuk merubah password! 
					</div>');
				redirect('authentifikasi/forgotPassword');
			}
		}
	}

	public function resetPassword()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->ModelUser->getUserWhere(['email' => $email]);

		if($user){
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
			if ($user_token) {
				// jika token belum expired
				if(time() - $user_token['date_created'] < (60*60*24)){
					$this->session->set_userdata('reset_emailed', $email);
					$this->db->delete('user_token', ['email' => $email]);
					$this->changePassword();
				}else{
					$this->db->delete('user_token', ['email' => $email]);

					$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
					Gagal aktifasi akun. Token kadaluarsa! 
					</div>');
					redirect('authentifikasi');
				}
			}else{
				$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
					Reset password gagal! Token salah! 
				</div>');
				redirect('authentifikasi/forgotPassword');
			}
		}else{
			$this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">
					Reset password gagal! Email salah! 
				</div>');
			redirect('authentifikasi/forgotPassword');
		}
	}

	public function changePassword()
	{
		if(!$this->session->userdata('reset_emailed')){
			redirect('authentifikasi');
		}

		$this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]');
		$this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[3]|matches[password1]');
		if($this->form_validation->run() == false){
			$data['judul'] = 'Change Password';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('authentifikasi/changePassword');
			$this->load->view('templates/auth_footer');
		}else{
			$password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
			$email = $this->session->userdata('reset_emailed');

			$this->db->set('password', $password);
			$this->db->where('email', $email);
			$this->db->update('user');

			$this->session->userdata('resete_emailed');
			$this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">
					Password telah di ubah, silahkan login! 
				</div>');
			redirect('authentifikasi');
		}
	}
}
