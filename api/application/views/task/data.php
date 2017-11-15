<?= $this->load->view('header')?>


<?php

 if(!IsUserLogin()){ ?>
 	
	<div class='alert alert-warning'>
 		Silahkan <?= anchor('user', 'Login')?> Dulu
	</div>
				
<?php
 }else if(!IsAllowView(MODULTASK)){
 ?>		
 	<div class='alert alert-warning'>
 		Tidak diizinkan melihat data
	</div>
<?	
 }else{

	if(!IsAllowDelete(MODULTASK)){
?>		
		<style>
			.cekboxaction{
				display:none;
			}
		</style>	
		
<?php		
	}
	
	// if (!IsOtherModuleActive(OTHERMODUL_CANLOOKALLTASKASSIGN)){
		// $user = GetUserLogin('UserName');
		// if(IsOtherModuleActive(OTHERMODUL_ONLYLOOKOWNTASK)){
			// $this->db->where(TBL_TASKS.".".COL_CREATEDBY,$user);
		// }else{
			// $this->db->join(TBL_TASKASSIGNMENTS, TBL_TASKASSIGNMENTS.'.'.COL_TASKID.'='.TBL_TASKS.'.'.COL_TASKID,'inner');
			// $this->db->where(TBL_TASKASSIGNMENTS.".".COL_USERNAME, $user);
		// }
// 		
		// $this->db->join(TBL_TASKSTATUS, TBL_TASKSTATUS.'.'.COL_TASKSTATUSID.'='.TBL_TASKS.'.'.COL_TASKSTATUSID,'inner');
		// $this->db->join(TBL_PROJECTS, TBL_PROJECTS.'.'.COL_PROJECTID.'='.TBL_TASKS.'.'.COL_PROJECTID, 'inner');
		// $this->db->join(TBL_CATEGORIES, TBL_CATEGORIES.'.'.COL_CATEGORYID.'='.TBL_TASKS.'.'.COL_CATEGORYID, 'inner');
		// $this->db->join(TBL_TASKTYPES, TBL_TASKTYPES.'.'.COL_TASKTYPEID.'='.TBL_TASKS.'.'.COL_TASKTYPEID, 'inner');
		// // $this->db->where(COL_CREATEDBY, $user);
		// $task = $this->db->get(TBL_TASKS);
		// //echo $this->db->last_query();
		// $data = array();
		// $i = 0;
		// foreach ($task->result_array() as $d){
			// $percent = '<div class="progress">
						  // <div class="progress-bar" role="progressbar" aria-valuenow="'.$d[COL_PERCENTCOMPLETE].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$d[COL_PERCENTCOMPLETE].'%;">
						    // '.$d[COL_PERCENTCOMPLETE].'%
						  // </div>
						// </div>';
			// $assign = $this->mtask->GetAssignString($d[COL_TASKID]);
			// $rlastcomment = $this->mtask->GetLastComment($d[COL_TASKID])->row_array();
			// // $lastcomment = empty($rlastcomment) ? "-" : $rlastcomment[COL_DESCRIPTION];
			// $lastcomment = empty($rlastcomment) ? "-" : '<a tabindex="0"  data-placement="auto" role="button" data-toggle="popover" data-trigger="focus" title="'.$rlastcomment[COL_CREATEDBY].'" data-content="'.$rlastcomment[COL_DESCRIPTION].'">'.substr($rlastcomment[COL_DESCRIPTION],0,25).'</a>';
			// // $lastcomment = empty($rlastcomment) ? "-" :'<a href="#" data-toggle="tooltip" data-placement="left" title="'.$rlastcomment[COL_DESCRIPTION].'">'.substr($rlastcomment[COL_DESCRIPTION],0,25).'</a>';
			// // $lastcomment = empty($rlastcomment) ? "-" : "<a class='tooltip' href='#'>".$rlastcomment[COL_DESCRIPTION]."<span class='bubble'>".$rlastcomment[COL_DESCRIPTION]."</span></a>";
			// $lastcommentdate = empty($rlastcomment) ? "-" : $rlastcomment[COL_CREATEDON];
			// $p = $this->mtaskpriority->GetByID($d[COL_TASKPRIORITYID])->row_array();
// 			
			// $enddate = explode("-", $d[COL_DUEDATE]);
			// $tgl = $enddate[2];
			// $bln= $enddate[1];
			// $thn = $enddate[0];
			// $enddate1 = $tgl.'-'.$bln.'-'.$thn;
			// $sekarang = date("d-m-Y");
			// if ($d[COL_DUEDATE] < date("Y-m-d")){
				// $sisahari = '0';
			// }else{
				// $sisahari = (strtotime($enddate1) - strtotime($sekarang)) / 86400;
			// }
// 			
// 			
			// // echo $this->last_query();
			// $data[$i] = array(
							// '<input type="checkbox" class="cekbox" name="cekbox[]" value="'.$d[COL_TASKID].'" />',
							// $d[COL_TASKID],
							// $d[COL_PROJECTNAME],
							// $d[COL_CATEGORYNAME],
							// $d[COL_TASKTYPENAME],							
							// anchor('task/edit/'.$d[COL_TASKID],$d[COL_SUMMARY]),
							// $d[COL_STARTEDDATE],
							// $d[COL_TASKSTATUSNAME],
							// $p[COL_TASKPRIORITYNAME],
							// $percent,
							// // $d[COL_CREATEDBY],
							// $assign ,
							// $sisahari." hari",
							// $lastcomment,
							// $lastcommentdate,
							// // $d[COL_ISCLOSED],
							// // $d[COL_CLOSEDBY].'<br/>'.$d[COL_CLOSEDON],
							// anchor('task/view/'.$d[COL_TASKID],'View'),
						// );
			// $i++;
		// }
		// $data = json_encode($data);
// 		
	// }else{
		$data = array();
		$i = 0;
		foreach ($c->result_array() as $d){
			$percent = '<div class="progress">
						  <div class="progress-bar" role="progressbar" aria-valuenow="'.$d[COL_PERCENTCOMPLETE].'" aria-valuemin="0" aria-valuemax="100" style="width: '.$d[COL_PERCENTCOMPLETE].'%;">
						    '.$d[COL_PERCENTCOMPLETE].'%
						  </div>
						</div>';
			$assign = $this->mtask->GetAssignString($d[COL_TASKID]);
			// echo $this->last_query();
			$rlastcomment = $this->mtask->GetLastComment($d[COL_TASKID])->row_array();
			$lastcomment = empty($rlastcomment) ? "-" : '<a tabindex="0"  data-placement="auto" role="button" data-toggle="popover" data-trigger="focus" title="'.$rlastcomment[COL_CREATEDBY].'" data-content="'.str_replace('"','&quot;',$rlastcomment[COL_DESCRIPTION]).'">'.str_replace('"','&quot;',substr($rlastcomment[COL_DESCRIPTION],0,25)).'</a>';
			$lastcommentdate = empty($rlastcomment) ? "-" : $rlastcomment[COL_CREATEDON];
			$p = $this->mtaskpriority->GetByID($d[COL_TASKPRIORITYID])->row_array();
			
			if($d[COL_DUEDATE] == '' || $d[COL_DUEDATE] == '0000-00-00' || $d[COL_DUEDATE] == null){
				$sisahari = '-';
			}
			$enddate = explode("-", $d[COL_DUEDATE]);
			$tgl = $enddate[2];
			$bln= $enddate[1];
			$thn = $enddate[0];
			$enddate1 = $tgl.'-'.$bln.'-'.$thn;
			$sekarang = date("d-m-Y");
			if ($d[COL_DUEDATE] >= date("Y-m-d")){
				$sisahari = (strtotime($enddate1) - strtotime($sekarang)) / 86400;
			}else{
				$sisahari = -1;
			}
			if(!IsAllowUpdate(MODULTASK)){
				$edittask = $d[COL_SUMMARY].". ".anchor('task/view/'.$d[COL_TASKID],"View");
			}else{
				$edittask = $d[COL_SUMMARY].". ".anchor('task/view/'.$d[COL_TASKID],"View")." | ".anchor('task/edit/'.$d[COL_TASKID],"Edit");
				#$edittask = anchor('task/edit/'.$d[COL_TASKID],$d[COL_SUMMARY]);
			}
			
			if($d[COL_DUEDATE] == null || $d[COL_DUEDATE] == '0000-00-00' || $d[COL_DUEDATE] == ''){
				$batas='';
				
			}else{
				$batas = date('d',strtotime($d[COL_DUEDATE]))."-".date('m',strtotime($d[COL_DUEDATE]))."-".date('Y',strtotime($d[COL_DUEDATE]));
			}
			
			if(($d[COL_CLOSEDON] != null || $d[COL_CLOSEDON] != '0000-00-00 00:00:00' || $d[COL_CLOSEDON] != '')){
				$closed = date('d',strtotime($d[COL_CLOSEDON]))."-".date('m',strtotime($d[COL_CLOSEDON]))."-".date('Y',strtotime($d[COL_CLOSEDON]));
			}else{
				$closed='';
			}
			
			if ($d[COL_ISCLOSED] == 1 && $d[COL_CLOSEDON] > $d[COL_DUEDATE] && $batas != '') {
				$terlambat = ((strtotime($closed) - strtotime($batas)) / 86400);
			}else if(date('Y-m-d') > $d[COL_DUEDATE] && $d[COL_ISCLOSED] == 0 && $batas != ''){
				$terlambat = ((strtotime(date("d-m-Y")) - strtotime($batas)) / 86400);
				
			}else{
				$terlambat = '-';
			}
			
			$durasites = "";
			if(!empty($d[COL_STARTCHECKON])){
				if($d[COL_ISCOMPLETED]){
					$durasites = ((strtotime($d[COL_COMPLETEDON]) - strtotime($d[COL_STARTCHECKON])) / 86400);
				}else{
					$durasites = ((time() - strtotime($d[COL_STARTCHECKON])) / 86400);
				}
			}
			
			$project = $this->db->select(COL_PROJECTNAME)->where(COL_PROJECTID, $d[COL_PROJECTID])->get(TBL_PROJECTS)->row_array();
			
			if(!IsAllowUpdate(MODULTASK)){
				$viewtask = 'Edit';
			}else{
				$viewtask = anchor('task/edit/'.$d[COL_TASKID],'Edit');
			}
			
			$data[$i] = array(
							'<input type="checkbox" class="cekbox" name="cekbox[]" value="'.$d[COL_TASKID].'" />',
							$d[COL_TASKID],
							$project[COL_PROJECTNAME],
							$d[COL_CATEGORYNAME],
							$d[COL_TASKTYPENAME],
							// anchor('task/edit/'.$d[COL_TASKID],$d[COL_SUMMARY]),
							$edittask,
							$d[COL_STARTEDDATE],
							$d[COL_SWONO],
							$d[COL_TASKSTATUSNAME],
							$p[COL_TASKPRIORITYNAME],
							$d[COL_CREATEDBY],
							$percent,
							// $d[COL_CREATEDBY],
							$assign,
							$sisahari >= 0 ? $sisahari." hari" : '-',
							$d[COL_ISCLOSED] == 1 ? $d[COL_CLOSEDON] : '-',
							$terlambat < 1 ? '-' : desimal($terlambat)." hari",
							$durasites === "" ? '-' : desimal($durasites)." hari",
							// $batas.', '.date('Y-m-d'),
							$lastcomment,
							$lastcommentdate,
							// $d[COL_CLOSEDBY].'<br/>'.$d[COL_CLOSEDON],
							#$viewtask,
						);
			$i++;
		}
		$data = json_encode($data);
	// }	
	?>

	<div class="page-wrapper" style="padding:0">	
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						<h1 style="margin:0"><?= $title ?></h1>
						<br>
					</div>
					<div class="col-md-12">
						<div>
							<?= form_open(current_url(),array('method'=>'get')) ?>
							<div class="input-group search row">
								<div class="col-md-3">
									<input class="form-control swo" type="text" name="Swono" placeholder="SWO" value="<?=$swono ? $swono : set_value('Swono')?>"/>
								</div>
								<div class="col-md-3">				
									<select name="Search" class="form-control ">
										<option value="all" <?= $s == 'all'? 'selected': '' ?>>Semua</option>
										<?php
										if(GetUserLogin(COL_ROLEID) == ADMINROLE) {
										?>
											<option value="0" <?= $s == '0'? 'selected': '' ?>>Belum Closed</option>
											<option value="1" <?= $s == '1'? 'selected': '' ?>>Sudah Closed</option>
											<option value="2" <?= $s == '2'? 'selected': '' ?>>Belum Dicheck</option>
											<option value="3" <?= $s == '3'? 'selected': '' ?>>Sudah Dicheck/closed</option>
										<?php
										}
										else if(!IsOtherModuleActive(OTHERMODUL_SHOW_TESTERTASK)) {
										?>
											<option value="0" <?= $s == '0'? 'selected': '' ?>>Belum Closed</option>
											<option value="1" <?= $s == '1'? 'selected': '' ?>>Sudah Closed</option>
										<?php
										}
										else {
										?>
											<option value="0" <?= $s == '0'? 'selected': '' ?>>Belum Closed</option>
											<option value="2" <?= $s == '2'? 'selected': '' ?>>Belum Dicheck</option>
											<option value="3" <?= $s == '3'? 'selected': '' ?>>Sudah Dicheck</option>
										<?php
										}
										?>
									</select>
								</div>
								<div class="col-md-3">
									<?php $Category = $this->mcategory->GetAll(); ?>
									<select name="CategoryID" id="CategoryID" class="required form-control">
										<option value="">Semua Kategori</option>
										<?=GetComboboxCI($Category, "CategoryID", "CategoryName",$categoryid ? $categoryid: set_value('CategoryID'))?>
									</select>
								</div>
								<div class="col-md-3">
									<?php $TaskType = $this->mtasktype->GetAll(); ?>
									<select name="TaskTypeID" id="TaskTypeID" class="required form-control">
										<option value="">Semua Jenis</option>
										<?=GetComboboxCI($TaskType, "TaskTypeID", "TaskTypeName",$tasktypeid ? $tasktypeid : set_value('TaskTypeID'))?>
									</select>
								</div>
								<input type="hidden" name="projectid" value="<?= $this->input->get('projectid') ?>" />
								<input type="hidden" name="favorite" value="<?= $this->input->get('favorite') ?>" />
								<span class="input-group-btn">
									<button type="submit" class="btn btn-primary" style="margin-right: 15px;margin-left: -15px;" type="button">Tampilkan</button>
								</span>
								
							</div>
							<?= form_close() ?>
						</div>
					</div>
					<div class="col-md-12">
						<br>
						<?=anchor('task/delete','<i class="clip-remove"></i> Hapus',array('class'=>'cekboxaction ui btn btn-danger','confirm'=>'Apa anda yakin?'))?>
					</div>
				</div>
				<br>
				<!-- <div class="table-responsive"> -->
					<form id="dataform" method="post" action="#">
						<table id="databerita" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered" width="100%">
						</table>
					</form>
				<!-- </div> -->
				<div class="clear"></div>

				</div>
			</div>
		</div>
		<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>


<script type="text/javascript">
$(document).ready(function(){
	

		var pelangganTable = $('#databerita').dataTable({
	        "aaData": <?=$data?>,
            //"sDom": "Rlfrtip",
	        // "bJQueryUI": true,
	        "aaSorting" : [[1,'desc']],
        	// "sPaginationType": "full_numbers",
        	"scrollY" : 400,
        	"scrollX" : "150%",
        	"iDisplayLength": 100,
    		"aLengthMenu": [[100, 1000, 5000, -1], [100, 1000, 5000, "Semua"]],
	        "aoColumns": [
	        	{"sTitle": "<input type=\"checkbox\" id=\"cekbox\" class=\"cekbox\" />","sWidth":15,bSortable:false},
	        	{"sTitle": "ID"},
	            {"sTitle": "Project"},
	            {"sTitle": "Kategori"},
	            {"sTitle": "Jenis Tugas"},
	            {"sTitle": "Summary"},
	            {"sTitle": "Tanggal Mulai"},
				{"sTitle": "SWO"},
	            {"sTitle": "Status Tugas"},
	            {"sTitle": "Priority"},
	            {"sTitle": "CreatedBy"},
	            {"sTitle": "Persentase"},
	            // {"sTitle": "CreatedBy"},
	            {"sTitle": "Assign to"},
	            {"sTitle": "Sisa Hr"},
	            {"sTitle": "Tgl. Slsai"},
	            {"sTitle": "Lwt. Hr"},
	            {"sTitle": "Durasi tes"},
	            {"sTitle": "Lst Cmnt"},
	            {"sTitle": "Cmnt Date"},
	            //{"sTitle": "Act"}
	        ],
	        "dom":"R<'row'<'col-sm-4'l><'col-sm-4'B><'col-sm-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",
		    "buttons": ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5','print']
	    });
	    $("input[aria-controls=databerita]").unbind().bind('keyup',function(e){
		    if (e.keyCode == 13) {
		        pelangganTable.fnFilter(this.value);
		    }
		});
		$('#dataform').find('input').keydown(function(e){
			if(e.which == 13){
				return false;
			}
		});
		
		$(function () {
		  $('[data-toggle="popover"]').popover();
		});
		
		// $('[data-toggle="tooltip"]').tooltip();   
		
});
</script>
<?php } ?>
<?= $this->load->view('footer');?>
