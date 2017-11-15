<?php

class Dashboard extends MY_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('mtask');
		$this->load->model('mtaskpriority');
		$this->load->model('mnews');
	}
	
	public function index(){
		if(!IsUserLogin()){
			show_error('Silahkan login');
		}
		// $data['title'] = 'Daftar Tugas Belum Selesai';
		$data['news'] = $this->mnews->TampilNews();
        $showtestertask = IsOtherModuleActive(OTHERMODUL_SHOW_TESTERTASK);

        if (!IsOtherModuleActive(OTHERMODUL_CANLOOKALLTASKASSIGN)){
            $user = GetUserLogin('UserName');
            if(IsOtherModuleActive(OTHERMODUL_ONLYLOOKOWNTASK)){
                $this->db->where(TBL_TASKS.".".COL_CREATEDBY,$user);
            }else{
                $this->db->join(TBL_TASKASSIGNMENTS, TBL_TASKASSIGNMENTS.'.'.COL_TASKID.'='.TBL_TASKS.'.'.COL_TASKID,'inner');
                $this->db->where(TBL_TASKASSIGNMENTS.".".COL_USERNAME, $user);
            }

            $this->db->join(TBL_TASKSTATUS, TBL_TASKSTATUS.'.'.COL_TASKSTATUSID.'='.TBL_TASKS.'.'.COL_TASKSTATUSID,'inner');
            $this->db->join(TBL_CATEGORIES, TBL_CATEGORIES.'.'.COL_CATEGORYID.'='.TBL_TASKS.'.'.COL_CATEGORYID, 'inner');
            $this->db->join(TBL_TASKTYPES, TBL_TASKTYPES.'.'.COL_TASKTYPEID.'='.TBL_TASKS.'.'.COL_TASKTYPEID, 'inner');
        }else{
            $this->db->join(TBL_TASKSTATUS, TBL_TASKSTATUS.'.'.COL_TASKSTATUSID.'='.TBL_TASKS.'.'.COL_TASKSTATUSID,'inner');
            $this->db->join(TBL_CATEGORIES, TBL_CATEGORIES.'.'.COL_CATEGORYID.'='.TBL_TASKS.'.'.COL_CATEGORYID, 'inner');
            $this->db->join(TBL_TASKTYPES, TBL_TASKTYPES.'.'.COL_TASKTYPEID.'='.TBL_TASKS.'.'.COL_TASKTYPEID, 'inner');
        }
        $projectid = $this->input->get('projectid');

        if(!empty($projectid)){
            $this->db->where(COL_PROJECTID,$projectid);
        }
        if($showtestertask) {
            //$this->db->where(COL_ISCLOSED, true);
            $this->db->where(COL_ISCHECKED, false);
        }
        else {
            $this->db->where(COL_ISCHECKED, false);
        }

        $data['task'] = $this->db->order_by(TBL_TASKS.'.'.COL_TASKID, 'desc')->get(TBL_TASKS);
		
		$this->load->view('user/dashboard', $data);
	}	
	
}
