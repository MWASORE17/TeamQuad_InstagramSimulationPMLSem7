<?php

class TaskResolution extends MY_Controller{
		
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('mtaskresolution');
		$this->load->library('form_validation');
	}
	
	function index(){
		$data['title'] = 'Daftar Resolusi Tugas ';
		$data['c'] = $this->mtaskresolution->GetAll();
		// echo $this->db->last_query();
		$this->load->view('taskresolution/data', $data);
	}
	
	function add(){
		$data['edit'] = FALSE;
		// $data['lastid'] = $this->mtaskresolution->lastid();
		$data['title'] = 'Tambah Resolusi Tugas';
		$data['c'] = $this->mtaskresolution->GetAll();
		$data['parenttask'] = $this->mtaskresolution->GetAll();
		$rules = array(
			// array(
				// 'field'=>'TaskResolutionID',
				// 'label'=>'ID Resolusi Tugas',
				// 'rules'=>'required'
			// ),
			array(
				'field'=>'TaskResolutionName',
				'label'=>'Nama Resolusi Tugas',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$TaskResolutionID = $this->mtaskresolution->lastid()+1;	
			$TaskResolutionName = $this->input->post('TaskResolutionName');
			$Order = $this->input->post('Order');
			
			$datataskresolution = array(
					COL_TASKRESOLUTIONID => $TaskResolutionID,
					COL_TASKRESOLUTIONNAME => $TaskResolutionName,
					COL_ORDER => $Order
			);
			
			$this->mtaskresolution->insert($datataskresolution);
			
			redirect(site_url('taskresolution/edit/'.$TaskResolutionID)."?success=1");
		}else{
			$this->load->view('taskresolution/form', $data);
		}
		
	}
	
	function edit($id){
		$data['edit'] = TRUE;
		$data['title'] = 'Edit Kategori';
		$data['result'] = $this->mtaskresolution->GetByID($id)->row();
		$data['parenttask'] = $this->mtaskresolution->GetAll();
		// $data['result'] = $this->mpost->GetAllAuction(array('p.'.COL_POSTID=>$id))->row();
		$rules = array(
			array(
				'field'=>'TaskResolutionID',
				'label'=>'ID Resolusi Tugas',
				'rules'=>'required'
			),
			array(
				'field'=>'TaskResolutionName',
				'label'=>'Nama Resolusi Tugas',
				'rules'=>'required'
			)
		);
		
		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()){
			$TaskResolutionID = $this->input->post('TaskResolutionID');	
			$TaskResolutionName = $this->input->post('TaskResolutionName');
			$Order = $this->input->post('Order');
			
			$datataskresolution = array(
					COL_TASKRESOLUTIONID => $TaskResolutionID,
					COL_TASKRESOLUTIONNAME => $TaskResolutionName,
					COL_ORDER => $Order
			);
						
			$this->mtaskresolution->update($datataskresolution,$TaskResolutionID);
			
			redirect(site_url('taskresolution/edit/'.$TaskResolutionID)."?success=1");
		}else{
			$this->load->view('taskresolution/form', $data);
		}
		
	}
	function delete(){
		// CheckLogin();
		$data = $this->input->post('cekbox');

		$deleted = 0;
		$deletedcontent = "";

		for ($i=0; $i < count($data); $i++) {
			$row = $this->mtaskresolution->GetByID($data[$i]);
			
			if (CheckRow(TBL_TASKS, COL_TASKRESOLUTIONID, $data[$i])){
				$this->mtaskresolution->delete($data[$i]);
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