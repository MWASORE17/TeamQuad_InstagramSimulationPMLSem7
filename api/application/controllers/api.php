<?php
/**
 * 
 */
class Api extends MY_Controller{
	
	function __construct() {
		parent::__construct();
		header('Content-type: application/json');
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
	}
    
	function GetUserByToken($token){
		if(!$token){
			return "";
		}
		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(!empty($username)){
			return $username['UserName'];
		}else{
			return "";
		}
	}
	function GetUserToken($token){
		if(!$token){
			return "";
		}
		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(!empty($username)){
			ShowJsonSuccess("Get User Success ",$username);
		}else{
			ShowJsonError("Get User Failed ",$username);
		}
	}

	function GetUser($username){
		if(!$username){
			return "";
		}
		$username = $this->db->where('UserName',$username)->get('users')->row_array();
		if(!empty($username)){
			return $username['UserName'];
		}else{
			return "";
		}
	}
	
	function GetUserByEmail(){
		$email = $this->input->get('email');
		if(!$email){
			return "";
		}
		$username = $this->db->where(COL_EMAIL,$email)->get(TBL_USERINFORMATION)->row_array();
		if(!empty($username)){
			ShowJsonSuccess($username[COL_EMAIL]);
		}else{
			ShowJsonError(1);
		}
	}
	
	function addPost(){
		$token = $this->input->post('token');
		if(empty($token)){
			ShowJsonError("Token Kosong");
			return;
		}
		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(empty($username)){
			ShowJsonError("Username tidak ditemukan");
			return;
		}

		$image = $this->input->post('image');
		$ImagePath = $username['UserName'] . mktime(). ".jpg";
		file_put_contents("assets/images/uploaded/".$ImagePath, base64_decode($image));

		$insertdata = array(
			'UserName'=>$username['UserName'],
			'ImagePath'=> $ImagePath,
			'Content'=>$this->input->post('Content') ? $this->input->post('Content') : null,
			'Location'=>$this->input->post('Location') ? $this->input->post('Location') : null,
			'CreatedOn'=> date('Y-m-d H:i:s'),
		);
		if($this->db->insert('posts',$insertdata)){
			ShowJsonSuccess("Berhasil Post");
		}else{
			ShowJsonError("Gagal Post");
		}		
	}

	function getPostDetail(){
		$id = $this->input->get('id');
		if(empty($id)){
			ShowJsonError('ID kosong');
			return;
		}
		$this->db->where('PostID',$id);
		$post = $this->db->get('posts');
		
		$count = $post->num_rows();

		if(!$count){
			ShowJsonError('Data tidak ditemukan');
			return;
		}

		$d = $post->row_array();

		$data = array(
			'PostID' => $d['PostID'],
			'ImagePath' => $d['ImagePath'],
			'UserName' => $d['UserName'],
			'Content' => $d['Content'],
			'Location' => $d['Location'],
			'CreatedOn' => $d['CreatedOn']
		);
			
		echo json_encode($data);
	}
	
	function getTimelinePost($token){
		if(!$token){
			ShowJsonError("Token Kosong");
			return;
		}
		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(empty($username)){
			ShowJsonError("Username tidak ditemukan");
			return;
		}
		
		$query = $this->db->query(
			"Select u.UserName, p.PostID, p.UserId, p.ImagePath, p.Content, p.Location, p.CreatedOn,
			(SELECT COUNT(c.id) FROM comment c where c.post_id = p.PostID) as TotalComment,
			(SELECT COUNT(l.id) FROM likes l where l.post_id = p.PostID) as TotalLikes
			from 
        users u inner join posts p on p.UserId = u.id 
				where u.id = '". $username['id'] ."' or u.id in (Select a.follow_user_id from follow a where a.user_id = '". $username['id'] ."') ORDER BY p.CreatedOn DESC"
			);

		$data = array("status" => true, "message" => "get Timeline Success", "data" => $query->result());

		newJson($data);
	}

	function getPostUser(){
		$username = $this->input->get('username');
		if(empty($username)){
			ShowJsonError("Username Kosong");
			return;
		}
		$username = $this->GetUser($username);

		if(empty($username)){
			ShowJsonError("Username tidak ditemukan");
			return;
		}
		
		$this->db->where('UserName',$username);
		$this->db->order_by('CreatedOn','asc');
		$post = $this->db->get('posts');
		
		$data = array();
		$i = 0;
		foreach($post->result_array() as $d){
			$data[$i] = array(
							'PostID' => $d['PostID'],
							'ImagePath' => $d['ImagePath'],
							'Content' => $d['Content'],
							'Location' => $d['Location'],
							'CreatedOn' => $d['CreatedOn']
						);
			$i++;
		}
		
		echo json_encode($data);
	}
		
	function GetComment(){
		$postid = $this->input->get('postid');
		$this->db->where(array(COL_ISVERIFIED=>1));
		$this->db->where(COL_POSTID,$postid);
		$this->db->order_by(COL_COMMENTTIME,'asc');
		$comment = $this->db->get(TBL_COMMENTS);
		
		$data = array();
		$i = 0;
		foreach($comment->result_array() as $cmt){
			$data[$i] = array(
							COL_NAME => $cmt[COL_NAME],
							COL_EMAIL => $cmt[COL_EMAIL],
							COL_WEBSITE => $cmt[COL_WEBSITE],
							COL_COMMENT => $cmt[COL_COMMENT]
						);
			$i++;
		}
		
		echo json_encode($data);
	}
		
	function InsertComment(){
		$post = $this->input->get('post');
		if(empty($post)){
			ShowJsonError('Post ID kosong');
			return;
		}
        $captcha = $this->session->userdata('Captcha');
        $usercaptcha = $this->input->post('captcha');
        
        if(isset($_POST['captcha'])){
            if($captcha != $usercaptcha){
				$res = array('error'=>'Kode captcha tidak tepat');
				echo json_encode($res);
				return;
            }
        }
		$data = array(
					COL_POSTID=>$post,
					COL_NAME=>$this->input->post('nama'),
					COL_EMAIL=>$this->input->post('email'),
					COL_WEBSITE=>$this->input->post('website'),
					COL_COMMENTTIME=>date('Y-m-d H:i:s'),
					COL_COMMENT=>$this->input->post('pesan'),
					COL_ISVERIFIED=>0

		);

		$this->db->insert(TBL_COMMENTS,$data);

		$berita = $this->db->where(COL_POSTID,$post)->get(TBL_POSTS)->row();

		$this->load->model('mpost');
		$rowpost = $this->mpost->GetAll(array('p.'.COL_POSTID=>$post))->row();
		
		#$this->load->library('email',$config);
		$this->load->library('email',GetEmailConfig());
		$this->email->set_newline("\r\n");
		
		$this->email->from(GetSetting('EmailSender'), GetSetting('EmailSenderName'));
		$this->email->to(GetSetting('AdminEmail'));
		if(CCEMAIL){
			$this->email->cc(CCEMAIL);
		}
		//$this->email->cc('deka@somemail.com');
		//$this->email->bcc('them@their-example.com');
		
		$message = "Email: ".$this->input->post('email')." <br />";
		$message .= "Nama: ".$this->input->post('nama')." <br />";
		$message .= "Post: Komentar pada ".$rowpost->PostTitle."<br />";
		$message .= "Pesan: ".$this->input->post('pesan')."<br />";
		$this->email->subject("Komentar pada ".$rowpost->PostTitle." | ".SITENAME);
		$this->email->message($message);
		$this->email->send();

		$res = array('error'=>0,'message'=>'Email anda berhasil didaftarkan');
		echo json_encode($res);
	}
	
	function Getaccount(){
		$token = $this->input->post('token');
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		$username = $this->GetUserByToken($token);

		if(empty($username)){
			ShowJsonError('Username tidak ditemukan');
			return;
		}
		$this->db->where('UserName', $username);
		$a = $this->db->get('users')->row_array();
		$res = array(
			'UserName' => $a['UserName'],
			'Email' => $a['Email'],
			'Name' => $a['Name'],
			'ImagePath' => $a['ImagePath'],
		);
		
		echo json_encode($res);
	}

	function CheckLogin(){
		$this->load->library('user_agent');
		
		$username = $this->input->post('UserName');
		$password = $this->input->post('Password');
		
		if(!$username){
			$data = array("status" => false, "message" => "Username tidak valid");
			newJson($data);
			return;
		}
		
		$this->load->model('muser');
		$this->db->where("((UserName = '".$username."') OR (Email = '".$username."'))");
		$this->db->where(COL_PASSWORD,md5($password));
		$row = $this->db->get('users u')->row_array();
		
		$ceklogin = $this->muser->CheckLogin($username,$password);
    	$status = 1;
		$token = "";
		$message = "";
				
	    if($ceklogin){
			$token = vEncode($username);
			$data = array('Token' => $token);		
			$this->db->where(COL_USERNAME,$row[COL_USERNAME]);
			$this->db->update('users',$data);
			$data = new StdClass();
			$data->token = $token;
			$data = array("status" => true, "message" => "Login Berhasil", "data" => $token);
				
	    }else{
	      $data = array("status" => false, "message" => "Username / Password tidak tepat");
		}
    	newJson($data);
	}
	
	function postRegisterUser(){
		$this->load->model('muser');
        $username = $this->input->post('UserName');
		$password = $this->input->post('Password');
		$rpassword = $this->input->post('RPassword');
		$email = $this->input->post('Email');
        
        $rules = array(
			array(
				'field'=>'Password',
				'label'=>'Password',
				'rules'=>'required|min_length[6]'
			),
			array(
				'field'=>'RPassword',
				'label'=>'Repeat Password',
				'rules'=>'required|matches[Password]'
			),
		);
		$this->load->library('form_validation');
		$this->form_validation->set_rules($rules);
		$error = "";
		if(!$this->form_validation->run()){
			$error .= validation_errors();
		}
				
		$cekuser = $this->muser->IsUsernameExist($username);
		if($cekuser){
			$error .= 'UserName Already Registered';
		}
			
		if(!empty($error)){
			$data = array("status" => false, "message" => $error);
			ShowJsonError($error);
			return;
		}
		
		$insertdata = array(
			COL_USERNAME=>$username,
			COL_PASSWORD=>md5($password),
			'Email'=>$email,
		);
				
		if($this->muser->insert($insertdata)){
			ShowJsonSuccess("Registrasi Berhasil");	
		}else{
			ShowJsonError("Registrasi Gagal");
		}
	}
	
	function _isValidNumber($hp){
		if(!is_numeric($hp) || strlen($hp) < 10 || strlen($hp) > 12){
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	function searchresume(){
		$this->load->model('muser');
		
		$token = $this->input->get('token');
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		$data['username'] = $this->GetUserByToken($token);
		$nama = $this->input->get('nama');
		#$umurdari = $this->input->post('umurdari');
		#$umursampai = $this->input->post('umursampai');
		$provinsi = $this->input->get('provinsi');
		$cat = $this->input->get('category');
		$joblevel = $this->input->get('joblevel');
		$education = $this->input->get('qualification');
		$jobtype = $this->input->get('jobtypes');
		
		if(!empty($nama)){
			$this->db->like('ui.'.COL_FIRSTNAME,$nama);
		}

		if(!empty($provinsi)){
			$this->db->where('ui.'.COL_PROVINCEID,$provinsi);
		}
		
		if(!empty($cat)){
			$this->db->join(TBL_USERJOBCATEGORIES, ''.TBL_USERJOBCATEGORIES.'.'.COL_USERNAME.' = p.'.COL_USERNAME.'','inner');
			$this->db->where(''.TBL_USERJOBCATEGORIES.'.'.COL_JOBCATEGORYID.'',$cat);
		}
		
		if(!empty($joblevel)){
			$this->db->where('ui.'.COL_RECENTLEVELID,$joblevel);
		}
		
		if(!empty($education)){
			$this->db->where('ui.'.COL_LATESTEDUCATIONID,$education);
		}
		
		if(!empty($jobtype)){
			$this->db->join(''.TBL_USERJOBTYPES.'', ''.TBL_USERJOBTYPES.'.'.COL_USERNAME.' = p.'.COL_USERNAME.'','inner');
			$this->db->where(''.TBL_USERJOBTYPES.'.'.COL_JOBTYPEID.'',$jobtype);
		}
		
		$data['result'] = $result = $this->muser->GetAll(array('p.'.COL_ROLEID=>JOBSEEKERROLE));
		$this->load->view(MLD_PREFIX.'/findresumes',$data);
	}
	
	function updateaccount(){
		$token = $this->input->post('token');
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		if(empty($this->input->post('Email'))){
			ShowJsonError('Email kosong');
			return;
		}
		$username = $this->GetUserByToken($token);

		if(empty($username)){
			ShowJsonError('Username tidak ditemukan');
			return;
		}
		
		$insertdata = array(
			'Name'=>$this->input->post('Name') ? $this->input->post('Name') : null,
			'ImagePath'=>$this->input->post('ImagePath') ? $this->input->post('ImagePath') : null,
			'Email'=>$this->input->post('Email') ? $this->input->post('Email') : null,
		);
		$this->db->where('UserName',$username);
		$this->db->update('users',$insertdata);
	
		ShowJsonSuccess('Berhasil simpan');
	}

	function getChangePassword(){
		$token = $this->input->post('token');
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		$username = $this->GetUserByToken($token);
		if(empty($username)){
			ShowJsonError('Username tidak ditemukan');
			return;
		}
		
		if(empty($this->input->post('Password'))){
			ShowJsonError('Password kosong');
			return;
		}

		if($this->input->post('Password') != $this->input->post('RPassword')){
			ShowJsonError('Password baru tidak sama');
			return;
		}
		
		$result = $this->db->where('UserName',$username)->get('users')->row_array();
		$rpassword = $result['Password'];
		$postpassword = $this->input->post('OldPassword');
		
		if($rpassword != md5($postpassword)){
			ShowJsonError('Password lama tidak valid');
			return;
		}
		
		$insertdata = array(
			'Password'=>md5($this->input->post('Password')),
		);
		$this->db->where('UserName',$username);
		$this->db->update('users',$insertdata);
		ShowJsonSuccess('Berhasil ubah password');
	}
}
