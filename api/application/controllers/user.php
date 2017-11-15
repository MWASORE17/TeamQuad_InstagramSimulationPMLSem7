<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller{
	
	private $table = 'users';
	function __construct(){
		parent::__construct();
		$this->load->model('muser');
		$this->load->model('mrole');
		$this->load->library('form_validation');
	}
	
	public function index(){
		if(IsUserLogin()){
			redirect('dashboard');
		}
		$this->load->view('user/login');
	}
	
	public function login1(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		
		
	}
	function Login(){
		// if(IsUserLogin()){
			// redirect();
		// }
		// if(!IsSiteModuleActive(ACCESS_FRONTENDLOGIN)){
			// show_error('This Action is not allowed',403,"Not Allowed");
		// }
		$this->load->library('form_validation');
		$rules = array(
					array(
						'field' => 'UserName',
						'label' => 'Username',
						'rules' => 'required'
					),
					array(
						'field' => 'Password',
						'label' => 'Password',
						'rules' => 'required'
					)
		);
		
		$this->form_validation->set_rules($rules);
		$userrole = $this->muser->GetAllUser(array('UserName'=>$this->input->post('UserName')))->row_array();
		$role = $this->input->post('RoleID') ? $userrole['RoleNo'] : "";
        #echo $role;
		if($this->form_validation->run()){
			if($this->muser->CheckLogin($this->input->post('UserName'),$this->input->post('Password'),$role)){
			    $user = $this->muser->CheckLogin($this->input->post('UserName'),$this->input->post('Password'),$role);
				
				if($this->muser->IsSuspend($user)){
					#show_error(lang('account_suspended'));
					redirect(site_url('user/login')."?msg=suspend&role=".$role);
				}
			
				
				SetUserLogin($this->muser->CheckLogin($this->input->post('UserName'),$this->input->post('Password')));
				
				$name = $this->input->post('UserName');
				$this->db->update($this->table,array('LastLogin'=>date('Y-m-d H:i:s'),'LastIPAddress'=>$this->input->ip_address()),array('UserName'=>$name));
				 
				
				redirect('dashboard');
				
			}else{
				#show_error('Username / password tidak tepat');
				redirect(site_url('user/login')."?msg=notmatch&role=".$role);
			}
		}else{
			$this->load->view('user/login');
		}
	}

	function Logout(){
		UnsetUserLogin("a");
		redirect(site_url());
	}
	function admin(){
		$this->load->view('user/admin');
	}
	function datauser(){
		$data['title'] = 'Daftar User ';
		$data['c'] = $this->muser->GetAll();
		// echo $this->db->last_query();
		
		$this->load->view('user/data', $data);
	}
	function add(){
		$data['edit'] = FALSE;
		// $data['lastid'] = $this->muser->lastid();
		$data['title'] = 'Tambah User';
		$data['c'] = $this->muser->GetAll();
		$data['role'] = $this->mrole->GetAll();
		$rules = array(
			array(
				'field'=>'UserName',
				'label'=>'UserName',
				'rules'=>'required'
			),
			array(
				'field'=>'Password',
				'label'=>'Password',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$UserName = $this->input->post('UserName');	
			$Password = $this->input->post('Password');
			$Password2 = $this->input->post('Password2');
			$RoleNo = $this->input->post('RoleNo');
			$IsSuspend = $this->input->post('IsSuspend');
			
			if($this->muser->CheckUserName($UserName)){
				if ($Password == $Password2){
					
					$user = array(
							COL_USERNAME => $UserName,
							COL_PASSWORD => md5($Password),
							COL_ROLEID => $RoleNo,
							COL_ISSUSPEND => $IsSuspend,
							COL_EMAILADDRESS => $this->input->post('EmailAddress')
					);
					
					$this->muser->insert($user);
					
					redirect(site_url('user/edit/'.$UserName)."?success=1");
				
				}else{
					// ShowJsonError("Password Anda tidak Sesuai");
					redirect(site_url('user/add')."?msg=pass");
					return FALSE;
				}
			}else{
				// ShowJsonError("Username telah terdaftar");
				redirect(site_url('user/add')."?msg=user");
				return FALSE;
			}
			
			
		}else{
			$this->load->view('user/formadduser',$data);
		}	
	}
	
	function edit($username){
		$data['edit'] = TRUE;
		// $data['lastid'] = $this->muser->lastid();
		$data['title'] = 'Edit User';
		$data['result'] = $this->muser->GetAllUser(array(COL_USERNAME => $username))->row_array();
		// echo $this->db->last_query();
		$data['role'] = $this->mrole->GetAll();
		$rules = array(
			array(
				'field'=>'UserName',
				'label'=>'UserName',
				'rules'=>'required'
			),
			
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$UserName = $this->input->post('UserName');	
			$Password = $this->input->post('Password');
			$Password2 = $this->input->post('Password2');
			$RoleNo = $this->input->post('RoleNo');
			$IsSuspend = $this->input->post('IsSuspend');
			
			
				if ($Password == '' && $Password2 == ''){
					
					$user = array(
							
							COL_ROLEID => $RoleNo,
							COL_ISSUSPEND => $IsSuspend,
							COL_EMAILADDRESS => $this->input->post('EmailAddress')
					);
					
					$this->muser->update($user,$username);
					
					redirect(site_url('user/edit/'.$UserName)."?success=1");
				
				}else{
					if ($Password == $Password2){
						$user = array(
								
								COL_ROLEID => $RoleNo,
								COL_PASSWORD => md5($Password),
								COL_ISSUSPEND => $IsSuspend,
								COL_EMAILADDRESS => $this->input->post('EmailAddress')
						);
						
						$this->muser->update($user,$username);
						
						redirect(site_url('user/edit/'.$UserName)."?success=1");
						
					}else{
						// ShowJsonError("Password Anda tidak Sesuai");
						redirect(site_url('user/edit'.$UserName)."?msg=pass");
						return FALSE;
					}
				}
			
			
			
		}else{
			$this->load->view('user/formadduser',$data);
		}	
	}
	function delete(){
		// CheckLogin();
		$data = $this->input->post('cekbox');

		$deleted = 0;
		$deletedcontent = "";

		for ($i=0; $i < count($data); $i++) {
			$row = $this->muser->GetAllUser(array(COL_USERNAME => $data[$i]));
			
			if (CheckRow(TBL_TASKASSIGNMENTS, COL_USERNAME, $data[$i])){
				$this->muser->delete($data[$i]);
	            // $this->mattachment->deleteReference(array(COL_MODULEID => MODULE_TASK, COL_REFERENCEID => $data[$i]));
				// $this->mcomment->deleteByTask($data[$i]);
	            $deleted++;
			}
			
		}
		
		if($deleted){
			ShowJsonSuccess($deleted." data sudah dihapus");
			// redirect('task');
		}else{
			ShowJsonError($deleted." data belum dihapus");
		}
	}
	function changepass(){
		
		$data['title'] = "Ubah Password";
		
		$rules = array(
			array(
				'field'=>'PasswordLama',
				'label'=>'Password Lama',
				'rules'=>'required'
			),
			array(
				'field'=>'Password',
				'label'=>'Password Baru',
				'rules'=>'required'
			),
			array(
				'field'=>'Password2',
				'label'=>'Ulangi Password',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$username = GetUserLogin("UserName");
			$passL = $this->input->post('PasswordLama');
			
			$this->db->where(COL_USERNAME, $username);
			$u = $this->db->get(TBL_USERS)->row_array();
			
			if (md5($passL) == $u[COL_PASSWORD]){
				if($this->input->post('Password') == $this->input->post('Password2')){
					$this->db->where(COL_USERNAME, $username);	
					$this->db->update(TBL_USERS,array(COL_PASSWORD => md5($this->input->post('Password'))));
					
					
					redirect(site_url('user/changepass')."?success=1");
				}else{
					redirect(site_url('user/changepass')."?msg=pass");	
					
				}
				
			}else{
				redirect(site_url('user/changepass')."?msg=plama");
			}
		}
		$this->load->view('user/passwordchange', $data);
	}
}
