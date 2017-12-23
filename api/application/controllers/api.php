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
			'UserId'=>$username['id'],
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

	function getPostDetail($token, $id){
		if(!$token){
			ShowJsonError("Token Kosong");
			return;
		}
		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(empty($username)){
			ShowJsonError("Username tidak ditemukan");
			return;
		}

		if(empty($id)){
			ShowJsonError('ID kosong');
			return;
		}
		$post = $this->db->query(
			"Select COALESCE(l.IsUnlike, 1) As IsUnlike, u.UserName, p.PostID, p.UserId, u.ImagePath As UserImagePath, p.ImagePath, p.Content, p.Location, p.CreatedOn,
			(SELECT COUNT(c.id) FROM comment c where c.post_id = p.PostID) as TotalComment,
			(SELECT COUNT(l.id) FROM likes l where l.post_id = p.PostID and l.IsUnLike = 0) as TotalLikes
			from 
        users u inner join posts p on p.UserId = u.id left join likes l on l.post_id = p.PostID
				where p.PostID = '". $id ."' ORDER BY p.CreatedOn DESC"
			);
		
		$count = $post->num_rows();

		if(!$count){
			ShowJsonError('Data tidak ditemukan');
			return;
		}
		$d = $post->row_array();
		$data = array("status" => true, "message" => "get Post Detail Success", "data" => $d);

		newJson($data);
	}
	
	function getFeeds($token){
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
			"Select 
				Distinct p.PostID,
				COALESCE((Select COALESCE(ll.IsUnlike, 1) from posts pp inner join likes ll on pp.PostID = ll.post_id where ll.user_id = '". $username['id'] ."' and pp.PostID = p.PostID), 1)As IsUnlike, 

				u.UserName, p.UserId, u.ImagePath As UserImagePath, p.ImagePath, p.Content, p.Location, p.CreatedOn,

				(SELECT COUNT(c.id) FROM comment c where c.post_id = p.PostID) as TotalComment,
				(SELECT COUNT(l.id) FROM likes l where l.post_id = p.PostID and l.IsUnLike = 0) as TotalLikes
					from 
				        users u inner join posts p on p.UserId = u.id left join likes l on p.PostID = l.post_id
				        where u.id = '". $username['id'] ."' or u.id in (Select DISTINCT(a.follow_user_id) from follow a where a.user_id = '". $username['id'] ."') 
				                ORDER BY p.CreatedOn DESC"
			);

		$count = $query->num_rows();

		if(!$count){
			ShowJsonError('Data tidak ditemukan');
			return;
		}
		$data = array("status" => true, "message" => "get Timeline Success", "data" => $query->result());

		newJson($data);
	}

	function getPostUser($token){
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
			"Select 
				Distinct p.PostID,
				COALESCE((Select COALESCE(ll.IsUnlike, 1) from posts pp inner join likes ll on pp.PostID = ll.post_id where ll.user_id = '". $username['id'] ."' and pp.PostID = p.PostID), 1)As IsUnlike, 

				u.UserName, p.UserId, u.ImagePath As UserImagePath, p.ImagePath, p.Content, p.Location, p.CreatedOn,

				(SELECT COUNT(c.id) FROM comment c where c.post_id = p.PostID) as TotalComment,
				(SELECT COUNT(l.id) FROM likes l where l.post_id = p.PostID and l.IsUnLike = 0) as TotalLikes
					from 
				        users u inner join posts p on p.UserId = u.id left join likes l on p.PostID = l.post_id
				        where u.id = '". $username['id'] ."'  
				                ORDER BY p.CreatedOn DESC"
			);

		$count = $query->num_rows();

		if(!$count){
			ShowJsonError('Data tidak ditemukan');
			return;
		}
		$data = array("status" => true, "message" => "get User Post Success", "data" => $query->result());

		newJson($data);
	}
		
	function GetComment(){
		$token = $this->input->post('token');
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(empty($username)){
			ShowJsonError('Username tidak ditemukan');
			return;
		}

		$id = $this->input->post('id');
		if(empty($id)){
			ShowJsonError('ID kosong');
			return;
		}
		
		$comment = $this->db->query("Select c.id, c.post_id, c.user_id, c.content, c.created_on, u.UserName as username, u.ImagePath as user_image from users u inner join comment c on u.id = c.user_id inner join posts p on p.PostID = c.post_id where c.post_id = '". $id ."'");
		
		ShowJsonSuccess("Data ditemukan", $comment->result());
	}
		
	function InsertComment(){
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

		$id = $this->input->post('id');
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

		$userid = $this->db->where('Token',$token)->get('users')->row_array();
		$data = array(
					'post_id'=>$id,
					'user_id'=>$userid['id'],
					'content'=>$this->input->post('content'),
					'created_on'=>date('Y-m-d H:i:s')

		);

		if($this->db->insert('comment',$data)){
			ShowJsonSuccess("Komentar Berhasil");	
		}else{
			ShowJsonError("Komentar Gagal");
		}
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
		
		ShowJsonSuccess("Get Account Success", $res);
	}

	function GetUserProfile(){
		$token = $this->input->post('token');
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(empty($username)){
			ShowJsonError("Username tidak ditemukan");
			return;
		}

		$query = $this->db->query(
			"Select u.id, u.UserName, u.Password, u.Name, u.Email, u.ImagePath, u.Token,
(Select count(a.follow_user_id) from follow a where a.follow_user_id = '". $username['id'] ."') as TotalFollowers,
(Select count(a.follow_user_id) from follow a where a.user_id = '". $username['id'] ."') as TotalFollowing,
(SELECT COUNT(l.PostID) FROM posts l where l.UserId = '". $username['id'] ."') as TotalPosts
	from 
        users u 
				where u.id = '". $username['id'] ."'"
			);

		$data = array("status" => true, "message" => "get Profile Success", "data" => $query->row());
		newJson($data);
	}

	function GetSearchUserProfile($token, $user_id){
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(empty($username)){
			ShowJsonError("Username tidak ditemukan");
			return;
		}

		$query = $this->db->query(
			"Select u.id, u.UserName, u.Password, u.Name, u.Email, u.ImagePath, u.Token,
(Select count(*) from follow f where f.user_id = '". $username['id'] ."' and f.follow_user_id = '". $user_id ."') as IsFollowing,
(Select count(a.follow_user_id) from follow a where a.follow_user_id = '". $user_id ."') as TotalFollowers,
(Select count(a.follow_user_id) from follow a where a.user_id = '". $user_id ."') as TotalFollowing,
(SELECT COUNT(l.PostID) FROM posts l where l.UserId = '". $user_id ."') as TotalPosts
	from 
        users u 
				where u.id = '". $user_id ."'"
			);

		$data = array("status" => true, "message" => "get User Profile Success", "data" => $query->row());
		newJson($data);
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
    $name = $this->input->post('Name');
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
			'Name'=>$name
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
	
	function searchuser($token, $username){
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		$query = $this->db->query(
			"Select * from users where UserName like '%". $username ."%'"
		);

		$count = $query->num_rows();
		if(!$count){
			ShowJsonError('User tidak ditemukan');
			return;
		}

		$data = array("status" => true, "message" => "get User Success", "data" => $query->result());
		newJson($data);
		return;
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

	function postlike(){
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

		$id = $this->input->post('id');
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

		$userid = $this->db->where('Token',$token)->get('users')->row_array();

		//$this->db->where('IsUnlike',1);
		$this->db->where('user_id',$userid['id']);
		$ceklike = $this->db->where('post_id',$id)->get('likes')->row_array();

		if(!empty($ceklike)){
			if($ceklike['IsUnlike']){
				$data = array('IsUnlike' => 0);
					
				if($this->db->where('post_id',$id)->update('likes',$data)){
					ShowJsonSuccess("Berhasil Like");
					return;
				}else{
					ShowJsonError("Gagal Like");
					return;
				}
			}
		}

		if(empty($ceklike)){
			$data = array(
				'post_id' => $id,
				'user_id' => $userid['id'],
				'created_on' => date('Y-m-d H:i:s')
			);
				
			if($this->db->insert('likes',$data)){
				ShowJsonSuccess("Berhasil Like");
				return;
			}else{
				ShowJsonError("Gagal Like");
				return;
			}
		}
		ShowJsonSuccess("Berhasil Like");
	}

	function postunlike(){
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

		$id = $this->input->post('id');
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

		$userid = $this->db->where('Token',$token)->get('users')->row_array();
		
		$this->db->where('IsUnlike',0);
		$this->db->where('user_id',$userid['id']);
		$cekunlike = $this->db->where('post_id',$id)->get('likes')->row_array();

		$data = array('IsUnlike' => 1);
					
		if(!empty($cekunlike)){
			$this->db->where('user_id',$userid['id']);
			$this->db->where('post_id',$id)->update('likes',$data);
			ShowJsonSuccess("Berhasil UnLike");
			return;
		}else{
			ShowJsonError("Gagal UnLike");
			return;
		}
	}


	function getRecommendation($token){
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}

		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(empty($username)){
			ShowJsonError('Username tidak ditemukan');
			return;
		}

		$query = $this->db->query("
			Select u.id, u.UserName, u.Name, u.Email, u.ImagePath, u.Password, u.Token
				from users u
					left join follow f on u.id = f.user_id 
						where u.id <> '". $username['id'] ."' AND
			            	u.id not in 
			                (Select f.follow_user_id
											from users u 
												left join follow f on u.id = f.user_id 
										        	where u.id = '". $username['id'] ."')");
		if($query->num_rows() == 0){
			ShowJsonError("No Recommendation");
			return;
		}
		ShowJsonSuccess("Success get Recommendation", $query->result());


	}

	function getFollowingNotif($token){
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}

		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(empty($username)){
			ShowJsonError('Username tidak ditemukan');
			return;
		}

		$query = $this->db->query("
			Select * from (
SELECT 'comment' as Type, u.id, u.UserName, u.Name, u.Email, u.ImagePath AS UserImage, u.Password, u.Token, f.created_on, 2 AS IsFollowing, p.ImagePath AS ImagePath, ua.id AS toId, ua.UserName AS toUserName, ua.Token AS toToken, c.content
        from follow f 
        inner join users u on u.id = f.follow_user_id 
        inner join comment c on u.id = c.user_id 
        inner join posts p on p.PostID = c.post_id
        inner join users ua on p.UserId = ua.id
        where f.user_id = '". $username['id'] ."' and u.id <> ua.id and ua.id <> '". $username['id'] ."'
UNION ALL		
SELECT 'like' as Type, u.id, u.UserName, u.Name, u.Email, u.ImagePath AS UserImage, u.Password, u.Token, f.created_on, 2 AS IsFollowing, p.ImagePath AS ImagePath, ua.id AS toId, ua.UserName AS toUserName, ua.Token AS toToken, 'asdf' AS content
        from follow f
        inner join users u on u.id = f.follow_user_id 
        inner join likes l on u.id = l.user_id 
        inner join posts p on p.PostID = l.post_id
        inner join users ua on p.UserId = ua.id
        where f.user_id = '". $username['id'] ."' and u.id <> ua.id and ua.id <> '". $username['id'] ."'
UNION ALL
SELECT 'follow' as Type, u.id, u.UserName, u.Name, u.Email, u.ImagePath AS UserImage, u.Password, u.Token, f.created_on, 2 AS IsFollowing, '12345435' AS ImagePath, ua.id AS toId, ua.UserName AS toUserName, ua.Token AS toToken, 'asdf' AS content
        from users u 
        inner join follow f on u.id = f.user_id 
        inner join users ua on f.follow_user_id = ua.id
        where f.user_id in (Select f.follow_user_id from follow f where f.user_id = '". $username['id'] ."') and u.id <> ua.id and ua.id <> '". $username['id'] ."'
) a Order By created_on DESC
			");
		if($query->num_rows() == 0){
			ShowJsonError("no notification for your following");
			return;
		}
		ShowJsonSuccess("Success get your following notification", $query->result());
	}

	function getNotifYou($token){
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}

		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(empty($username)){
			ShowJsonError('Username tidak ditemukan');
			return;
		}

		$query = $this->db->query("
			Select * from 
(SELECT 'comment' as Type, ua.id, ua.UserName, ua.Name, ua.Email, ua.ImagePath AS UserImage, ua.Password, ua.Token, c.created_on, 2 AS IsFollowing, p.ImagePath, 1 AS toId, 'asdfsd' AS toUserName, 'adfasdf' AS toToken, 'asdf' AS content
	from users u 
               inner join posts p on u.id = p.UserId 
               inner join comment c on p.PostID = c.post_id
               inner join users ua on c.user_id = ua.id
   	where c.user_id <> u.id and u.id = '". $username['id'] ."'
UNION ALL
SELECT 'like' as Type, ua.id, ua.UserName, ua.Name, ua.Email, ua.ImagePath AS UserImage, ua.Password, ua.Token, l.created_on, 2 AS IsFollowing, p.ImagePath, 1 AS toId, 'asdfsd' AS toUserName, 'adfasdf' AS toToken, 'asdf' AS content
	from users u
		inner join posts p on u.id = p.UserId
		inner join likes l on p.PostID = l.post_id
    	inner join users ua on l.user_id = ua.id
    	where l.user_id <> u.id and u.id = '". $username['id'] ."' and l.IsUnlike = 0
UNION ALL
SELECT 'follow' as Type, u.id, u.UserName, u.Name, u.Email, u.ImagePath AS UserImage, u.Password, u.Token, f.created_on, 
(Select count(*) from follow f where f.user_id = '". $username['id'] ."' and f.follow_user_id = u.id) AS IsFollowing, '123' AS ImagePath, 1 AS toId, 'asdfsd' AS toUserName, 'adfasdf' AS toToken, 'asdf' AS content
	from users u 
		inner join follow f on u.id = f.user_id
    	where f.follow_user_id = '". $username['id'] ."') 
a Order By created_on DESC
			");
		if($query->num_rows() == 0){
			ShowJsonError("no notification for you");
			return;
		}
		ShowJsonSuccess("Success get your notification", $query->result());
	}

	function getFollower($token){
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}

		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(empty($username)){
			ShowJsonError('Username tidak ditemukan');
			return;
		}

		$query = $this->db->query("Select u.id, u.UserName, u.Name, u.Email, u.ImagePath, u.Password, u.Token 
				from users u inner join follow f on f.user_id = u.id where follow_user_id = '". $username['id'] ."'");
		if($query->num_rows() == 0){
			ShowJsonError("Tidak ada Follower");
			return;
		}
		ShowJsonSuccess("Success get Follower", $query->result());
	}

	function getFollowing($token){
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(empty($username)){
			ShowJsonError('Username tidak ditemukan');
			return;
		}

		$query = $this->db->query("
			Select u.id, u.UserName, u.Name, u.Email, u.ImagePath, u.Password, u.Token 
				from users u inner join follow f on f.follow_user_id = u.id where user_id = '". $username['id'] ."'");

		if($query->num_rows() == 0){
			ShowJsonError("Tidak ada Following");
			return;
		}

		ShowJsonSuccess("Success get Follower", $query->result());
	}

	function follow(){
		$token = $this->input->post('token');
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(empty($username)){
			ShowJsonError('Username tidak ditemukan');
			return;
		}

		$tousername = $this->input->post('tousername');
		if(empty($tousername)){
			ShowJsonError('UserName kosong');
			return;
		}
		
		$cekusername = $this->GetUser($tousername);
		if(empty($cekusername)){
			ShowJsonError('Tidak ada user yang di follow');
			return;
		}

		$toUserId = $this->db->query("Select * from users where UserName = '". $tousername ."'");
		$toUserId = $toUserId->row();

		$data = array(
			'user_id' => $username['id'],
			'follow_user_id' => $toUserId->id,
			'created_on' => date('Y-m-d H:i:s')
		);
			
		if($this->db->insert('follow',$data)){
			ShowJsonSuccess("Berhasil Follow");
			return;
		}else{
			ShowJsonError("Gagal Follow");
			return;
		}
	}

	function unfollow(){
		$token = $this->input->post('token');
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		$username = $this->db->where('Token',$token)->get('users')->row_array();
		if(empty($username)){
			ShowJsonError('Username tidak ditemukan');
			return;
		}

		$tousername = $this->input->post('tousername');
		if(empty($tousername)){
			ShowJsonError('UserName kosong');
			return;
		}
		
		$cekusername = $this->GetUser($tousername);
		if(empty($cekusername)){
			ShowJsonError('Tidak ada user yang di follow');
			return;
		}

		$toUserId = $this->db->query("Select * from users where UserName = '". $tousername ."'");
		$toUserId = $toUserId->row();

		$this->db->where('user_id', $username['id']);	
		$this->db->where('follow_user_id', $toUserId->id);	
		$this->db->delete('follow');

		ShowJsonSuccess("Berhasil Unfollow");
	}
}
