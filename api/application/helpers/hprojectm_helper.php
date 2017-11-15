<?php
class Encryption {
    var $skey 	= "SuPerEncKey2010";
    //var $skey 	= "SuPerEncKey2010"."\0"; // you can change it
    //$skey = $skey."\0";

    public  function safe_b64encode($string) {

        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    public function safe_b64decode($string){
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public function encode($value){

        if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext));
    }

    public function decode($value){

        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }
}

function GetUserLogin($param=""){
	$CI =& get_instance();
	$CI->load->library('session');
	$CI->load->model('muser');
	$username = $CI->session->userdata('ProjectmUserLogin');
	if(empty($username)){
	    return "";
	}
	if(empty($param)){
		return $CI->muser->GetAll(array('UserName'=>$username));
	}else{
		$res = $CI->muser->GetAll(array('UserName'=>$username))->row();
		if(empty($res)){
			$CI->session->unset_userdata('ProjectmUserLogin');
			redirect(site_url()."?logged_out=true");
		}
		return $res->$param;
	}
}

function CheckLogin($stop=""){
	$CI =& get_instance();
	$CI->load->library('session');
	$CI->load->helper('url');
	$session = $CI->session->userdata('ProjectmUserLogin');
	
	if(empty($session)){
		if($stop){
			show_404();
			return;
		}
		show_error('Silahkan Login Kembali untuk alasan keamanan');
		#redirect(site_url(ADMINFOLDER.'/login')."?redirected=".current_url());
	}else{
		return TRUE;
	}
}

function CheckRow($table,$colom,$id){
	$CI =& get_instance();
	$CI->load->database();
	
	$cek = $CI->db->where(array($colom => $id))->get($table);
	
	if($cek->num_rows() == 0){
		return TRUE;
	}else{
		return FALSE;
	}
}

function GetLoginUserName(){
	$a = GetUserLogin()->row();
	return $a->UserName;
}

function IsOtherModuleActive($modul,$role=""){
	if($role == ""){
		$role = GetUserLogin('RoleID');
	}
	
	// if($role == ADMINROLE){
		// return TRUE;
	// }
	
	$CI =& get_instance();
	$CI->load->database();
	$cek = $CI->db->where(array(COL_ROLEID=>$role,COL_OTHERMODULEID=>$modul))->get(TBL_ROLEOTHERMODULES);
	if($cek->num_rows() > 0){
		return TRUE;
	}else{
		return FALSE;
	}
}

function IsAllowInsert($modul,$role=""){
	if($role == ""){
		$role = GetUserLogin('RoleID');
	}
	
	// if($role == ADMINROLE){
		// return TRUE;
	// }
	
	$CI =& get_instance();
	$CI->load->database();
	$cek = $CI->db->where(array(COL_ROLEID=>$role,COL_MODULEID=>$modul,COL_INSERT=>1))->get(TBL_ROLEPRIVILEGES);
	if($cek->num_rows() > 0){
		return TRUE;
	}else{
		return FALSE;
	}
}

function IsAllowUpdate($modul,$role=""){
	if($role==""){
		$role = GetUserLogin('RoleID');
	}
	
	// if($role == ADMINROLE){
		// return TRUE;
	// }
	
	$CI =& get_instance();
	$CI->load->database();
	$cek = $CI->db->where(array(COL_ROLEID=>$role,COL_MODULEID=>$modul,COL_UPDATE=>1))->get(TBL_ROLEPRIVILEGES);
	if($cek->num_rows() > 0){
		return TRUE;
	}else{
		return FALSE;
	}
}

function IsAllowDelete($modul,$role=""){
	if($role==""){
		$role = GetUserLogin('RoleID');
	}
	
	// if($role == ADMINROLE){
		// return TRUE;
	// }
	
	$CI =& get_instance();
	$CI->load->database();
	$cek = $CI->db->where(array(COL_ROLEID=>$role,COL_MODULEID=>$modul,COL_DELETE=>1))->get(TBL_ROLEPRIVILEGES);
	if($cek->num_rows() > 0){
		return TRUE;
	}else{
		return FALSE;
	}
}

function IsAllowView($modul,$role=""){
	
	if($role==""){
		$role = GetUserLogin('RoleID');
	}
	
	// if($role == ADMINROLE){
		// return TRUE;
	// }
		
	$CI =& get_instance();
	$CI->load->database();
	$cek = $CI->db->where(array(COL_ROLEID=>$role,COL_MODULEID=>$modul,COL_VIEW=>1))->get(TBL_ROLEPRIVILEGES);
	if($cek->num_rows() > 0){
		return TRUE;
	}else{
		return FALSE;
	}
}

// function IsAllowOtherModul($modul,$role=""){
	// if($role==""){
		// $role = GetUserLogin('RoleID');
	// }
// 	
	// // if($role == ADMINROLE){
		// // return TRUE;
	// // }
// 	
	// $CI =& get_instance();
	// $CI->load->database();
	// $cek = $CI->db->where(array(COL_ROLEID=>$role,COL_MODULEID=>$modul,COL_UPDATE=>1))->get(TBL_ROLEOTHERMODULES);
	// if($cek->num_rows() > 0){
		// return TRUE;
	// }else{
		// return FALSE;
	// }
// }



function ShowJsonError($error){
	echo json_encode(array('error'=>$error));
}

function ShowJsonSuccess($success){
	echo json_encode(array('error'=>0,'success'=>$success));
}

if(!function_exists('vEncode')){
	function vEncode($string){
		$encrypt = new Encryption();
		return $encrypt->encode($string);
	}
}

if(!function_exists('vDecode')){
	function vDecode($string){
		$encrypt = new Encryption();
		return $encrypt->decode($string);
	}
}

if(!function_exists('FileExtension_Check')){
	function FileExtension_Check($filename,$filetype){
		$file = explode(".", $filename);
		$extension = $file[count($file)-1];
		$extension = strtolower($extension);
		if($filetype == "gambar"){
			if($extension != "jpg" && $extension != "jpeg" && $extension != "gif" && $extension != "png"){
				return FALSE;
			}
		}
		return TRUE;
	}
}
if(!function_exists('FileExtension')){
	function FileExtension($filename){
		$file = explode(".", $filename);
		$extension = $file[count($file)-1];
		return $extension;
	}
}
if(!function_exists('indodate')){
	function indodate($date,$tgl=TRUE){
		if($tgl){
			return date('d M Y',strtotime($date));
		}else{
			return date('d M Y h:i A',strtotime($date));
		}
	}
}
if(!function_exists('tgldate')){
	function tgldate($date){
		return date('d M Y',strtotime($date));
	}
}
if(!function_exists('tgldatetime')){
	function tgldatetime($date){
		return date('d-M-Y H:i A',strtotime($date));
	}
}
if(!function_exists('isodate')){
	function isodate($date){
		if($date == "0000-00-00" || $date == "0000-00-00 00:00:00" || empty($date)){
			return "-";
		}else{
			return date('Y-m-d',strtotime($date));
		}
	}
}

function pecahtanggal($tanggal,$delimiter='-'){
		$pisah = explode($delimiter, $tanggal);
		$data = array(
			'tahun'=>$pisah[0],
			'bulan'=>$pisah[1],
			'tanggal'=>$pisah[2],
			'hari'=>$pisah[3],
		);
		return $data;
}

function desimal($number,$digit=0){
	return number_format($number,$digit,'.',',');
}
function rupiah($number,$digit=0){
	return "Rp <span>".number_format($number,$digit,'.',',')."</span>";
}
function toNum($t){
	$cariini = array(',');
	$a = str_replace($cariini,"",$t);
	return $a;
}
function GetFilteredTaskStatus(){
	$CI =& get_instance();
	$CI->load->database();
	$notin[] = TASKSTATUS_FINISHED;
	if(!IsOtherModuleActive(OTHERMODUL_SETSTATUS_NEW)){
		$notin[] = TASKSTATUS_NEW;
	}
	if(!IsOtherModuleActive(OTHERMODUL_SETSTATUS_UNCONFIRMED)){
		$notin[] = TASKSTATUS_UNCONFIRMED;
	}
	if(!IsOtherModuleActive(OTHERMODUL_SETSTATUS_ASSIGNED)){
		$notin[] = TASKSTATUS_ASSIGNED;
	}
	if(!IsOtherModuleActive(OTHERMODUL_SETSTATUS_RESEARCHING)){
		$notin[] = TASKSTATUS_RESEARCHING;
	}
	if(!IsOtherModuleActive(OTHERMODUL_SETSTATUS_WAITINGCUSTOMER)){
		$notin[] = TASKSTATUS_WAITINGONCUSTOMER;
	}
	if(!IsOtherModuleActive(OTHERMODUL_SETSTATUS_REQUIRETESTING)){
		$notin[] = TASKSTATUS_REQUIRESTESTING;
	}
	$CI->db->where_not_in(COL_TASKSTATUSID,$notin);
	return $CI->db->get(TBL_TASKSTATUS);
}
function GetTaskEmail($taskid){
	$CI =& get_instance();
	$CI->load->database();
	$CI->load->model('mtask');
	$CI->load->model('mcomment');
	$CI->load->model('mtaskassignment');
	$ctask = $CI->mtask->GetByID($taskid)->row_array();
	$u[] = $ctask[COL_CREATEDBY];
	
	$assign = $CI->mtaskassignment->GetByTaskID($taskid);
	if(!empty($assign)){
		foreach ($assign->result_array() as $a){
			if($a[COL_USERNAME] != $ctask[COL_CREATEDBY]){
				$u[] = $a[COL_USERNAME];
			}
		}
	}
	
	$CI->db->where(COL_TASKID, $taskid);
	$CI->db->group_by(COL_CREATEDBY);
	$com = $CI->db->get(TBL_COMMENTS);
	foreach ($com->result_array() as $c){
		if(($c[COL_CREATEDBY] != $ctask[COL_CREATEDBY]) || ($c[COL_CREATEDBY] != $a[COL_USERNAME])){
			$u[] = $c[COL_CREATEDBY];
		}
	}
	
	return $u;
	
}

function GetSisaHari($destination){
	$enddate = explode("-", $destination);
			$tgl = $enddate[2];
			$bln= $enddate[1];
			$thn = $enddate[0];
			$enddate1 = $tgl.'-'.$bln.'-'.$thn;
			$sekarang = date("d-m-Y");
			if ($destination < $sekarang){
				return '0';
			}else{
				return ((strtotime($enddate1) - strtotime($sekarang)) / 86400);
			}	
}


function GetEmailConfig(){
	$local = array(
	    'protocol' => 'smtp',
	    'smtp_host' => 'ssl://smtp.googlemail.com',
	    'smtp_port' => 465,
	    'mailtype' => 'html',
	    'smtp_user' => 'vegatech.debug@gmail.com',
	    'smtp_pass' => 'pegatek123'
	);
	
	$hosted = array(
		'mailtype' => 'html'
	);
	
	if(EMAILPROTOCOL == "smtp"){
		return $local;
	}else{
		return $hosted;
	}
}

function GetNewTaskMessage(){
	return "Dear @USERNAME@, anda telah diberikan tugas @SUMMARY@ tanggal @STARTEDDATE@ - @DUEDATE@ dengan rincian @DESCRIPTION@, dibuat oleh : @CREATEDBY@";
}

function GetNewCommentkMessage(){
	return "@USERNAME@ telah memberikan komentar di tugas @SUMMARY@ pada tanggal @CREATEDON@ dengan isi komentar @DESCRIPTION@";
}

function TaskEmail($string,$taskid,$username){
	$CI =& get_instance();
	$CI->load->model('mtask');
	$CI->load->model('mtaskassignment');
	// $CI->load->model('mdeposit');
	$CI->load->database();
	
	$row = $CI->mtask->GetByID($taskid)->row_array();
	// $ta = $CI->mtaskassignment->GetByID($taskid)->row_array();
	// $user = $CI->muser->GetAll(array('p.UserName'=>$row->UserName))->row();
		
	$find = array(
			'@USERNAME@',
			'@SUMMARY@',
			'@STARTEDDATE@',
			'@DUEDATE@',
			'@DESCRIPTION@',
			'@CREATEDBY@',
			
	);
	
	// $depositto = $CI->db->where('BankTypeID',$row->DepositTo)->get('banks')->row();
	
	$replace = array(
			$username,
			$row[COL_SUMMARY],
			$row[COL_STARTEDDATE],
			$row[COL_DUEDATE],
			$row[COL_DESCRIPTION],
			$row[COL_CREATEDBY],
	);
	
	return str_replace($find, $replace, $string);
}

function CommentEmail($string,$taskid,$commentid, $username){
	$CI =& get_instance();
	$CI->load->model('mtask');
	$CI->load->model('mcomment');
	// $CI->load->model('mdeposit');
	$CI->load->database();
	
	$row = $CI->mtask->GetByID($taskid)->row_array();
	$com = $CI->mcomment->GetByID($commentid)->row_array();
	// $user = $CI->muser->GetAll(array('p.UserName'=>$row->UserName))->row();
		
	$find = array(
			'@USERNAME@',
			'@SUMMARY@',
			'@CREATEDON@',
			'@DESCRIPTION@',			
			
	);
	
	// $depositto = $CI->db->where('BankTypeID',$row->DepositTo)->get('banks')->row();
	
	$replace = array(
			$username,
			$row[COL_SUMMARY],
			$com[COL_CREATEDON],
			$com[COL_DESCRIPTION],
			
	);
	
	return str_replace($find, $replace, $string);
}