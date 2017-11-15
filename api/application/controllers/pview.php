<?php

class Pview extends MY_Controller{
		
	
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
		
	}
	
	function task($id){
		if(!$id){
			show_404();
		}
		$data['title'] = 'View Tugas';
		
		$a = explode('-',$id);
		$idt = ($a[0]-666)/59;
		$nmp = $a[1];
		
		$pro = $this->mproject->getall();
		$a = '';
		foreach($pro->result_array() as $prov){
			if (str_replace(' ', '', strtolower($prov[COL_PROJECTNAME])) == $nmp){
				$a = $prov[COL_PROJECTID];
			}
		}
		
		$this->db->where(array(COL_TASKID => $idt, COL_PROJECTID => $a));
		$this->db->join(TBL_TASKRESOLUTIONS,TBL_TASKRESOLUTIONS.'.'.COL_TASKRESOLUTIONID.' = '.TBL_TASKS.'.'.COL_TASKRESOLUTIONID,'left');
		$this->db->join(TBL_TASKSEVERITIES,TBL_TASKSEVERITIES.'.'.COL_TASKSEVERITYID.' = '.TBL_TASKS.'.'.COL_TASKSEVERITYID,'left');
		$this->db->join(TBL_TASKTYPES,TBL_TASKTYPES.'.'.COL_TASKTYPEID.' = '.TBL_TASKS.'.'.COL_TASKTYPEID,'left');
		$this->db->join(TBL_TASKSTATUS,TBL_TASKSTATUS.'.'.COL_TASKSTATUSID.' = '.TBL_TASKS.'.'.COL_TASKSTATUSID,'left');
		$this->db->join(TBL_TASKPRIORITIES,TBL_TASKPRIORITIES.'.'.COL_TASKPRIORITYID.' = '.TBL_TASKS.'.'.COL_TASKPRIORITYID,'left');
		$this->db->join(TBL_CATEGORIES,TBL_CATEGORIES.'.'.COL_CATEGORYID.' = '.TBL_TASKS.'.'.COL_CATEGORYID,'left');
		$this->db->join(TBL_ATTACHMENTS,TBL_ATTACHMENTS.'.'.COL_REFERENCEID.' = '.TBL_TASKS.'.'.COL_TASKID,'left');
		
		$data['result'] = $v = $this->db->get(TBL_TASKS)->row_array();
		// $data['result'] = $v = $this->mtask->GetAll(array(COL_TASKID => $idt, COL_PROJECTID => $a))->row_array();
		if(!$v){
			show_404();
		}
		$data['comment'] = $this->mcomment->GetAll(array(COL_TASKID => $idt, COL_COMMENTYPEID." !=" => COMMENTTYPE_BUG));
		$data['taskstatus'] = GetFilteredTaskStatus();
		
		// $idp = $id * 59 + 666;
		// $pro = $this->mproject->getall(array(COL_PROJECTID => $v[COL_PROJECTID]))->row_array();
		// $nmpro = str_replace(' ', '', strtolower($pro[COL_PROJECTNAME]));
// 		
		// $publiclink = base_url().'pview/task/'.$idp.'-'.$nmpro;
		// $data['viewpublic'] = $publiclink;
		$this->load->view('task/pview', $data);
	}
}	