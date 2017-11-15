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
		$username = $this->db->where(COL_TOKEN,$token)->get(TBL_USERINFORMATION)->row_array();
		if(!empty($username)){
			return $username[COL_USERNAME];
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
	
	
	function GetPost(){
		$this->load->model('mpost');
		$this->load->model('mkategori');
		$this->load->model('muser');
		$this->load->model('mtag');
		$this->load->library('typography');
		$this->load->helper('currency');
		
		$data['l'] = $l = $this->input->get('l');
		if(!empty($l)){
			$this->db->where('p.'.COL_LANGUAGEID,$l);
		}
		$data['r'] = $this->mpost->GetAllPost(array('p.'.COL_POSTTYPEID=>BERITANO));
		$this->load->view(MLD_PREFIX.'/getpost',$data);
	}
	
	function GetPage(){
		$id = $this->input->get('id');
		$lang = $this->input->get('lang');
		$gadget = $this->input->get('gadget');
				
		$gadgetid = $data['gadgetid'] = $gadget;
		
		$l = $data['l'] = $lang;
		$this->db->where(COL_FORMID,$id);
		if($l){
			$this->db->join(TBL_LANGUAGES,''.TBL_LANGUAGES.'.'.COL_LANGUAGEID.' = '.TBL_FORMS.'.'.COL_LANGUAGEID.'','left')->where(''.TBL_FORMS.'.'.COL_LANGUAGEID.'',$l);
		}
		if($gadgetid){
			if($gadgetid == DEFAULTGADGETID){
				$data['r'] = $r = $this->db->where("((".COL_GADGETID." = '".$gadgetid."') OR (".COL_GADGETID." IS NULL))")->get(TBL_FORMS);
			}else{
				$data['r'] = $r = $this->db->where(array(COL_GADGETID=>$gadgetid))->get(TBL_FORMS);
			}
		}else{
			$data['r'] = $r = $this->db->where("((".COL_GADGETID." = '".DEFAULTGADGETID."') OR (".COL_GADGETID." IS NULL))")->get(TBL_FORMS);
		}
		
		$this->load->view(MLD_PREFIX.'/getpage',$data);
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
		
	function changepassword(){
		$this->load->model('muser');
		$key = $this->input->get('Password');
		$email = $this->input->get('Email');
		$row = $this->muser->GetAll(array('ui.'.COL_EMAIL=>$email))->row();
		$data = array(COL_PASSWORD=>md5($key));
		$this->muser->update($data,$row->UserName);
		
		$this->load->library('email',GetEmailConfig());
		#$this->load->library('email',$config);
		$this->email->set_newline("\r\n");
		
		if(IsNotifActive(NOTIF_PASSWORD_CHANGED)){
			$pref = GetNotif(NOTIF_PASSWORD_CHANGED);
			
			$message = ReplaceUserEmail($pref->Content, $row->UserName);
			$subject = ReplaceUserEmail($pref->Subject, $row->UserName);
			
			$this->email->from($pref->SenderEmail, $pref->SenderName);
			$this->email->to($row->Email);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->send();
		}
		
		ShowJsonSuccess($data);
	}
	
	function CheckLogin(){
		$this->load->library('user_agent');
		
		$username = $this->input->post('UserName');
		$password = $this->input->post('Password');
		
		if(!$username){
			echo json_encode(array('Status' => 2,'token' => "",'Message'=>"Username tidak falid"));
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
			$status = 1;
            $message = "Login Berhasil";
			$token = vEncode($username);
			$data = array('Token' => $token);
						
			$this->db->where(COL_USERNAME,$row[COL_USERNAME]);
			$this->db->update('users',$data);
			 
        }else{
            $status = 2;
			$message = "Username atau Password tidak tepat";
			$token = "error";
        }
        
        echo json_encode(array('Status' => $status,'token' => $token,'message'=>$message));
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
			$error .= 'UserName Already Registered'."<br />";
		}
			
		if(!empty($error)){
			showJSONerror($error);
			return;
		}
		
		$insertdata = array(
			COL_USERNAME=>$username,
			COL_PASSWORD=>md5($password),
			'Email'=>$email,
		);
				
		$this->muser->insert($insertdata);
		
		ShowJsonSuccess('Register berhasil');
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
	
	function updateaccountinformation(){
		$this->load->model('muser');
		$token = $this->input->post('token');
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		$username = $this->GetUserByToken($token);
		
		$data['result'] = $result = $this->muser->GetAll(array('p.'.COL_USERNAME=>$username))->row();
		
		$insertdata = array(
			COL_USERNAME=>$username,
		);
		
		$isBankInfo = $this->input->post('isBankInfo');
		if($isBankInfo > 0){
			$bankdetail = array(
				COL_BANKNAME => $this->input->post('BankName'),
				COL_BANKACCOUNTNAME => $this->input->post('BankAccountName'),
				COL_BANKACCOUNTNUMBER => $this->input->post('BankAccountNumber'),
			);
			
			$this->muser->updatemeta($bankdetail,$username);
			ShowJsonSuccess('Berhasil simpan');
			return;
		}
		
		if($this->input->post('Password')!=""){
			$insertdata['Password'] = md5($this->input->post('Password'));
		}
		$this->muser->update($insertdata,$username);
		
		$datadetail = array(
                COL_FIRSTNAME => $this->input->post('FirstName'),
				COL_LASTNAME => $this->input->post('LastName'),
				COL_COUNTRYID => $this->input->post('CountryID'),
				COL_PROVINCEID => $this->input->post('ProvinceID'),
				COL_CITYID=> $this->input->post('CityID'),
				COL_EMAIL => $this->input->post('Email'),
				COL_ADDRESS => $this->input->post('Address'),
				COL_PHONENUMBER => $this->input->post('PhoneNumber'),
				COL_HP => $this->input->post('HP'),
				COL_POSTALCODE => $this->input->post('PostalCode'),
				COL_PROFILEPICTURE => $this->input->post('MediaID'),
				COL_GENDER => $this->input->post('Gender'),
				'BannerID' => $this->input->post('BannerID'),
				COL_MASTERCOMPANYID => $this->input->post('MasterCompanyID'),
				COL_COMPANYINDUSTRYID => $this->input->post('CompanyIndustryID'),
				COL_COMPANYTYPEID=> $this->input->post('CompanyTypeID'),
				COL_COMPANYWEBSITE => $this->input->post('CompanyWebsite'),
				COL_OTHERINDUSTRYNAME => $this->input->post('OtherIndustryName'),
				COL_OTHERCOMPANYTYPENAME => $this->input->post('OtherCompanyTypeName'),
				COL_COMPANYDESCRIPTION=> $this->input->post('CompanyDescription'),
				COL_RECENTSALARY=> $this->input->post('DeliveryFee'),
        );
		
		$this->muser->updatemeta($datadetail,$username);
		
		ShowJsonSuccess('Berhasil simpan');
	}

	function getChangePassword(){
		$this->load->model('muser');
		$token = $this->input->get('token');
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		$username = $this->GetUserByToken($token);
		$result = $this->muser->GetAll(array('p.'.COL_USERNAME=>$username))->row_array();
		
		if($this->input->get('Password') != $this->input->get('RPassword')){
			ShowJsonError('Password baru tidak sama');
			return;
		}
		
		#$row = $this->muser->GetAll(array('ui.'.COL_EMAIL=>$email))->row();
		#$data = array(COL_PASSWORD=>md5($this->input->post('Password')));
		#$this->muser->update($data,$row->UserName);
		
		$rpassword = $result[COL_PASSWORD];
		$postpassword = $this->input->get('OldPassword');
		
		if($rpassword != md5($postpassword)){
			ShowJsonError('Password lama tidak valid');
			return;
		}
		
		$insertdata = array(
			COL_USERNAME=>$username,
		);
		$insertdata['Password'] = md5($this->input->get('Password'));
		$this->muser->update($insertdata,$username);
		ShowJsonSuccess('Berhasil ubah password');
	}

	function searchlelang(){
		$keyword = $this->input->get('search');
		
		$this->load->model('mpost');
		$this->load->helper('captcha');
		
		if(!empty($keyword)){
			$this->db->like('p.'.COL_POSTTITLE,$keyword);
		}
		
		if(!empty($orderby)){
			$this->db->order_by($orderby,$order);
		}
		$this->db->where("((p.PostExpiredDate >= '".date('Y-m-d')."') OR (p.PostExpiredDate IS NULL) OR (p.PostExpiredDate = ''))");
		$this->db->where("((ui.ExpiredDate >= '".date('Y-m-d')."') OR (ui.ExpiredDate IS NULL) OR (ui.ExpiredDate = '0000-00-00'))");
		$this->db->where('p.'.COL_ISVERIFIED,1);
		$this->db->where('p.'.COL_POSTTYPEID,LELANGNO);
		$data['model'] = $model = $this->mpost->GetAllAuction(array(COL_ISSOLD=>0),'','');
		// echo $this->db->last_query();
				
		//pagination
		if($this->input->get('page')==""){
			$page = $data['page'] = 1;
		}else{
			$page = $data['page'] = $this->input->get('page');
		}
		
		$perpage = 9;
		//$perpage = GetSetting('CategoryPerPage');
		$allrow = $model->num_rows();
		
		if($allrow > 0){
			$data['exist'] = $exist = TRUE;
		}else{
			$data['exist'] = $exist = FALSE;
		}
		
		if($exist){
			$from = ($page*$perpage) - $perpage;
			$data['pagenum'] = ceil($allrow / $perpage);
			$data['page'] = $page;
		}else{
			$from = 0;
			$data['nopagination']= TRUE;
			$data['pagenum'] = 0;
		}
		
		$orderby = '';
		$order = 'asc';
		
		$data['posttypes'] = LELANGNO;
		
		$this->load->view(MLD_PREFIX.'/getdata',$data);
	}

	function getlelangbid(){
		$token = $this->input->get('token');
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		$username = $this->GetUserByToken($token);
		$this->load->model('mauction');
		$this->load->model('muser');
		$this->load->model('mauctionbidder');
		$bidAmountUser = $this->input->post('amount');
		$llgID = $this->input->post('id');
		
		$post = $this->mauction->GetAuctionByID($llgID)->row_array();
		
		if ($post[COL_ENDDATE] <= date('Y-m-d H:i:s')){
			ShowJsonError("Bid Gagal, Waktu lelang Telah Habis");
			return false;
		}else{
			if(LELANGWALLETTYPEID == WALLET_CASH){
				$UserWalletType = WALLET_CASH;
			}else{
				$UserWalletType = WALLET_LELANGPOIN;
			}
			
			$auct = $this->mauction->GetAuctionByID($llgID);
			foreach ($auct->result_array() as $rowA) {
				$bidMulti = $rowA[COL_BIDMULTIPLY];
				$isBidM = $rowA[COL_ISBIDMULTIPLY];
				$postID = $rowA[COL_POSTID];
				$bidsekarang = $rowA[COL_CURRENTBID];
				$biddasar = $rowA[COL_STARTINGBID];
				$CurrentBidder = $rowA[COL_CURRENTBIDBY];
				$EndDate = $rowA[COL_ENDDATE];
			}
			
			$tanggalSkrg = date("Y-m-d H:i:s");
			
			
			$walletUser = $this->muser->GetBalance($username, $UserWalletType);
			
			if ($walletUser < $bidAmountUser){
				ShowJsonError("Maaf, Point/Cash Anda tidak cukup, Silahkan tambah ".anchor('lelang/addpoint','Point/Cash')." Anda Terlebih Dahulu");
				return false;
				
			}else{
				
				if ($bidsekarang == 0){
					$CurrentBid = $biddasar;
				}else{
					$CurrentBid = $bidsekarang;
				}
				
				if ($bidAmountUser <= $CurrentBid){
		
					$alert = "Maaf Current Bid Sudah Bertambah, Silahkan naikkan Bid Anda";
					ShowJsonError($alert);
					return false;
				}else{
					if($CurrentBidder != ''){
						$bidder = $CurrentBidder;
						$bidnilai = $bidsekarang;
						
						$wallet = $this->muser->GetBalance($bidder, $UserWalletType);
						
						$point = $wallet + $bidnilai;
						$pointupdate = array(
							COL_BALANCE => $point
						);
						$this->muser->UpdateBalance($bidder, $pointupdate);
						
						$newDataAuction = array(
							COL_CURRENTBID => $bidAmountUser,
							COL_CURRENTBIDBY => $username,
							COL_CURRENTBIDON => date('Y-m-d H:i:s')
						);
						$this->mauction->UpdateAuction($llgID, $newDataAuction);
						
						$idBidder = $this->mauctionbidder->lastid();
						$idBidder++;
						$newDataBidder = array(
							COL_AUCTIONBIDDERSID => $idBidder,
							COL_POSTID => $llgID,
							COL_USERNAME => $username,
							COL_BIDON => date('Y-m-d H:i:s'),
							COL_BIDAMOUNT => $bidAmountUser
							
						);
						$this->mauctionbidder->insert($newDataBidder);
						
						$wallet1 = $this->muser->GetBalance($username, $UserWalletType);
						$point1 = $wallet1 - $bidAmountUser;
						$Newpointupdate = array(
							COL_BALANCE => $point1
						);
						$this->muser->UpdateBalance($username, $Newpointupdate);
						
						//ShowJsonSuccess("Bid berhasil");
						$resp["error"] = 0;
						$resp["success"] = "Bid Berhasil";
						$resp["lastbid"] = $bidAmountUser;
						$resp['lastbider'] = GetUserLogin('UserName');
						echo json_encode($resp);
					}else{
						$newDataAuction = array(
							COL_CURRENTBID => $bidAmountUser,
							COL_CURRENTBIDBY => GetUserLogin('UserName'),
							COL_CURRENTBIDON => date('Y-m-d H:i:s')
						);
						$this->mauction->UpdateAuction($llgID, $newDataAuction);
						
						$idBidder = $this->mauctionbidder->lastid();
						$idBidder++;
						$newDataBidder = array(
							COL_AUCTIONBIDDERSID => $idBidder,
							COL_POSTID => $llgID,
							COL_USERNAME => $username,
							COL_BIDON => date('Y-m-d H:i:s'),
							COL_BIDAMOUNT => $bidAmountUser
							
						);
						$this->mauctionbidder->insert($newDataBidder);
						
						$wallet1 = $this->muser->GetBalance($username, $UserWalletType);
						$point1 = $wallet1 - $bidAmountUser;
						$Newpointupdate = array(
							COL_BALANCE => $point1
						);
						$this->muser->UpdateBalance($username, $Newpointupdate);
						
					 //ShowJsonSuccess("Bid berhasil");
					 	$resp["error"] = 0;
						$resp["success"] = "Bid Berhasil";
						$resp["lastbid"] = $bidAmountUser;
						$resp['lastbider'] = $username;
						echo json_encode($resp);
					}
					
				}
			}
				
		
		//ShowJsonSuccess("Bid berhasil");
		}
		
	}

	function getlelangbuyin(){
		$this->load->model('mauction');
		$this->load->model('muser');
		$this->load->model('mauctionbidder');
		$bidAmountUser = $this->input->get('amount');
		$llgID = $this->input->get('id');
		
		$token = $this->input->get('token');
		if(empty($token)){
			ShowJsonError('Token kosong');
			return;
		}
		$username = $this->GetUserByToken($token);
		
		if(!$username){
			ShowJsonError("Anda Belum Masuk, Silahkan Terlebih Dahulu");
			return false;
		}else{
			$post = $this->mauction->GetAuctionByID($llgID)->row_array();
			
			if ($post[COL_ENDDATE] <= date('Y-m-d H:i:s')){
				ShowJsonError("Bid Gagal, Waktu lelang Telah Habis");
				return false;
			}else{
				if(LELANGWALLETTYPEID == WALLET_CASH){
					$UserWalletType = WALLET_CASH;
				}else{
					$UserWalletType = WALLET_LELANGPOIN;
				}
				
				$auct = $this->mauction->GetAuctionByID($llgID);
				foreach ($auct->result_array() as $rowA) {
					$bidMulti = $rowA[COL_BIDMULTIPLY];
					$isBidM = $rowA[COL_ISBIDMULTIPLY];
					$postID = $rowA[COL_POSTID];
					$bidsekarang = $rowA[COL_CURRENTBID];
					$biddasar = $rowA[COL_STARTINGBID];
					$CurrentBidder = $rowA[COL_CURRENTBIDBY];
					$EndDate = $rowA[COL_ENDDATE];
				}
				
				$tanggalSkrg = date("Y-m-d H:i:s");
				
				
				$walletUser = $this->muser->GetBalance($username, $UserWalletType);
				
				if ($walletUser < $bidAmountUser){
					ShowJsonError("Maaf, Point/Cash Anda tidak cukup, Silahkan tambah ".anchor('lelang/addpoint','Point/Cash')." Anda Terlebih Dahulu");
					return false;
					
				}else{
					
					if ($bidsekarang == 0){
						$CurrentBid = $biddasar;
					}else{
						$CurrentBid = $bidsekarang;
					}
					
					if ($bidAmountUser <= $CurrentBid){
			
						$alert = "Maaf Current Bid Sudah Bertambah, Silahkan naikkan Bid Anda";
						ShowJsonError($alert);
						return false;
					}else{
						if($CurrentBidder != ''){
							$bidder = $CurrentBidder;
							$bidnilai = $bidsekarang;
							
							$wallet = $this->muser->GetBalance($bidder, $UserWalletType);
							
							$point = $wallet + $bidnilai;
							$pointupdate = array(
								COL_BALANCE => $point
							);
							$this->muser->UpdateBalance($bidder, $pointupdate);
							
							$newDataAuction = array(
								COL_CURRENTBID => $bidAmountUser,
								COL_CURRENTBIDBY => $username,
								COL_CURRENTBIDON => date('Y-m-d H:i:s')
							);
							$this->mauction->UpdateAuction($llgID, $newDataAuction);
							
							$idBidder = $this->mauctionbidder->lastid();
							$idBidder++;
							$newDataBidder = array(
								COL_AUCTIONBIDDERSID => $idBidder,
								COL_POSTID => $llgID,
								COL_USERNAME => $username,
								COL_BIDON => date('Y-m-d H:i:s'),
								COL_BIDAMOUNT => $bidAmountUser
								
							);
							$this->mauctionbidder->insert($newDataBidder);
							
							$wallet1 = $this->muser->GetBalance($username, $UserWalletType);
							$point1 = $wallet1 - $bidAmountUser;
							$Newpointupdate = array(
								COL_BALANCE => $point1
							);
							$this->muser->UpdateBalance($username, $Newpointupdate);
							
							//ShowJsonSuccess("Bid berhasil");
							$resp["error"] = 0;
							$resp["success"] = "Bid Berhasil";
							$resp["lastbid"] = $bidAmountUser;
							$resp['lastbider'] = $username;
							echo json_encode($resp);
						}else{
							$newDataAuction = array(
								COL_CURRENTBID => $bidAmountUser,
								COL_CURRENTBIDBY => $username,
								COL_CURRENTBIDON => date('Y-m-d H:i:s')
							);
							$this->mauction->UpdateAuction($llgID, $newDataAuction);
							
							$idBidder = $this->mauctionbidder->lastid();
							$idBidder++;
							$newDataBidder = array(
								COL_AUCTIONBIDDERSID => $idBidder,
								COL_POSTID => $llgID,
								COL_USERNAME => $username,
								COL_BIDON => date('Y-m-d H:i:s'),
								COL_BIDAMOUNT => $bidAmountUser
								
							);
							$this->mauctionbidder->insert($newDataBidder);
							
							$wallet1 = $this->muser->GetBalance($username, $UserWalletType);
							$point1 = $wallet1 - $bidAmountUser;
							$Newpointupdate = array(
								COL_BALANCE => $point1
							);
							$this->muser->UpdateBalance($username, $Newpointupdate);
							
						 //ShowJsonSuccess("Bid berhasil");
						 	$resp["error"] = 0;
							$resp["success"] = "Bid Berhasil";
							$resp["lastbid"] = $bidAmountUser;
							$resp['lastbider'] = $username;
							echo json_encode($resp);
						}
						
					}
				}
					
			
			//ShowJsonSuccess("Bid berhasil");
			}
		}
	}

	function GetAllUser(){
		$role = $this->input->get('role');
		$child = $this->input->get('child');
		$this->load->model('muser');
		if($role){
			$this->db->where('p.'.COL_ROLEID,$role);
		}
		if($child){
			//$this->db->where('ui.'.COL_PARENTUSERNAME.' IS NOT NULL');
		}
		$a = $this->muser->GetAll();
		$res = array();
		foreach($a->result_array() as $d){
			$pp = GetMedia($d[COL_PROFILEPICTURE]);
			if(!empty($pp)){
				$pp = media_url().$pp->MediaPath;
				$pp = MY_ASSETURL.'/images/timthumb.php?src='.$pp.'&w=350&h=350&q=100';
			}else{
				$pp = "";
			}
			$d['ProfilePicture'] = $pp;
			if($child){
				$countanak = $this->db->where(COL_PARENTUSERNAME,$d[COL_USERNAME])->select('COUNT(*) as Jum')->get(TBL_USERINFORMATION)->row_array();
				if(!empty($countanak['Jum'])){
					continue;
				}
			}
			$res[] = $d;
		}
		echo json_encode($res);
	}
}
