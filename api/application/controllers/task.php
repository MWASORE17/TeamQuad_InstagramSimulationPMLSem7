<?php

class Task extends MY_Controller{
		
	
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
		$this->load->library('form_validation');
		$this->load->model('mtaskstatus');
		$this->load->model('muser');
		$this->load->model('mversions');
	}
	
	function index(){
        $showtestertask = IsOtherModuleActive(OTHERMODUL_SHOW_TESTERTASK);
        $roleuser = GetUserLogin(COL_ROLEID);
		$usernamek = GetUserLogin('UserName');
		$data['title'] = 'Daftar Tugas Belum Selesai';
		$data['hide'] = FALSE;
		// $this->db->join(TBL_TASKSTATUS, TBL_TASKSTATUS.'.'.COL_TASKSTATUSID.'='.TBL_TASKS.'.'.COL_TASKSTATUSID, 'left');
		// $this->db->join(TBL_PROJECTS, TBL_PROJECTS.'.'.COL_PROJECTID.'='.TBL_TASKS.'.'.COL_PROJECTID, 'left');
		// $this->db->join(TBL_CATEGORIES, TBL_CATEGORIES.'.'.COL_CATEGORYID.'='.TBL_TASKS.'.'.COL_CATEGORYID, 'left');
		// $this->db->join(TBL_TASKTYPES, TBL_TASKTYPES.'.'.COL_TASKTYPEID.'='.TBL_TASKS.'.'.COL_TASKTYPEID, 'left');
		$categoryid = $data['categoryid'] = $this->input->get('CategoryID');
		$tasktypeid = $data['tasktypeid'] = $this->input->get('TaskTypeID');
		$swono = $data['swono'] = $this->input->get('Swono');

		if (!IsOtherModuleActive(OTHERMODUL_CANLOOKALLTASKASSIGN)){
			$user = GetUserLogin('UserName');
			if(IsOtherModuleActive(OTHERMODUL_ONLYLOOKOWNTASK)){
				$this->db->where(TBL_TASKS.".".COL_CREATEDBY,$user);
			}else{
				$this->db->join(TBL_TASKASSIGNMENTS, TBL_TASKASSIGNMENTS.'.'.COL_TASKID.'='.TBL_TASKS.'.'.COL_TASKID,'inner');
				$this->db->where(TBL_TASKASSIGNMENTS.".".COL_USERNAME, $user);
			}
			
			$this->db->join(TBL_TASKSTATUS, TBL_TASKSTATUS.'.'.COL_TASKSTATUSID.'='.TBL_TASKS.'.'.COL_TASKSTATUSID,'inner');
			// $this->db->join(TBL_PROJECTS, TBL_PROJECTS.'.'.COL_PROJECTID.'='.TBL_TASKS.'.'.COL_PROJECTID, 'inner');
			$this->db->join(TBL_CATEGORIES, TBL_CATEGORIES.'.'.COL_CATEGORYID.'='.TBL_TASKS.'.'.COL_CATEGORYID, 'inner');
			$this->db->join(TBL_TASKTYPES, TBL_TASKTYPES.'.'.COL_TASKTYPEID.'='.TBL_TASKS.'.'.COL_TASKTYPEID, 'inner');
			#// $this->db->where(COL_CREATEDBY, $user);
			// $task = $this->db->get(TBL_TASKS);
		}else{
				
			$this->db->join(TBL_TASKSTATUS, TBL_TASKSTATUS.'.'.COL_TASKSTATUSID.'='.TBL_TASKS.'.'.COL_TASKSTATUSID,'inner');
			// $this->db->join(TBL_PROJECTS, TBL_PROJECTS.'.'.COL_PROJECTID.'='.TBL_TASKS.'.'.COL_PROJECTID, 'inner');
			$this->db->join(TBL_CATEGORIES, TBL_CATEGORIES.'.'.COL_CATEGORYID.'='.TBL_TASKS.'.'.COL_CATEGORYID, 'inner');
			$this->db->join(TBL_TASKTYPES, TBL_TASKTYPES.'.'.COL_TASKTYPEID.'='.TBL_TASKS.'.'.COL_TASKTYPEID, 'inner');
		}
		
		$favorite = $this->input->get('favorite');
		if(!empty($favorite)){
			
			$data['title'] = 'Daftar Semua Tugas Favorite';
			$this->db->join(TBL_TASKFAVORITE, TBL_TASKFAVORITE.'.'.COL_TASKID.'='.TBL_TASKS.'.'.COL_TASKID,'inner');
			$this->db->where(TBL_TASKFAVORITE.".".COL_USERNAME, $favorite);

		}		
		
		$search = $this->input->get('Search');
		if(empty($search)){
            /*if($roleuser == ADMINROLE) $search = '0';
            else if($showtestertask) $search = '2';
			else $search = '0';*/
            $search = '0';
		}
		
		$projectid = $this->input->get('projectid');
		if($search == 'all'){
			if(!empty($favorite)){
				$data['title'] = 'Daftar Semua Tugas Favorite';
			}else{	
				$data['title'] = 'Daftar Semua Tugas';
				//if($showtestertask) $this->db->where(COL_ISCLOSED, true);
				// $data['s'] = 'all';
			}
		}
		if ($search == '1'){
			if(!empty($favorite)){
				$data['title'] = 'Daftar Tugas Favorite Sudah Selesai';
			}else{
				$data['title'] = 'Daftar Tugas Sudah Selesai';
				// $data['s'] = '1';
			}
		}
		if ($search == '0'){
			if(!empty($favorite)){
				$data['title'] = 'Daftar Tugas Favorite Belum Selesai';
			}else{
				$data['title'] = 'Daftar Tugas Belum Selesai';
				// $data['s'] = '0';
			}
		}
        if ($search == '3'){
			if(!empty($favorite)){
				$data['title'] = 'Daftar Tugas Favorite Sudah Dicheck';
			}else{
				$data['title'] = 'Daftar Tugas Sudah Dicheck';
				// $data['s'] = '1';
			}
        }
        if ($search == '2'){
			if(!empty($favorite)){
				$data['title'] = 'Daftar Tugas Favorite Belum Dicheck';
			}else{
				$data['title'] = 'Daftar Tugas Belum Dicheck';
				// $data['s'] = '0';
			}
        }
		if($search != 'all'){
            if($search == '0' || $search == '1') $this->db->where(COL_ISCOMPLETED, $search);
            else if($search == '2') {
                #$this->db->where(COL_ISCLOSED, true);
                $this->db->where(COL_ISCLOSED, true);
                $this->db->where(COL_ISCHECKED, false);
            }
            else if($search == '3') {
                $this->db->where(COL_ISCLOSED, true);
                $this->db->where(COL_ISCHECKED, true);
            }
		}
		if(!empty($categoryid)){
			$this->db->where(TBL_CATEGORIES.'.'.COL_CATEGORYID,$categoryid);
		}
		if(!empty($tasktypeid)){
			$this->db->where(TBL_TASKTYPES.'.'.COL_TASKTYPEID,$tasktypeid);
		}
		if(!empty($swono)){
			$this->db->where(COL_SWONO,$swono);
		}
		if(!empty($projectid)){
			$this->db->where(COL_PROJECTID,$projectid);
		}
		$data['s'] = $search;
		$data['c'] = $this->db->get(TBL_TASKS);
		$this->load->view('task/data', $data);
	}
	
	function add(){
		$data['edit'] = FALSE;
		// $data['lastid'] = $this->mtask->lastid()+1;
		$data['title'] = 'Tambah Tugas';
		$data['c'] = $this->mtask->GetAll();
		$data['Project'] = $this->mproject->GetAll(array(COL_ISACTIVE => 1));
		$data['TaskType'] = $this->mtasktype->GetAll();
		$data['Category'] = $this->mcategory->GetAll();
		$data['Priority'] = $this->mtaskpriority->GetAll();
		$data['Severity'] = $this->mtaskseverity->GetAll();
		$data['Version'] = $this->mversions->GetAll();
		
		$data['laporanCustomerId']  = TASKTYPE_LAPORAN_CUSTOMER;
		
		$rules = array(
			
			array(
				'field'=>'Summary',
				'label'=>'Summary',
				'rules'=>'required'
			),
			array(
				'field'=>'Description',
				'label'=>'Description',
				'rules'=>'required'
			),
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$TaskID = $this->mtask->lastid()+1;
			
			$ProjectID = $this->input->post('ProjectID');
			$TaskTypeID = $this->input->post('TaskTypeID');
			$CategoryID = $this->input->post('CategoryID');
			$TaskPriorityID = $this->input->post('TaskPriorityID');
			$assign = $this->input->post('AssignmentTo');
			$SwoNo = $TaskTypeID == TASKTYPE_LAPORAN_CUSTOMER ? $this->input->post('Swono'):null;
			
			if($this->input->post('DueDate') < $this->input->post('StartedDate')){
				redirect(site_url('task/add')."?error=ed");
				
			}
			
			$taskstatus = TASKSTATUS_UNCONFIRMED;
			
			if(!empty($assign)){
				$taskstatus = TASKSTATUS_NEW;
			}
			if($this->input->post('StartedDate') == '' || $this->input->post('StartedDate') == '0000-00-00'){
				$tglMulai = date('Y-m-d');
			}else{
				$tglMulai = $this->input->post('StartedDate');
			}
			
			$datatask = array(
					COL_TASKID => $TaskID,
					COL_SUMMARY => $this->input->post('Summary'),
					COL_PROJECTID => $ProjectID,
					COL_TASKTYPEID => $TaskTypeID,
					COL_CATEGORYID => $CategoryID,
					COL_TASKPRIORITYID => $TaskPriorityID,
					COL_STARTEDDATE => $tglMulai,
					COL_DUEDATE => $this->input->post('DueDate'),
					COL_DESCRIPTION => $this->input->post('Description'),
					COL_ISPRIVATE => $this->input->post('IsPrivate'),
					COL_CREATEDBY => GetUserLogin("UserName"),
					COL_CREATEDON => date("Y-m-d H:i:s"),
					COL_TASKSTATUSID => $taskstatus,
					COL_TASKSEVERITYID => $this->input->post('TaskSeverityID'),
					COL_VERSIONID => $this->input->post('VersionID'),
					COL_SWONO => $SwoNo,
			);
			
			$this->mtask->insert($datatask);
			
			// $lastassignid = $this->mtaskassignment->lastid() +1;
			// foreach ($this->input->post('AssignmentTo') as $assign) {
				// $dataAssign = array(
					// COL_TASKASSIGNMENTID => $lastassignid++,
					// COL_TASKID => $TaskID,
					// COL_USERNAME => $assign
				// );
// 			
				// $this->mtaskassignment->insert($dataAssign);
			// }
			
			$this->load->library('email',GetEmailConfig());
			$this->email->set_newline("\r\n");

            $mailto = $assign;
			$mailto[] = ADMINUSERNAME;
            if(!$assign){
				$mailto[] = 'headsupport';
			}
			if(!empty($mailto)){
                for ($i=0; $i < count($mailto); $i++) {
					
					// $pref = GetNotif(NOTIF_DEPOSIT_ADMIN);
					$user = $this->muser->GetByID($mailto[$i])->row_array();
					
					if(!empty($user[COL_EMAILADDRESS])){
					
						$message = TaskEmail(GetNewTaskMessage(),$TaskID,$mailto[$i]);
						$subject = TaskEmail(SUBJECT_EMAIL_TASK,$TaskID,$mailto[$i]);
						$this->email->from(SMTP_SENDER, SMTP_SENDER_NAME);
						$this->email->subject($subject);
					    $this->email->message($message);
						$this->email->to($user[COL_EMAILADDRESS]);
					    $this->email->send();
					}
				}
			}
						
			if($assign){
				for ($i=0; $i < count($assign); $i++) {
					$lastassignid = $this->mtaskassignment->lastid() +1; 
					$data = array(COL_TASKASSIGNMENTID=>$lastassignid,COL_TASKID=>$TaskID,COL_USERNAME=>$assign[$i]);
					$this->mtaskassignment->insert($data);
				}
			}else{
				$lastassignid = $this->mtaskassignment->lastid() +1; 
				$data = array(COL_TASKASSIGNMENTID=>$lastassignid,COL_TASKID=>$TaskID,COL_USERNAME=>'headsupport');
				$this->mtaskassignment->insert($data);
			}
			
			$attachID = $this->input->post('MediaID');
			if(is_array($attachID)){
				foreach ($attachID as $attach) {
					$this->mattachment->update(array(COL_REFERENCEID => $TaskID, COL_MODULEID => MODULTASK), $attach);
				}
			}
			// $categories = $this->input->post('CategoryID'.'-'.$lang);
			// if($categories){
				// for ($i=0; $i < count($categories); $i++) { 
					// $data = array(COL_POSTID=>$last,COL_CATEGORYID=>$categories[$i]);
					// $this->db->insert(TBL_POSTCATEGORIES,$data);
				// }
			// }else{
				// $data = array(COL_POSTID=>$last,COL_CATEGORYID=>0);
				// $this->db->insert(TBL_POSTCATEGORIES,$data);
			// }
			
			redirect(site_url('task/edit/'.$TaskID)."?success=1");
		}else{
			$this->load->view('task/form', $data);
		}
		
	}
	
	function edit($id){
		$data['edit'] = TRUE;
		$data['title'] = 'Edit Tugas';
		$data['result'] = $this->mtask->GetByID($id)->row_array();
		$data['Project'] = $this->mproject->GetAll();
		$data['TaskType'] = $this->mtasktype->GetAll();
		$data['Category'] = $this->mcategory->GetAll();
		$data['Priority'] = $this->mtaskpriority->GetAll();
		$data['Severity'] = $this->mtaskseverity->GetAll();
		$data['Version'] = $this->mversions->GetAll();
		#$data['StatusTask'] = $this->mtaskstatus->GetAll();
		$data['StatusTask'] = GetFilteredTaskStatus();
		$data['attach'] = $this->mattachment->GetAll(array(COL_MODULEID => MODULTASK, COL_REFERENCEID => $id));
		
			
		$data['laporanCustomerId']  = TASKTYPE_LAPORAN_CUSTOMER;
		
		$userassign = array();
		foreach ($this->mtaskassignment->GetByTaskID($id)->result_array() as $cats) {
			$userassign[] = $cats[COL_USERNAME];
		}
		if(empty($userassign)){

			$lastassignid = $this->mtaskassignment->lastid() +1;
			$data = array(COL_TASKASSIGNMENTID=>$lastassignid,COL_TASKID=>$id,COL_USERNAME=>'');;

			$this->db->insert(TBL_TASKASSIGNMENTS,$data);

			redirect(current_url());

		}
		
		$data['userassign'] = $userassign;
		$rules = array(
			array(
				'field'=>'TaskID',
				'label'=>'ID Tugas',
				'rules'=>'required'
			),
			array(
				'field'=>'Summary',
				'label'=>'Summary',
				'rules'=>'required'
			),
			array(
				'field'=>'Description',
				'label'=>'Description',
				'rules'=>'required'
			),
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			#$TaskID = $this->input->post('TaskID');
			$TaskID = $id;
			$ProjectID = $this->input->post('ProjectID');
			$TaskTypeID = $this->input->post('TaskTypeID');
			$SwoNo = $TaskTypeID == TASKTYPE_LAPORAN_CUSTOMER ? $this->input->post('Swono'):null;
			$CategoryID = $this->input->post('CategoryID');
			$TaskPriorityID = $this->input->post('TaskPriorityID');
			
			$role = GetUserLogin('RoleID');
			
			if($this->input->post('DueDate') < $this->input->post('StartedDate')){
				redirect(site_url('task/edit/'.$TaskID)."?error=ed");
				
			}
			
			$datatask = array(
					COL_TASKID => $TaskID,
					COL_SUMMARY => $this->input->post('Summary'),
					COL_PROJECTID => $ProjectID,
					COL_TASKTYPEID => $TaskTypeID,
					COL_CATEGORYID => $CategoryID,
					COL_SWONO => $SwoNo,
					COL_TASKPRIORITYID => $TaskPriorityID,
					COL_STARTEDDATE => $this->input->post('StartedDate'),
					COL_DUEDATE => $this->input->post('DueDate'),
					COL_DESCRIPTION => $this->input->post('Description'),
					COL_ISPRIVATE => $this->input->post('IsPrivate'),
					COL_UPDATEBY => GetUserLogin("UserName"),
					COL_UPDATEON => date("Y-m-d H:i:s"),
					COL_TASKSTATUSID => $this->input->post('TaskStatusID'),
					COL_PERCENTCOMPLETE => $this->input->post('Persentase'),
					COL_VERSIONID => $this->input->post('VersionID'),
			);
			
			
			$this->mtask->update($datatask, $TaskID);
						
			$this->mtaskassignment->DeleteAssign($TaskID);
						
			$assign = $this->input->post('AssignmentTo');
			
			$this->load->library('email',GetEmailConfig());
			$this->email->set_newline("\r\n");
			
			if(!empty($assign)){
				
					
				for ($i=0; $i < count($assign); $i++) {
						
					$lastassignid = $this->mtaskassignment->lastid() +1; 
					$data = array(COL_TASKASSIGNMENTID=>$lastassignid,COL_TASKID=>$TaskID,COL_USERNAME=>$assign[$i]);
					$this->mtaskassignment->insert($data);
					// $pref = GetNotif(NOTIF_DEPOSIT_ADMIN);
					$user = $this->muser->GetByID($assign[$i])->row_array();
					
					if(!empty($user[COL_EMAILADDRESS])){
					
						$message = TaskEmail(GetNewTaskMessage(),$TaskID,$assign[$i]);
						$subject = TaskEmail(SUBJECT_EMAIL_TASK,$TaskID,$assign[$i]);
						$this->email->from(SMTP_SENDER, SMTP_SENDER_NAME);
						$this->email->subject($subject);
					    $this->email->message($message);
						$this->email->to($user[COL_EMAILADDRESS]);
					    $this->email->send();
					}
				}
			}else{
				$lastassignid = $this->mtaskassignment->lastid() +1;
				$data = array(COL_TASKASSIGNMENTID=>$lastassignid,COL_TASKID=>$TaskID,COL_USERNAME=>'');
				$this->mtaskassignment->insert($data);
			}
			
			// if($assign){
				// for ($i=0; $i < count($assign); $i++) {
					// $lastassignid = $this->mtaskassignment->lastid() +1; 
					// $data = array(COL_TASKASSIGNMENTID=>$lastassignid,COL_TASKID=>$TaskID,COL_USERNAME=>$assign[$i]);
					// $this->mtaskassignment->insert($data);
				// }
				
			// }else{
				// $lastassignid = $this->mtaskassignment->lastid() +1;
				// $data = array(COL_TASKASSIGNMENTID=>$lastassignid,COL_TASKID=>$TaskID,COL_USERNAME=>'');
				// $this->mtaskassignment->insert($data);
			// }
			// $this->mattachment->deleteReference(array(COL_REFERENCEID => $TaskID));
			$idattach = $this->mattachment->GetAll(array(COL_MODULEID => MODULTASK, COL_REFERENCEID => $id))->row_array();
			$attachID = $this->input->post('MediaID');
			$this->mattachment->clearfromtask($TaskID);
			if(is_array($attachID)){
				
				foreach ($attachID as $attach) {
					$this->mattachment->update(array(COL_REFERENCEID => $TaskID, COL_MODULEID => MODULTASK), $attach);
				}
				// if (!empty($idattach)){
					// $idA = $idattach[COL_ATTACHMENTID];
					// if ($idA != $attachID){
						// $this->mattachment->delete($idA);
						// $this->mattachment->update(array(COL_REFERENCEID => $TaskID, COL_MODULEID => MODULTASK), $attachID);
					// }else if($attachID == 0){
						// $this->mattachment->delete($idA);
					// }
				// }else{
					// $this->mattachment->update(array(COL_REFERENCEID => $TaskID, COL_MODULEID => MODULTASK), $attachID);
				// }
			}
			redirect(site_url('task/edit/'.$TaskID)."?success=1");
		}else{
			$this->load->view('task/form', $data);
		}
		
	}
	function delete(){
		// CheckLogin();
		$data = $this->input->post('cekbox');

		$deleted = 0;
		$deletedcontent = "";

		for ($i=0; $i < count($data); $i++) {
			$row = $this->mtask->GetByID($data[$i]);
			
			$this->mtask->delete($data[$i]);
            $this->mattachment->deleteReference(array(COL_MODULEID => MODULTASK, COL_REFERENCEID => $data[$i]));
			
			$com = $this->mcomment->GetAll(array(COL_TASKID => $data[$i]));
			foreach ($com->result_array() as $comm) {
				$this->mattachment->deleteReference(array(COL_MODULEID => MODULCOMMENT, COL_REFERENCEID => $comm[COL_COMMENTID]));
			}
			
			$this->mcomment->deleteByTask($data[$i]);
			$this->mtaskassignment->DeleteAssign($data[$i]);
            $deleted++;
		}
		
		if($deleted){
			ShowJsonSuccess($deleted." data sudah dihapus");
			// redirect('task');
		}else{
			ShowJsonError($deleted." data belum dihapus");
		}
	}
	
	function view($id){
		$data['title'] = 'View Tugas';
		$data['result'] = $v = $this->mtask->GetByID($id)->row_array();
		$username=GetUserLogin("UserName");
		
		$allowed = false;
		
		if (IsOtherModuleActive(OTHERMODUL_CANLOOKALLTASKASSIGN)){
			$allowed = TRUE;
		}
		
		$cekassign = $this->db->where('UserName', $username)->where('TaskID', $id)->get('taskassignments')->num_rows();
		if($cekassign){
			$allowed = true;
		}
		
		if($data['result']['CreatedBy'] == $username){
			$allowed = true;
		}
		
		if(!$allowed){
			show_error("You are not allowed to view this task",403,"Forbidden Access");
		}
		
		$favorite = $this->mtask->GetFavorite($username,$id)->num_rows();
		if($favorite){
			$data['favorite'] = TRUE;
		}else{
			$data['favorite'] = FALSE;
		}		
		// echo $this->db->last_query();
		$data['comment'] = $this->mcomment->GetAll(array(COL_TASKID => $id));
		$data['taskstatus'] = GetFilteredTaskStatus();
		$data['laporanCustomerId']  = TASKTYPE_LAPORAN_CUSTOMER;
		
		$idp = $id * 59 + 666;
		$pro = $this->mproject->getall(array(COL_PROJECTID => $v[COL_PROJECTID]))->row_array();
		$nmpro = str_replace(' ', '', strtolower($pro[COL_PROJECTNAME]));
		
		$publiclink = base_url().'pview/task/'.$idp.'-'.$nmpro.'.html';
		$data['viewpublic'] = $publiclink;
		$this->load->view('task/view', $data);
	}
	
	function closeTask($id){
			
		$datatask = array(
			COL_ISCLOSED => TASK_ISCLOSED,
			COL_CLOSEDBY => GetUserLogin("UserName"),
			COL_CLOSEDON => date("Y-m-d H:i:s"),
			COL_TASKSTATUSID => TASKSTATUS_FINISHED,
			COL_CLOSEDMESSAGE => $this->input->post('ClosedMessage'),
			COL_PERCENTCOMPLETE => 100,
		);
		
		$this->mtask->update($datatask, $id);
		ShowJsonSuccess('Tugas Sudah di Close');
		
	}
	function editpersen($id){
		$dataedit = array(
			COL_PERCENTCOMPLETE => $this->input->post('persentase'),
			// COL_UPDATEBY => GetUserLogin("UserName"),
			// COL_UPDATEON => date("Y-m-d H:i:s"),
		);
		if($this->mtask->update($dataedit,$id)){
			ShowJsonSuccess('Persentase telah diperbaharui');
		}
		else{
			ShowJsonError('Persentase gagal diperbaharui');
		}
		
	}
	function editstatus($id){
		#$data['result'] = $this->mtaskstatus->GetAll();
		$data['result'] = GetFilteredTaskStatus();
		#echo $this->db->last_query();
		$data['title'] = 'Edit Status';
		$data['id'] =$id;
		$rules = array(
			array(
				'field'=>'TaskStatusID',
				'label'=>'Status Tugas',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$dataedit = array(
				COL_TASKSTATUSID => $this->input->post('TaskStatusID'),
				// COL_UPDATEBY => GetUserLogin("UserName"),
				// COL_UPDATEON => date("Y-m-d H:i:s"),
			);
			if($this->mtask->update($dataedit,$id)){
				redirect(site_url('task/view/'.$id));
			}else{
				redirect(site_url('task/editstatus/'.$id.'?msg=err'));
			}
		}else{
			$this->load->view('task/tasktype', $data);
		}
	}
	
	function changeStatus($id){
		if($this->mtask->update(array(COL_TASKSTATUSID => $this->input->get('statusID')),$id)){
			ShowJsonSuccess('Status berhasil diganti');
		}else{
			ShowJsonError('Status gagal diganti');
		}
	}
	
	function laporan(){
		if(!empty($_POST)){
			
			$dari = $this->input->post('FromDate') != "-" ?  $this->input->post('FromDate') : "";
			$sampai = $this->input->post('UntilDate') != "-" ?  $this->input->post('UntilDate') : "";
			$project = $this->input->post('ProjectID');
			
			if(!empty($dari)){
				$this->db->where(COL_STARTEDDATE.' >=',$dari.' 00:00:00');
			}
			
			if(!empty($sampai)){
				$this->db->where(COL_STARTEDDATE.' <=',$sampai.' 23:59:00');
			}

			if(!empty($project)){
				$this->db->where_in(COL_PROJECTID, $project);
			}
						
			$this->db->where(
							" (((".COL_ISCLOSED." = 1) AND (".COL_CLOSEDON." > ".COL_DUEDATE.")) OR ((".
							COL_ISCLOSED." = 0) AND (".COL_DUEDATE." < '".date('Y-m-d')."')))",null,FALSE
			);
			$data['result'] = $this->db->get(TBL_TASKS);
			$data['title'] = "Laporan Tugas yang Tidak Selesai Tepat Waktu";
			// echo $this->db->last_query();
			$this->load->view('task/laporan', $data);
		}else{	
			$this->load->view('task/reportlate');
		}
	}
	
	function laporannonkomentar(){
		if(!empty($_POST)){
			$this->load->helper('text');
			$dari = $this->input->post('FromDate') != "-" ?  $this->input->post('FromDate') : "";
			$sampai = $this->input->post('UntilDate') != "-" ?  $this->input->post('UntilDate') : "";
			$project = $this->input->post('ProjectID');
			$date = $this->input->post('Date');
			
			if(!empty($dari)){
				#$this->db->where(COL_STARTEDDATE.' >=',$dari.' 00:00:00');
			}
			
			if(!empty($sampai)){
				#$this->db->where(COL_STARTEDDATE.' <=',$sampai.' 23:59:00');
			}

			if(!empty($project)){
				#$this->db->where_in(COL_PROJECTID, $project);
			}
						
			#$this->db->where(
							#" (((".COL_ISCLOSED." = 1) AND (".COL_CLOSEDON." > ".COL_DUEDATE.")) OR ((".
							#COL_ISCLOSED." = 0) AND (".COL_DUEDATE." < '".date('Y-m-d')."')))",null,FALSE
			#);
			#$this->db->where("((IsClosed = 0) OR (IsClosed = 1 AND date(ClosedOn) = '".$date."'))");
			$this->db->where("((".COL_ISCOMPLETED." = 0) OR (".COL_ISCOMPLETED." = 1 AND date(".COL_COMPLETEDON.") = '".$date."'))");
			$this->db->where('date(StartedDate) <=',$date);
			$this->db->order_by(COL_TASKID,'desc');
			$data['result'] = $this->db->get(TBL_TASKS);
			$data['title'] = "Laporan tugas yang tidak dikomentari";
			// echo $this->db->last_query();
			$this->load->view('task/laporannonkomentar', $data);
		}else{	
			$this->load->view('task/reportnonkomentar');
		}
	}
	
	function testing(){
		$this->load->view('task/justtesting');
	}

    function startChecking($id) {
        $dataupdate = array(
            COL_UPDATEBY => GetUserLogin(COL_USERNAME),
            COL_UPDATEON => date('Y-m-d H:i:s'),
            COL_STARTCHECKON => date('Y-m-d H:i:s'),
            COL_STARTCHECKBY => GetUserLogin(COL_USERNAME),
            COL_TASKSTATUSID => TASKSTATUS_ONTESTING
        );
        $update = $this->db->where(COL_TASKID, $id)->update(TBL_TASKS, $dataupdate);
        if($update) ShowJsonSuccess('Success');
        else ShowJsonError('Error');
        return;
    }

    function finishChecking($id) {
        $message = $this->input->post('FinishMessage');
        $dataupdate = array(
            COL_UPDATEBY => GetUserLogin(COL_USERNAME),
            COL_UPDATEON => date('Y-m-d H:i:s'),
            COL_ISCHECKED => true,
            COL_FINISHCHECKON => date('Y-m-d H:i:s'),
            COL_FINISHMESSAGE => $message,
            COL_FINISHCHECKBY => GetUserLogin(COL_USERNAME),
            COL_ISCOMPLETED => 1,
            COL_COMPLETEDBY => GetUserLogin(COL_USERNAME),
            COL_COMPLETEDON => date('Y-m-d H:i:s'),
            COL_COMPLETEMESSAGE => $message,
            COL_TASKSTATUSID => TASKSTATUS_CLOSED
        );
        $update = $this->db->where(COL_TASKID, $id)->update(TBL_TASKS, $dataupdate);
        if($update) ShowJsonSuccess('Success');
        else ShowJsonError('Error');
        return;
    }

    function laporanbugs() {
        $fromdate = $data['fromdate'] = $this->input->post('FromDate') ? $this->input->post('FromDate') : date('Y-m-d');
        $todate = $data['todate'] = $this->input->post('ToDate') ? $this->input->post('ToDate') : date('Y-m-d');
        $project = $data['projects'] =  $this->input->post('ProjectID');

        $this->db->select("*, ".TBL_COMMENTS.".".COL_DESCRIPTION." as ".COL_DESCRIPTION);
        $this->db->select(TBL_COMMENTS.".".COL_CREATEDBY." as ".COL_CREATEDBY);
        $this->db->select(TBL_COMMENTS.".".COL_CREATEDON." as ".COL_CREATEDON);

        $this->db->join(TBL_TASKS.' '.TBL_TASKS, TBL_TASKS.'.'.COL_TASKID.'='.TBL_COMMENTS.'.'.COL_TASKID,'inner');
        $this->db->join(TBL_PROJECTS.' '.TBL_PROJECTS, TBL_PROJECTS.'.'.COL_PROJECTID.'='.TBL_TASKS.'.'.COL_PROJECTID,'inner');

        if(!empty($fromdate)) $this->db->where("DATE_FORMAT(".TBL_COMMENTS.'.'.COL_CREATEDON.",'%Y-%m-%d') >=",$fromdate);
        if(!empty($todate)) $this->db->where("DATE_FORMAT(".TBL_COMMENTS.'.'.COL_CREATEDON.",'%Y-%m-%d') <=",$todate);
        if(!empty($project)) $this->db->where_in(TBL_TASKS.'.'.COL_PROJECTID, $project);

        $this->db->where(COL_COMMENTYPEID, COMMENTTYPE_BUG);

        $data['comments'] = $this->db->get(TBL_COMMENTS)->result_array();
        $this->load->view('task/laporanbugs', $data);
    }

    function laporanchecking() {
        //$date = $this->input->post('Date');
        $data['title'] = 'Laporan Checking Tugas';

        $this->db->join(TBL_PROJECTS.' '.TBL_PROJECTS, TBL_PROJECTS.'.'.COL_PROJECTID.'='.TBL_TASKS.'.'.COL_PROJECTID,'inner');
        $this->db->where(COL_ISCLOSED, TRUE);
        $this->db->where(COL_ISCHECKED, FALSE);

        $data['result'] = $this->db->get(TBL_TASKS)->result_array();
        $this->load->view('task/laporanchecking', $data);
    }

    function datediff() {
        $nowdate = date('Y-m-d');
        $closedate = date('Y-m-d', strtotime('2015-09-19 13:09:10'));
        //$checkdate = date('Y-m-d', strtotime($item[COL_STARTCHECKON]));
        echo $nowdate.'<br />';
        echo $closedate.'<br />';
        echo intval((strtotime($nowdate) - strtotime($closedate)) / 86400);
    }
	function addFavoriteTask($id){
		$usernamefav = 	GetUserLogin("UserName");
		$datataskfav = array(
			COL_USERNAME => $usernamefav,
			COL_TASKID => $id,
		);
		$cekfavorite = $this->mtask->GetFavorite($usernamefav,$id)->num_rows();
		if($cekfavorite){
			ShowJsonError('Tugas Sudah Ada di Daftar Favorite');
			return;
		}else{
			$this->mtask->favorite($datataskfav);
			ShowJsonSuccess('Ditambah ke Daftar Favorite');
		}	
		
	}
	function removeFavoriteTask($id){
		$usernamefav=GetUserLogin("UserName");
		
		$datataskfav = array(
			COL_USERNAME => $usernamefav,
			COL_TASKID => $id,
		);
		
		$this->db->where(COL_TASKID,$id);
		$this->db->where(COL_USERNAME,$usernamefav);
		$this->db->delete(TBL_TASKFAVORITE);
		ShowJsonSuccess('Dihapus dari Daftar Favorite');
		
	}
}
