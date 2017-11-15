<?php

class TaskStatus extends MY_Controller{
		
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('mtaskstatus');
		$this->load->library('form_validation');
	}
	
	function index(){
		$data['title'] = 'Daftar Status Tugas';
		$data['c'] = $this->mtaskstatus->GetAll();
		// echo $this->db->last_query();
		$this->load->view('taskstatus/data', $data);
	}
	
	function add(){
		$data['edit'] = FALSE;
		// $data['lastid'] = $this->mtaskstatus->lastid();
		$data['title'] = 'Tambah Status Tugas';
		$data['c'] = $this->mtaskstatus->GetAll();
		// $data['parenttask'] = $this->mtasktype->GetAll();
		$rules = array(
			// array(
				// 'field'=>'TaskStatusID',
				// 'label'=>'Jenis Tugas',
				// 'rules'=>'required'
			// ),
			array(
				'field'=>'TaskStatusName',
				'label'=>'Nama Jenis Tugas',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$TaskStatusID = $this->mtaskstatus->lastid()+1;	
			$TaskStatusName = $this->input->post('TaskStatusName');
			$Order = $this->input->post('Order');
			
			$datataskstatus = array(
					COL_TASKSTATUSID => $TaskStatusID,
					COL_TASKSTATUSNAME => $TaskStatusName,
					COL_ORDER => $Order
			);
			
			$this->mtaskstatus->insert($datataskstatus);
			
			redirect(site_url('taskstatus/edit/'.$TaskStatusID)."?success=1");
		}else{
			$this->load->view('taskstatus/form', $data);
		}
		
	}
	
	function edit($id){
		$data['edit'] = TRUE;
		$data['title'] = 'Edit Status Tugas';
		$data['result'] = $this->mtaskstatus->GetByID($id)->row();
		// $data['parenttask'] = $this->mtasktype->GetAll();
		
		$rules = array(
			array(
				'field'=>'TaskStatusID',
				'label'=>'Jenis Tugas',
				'rules'=>'required'
			),
			array(
				'field'=>'TaskStatusName',
				'label'=>'Nama Jenis Tugas',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$TaskStatusID = $this->input->post('TaskStatusID');	
			$TaskStatusName = $this->input->post('TaskStatusName');
			$Order = $this->input->post('Order');
			
			$datataskstatus = array(
					COL_TASKSTATUSID => $TaskStatusID,
					COL_TASKSTATUSNAME => $TaskStatusName,
					COL_ORDER => $Order
			);
			
			$this->mtaskstatus->update($datataskstatus,$TaskStatusID);
			
			
			redirect(site_url('taskstatus/edit/'.$TaskStatusID)."?success=1");
		}else{
			$this->load->view('taskstatus/form', $data);
		}
		
	}
	function delete(){
		// CheckLogin();
		$data = $this->input->post('cekbox');

		$deleted = 0;
		$deletedcontent = "";

		for ($i=0; $i < count($data); $i++) {
			$row = $this->mtaskstatus->GetByID($data[$i]);
			
			if (CheckRow(TBL_TASKS, COL_TASKSTATUSID, $data[$i])){
				$this->mtaskstatus->delete($data[$i]);
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
	
}