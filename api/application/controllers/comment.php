<?php

class Comment extends MY_Controller{
		
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('mtask');
		$this->load->model('mproject');
		$this->load->model('mtasktype');
		$this->load->model('mcategory');
		$this->load->model('mtaskpriority');
		$this->load->model('mtaskseverity');
		$this->load->model('mattachment');
		$this->load->model('mtaskassignment');
		$this->load->model('mcomment');
		$this->load->model('muser');
		$this->load->library('form_validation');
	}
	
	function index(){
		$data['title'] = 'Daftar Komentar';
		// $data['c'] = $this->mcomment->GetAll();
		$data['u'] = $this->muser->getall();
		
		$this->db->select();
		
		$search = $this->input->get('Search');
		// if(empty($search)){
			// $search = '0';
		// }
		// $projectid = $this->input->get('projectid');
		if($search == 'all'){
			$data['title'] = 'Daftar Semua Komentar';
			// $data['s'] = 'all';
		}
		
		$username = GetUserLogin(COL_USERNAME);
		$role = GetUserLogin(COL_ROLEID);
		$viewall = IsOtherModuleActive(OTHERMODUL_CANLOOKALLTASKASSIGN, $role); 
		
		if($search != 'all'){
			$this->db->where(TBL_COMMENTS.".".COL_CREATEDBY, $search);
		}
		$data['s'] = $search;
				
		if(!$viewall){
			$this->db->select(TBL_COMMENTS.'.*');
			$this->db->join(TBL_TASKS." t",'t.'.COL_TASKID.' = '.TBL_COMMENTS.'.'.COL_TASKID,'inner');
			$this->db->join(TBL_TASKASSIGNMENTS." ta",'ta.'.COL_TASKID.' = t.'.COL_TASKID,'inner');
			$this->db->where('ta.'.COL_USERNAME,$username);
		}
		$this->db->where("date(".TBL_COMMENTS.".".COL_CREATEDON.") >=",date('Y-m-d', strtotime('- 60 day')));
		$data['c'] = $this->db->get(TBL_COMMENTS);
		// echo $this->db->last_query();
		$this->load->view('comment/data', $data);
	}
	
	function add(){
		$lastid = $this->mcomment->lastid()+1;
		
		$TaskID = $this->input->post('taskid');
		
		$comment= array(
			COL_TASKID => $TaskID,
            COL_COMMENTYPEID => $this->input->post('CommentType'),
			COL_COMMENTID => $lastid,
			COL_DESCRIPTION => str_replace("\n","<br />",$this->input->post('isikomentar')),
			COL_CREATEDBY => GetUserLogin("UserName"),
			COL_CREATEDON => date("Y-m-d H:i:s")
		);
		$this->mattachment->clearfromcomment($lastid);
		$attachID = $this->input->post('MediaID');
		if (is_array($attachID)){
			foreach($attachID as $att){
				$this->mattachment->update(array(COL_REFERENCEID => $lastid, COL_MODULEID => MODULCOMMENT), $att);
			}
		}
		
		
		if ($this->mcomment->insert($comment)){
			$this->load->library('email',GetEmailConfig());
			$this->email->set_newline("\r\n");
			
			$mailto = GetTaskEmail($TaskID);
			
			foreach ($mailto as $mail){
				if ($mail != GetUserLogin("UserName")){
					$user = $this->muser->GetByID($mail)->row_array();
					if (!empty($user[COL_EMAILADDRESS])){
						$message = CommentEmail(GetNewCommentkMessage(),$TaskID,$lastid,GetUserLogin("UserName"));
						$subject = CommentEmail(SUBJECT_EMAIL_COMMENT,$TaskID,$lastid,GetUserLogin("UserName"));
						$this->email->from(SMTP_SENDER, SMTP_SENDER_NAME);
					    $this->email->subject($subject);
					    $this->email->message($message);
						$this->email->to($user[COL_EMAILADDRESS]);
						$this->email->send();
					}
				}
			}
			
			// $this->db->where(COL_TASKID, $TaskID);
			// $this->db->group_by(COL_CREATEDBY);
			// $com = $this->db->get(TBL_COMMENTS);
			// //Email for User Comment
			// foreach($com->result_array() as $c) {
				// // $pref = GetNotif(NOTIF_DEPOSIT_ADMIN);
				// $user = $this->muser->GetByID($c[COL_CREATEDBY])->row_array();
				// if (!empty($user[COL_EMAILADDRESS])){
					// $message = CommentEmail(GetNewCommentkMessage(),$TaskID,$lastid,$c[COL_CREATEDBY]);
					// $subject = CommentEmail(SUBJECT_EMAIL_COMMENT,$TaskID,$lastid,$c[COL_CREATEDBY]);
					// $this->email->from(SMTP_SENDER, SMTP_SENDER_NAME);
				    // $this->email->subject($subject);
				    // $this->email->message($message);
					// $this->email->to($user[COL_EMAILADDRESS]);
					// $this->email->send();
				// }
			// }
// 			
			// //Email For User Created Task
			// $usertask = $this->mtask->GetByID($TaskID)->row_array();
			// $usert = $this->muser->GetByID($usertask[COL_CREATEDBY])->row_array();
			// if (!empty($usert[COL_EMAILADDRESS])){
				// $message = CommentEmail(GetNewCommentkMessage(),$TaskID,$lastid,$c[COL_CREATEDBY]);
				// $subject = CommentEmail(SUBJECT_EMAIL_COMMENT,$TaskID,$lastid,$c[COL_CREATEDBY]);
				// $this->email->from(SMTP_SENDER, SMTP_SENDER_NAME);
			    // $this->email->subject($subject);
			    // $this->email->message($message);
				// $this->email->to($usert[COL_EMAILADDRESS]);
				// $this->email->send();
			// }			
				
			ShowJsonSuccess('Komentar Berhasil dikirim');	
			return true;
		}else{
			ShowJsonError('Komentar gagal dikirim');
			return false;
		}
		
	}
	
		
	function delete($id){
		// CheckLogin();
		// $data = $this->input->get('id');
		// $id = $this->input->get('id');
		$deleted = $this->mcomment->delete($id);
		$attach = $this->mattachment->GetAll(array(COL_REFERENCEID => $id))->row();
		if (!empty($attach)){
			$this->mattachment->delete($attach->AttachmentID);
		}
		if($deleted){
			ShowJsonSuccess("Komentar sudah dihapus");
			// redirect('task');
		}else{
			ShowJsonError("Komentar belum dihapus");
		}
	}
	
	function edit($id){
		$data['title'] = 'Edit Komentar';
		
		$data['comment'] = $this->mcomment->GetAll(array(COL_COMMENTID => $id))->row_array();
		// echo $this->db->last_query();
		$data['attach'] = $this->mattachment->GetAll(array(COL_MODULEID => MODULCOMMENT, COL_REFERENCEID => $id));
		$rules = array(
			array(
				'field'=>'isikomentar',
				'label'=>'Komentar',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			
			$TaskID = $this->input->post('taskid');
			$comment= array(
                COL_DESCRIPTION => str_replace("\n","<br />",$this->input->post('isikomentar')),
                COL_COMMENTYPEID => $this->input->post('CommentType'),
				COL_UPDATEBY => GetUserLogin("UserName"),
				COL_UPDATEON => date("Y-m-d H:i:s")
			);
						
			$idattach = $this->mattachment->GetAll(array(COL_MODULEID => MODULCOMMENT, COL_REFERENCEID => $id))->row_array();
			$attachID = $this->input->post('MediaID');
			$this->mattachment->clearfromcomment($id);
			if(is_array($attachID)){
				
				foreach ($attachID as $attach) {
					$this->mattachment->update(array(COL_REFERENCEID => $id, COL_MODULEID => MODULCOMMENT), $attach);
				}
			}
			// $idattach = $this->mattachment->GetAll(array(COL_MODULEID => MODULCOMMENT, COL_REFERENCEID => $id))->row_array();
			// $attachID = $this->input->post('MediaID');
			// if (!empty($idattach)){
				// $idA = $idattach[COL_ATTACHMENTID];
				// if ($idA != $attachID){
					// $this->mattachment->delete($idA);
					// $this->mattachment->update(array(COL_REFERENCEID => $id, COL_MODULEID => MODULCOMMENT), $attachID);
				// }else if($attachID == 0){
					// $this->mattachment->delete($idA);
				// }
			// }else{
				// $this->mattachment->update(array(COL_REFERENCEID => $id, COL_MODULEID => MODULCOMMENT), $attachID);
			// }
// 			
			if ($this->mcomment->update($comment, $id)){
				redirect(site_url('task/view/'.$TaskID));
			}else{
				// ShowJsonError('Komentar gagal dikirim');
				return false;
			}
		}
		$this->load->view('comment/edit', $data);
	}
	
	function editcomment(){
		$id = $this->input->post('id');
		$komen = $this->input->post('komentar');
		$comment= array(
				COL_DESCRIPTION => $komen,
				COL_UPDATEBY => GetUserLogin("UserName"),
				COL_UPDATEON => date("Y-m-d H:i:s")
			);
		if ($this->mcomment->update($comment, $id)){
				ShowJsonSuccess("berhasil di Update");
			}else{
				ShowJsonError('Komentar gagal dikirim');
				return false;
			}
	}

}